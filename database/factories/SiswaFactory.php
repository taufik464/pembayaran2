<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'nis' => (string) $this->faker->unique()->numberBetween(1000, 9999),
            'nisn' => (string) $this->faker->unique()->numberBetween(100000000000, 9999999999999),
            'kelas_id' => $this->faker->numberBetween(1, 8), // Asumsikan ada 10 kelas
            'user_id' => null,
            'no_hp' => $this->faker->phoneNumber(),
            'foto' => $this->faker->imageUrl(640, 480, 'people', true),
        ];
    }
}
