<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AnimeController extends Controller
{

    public function importAnimeData()
    {
        $animeData = [];

        try {
            for ($i = 0; $i < 4; $i++) {
                $response = Http::get("https://api.jikan.moe/v4/top/anime?limit=25&page=" . ($i + 1)); //At a time we fetch only 25 data only

                if ($response->successful()) {
                    $responseData = $response->json();

                    if (isset($responseData['data']) && count($responseData['data']) > 0) {
                        $animeData = array_merge($animeData, $responseData['data']);
                    } else {
                        Log::warning("No data found on page " . ($i + 1));
                        return response()->json(['message' => 'No anime data found for this page.'], 204);
                    }
                } else {
                    Log::error("Failed to fetch data for page " . ($i + 1));
                    return response()->json(['message' => 'Failed to fetch anime data from API.'], 500);
                }
            }

            // Insert data into the database if not already exists
            foreach ($animeData as $anime) {
                if (!Anime::where('mal_id', $anime['mal_id'])->exists()) {
                    Anime::create([
                        'mal_id' => $anime['mal_id'],
                        'slug' => strtolower(str_replace(' ', '-', $anime['title'])),
                        'title' => $anime['title'],
                        'synopsis' => $anime['synopsis'],
                        'image_url' => $anime['images']['jpg']['image_url'],
                    ]);
                }
            }

            return response()->json(['message' => 'Anime data stored successfully!'], 200);

        } catch (\Exception $e) {
            Log::error('Error occurred while importing anime data: ' . $e->getMessage());

            return response()->json(['message' => 'An error occurred while processing the data.'], 500);
        }
    }

    public function getAnimeBySlug(Request $request, $slug)
    {
        $validator = Validator::make(['slug' => $slug], [
            'slug' => 'required|string|alpha_dash',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid slug. Please check the format.'], 400);
        }

        $anime = Anime::where('slug', $slug)->first();

        if ($anime) {
            return response()->json($anime, 200);
        }

        return response()->json(['message' => 'Anime not found'], 204);
    }

}
