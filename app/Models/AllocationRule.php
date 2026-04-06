<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllocationRule extends Model
{
    protected $fillable = [
        'allocation_profile_id',
        'name',
        'percentage',
        'target_account_id'
    ];

    protected $casts = [
        'percentage' => 'decimal:2'
    ];

    public function profile()
    {
        return $this->belongsTo(AllocationProfile::class, 'allocation_profile_id');
    }

    public function targetAccount()
    {
        return $this->belongsTo(Account::class, 'target_account_id');
    }
    public function account()
    {
        return $this->belongsTo(Account::class, 'target_account_id');
    }

}