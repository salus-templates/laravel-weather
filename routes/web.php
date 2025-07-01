<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    Log::info('Weather app home page accessed');
    return view('welcome');
});

Route::get('/weather', static function () {
    Log::info('Weather endpoint accessed');
    return response()->json([
        [
            'location' => 'Cape Town',
            'temperature' => '22°C',
            'condition' => 'Sunny'
        ],
        [
            'location' => 'Lagos',
            'temperature' => '25°C',
            'condition' => 'Cloudy'
        ],
        [
            'location' => 'Nairobi',
            'temperature' => '18°C',
            'condition' => 'Rainy'
        ],
        [
            'location' => 'Accra',
            'temperature' => '30°C',
            'condition' => 'Sunny'
        ]
    ]);
});

Route::get('/weather/{city}', static function ($city) {
    Log::debug('Weather endpoint accessed for city: $city');
    switch (strtolower($city)) {
        case 'capetown':
            $weather = ['location' => 'Cape Town', 'temperature' => '22°C', 'condition' => 'Sunny'];
            break;
        case 'lagos':
            $weather = ['location' => 'Lagos', 'temperature' => '25°C', 'condition' => 'Cloudy'];
            break;
        case 'nairobi':
            $weather = ['location' => 'Nairobi', 'temperature' => '18°C', 'condition' => 'Rainy'];
            break;
        case 'accra':
            $weather = ['location' => 'Accra', 'temperature' => '30°C', 'condition' => 'Sunny'];
            break;
        default:
            Log::warning("Weather data requested for unknown city: $city");
            return response()->json(['error' => 'City not found'], 404);
    }

    Log::info("Weather data retrieved for $city");
    return response()->json($weather);
});

Route::get('/error', static function () {
    Log::error('This is a test error log');
    return response()->json(['error' => 'This is a test error log'], 500);
});

Route::post('/weather', static function (Illuminate\Http\Request $request) {
    Log::info('Weather data submission endpoint accessed');
    $data = $request->validate([
        'location' => 'required|string|max:255',
        'temperature' => 'required|string|max:10',
        'condition' => 'required|string|max:50',
    ]);

    Log::info('Weather data submitted', $data);
    return response()->json(['message' => 'Weather data saved successfully'], 201);
});


