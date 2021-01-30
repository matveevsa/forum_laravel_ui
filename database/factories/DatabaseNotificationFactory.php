<?php

namespace Database\Factories;

use App\Models\DatabaseNotification;
use App\Models\User;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DatabaseNotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DatabaseNotification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => Str::uuid()->toString(),
            'type' => ThreadWasUpdated::class,
            'notifiable_id' => function () {
                return auth()->id() ?: User::factory()->create()->id;
            },
            'notifiable_type' => User::class,
            'data' => ['foo' => 'bar']
        ];
    }
}
