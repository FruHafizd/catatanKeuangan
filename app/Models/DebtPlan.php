<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebtPlan extends Model
{
    protected $fillable = [
        'user_id',
        'debt_name',
        'total_loan',
        'tenor_unit',
        'tenor_value',
        'income_type',
        'income_value',
        'monthly_expense',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
