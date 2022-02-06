<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $guarded  = ['id'];

    const MIN_AGE   = 1;
    const MAX_AGE   = 15;
    const CATEGORY  = 'Niño';

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
