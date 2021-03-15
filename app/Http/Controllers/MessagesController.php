<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessagesResource;
use App\Models\Messages;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MessagesController extends Controller {
    public function index(): AnonymousResourceCollection {
        return MessagesResource::collection(Messages::all());
    }

    public function create(Request $request): JsonResponse {
        $request->validate([
            'user_id' => 'required',
            'text' => 'required'
        ]);

        $isError = Messages::createMessage($request->toArray());

        if ($isError) {
            return $isError;
        }

        // return response
        return response()->json(['message' => 'message uploaded']);
    }
}
