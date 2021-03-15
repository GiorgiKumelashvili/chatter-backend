<?php

namespace Database\Factories;

use App\Models\Messages;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessagesFactory extends Factory {
    protected $model = Messages::class;

    public function definition(): array {
        return [
            'text' => $this->faker->text(200),
            'user_id' => '107001323067694768810', // atheros
        ];
    }
}
