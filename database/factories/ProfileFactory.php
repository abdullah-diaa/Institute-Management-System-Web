<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id, // Generate a user and use its ID
            'location' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'date_of_birth' => $this->faker->date,
            'profile_picture' => null, // Default profile picture
        ];
    }
}
