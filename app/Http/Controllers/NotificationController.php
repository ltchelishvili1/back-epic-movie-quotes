<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(): JsonResponse
    {
        $notifications = Notification::orderByDesc('id')->where('author_id', auth()->id())->get();

        return response()->json(['notifications' => NotificationResource::collection($notifications), 200]);
    }
    public function update(Request $request): JsonResponse
    {
        if ($request->id) {

            Notification::find($request->id)->update(['has_user_seen' => true]);

        } else {

            Notification::where('author_id', $request->author_id)->where('has_user_seen', false)->update(['has_user_seen' => true]);

        }
        return response()->json(['message' => __('validation.notification_updated_successfully')], 200);
    }
}
