<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\User;

class FavoriteController extends Controller
{
    public function favoriteAdd($city)
    {
        auth()->user()->addFavorite($city);
        $this->shareFavorites();
        return redirect()->route('weather');
    }

    public function shareFavorites()
    {
        if (auth()->check()) {
            $favorite = auth()->user()->favorite;
            View::share("favorite", $favorite);
        }
    }
}
