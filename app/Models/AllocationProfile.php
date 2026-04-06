<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllocationProfile extends Model
{
    protected $fillable = [
        'user_id',
        'version',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rules()
    {
        return $this->hasMany(AllocationRule::class);
    }
   
    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }
}