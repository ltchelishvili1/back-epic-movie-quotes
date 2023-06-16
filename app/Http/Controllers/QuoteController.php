<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function store(StoreQuoteRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('quote-image');

            $thumbnail = url('storage/' . $path);
        }


        $quote = Quote::updateOrCreate([
            'quote' => $validated['quote'],
            'movie_id' => $validated['movie_id'],
            'user_id' => $validated['user_id'],
            'image' => $thumbnail,
        ]);

        return response()->json(['quote' => $quote], 201);
    }

    public function update(UpdateQuoteRequest $request, Quote $quote)
    {

        $validated = $request->validated();
        $thumbnail = $quote->image;
        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('movie-image');

            $thumbnail = url('storage/' . $path);
        }

        $quote->update([
            'quote' => $validated['quote'],
            'image' => $thumbnail,
        ]);
    }

    public function destroy(Request $request, Quote $quote)
    {
        if ($quote->user_id !== auth()->id()) {
            return response()->json(['message' => 'Not Authorized'], 401);
        }

        $quote->delete();
        return response()->json(['message' => 'Movie deleted succesfully'], 200);

    }




}
