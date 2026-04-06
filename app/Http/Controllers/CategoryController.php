<?php
namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
class CategoryController extends Controller
{
public function categories(){
    $userId = auth()->id(); // Replace with actual authenticated user ID
    $categories = Category::where('user_id', $userId)->get();
    return response()->json($categories);
    }

    public function store(){
        
        $userId = auth()->id(); // Replace with actual authenticated user ID
        $category = Category::create([
            'user_id' => $userId,
            'name' => ''
        ]);
        return response()->json($category, 201);
    }
    // public function store(Request $request, IncomeService $incomeService)
    // {
    //      $request->validate([
    //         'amount' => 'required|numeric|min:1',
    //         'note' => 'nullable|string'
    //     ]);

    //     $incomeService->createIncome(
    //         $request->user()->id,
    //         $request->amount,
    //         $request->note
    //     );

    //     return back()->with('success', 'Income added');
    // }
}
