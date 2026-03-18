<?php

namespace Database\Factories;

use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),

            // You can keep this hashed password (Laravel default = "password")
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),

            // ✅ REQUIRED FIELDS (based on your DB constraints)
            'role' => UserRoleEnum::Donor->value,
            'gender' => 'male',
            'birth_date' => '2000-01-01',
            'status' => 'active',

            // Optional (only if your users table has otp column)
            // 'otp' => null,
            // 'otp_expires_at' => null,
        ];
    }

    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}