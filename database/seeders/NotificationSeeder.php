<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'type' => 'Khuyến mãi',
                'message' => '🎉 Bạn có khuyến mãi mới!',
                'is_read' => false,
            ]);
        }
    }
}


