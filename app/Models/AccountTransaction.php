<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class AccountTransaction extends Model
{
    protected $fillable = [
        'account_id',
        'financial_event_id',
        'type',
        'amount'
    ];

    protected $casts = [
        'amount' => 'decimal:2'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function event()
    {
        return $this->belongsTo(FinancialEvent::class, 'financial_event_id');
    }
    public function financialEvent()
    {
        return $this->belongsTo(FinancialEvent::class);
    }
}
