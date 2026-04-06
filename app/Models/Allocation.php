<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AllocationItem;
use App\Models\AllocationProfile;

class Allocation extends Model
{
    protected $fillable = [
        'user_id',
        'allocation_profile_id',
        'amount'
    ];

    public function items()
    {
        return $this->hasMany(AllocationItem::class);
    }

    public function profile()
    {
        return $this->belongsTo(AllocationProfile::class);
    }
}