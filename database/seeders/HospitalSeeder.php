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
        Hospital::create([
            'name'      => 'Hospital Sótero del Rio',
            'direction' => 'Av. Libertad 777',
        ]);
    }
}
