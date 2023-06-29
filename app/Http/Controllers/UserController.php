<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    public function index(): JsonResponse
    {

        return response()->json(
            [
                'message' => 'authenticated successfully',
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


        event(new Registered($user));

        if ($request->hasFile('photo')) {

            $path = $request->file('photo')->store('photo');

            $user->thumbnail = url('storage/' . $path);

            $user->save();
        }




        return response()->json($user);
    }
}
