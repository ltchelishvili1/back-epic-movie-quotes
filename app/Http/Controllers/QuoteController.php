<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class QuoteController extends Controller
{
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

    public function update(UpdateQuoteRequest $request, Quote $quote)
    {

        $response = Gate::inspect('view', $quote);

        if ($response->allowed()) {
            return response()->json(['message' => 'Not Authorized'], 401);
        }

        $validated = $request->validated();
        $validated['image'] = $quote->image;
        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('movie-image');

            $validated['image'] = url('storage/' . $path);
        }

        $quote->update($validated);
    }

    public function destroy(Request $request, Quote $quote)
    {
        $response = Gate::inspect('view', $quote);

        if (!$response->allowed()) {

            return response()->json(['message' => 'Not Authorized'], 401);
        }


        $quote->delete();

        return response()->json(['message' => 'Movie deleted succesfully'], 200);

    }




}
