<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

try {

    // bikin user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password)
    ]);

    // bikin account
    Account::create([
        'user_id' => $user->id,
        'name' => 'Wallet',
        'type' => 'wallet',
        'balance' => 0,
        'is_active' => true
    ]);

    // bikin category (pakai loop biar simpel)
    $categories = ['Shopping', 'Bills', 'Food', 'Transport'];

    foreach ($categories as $cat) {
        Category::create([
            'user_id' => $user->id,
            'name' => $cat
        ]);
    }
        $token = $user->createToken("auth_token")->plainTextToken;
    DB::commit(); // ✅ semua berhasil → simpan

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
        
} catch (\Exception $e) {
    DB::rollBack(); // ❌ kalau error → batal semua
}

    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email','password'))) {
            return response()->json([
                'message' => 'Invalid credentials'
            ],401);
        }

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}