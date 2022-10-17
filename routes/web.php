<?php

use AshAllenDesign\ShortURL\Classes\Builder;
use AshAllenDesign\ShortURL\Models\ShortURL;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $urls = ShortURL::latest()->get();
    return view('welcome', compact('urls'));
});

Route::post('/', function() {
    $builder = new Builder();

    $shortURLObject = $builder->destinationUrl(request()->url)->make();
    $shortURL = $shortURLObject->default_short_url;

    return back()->with('success', 'URL shortened successfully');
})->name('url.shorten');

Route::post('{id}', function($id) {
    $url = ShortURL::find($id);
    $url->url_key = request()->url;
    $url->destination_url = request()->destination;
    $url->save();

    return back()->with('success', 'URL updated succesfully');
})->name('update');
