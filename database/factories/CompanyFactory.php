<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
     protected $model = \App\Models\Company::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'logo' => 'public/logos/sample_logo.png', // Replace this with the path to your sample logo file
            'website' => $this->faker->url,
        ];
    }
}
