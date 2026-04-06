<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Allocation;
use App\Models\Account;

class AllocationItem extends Model
{
    protected $fillable = [
        'allocation_id',
        'account_id',
        'amount'
    ];

    public function allocation()
    {
        return $this->belongsTo(Allocation::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}