<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\UserCity;

class SaveController extends Controller
{

    public function saveCity($city)
    {
        UserCity::firstOrCreate(
            ['user_id' => auth()->id(), 'city' => $city, 'notification_enable' => false]
        );
        return redirect()->route("weather");
    }

    public function killCity($id) {
        $query = UserCity::findOrFail($id);
        $query->delete();
        return redirect()->route('weather');
    }

    public function addNotification($city) {
        $cities = UserCity::all();
        $notifCity = null;
        foreach ($cities as $value) {
            if ($value->user_id == auth()->id() && $value->city == $city) {
                $notifCity = $value;
            }
        }
        $notifCity->notification_enable = true;
        $notifCity->save();
        SaveController::shareNotification();
        return redirect()->route('weather');

    }

    public function removeNotification($city) {
        $cities = UserCity::all();
        foreach ($cities as $value) {
            if ($value->user_id == auth()->id() && $value->city == $city) {
                $notifCity = $value;
            }
        }
        $notifCity->notification_enable = false;
        $notifCity->save();
        SaveController::shareNotification();
        return redirect()->route('weather');
    }

    public static function shareNotification()
    {
        if (auth()->check()) {
            $notifsCities = [];
            $cities = UserCity::all();
            foreach ($cities as $value) {
                if ($value->user_id == auth()->id() && $value->notification_enable) {
                    $notifsCities[] = $value->city;
                }
            }
            View::share("notification", $notifsCities);
        }
    }
}
