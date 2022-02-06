<?php

namespace Database\Seeders;

use App\Models\Adult;
use App\Models\Child;
use App\Models\Hospital;
use App\Models\Oldman;
use App\Models\Patient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i=0; $i < 50; $i++) {
            $patient    = Patient::create([
                'hospital_id'       => Hospital::all()->random()->id,
                'name'              => $faker->name(),
                'age'               => 0,
                'category'          => 1,
                'noHistoriaClinica' => rand(0, 10),
            ]);
            
            $category   = Arr::random([Patient::CHILD, Patient::ADULT, Patient::OLDMAN]);

            switch ($category) {
                case Patient::CHILD :
                    $patient->update([
                        'age'       => mt_rand(Child::MIN_AGE, Child::MAX_AGE),
                        'category'  => $category,
                    ]);

                    Child::create([
                        'patient_id'    => $patient->id,
                        'relation'      => mt_rand(1, 4),
                    ]);

                    break;

                case Patient::ADULT :
                    $patient->update([
                        'age'       => mt_rand(Adult::MIN_AGE, Adult::MAX_AGE),
                        'category'  => $category,
                    ]);

                    $is_smoker  = rand(0, 1);
                    $time       = $is_smoker ? mt_rand(1, $patient->age - 10) : 0;

                    Adult::create([
                        'patient_id'    => $patient->id,
                        'is_smoker'     => $is_smoker,
                        'time'          => $time,
                    ]);

                    break;

                case Patient::OLDMAN :
                    $patient->update([
                        'age'       => mt_rand(Oldman::MIN_AGE, Oldman::MAX_AGE),
                        'category'  => $category,
                    ]);

                    Oldman::create([
                        'patient_id'    => $patient->id,
                        'has_diet'      => rand(0, 1),
                    ]);

                    break;
            }

        }
    }
}