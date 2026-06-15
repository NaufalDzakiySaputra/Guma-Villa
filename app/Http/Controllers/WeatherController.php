<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function getWeather()
    {
        $apiKey = env('OPENWEATHER_API_KEY');
        
        $lat = -6.7067;  // Koordinat Caringin/Puncak
        $lon = 106.9943;
        
        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'id'
        ]);
        
        if ($response->successful()) {
            $data = $response->json();
            
            // Return JSON untuk widget floating
            return response()->json([
                'city' => $data['name'],
                'temp' => round($data['main']['temp']),
                'description' => $data['weather'][0]['description'],
                'humidity' => $data['main']['humidity'],
                'icon' => $data['weather'][0]['icon']
            ]);
        }
        
        return response()->json(['error' => 'Gagal mengambil data cuaca'], 500);
    }
}