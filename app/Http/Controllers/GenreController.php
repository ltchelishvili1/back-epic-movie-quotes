<?php

namespace App\Http\Controllers;

use App\Http\Resources\GenreResource;
use App\Models\Genre;
use Illuminate\Http\JsonResponse;

class GenreController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(): JsonResponse
	{
		return response()->json(['genres' => GenreResource::collection(Genre::all())], 200);
	}
}
