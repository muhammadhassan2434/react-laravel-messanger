<?php

namespace Database\Factories;

use App\Models\Conservation;
use App\Models\Group;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);

        
        User::factory()->create([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => bcrypt('password')
        ]);
        User::factory()->create([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => bcrypt('password')
        ]);

        User::factory(10)->create();

        for($i = 0; $i < 5; $i++){
            $group = Group::factory()->create([

                'owner_id' =>1,
            ]);

            $users = User::inRandomOrder()->limit(rand(2, 5))->plunk('id');
            $group->users()->attch(array_unique([1,...$users]));


            Message::factory(1000)->create();
            $messages = Message::whereNull('group_id')->orderBy('created_at')->get();

            $conservations = $messages->groupBy(function($message){
                return collect([$message->sender_id, $message->receiver_id])->sort()
                ->implode(('_'));
            })->map(function($groupedMessage){
                return [
                    'user_id1' => $groupedMessage->first()->sender_id,
                    'user_id2' => $groupedMessage->first()->receiver_id,
                    'last_message_id' => $groupedMessage->last()->id,
                    'created_at' => new Carbon(),
                    'updated_at' => new Carbon(),
                ];
            })->values();
        }

        Conservation::insertOrIgnore($conservations->toArray());
    }

}
