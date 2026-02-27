<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'specialty',
        'crm',
        'phone',
        'email',
        'color',
        'is_active',
        // Remuneration
        'role',
        'contract_type',
        'remuneration_type',
        'fixed_salary',
        'commission_percentage',
        'pix_key',
        'bank_details',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ─── Scopes ───

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ─── Relationships ───

    public function scheduleSlots()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function appointments()
    {
        return $this->hasMany(Schedule::class);
    }
}
