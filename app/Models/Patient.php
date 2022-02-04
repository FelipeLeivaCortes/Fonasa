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

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * @param object $parameters (Required): Containts the data to calculate the priority.
     */
    public function priority()
    {
        if ($this->category == Patient::CHILD) {
            $patient    = DB::table('childrens')->select('relation')->where('patient_id', $this->id)->get()[0];

            if ( $this->age >= 1 && $this->age <= 5 ) {
                return $patient->relation + 3;
            
            } else if ( $this->age >= 6 && $this->age <= 12 ) {
                return $patient->relation + 2;

            } else if ( $this->age >= 13 && $this->age <= 15 ) {
                return $patient->relation + 1;

            }


        } else if ($this->category == Patient::ADULT){
            $patient    = DB::table('adults')->select('is_smoker', 'time')->where('patient_id', $this->id)->get()[0];
            return $patient->is_smoker == 1 ? ( $patient->time / 4 + 2 ) : 2;

        }else if ($this->category == Patient::OLDMAN){
            $patient    = DB::table('oldmans')->select('has_diet')->where('patient_id', $this->id)->get()[0];

            if ( $patient->has_diet && ( $this->age >= 60 && $this->age <= 100 ) ) {
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
