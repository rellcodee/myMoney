<?php

namespace App\Services;

use App\Models\FinancialEvent;
use App\Models\Account;
use App\Models\AccountTransaction;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoryService
{
    public function createCategory($userId, $name)
    {
        return Category::create([
            'user_id' => $userId,
            'name' => $name,
            
        ]);
    }
}
          