<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adult extends Model
{
    use HasFactory;

    protected $guarded  = ['id'];

    const MIN_AGE   = 16;
    const MAX_AGE   = 40;
    const CATEGORY  = 'Adulto';

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
