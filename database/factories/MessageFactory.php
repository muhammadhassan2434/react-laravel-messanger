<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\User;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition(): array
    {
        $senderId = User::inRandomOrder()->first()->id;
        $receiverId = User::where('id', '!=', $senderId)->inRandomOrder()->first()->id;
        $groupId = null;

        // 50% chance of associating this message with a group
        if (fake()->boolean(50)) {
            $groupId = Group::inRandomOrder()->first()->id ?? null;
            $senderId = User::inRandomOrder()->first()->id;
            $receiverId = null;
        }

        return [
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'group_id' => $groupId,
            'message' => fake()->realText(200),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now', 'UTC'),
        ];
    }
}
