<?php /** @noinspection PhpParamsInspection */

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class Messages extends Model {
    use HasFactory;

    protected $guarded = [];

    private static function sendBack($message): JsonResponse {
        return response()->json([
            'message' => $message
        ]);
    }

    public static function createMessage(array $data): ?JsonResponse {
        try {
            // create message
            self::create($data);
            return null;
        }
        catch (QueryException $queryException) {
            if ($queryException->getCode() === '23000') {
                return self::sendBack('query exception probably problem with user_id');
            }

            return self::sendBack($queryException->errorInfo);
        }
        catch (Exception $exception) {
            return self::sendBack($exception->getMessage());
        }
    }
}
