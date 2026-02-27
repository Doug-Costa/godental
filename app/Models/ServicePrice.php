<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePrice extends Model
{
    protected $fillable = [
        'name',
        'category',
        'default_price',
        'is_active',
    ];

    protected $casts = [
        'default_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // ─── Constants ───

    const CATEGORY_CONSULTA = 'Consulta';
    const CATEGORY_PROCEDIMENTO = 'Procedimento';
    const CATEGORY_RETORNO = 'Retorno';

    const CATEGORIES = [
        self::CATEGORY_CONSULTA,
        self::CATEGORY_PROCEDIMENTO,
        self::CATEGORY_RETORNO,
    ];

    // ─── Scopes ───

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    public function materials()
    {
        return $this->belongsToMany(InventoryItem::class, 'procedure_materials')
            ->withPivot('quantity_used');
    }
}
