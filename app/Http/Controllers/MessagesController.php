<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use App\Http\Resources\MessagesResource;
use App\Models\Messages;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Arr;

class MessagesController extends Controller {
    public function index(): AnonymousResourceCollection {
        return MessagesResource::collection(Messages::all());
    }

    public function create(Request $request): JsonResponse {
        $data = $request->validate([
            'image_url' => 'required',
            'text' => 'required',
            'user_id' => 'required'
        ]);

        // no need for image_url
        $isError = Messages::createMessage(Arr::only($data, ['text', 'user_id']));

        if ($isError) {
            return $isError;
        }

        // broad cast event to everyone else
        broadcast(new SendMessage($request->toArray()));

        // return response
        return response()->json(['message' => 'message uploaded']);
    }
}
