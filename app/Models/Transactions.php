<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $fillable = [
        'transaction_id',
        'session_id',
        'reference',
        'trazability_code',
        'transaction_state',
        'description',
        'bank_process_date',
        'request_date',
        'user_id',
    ];
}
