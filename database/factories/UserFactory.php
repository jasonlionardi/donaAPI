<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'no_regis_donor' => $this->faker->bothify('###?###?##'),
            'name' => $this->faker->name(),
            'username' => $this->faker->lexify('????????'),
            'phone' => '081'.$this->faker->numerify('########'),
            'email' => $this->faker->unique()->safeEmail(),
            'date_of_birth' => $this->faker->date('Y-m-d', '2005-05-05'),
            'gender' => $this->faker->regexify('[MF]'),
            'blood_type' => $this->faker->regexify('[ABO]'),
            'rhesus' => $this->faker->regexify('[\+\-]'),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role' => $this->faker->randomElement(['admin', 'donor']),
            // JANGAN PAKE DATA ROLE DI SINI, PAKE DATA DI TABLE ROLES
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
