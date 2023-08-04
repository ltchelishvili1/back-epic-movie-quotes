<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class UserController extends Controller
{
	protected $fileUploadService;

	public function __construct(FileUploadService $fileUploadService)
	{
		$this->fileUploadService = $fileUploadService;
	}

	public function index(): JsonResponse
	{
		return response()->json(
			[
				'message' => __('validation.auth_successfully'),
				'user'    => new UserResource(auth()->user()),
			],
			200
		);
	}

	public function show(Request $request, $user): JsonResponse
	{
		$existing_user = User::with('quotes', 'movies')->withCount('likes', 'comments')->find($user);

		if (!$existing_user) {
			return response()->json(
				[
					'message' => __('validation.user_not_found'),
				],
				404
			);
		}

		return response()->json(
			[
				'message' => __('validation.user_found'),
				'user'    => new UserResource($existing_user),
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
			$user->thumbnail = $this->fileUploadService->uploadFile($request->file('photo'), 'photo');
		}

		$user->save();

		return response()->json(['user' => new UserResource($user)], 200);
	}

	public function updateEmail(Request $request): JsonResponse
	{
		$user = User::find(auth()->id());

		$user->email_verified_at = null;

		$user->email = $request->email;

		event(new Registered($user));

		return response()->json(['message' => __('validation.check_email')]);
	}
}
