<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oldman extends Model
{
    use HasFactory;

    protected $guarded  = ['id'];

    const MIN_AGE   = 41;
    const MAX_AGE   = 100;
    const CATEGORY  = 'Anciano';

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
