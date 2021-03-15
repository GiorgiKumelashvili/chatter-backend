<?php
    /**
     * Run the database seeds.
     *
     * @return void
     */

namespace Database\Seeders;

use App\Models\Messages;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        $this->call([
            MessagesSeeder::class
        ]);
    }
}
