<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function getWeatherByCity(Request $request)
    {
        $city = $request->query('city', 'Bandung');
        
        $apiKey = env('OPENWEATHER_API_KEY');
        
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'id'
        ]);
        
        if ($response->successful()) {
            $data = $response->json();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'kota' => $data['name'],
                    'suhu' => $data['main']['temp'] . '°C',
                    'kondisi' => $data['weather'][0]['description'],
                ]
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Gagal mengambil data cuaca'
        ], 500);
    }
}