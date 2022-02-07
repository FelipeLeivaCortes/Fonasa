<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Patient extends Model
{
    use HasFactory;

    protected $guarded      = ['id'];

    const CHILD     = '1';
    const ADULT     = '2';
    const OLDMAN    = '3';

    const IN_LOBBY  = 'En sala de espera';
    const AWAITING  = 'En sala de pacientes';
    const ATTENDED  = 'Atentido';

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function category_name()
    {
        switch ( $this->category ){
            case Patient::CHILD :
                return Child::CATEGORY;
            
            case Patient::ADULT :
                return Adult::CATEGORY;

            case Patient::OLDMAN :
                return Oldman::CATEGORY;

        }
    }

    public function person()
    {
        switch ( $this->category ){
            case Patient::CHILD :
                return $this->hasOne(Child::class);

            case Patient::ADULT :
                return $this->hasOne(Adult::class);

            case Patient::OLDMAN :
                return $this->hasOne(Oldman::class);
        }
    }

    /**
     * @param object $parameters (Required): Containts the data to calculate the priority.
     */
    public function priority()
    {
        switch ($this->category) {
            case Patient::CHILD :
                if ( $this->age >= 1 && $this->age <= 5 ) {
                    return $this->person->relation + 3;
                
                } else if ( $this->age >= 6 && $this->age <= 12 ) {
                    return $this->person->relation + 2;
    
                } else if ( $this->age >= 13 && $this->age <= 15 ) {
                    return $this->person->relation + 1;
    
                }

            case Patient::ADULT :
                return $this->person->is_smoker == 1 ? ( $this->person->time / 4 + 2 ) : 2;

            case Patient::OLDMAN :
                if ( $this->person->has_diet && ( $this->age >= 60 && $this->age <= 100 ) ) {
                    return $this->age / 20 + 4;
                
                } else {
                    return $this->age / 30 + 3;
    
                }
        }
    }

    public function risk()
    {
        if ( $this->category == Patient::OLDMAN ) {
            return ( $this->age * $this->priority() ) / 100 + 5.3;

        } else {
            return ( $this->age * $this->priority() ) / 100;

        }
    }
}
