<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Creating 5 hospitals like test
         */
        $postfix    = ['A', 'B', 'C', 'D', 'E'];

        for ($i=0; $i < 5; $i++) { 
            Hospital::create([
                'name'      => 'Hospital '.$postfix[$i],
                'direction' => 'Dirección '.$postfix[$i],
            ]);
        }
    }
}
