<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalFinancial extends Model
{
    protected $table = 'goal_financials';

    protected $fillable = [
        'name',
        'target_amount',
        'image',
        'start_date',
        'end_date',
        'status',
    ];
}
