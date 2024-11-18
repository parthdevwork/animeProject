<?php

use App\Http\Controllers\AnimeController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:importAnimeData')->post('import-anime', [AnimeController::class, 'importAnimeData'])->name('importAnimeData');
Route::middleware('throttle:getAnimeBySlug')->get('anime/{slug}', [AnimeController::class, 'getAnimeBySlug'])->name('getAnimeBySlug');
