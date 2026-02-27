<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurrence extends Model
{
    use HasFactory;

    protected $fillable = ['financial_transaction_id', 'frequency', 'end_date'];

    protected $casts = [
        'end_date' => 'date',
    ];

    const FREQ_WEEKLY = 'weekly';
    const FREQ_MONTHLY = 'monthly';
    const FREQ_YEARLY = 'yearly';

    public function transaction()
    {
        return $this->belongsTo(FinancialTransaction::class);
    }
}
