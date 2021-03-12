<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use GenTux\Jwt\JwtToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class TokenController extends Controller {
    public const TOKEN_NAME = 'access_token';
    public const TIME = 6;

    public function create(JwtToken $jwt, Request $request): JsonResponse {
        $request->validate([
            'id' => 'required'
        ]);

        // find user with given id
        $user = User::find($request->id);

        // inject user into token creation
        $token = $jwt->createToken($user);

        // save jwt in httponly cookie for 6 month period
        $cookie = cookie(self::TOKEN_NAME, $token, $this->getTime());

        // send jwt and cookie
        return $this
            ->response('JWT cookie created')
            ->withCookie($cookie);
    }

    public function retrieve(): string {
        return Cookie::get(self::TOKEN_NAME);
    }

    private function getTime(): int {
        // time of self::TIME [e.g. 6] month ahead
        return Carbon::now()
            ->addMonths(self::TIME)
            ->getTimestamp();
    }

    private function response(string $message, int $error = null): JsonResponse {
        if ($error) {
            return response()->json(['message' => $message], $error);
        }

        return response()->json(['message' => $message]);
    }
}
