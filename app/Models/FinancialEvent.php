<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialEvent extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'allocation_profile_id',
        'category_id',
        'event_date',
        'note'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'event_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(AccountTransaction::class);
    }

    public function allocationProfile()
    {
        return $this->belongsTo(AllocationProfile::class);
    }
    public function category()
{
    return $this->belongsTo(Category::class);
}
}