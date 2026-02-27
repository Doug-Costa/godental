<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    protected $fillable = [
        'doctor_id',
        'day_of_week',
        'start_time',
        'end_time',
        'slot_duration',
    ];

    protected $casts = [
        'day_of_week' => 'integer',
        'slot_duration' => 'integer',
    ];

    // ─── Constants ───

    const DAYS = [
        0 => 'Domingo',
        1 => 'Segunda-feira',
        2 => 'Terça-feira',
        3 => 'Quarta-feira',
        4 => 'Quinta-feira',
        5 => 'Sexta-feira',
        6 => 'Sábado',
    ];

    // ─── Relationships ───

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // ─── Helpers ───

    public function getDayNameAttribute()
    {
        return self::DAYS[$this->day_of_week] ?? 'Desconhecido';
    }
}
