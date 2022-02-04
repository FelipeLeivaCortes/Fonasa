<?php

namespace Database\Factories;

use App\Models\Hospital;
use App\Models\Record;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class RecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hospital_id'   => Hospital::all()->random()->id,
            'professional'  => $this->faker->name(),
            'type'          => Arr::random([Record::TYPE_PEDIATRIA, Record::TYPE_URGENCIA, Record::TYPE_CGI]),
        ];
    }
}
