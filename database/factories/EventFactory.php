<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {   
        $name = (fake()->firstName() . " " . fake()->firstName());
        $slug = str_replace(' ', '-', strtolower($name));
        return [
            'name' => $name,
            'slug' => $slug,
            'startAt' => Carbon::now()->subDays(rand(1, 100)),
            'endAt' => Carbon::now()->addDays(rand(1, 100)),
            'createdAt' => Carbon::now(),
            'updatedAt' => Carbon::now()
        ];
    }
}
