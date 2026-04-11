<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'budget_limit',
        'is_active'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}