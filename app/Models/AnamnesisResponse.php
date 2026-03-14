<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnamnesisResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'instance_id',
        'question_id',
        'question_text',
        'answer_type',
        'answer_value',
    ];

    public function instance()
    {
        return $this->belongsTo(AnamnesisInstance::class, 'instance_id');
    }
}
