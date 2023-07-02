<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): JsonResponse
    {

        return response()->json(
            [
                'message' => __('validation.auth_successfully'),
                'user' => auth()->user()
            ],
            200
        );
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::find(auth()->id());

        $user->update($validated);

        if ($request->hasFile('photo')) {

            $path = $request->file('photo')->store('photo');

            $user->thumbnail = url('storage/' . $path);

            $user->save();
        }

        return response()->json($user);
    }



    public function updateEmail(Request $request): JsonResponse
    {

        $user = User::find(auth()->id());

        $user->email_verified_at = null;

        $user->email = $request->email;

        event(new Registered($user));

        return response()->json($request->email);
    }


}
