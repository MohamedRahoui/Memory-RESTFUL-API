<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->middleware('staff')->except(['getMoods', 'getDelay']);
        $this->path = config_path('settings.json');
    }

    public function getMoods()
    {
        $settings = json_decode(file_get_contents($this->path), true);
        return response()->json([
            "moods" => $settings["moods"]
        ]);
    }

    public function setMoods(Request $request)
    {
        $this->validate($request, [
            'moods' => 'array'
        ]);

        $settings = json_decode(file_get_contents($this->path), true);
        $settings["moods"] = $request->moods;
        file_put_contents($this->path, json_encode($settings));
        return response()->json([
            "moods" => $settings["moods"]
        ]);
    }

    public function getDelay()
    {
        $settings = json_decode(file_get_contents($this->path), true);
        return response()->json([
            "delay" => $settings["delay"]
        ]);
    }

    public function setDelay(Request $request)
    {
        $this->validate($request, [
            'delay' => 'required|integer'
        ]);

        $settings = json_decode(file_get_contents($this->path), true);
        $settings["delay"] = $request->delay;
        file_put_contents($this->path, json_encode($settings));
        return response()->json([
            "delay" => $settings["delay"]
        ]);
    }
}
