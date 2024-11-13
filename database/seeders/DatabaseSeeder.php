<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Group;
use App\Models\Message;
use App\Models\Conservation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create specific user records
        User::factory()->create([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => bcrypt('password')
        ]);
        User::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);

        User::factory(10)->create();

        for($i = 0; $i < 5; $i++){
            $group = Group::factory()->create([

                'owner_id' =>1,
            ]);

            $users = User::inRandomOrder()->limit(rand(2, 5))->pluck('id');
            $group->users()->attach(array_unique([1,...$users]));


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
