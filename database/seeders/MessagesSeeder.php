<?php

namespace Database\Seeders;

use App\Models\Messages;
use Illuminate\Database\Seeder;

class MessagesSeeder extends Seeder {
    public function run(): void {
        Messages::factory(5)->create();
    }
}
