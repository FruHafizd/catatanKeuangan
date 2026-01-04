<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecurringTransaction extends Model
{   
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'last_generated_at' => 'date',
        'is_active' => 'boolean',
    ];

    protected $fillable = [
        'user_id','name','amount',
        'type','frequency','start_date',
        'end_date','last_generated_at','is_active'
    ];

    public function transactions()  {
        return $this->hasMany(Transaction::class);
    }

}
