<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
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
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['quotes' => Quote::with('user', 'movie')->orderBy('created_at')->simplePaginate(5)]);
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

    public function choose(Quote $quote): JsonResponse
    {
        if ($quote->user_id !== auth()->id()) {
            return response()->json(['message' => 'Not Authorized'], 401);
        }

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

    public function search(SearchRequest $request)
    {
        $searchKey = $request->validated()['searchKey'];

        if(isset($searchKey) && trim($searchKey)[0] === '@') {

            $search = ltrim($searchKey, $searchKey[0]);

            $movie = MovieResource::collection(Movie::where(function ($query) use ($search) {

                $query->where('title->en', 'like', '%' . $search . '%')
                    ->orWhere('title->ka', 'like', '%' . $search . '%');
            })->orderByDesc('id')->simplePaginate(4));

            return response()->json(['movies' => $movie], 200);

        } elseif(isset($searchKey) && trim($searchKey)[0] === '#') {

            $search = ltrim($searchKey, $searchKey[0]);
            $quote = QuoteCardResource::collection(Quote::where(function ($query) use ($search) {
                $query->where('quote->en', 'like', '%' . $search . '%')
                    ->orWhere('quote->ka', 'like', '%' . $search . '%');
            })->orderByDesc('id')->simplePaginate(3));


            return response()->json(['quotes' => $quote], 200);


        } else {
            $quote = QuoteResource::collection(Quote::with(['movie','user','likes','comments.user'])
            ->where(function ($query) use ($searchKey) {
                $query->where('quote->en', 'like', '%' . $searchKey . '%')
                    ->orWhere('quote->ka', 'like', '%' . $searchKey . '%');
            })
            ->orWhereHas('movie', function (Builder $query) use ($searchKey) {
                $query->where('title->en', 'like', '%' . $searchKey . '%')
            ->orWhere('title->ka', 'like', '%' . $searchKey . '%');
            })->orderByDesc('id')->simplePaginate(3));
            ;

        }

        return response()->json(['posts' => $quote], 200);
    }


    public function destroy(Request $request, Quote $quote)
    {
        $quote->delete();
        return response()->json(['message' => 'Movie deleted succesfully'], 200);

    }

}
