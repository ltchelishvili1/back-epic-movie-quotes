<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Http\Resources\MovieResource;
use App\Http\Resources\QuoteCardResource;
use App\Http\Resources\QuoteResource;
use App\Models\Movie;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        $searchKey = $request->query('searchKey');

        $quotes = Quote::with(['movie', 'user', 'likes', 'comments.user'])
            ->search($searchKey)
            ->orderByDesc('id')
            ->simplePaginate(3);

        if(isset($searchKey) && (trim($searchKey)[0] === '#')) {

            return response()->json(['quotes' => QuoteCardResource::collection($quotes)], 200);

        }


        if (isset($searchKey) && (trim($searchKey)[0] === '@')) {
            $movies = Movie::search($searchKey)
                ->orderByDesc('id')
                ->simplePaginate(6);

            return response()->json(['movies' => MovieResource::collection($movies)], 200);
        }

        return response()->json(['posts' => QuoteResource::collection($quotes)]);

    }



    public function store(StoreQuoteRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('quote-image');

            $validated['image'] = url('storage/' . $path);
        }

        $quote = Quote::create($validated);

        return response()->json(['quote' => $quote], 201);
    }

    public function show(Quote $quote): JsonResponse
    {

        return response()->json(['quote' => $quote], 200);
    }


    public function update(UpdateQuoteRequest $request, Quote $quote)
    {
        $validated = $request->validated();

        $validated['image'] = $quote->image;
        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('movie-image');

            $validated['image'] = url('storage/' . $path);
        }

        $quote->update($validated);

        return response()->json(['quote' => $quote]);
    }


    public function destroy(Request $request, Quote $quote)
    {
        $quote->delete();
        return response()->json(['message' => 'Quote deleted succesfully'], 200);

    }

}
