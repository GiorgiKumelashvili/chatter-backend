<?php

namespace App\Models;

use App\Http\Controllers\TokenController;
use Carbon\Carbon;
use GenTux\Jwt\JwtPayloadInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property mixed id
 * @property mixed email
 */
class User extends Authenticatable implements JwtPayloadInterface {
    use HasFactory, Notifiable;

    protected array $fillable = [
        'id',
        'full_name',
        'email',
        'image_url',
    ];

    protected array $hidden = [
        'remember_token',
    ];

    protected array $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getPayload(): array {
        return [
            'sub' => $this->id,
            'exp' => Carbon::now()->addMonths(TokenController::TIME)->timestamp,
            'context' => [
                'email' => $this->email
            ]
        ];
    }
}
