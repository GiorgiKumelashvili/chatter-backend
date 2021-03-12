<?php
/** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use GenTux\Jwt\JwtToken;
use Google_Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller {
    private const GOOGLE_CLIENT_ID = 'GOOGLE_CLIENT_ID';

    public function authenticate(Request $request): JsonResponse {
        // validate google id_token which is similar to password
        $request->validate([
            'id_token' => 'required'
        ]);

        // Check if id_token is valid and authenticated
        $payload = $this->verifyUser($request->id_token);

        // if not authenticated then send message
        if (!$payload)
            return $this->response('Unauthenticated', 401);

        // if user doesnt exist create it in DB
        return $this->createUser($payload);
    }

    private function verifyUser(string $id_token): array {
        $client = new Google_Client(['client_id' => env(self::GOOGLE_CLIENT_ID)]);
        return $client->verifyIdToken($id_token);
    }

    private function createUser(array $payload): JsonResponse {
        // destructure payload of user data
        list('sub' => $id, 'name' => $fullName, 'email' => $email, 'picture' => $image) = $payload;

        // if user doesnt exist in db
        if (!User::where('email', '=', $email)->exists()) {
            User::create([
                'id' => $id,
                'full_name' => $fullName,
                'email' => $email,
                'image_url' => $image
            ]);

            return $this->response('User created');
        }

        return $this->response('User exists');
    }


    private function response(string $message, int $error = null): JsonResponse {
        if ($error) {
            return response()->json(['message' => $message], $error);
        }

        return response()->json(['message' => $message]);
    }
}
