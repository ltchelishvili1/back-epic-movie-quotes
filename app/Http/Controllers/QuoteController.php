<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quote\StoreQuoteRequest;
use App\Http\Requests\Quote\UpdateQuoteRequest;
use App\Http\Resources\QuoteCardResource;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use App\Services\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }


    public function index(Request $request): JsonResponse
    {
        $searchKey = $request->query('searchKey');

        $quotes = Quote::with(['movie', 'user', 'likes', 'comments.user'])
            ->search($searchKey)
            ->orderByDesc('id')
            ->simplePaginate(3);

        if(isset($searchKey) && (trim($searchKey)[0] === '#')) {

            return response()->json(['quotes' => QuoteCardResource::collection($quotes)], 200);

        }
        return response()->json(['posts' => QuoteResource::collection($quotes)]);

    }


    public function store(StoreQuoteRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {

            $validated['image'] = $this->fileUploadService->uploadFile($request->file('image'), 'quote-image');

        }

        $quote = Quote::create($validated);

        return response()->json(['quote' => new QuoteResource($quote)], 201);
    }

    public function show(Quote $quote): JsonResponse
    {

        return response()->json(['quote' => new QuoteResource($quote)], 200);
    }


    public function update(UpdateQuoteRequest $request, Quote $quote): JsonResponse
    {
        $validated = $request->validated();

        $validated['image'] = $quote->image;

        if ($request->hasFile('image')) {

            $validated['image'] = $this->fileUploadService->uploadFile($request->file('image'), 'quote-image');
        }

        $quote->update($validated);

        return response()->json(['quote' => new QuoteResource($quote)]);
    }


    public function destroy(Request $request, Quote $quote): JsonResponse
    {
        $quote->delete();

        return response()->json(['message' => __('validation.quote_deleted_successfully')], 200);

    }

}
