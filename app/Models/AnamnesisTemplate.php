<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnamnesisTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_default',
        'is_active',
        'created_by',
        'questions',
    ];

    protected $casts = [
        'questions' => 'array',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function instances()
    {
        return $this->hasMany(AnamnesisInstance::class, 'template_id');
    }
}
