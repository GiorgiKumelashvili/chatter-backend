<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed user_id
 * @property mixed text
 */
class MessagesResource extends JsonResource {
    public function toArray($request): array {
        $imageUrl = User::where('id', $this->user_id)
            ->first()
            ->image_url;

        return [
            'user_id'=>$this->user_id,
            'text' => $this->text,
            'image_url' => $imageUrl
        ];
    }
}
