<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherViewController extends Controller
{
    // Halaman utama form cek cuaca
    public function halamanCuaca()
    {
        return view('weather.form');
    }
    
    // Tampilkan hasil cuaca di view (untuk route /weather/{city})
    public function getWeatherView($city)
    {
        $apiKey = env('OPENWEATHER_API_KEY');
        
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q' => $city . ',ID',
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'id'
        ]);
        
        if ($response->successful()) {
            $data = $response->json();
            $weatherData = [
                'kota' => $data['name'],
                'suhu' => $data['main']['temp'],
                'kondisi' => $data['weather'][0]['description'],
                'kelembaban' => $data['main']['humidity'],
                'icon' => 'https://openweathermap.org/img/wn/' . $data['weather'][0]['icon'] . '.png'
            ];
            return view('weather.result', compact('weatherData'));
        }
        
        return view('weather.error', ['city' => $city]);
    }
    
    // API untuk cek cuaca via AJAX (return JSON)
    public function cekCuaca(Request $request)
    {
        $city = $request->query('city', 'Purwokerto');
        
        $apiKey = env('OPENWEATHER_API_KEY');
        
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q' => $city . ',ID',
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'id'
        ]);
        
        if ($response->successful()) {
            $data = $response->json();
            return response()->json([
                'success' => true,
                'kota' => $data['name'],
                'suhu' => $data['main']['temp'],
                'kondisi' => $data['weather'][0]['description'],
                'icon' => 'https://openweathermap.org/img/wn/' . $data['weather'][0]['icon'] . '.png'
            ]);
        }
        
        return response()->json(['success' => false, 'message' => 'Kota tidak ditemukan'], 404);
    }
}