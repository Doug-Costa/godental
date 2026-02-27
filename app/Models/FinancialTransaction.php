<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'amount',
        'type',
        'date',
        'due_date',
        'paid_at',
        'status',
        'category_id',
        'supplier_id',
        'patient_id',
        'bank_account_id',
        'payment_method_id',
        'related_type',
        'related_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
        'due_date' => 'date',
        'paid_at' => 'date',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_OVERDUE = 'overdue';

    public function category()
    {
        return $this->belongsTo(FinancialCategory::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function recurrence()
    {
        return $this->hasOne(Recurrence::class);
    }
}
