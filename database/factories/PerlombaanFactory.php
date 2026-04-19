<?php

namespace Database\Factories;

use App\Models\Perlombaan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Perlombaan>
 */
class PerlombaanFactory extends Factory
{
    protected $model = Perlombaan::class;

    public function definition(): array
    {
        $nama = fake()->unique()->sentence(3);

        return [
            'created_by' => User::factory(),
            'nama_lomba' => $nama,
            'slug' => Str::slug($nama).'-'.fake()->unique()->numberBetween(10, 999),
            'deskripsi' => fake()->paragraph(),
            'status' => Perlombaan::STATUS_REGISTRATION_OPEN,
            'deadline_pendaftaran' => now()->addDays(7)->toDateString(),
            'registration_start_at' => now()->subDay(),
            'registration_end_at' => now()->addDays(7),
            'submission_deadline_at' => now()->addDays(14),
            'announcement_at' => now()->addDays(21),
            'max_participants' => fake()->numberBetween(30, 200),
        ];
    }
}
