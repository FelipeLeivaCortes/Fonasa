<?php

namespace Database\Seeders;

use App\Models\Hospital;
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
            $category   = Arr::random([Patient::CHILD, Patient::ADULT, Patient::OLDMAN]);
            $age        = 0;

            if ($category == Patient::CHILD) {
                $age    = mt_rand(1, 15);
            
            } else if ($category == Patient::ADULT) {
                $age    = mt_rand(16, 40);

            } else {
                $age    = mt_rand(41, 100);

            }

            $patient    = Patient::create([
                'hospital_id'   => Hospital::all()->random()->id,
                'name'          => $faker->name(),
                'age'           => $age,
                'category'      => $category,
            ]);

            if ( $category == Patient::CHILD ) {
                DB::insert('insert into childrens (patient_id, relation) values (?, ?)', [$patient->id, mt_rand(1, 4) ]);

            } else if ( $category == Patient::ADULT ) {
                $is_smoker  = rand(0, 1);

                if ( $is_smoker ) {
                    DB::insert('insert into adults (patient_id, is_smoker, time) values (?, ?, ?)', [$patient->id, 1, mt_rand(1, $patient->age) ]);

                } else {
                    DB::insert('insert into adults (patient_id, is_smoker, time) values (?, ?, ?)', [$patient->id, 0, 0]);

                }

            } else {
                DB::insert('insert into oldmans (patient_id, has_diet) values (?, ?)', [$patient->id, rand(0, 1)] );

            }
        }
    }
}