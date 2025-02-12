<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserCity;
use App\Models\User;
use App\Http\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiCityController extends Controller
{
    use AuthorizesRequests;

    public function list(Request $request)
    {
        $cities = $request->user()->cities()->paginate(10);
        
        $customResponse = [
            'current_page' => $cities->currentPage(),
            'total_pages' => $cities->lastPage(),
            'total_cities' => $cities->total(),
            'cities' => $cities->items(),
        ];
    
        return response()->json($customResponse);
    }

    public function add(Request $request)
    {
        $request->validate(['city' => 'required|string|max:255']);

        $city = $request->user()->cities()->create([
            'city' => $request->city
        ]);

        return [
            'id' => $city->id,
            'city' => $city->city,
            'favorite' => $city->favorite,
        ];
    }

    public function toggleFavorite(string $city, Request $request)
    {
        $user = $request->user();
        $alreadyFavorite = $user->favorite;
        if ($alreadyFavorite == $city) {
            $user->favorite = null;
            $user->save();
            return ['message' => 'City ' . $city . ' has been removed from favorite.'];
        }
        $user->favorite = $city;
        $user->save();
        return ['message' => 'City ' . $city . ' has been added to favorite.'];
    }

    public function remove(string $city, Request $request)
    {
        $user = $request->user();
        $user->cities()->where('city', $city)->delete();
    }

    public function notification(string $city, Request $request)
    {
        $user = $request->user();
        $savedCity = $user->cities()->where('city', $city)->first();
        if ($savedCity->notification_enable == null || $savedCity->notification_enable == false) {
            $savedCity->notification_enable = true;
            $savedCity->save();
            return ['message' => 'Notification has been enable for ' . $savedCity->city . '.'];
        }
        $savedCity->notification_enable = false;
        $savedCity->save();
        return ['message' => 'Notification has been disabled for ' . $savedCity->city . '.'];
    }
}