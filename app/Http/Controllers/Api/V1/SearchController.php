<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\ScoutEngines\SphinxEngine;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        try {
            $query = $request->input('q');
            if (empty($query)) {
                return response()->json(['error' => 'Query cannot be empty'], 400);
            }
            Log::info('Query', ['query' => $query]);

            // Check if the results are cached
            $cacheKey = 'search_' . md5($query);
            $results = Cache::remember($cacheKey, 600, function () use ($query) {
                // Initialize the Builder with the Post model
                $builder = Post::search($query);

                Log::info('builder yx', ['builder ' => $builder]);

                // Check if the callback is null
                if ($builder->callback === null) {
                    Log::info('Callback is null, performing normal database search');

                    // Perform a normal database search using Eloquent
                    return Post::where('title', 'like', "%{$query}%")
                        ->orWhere('body', 'like', "%{$query}%")
                        ->get();
                } else {
                    $sphinx = new SphinxEngine();
                    return $sphinx->search($builder);
                }
            });

            return response()->json($results);

        } catch (\Exception $e) {
            Log::error('Search error:', ['exception' => $e]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
