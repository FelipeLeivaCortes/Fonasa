<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $guarded  = ['id'];

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
