<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $guarded  = ['id'];

    const STATE_OCUPPED     = 'Ocupada';
    const STATE_AVAILABLE   = 'Disponible';

    const TYPE_PEDIATRIA    = 'Pediatría';
    const TYPE_URGENCIA     = 'Urgencia';
    const TYPE_CGI          = 'Consulta General Integral';

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}
