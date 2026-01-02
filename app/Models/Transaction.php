<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $casts = [
        'date' => 'date'
    ];

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'date',
        'description',
    ];

    public function user()  {
        return $this->belongsTo(User::class);
    }

}
