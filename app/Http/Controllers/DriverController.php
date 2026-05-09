<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        return view('driver.index');
    }

    public function updateLocation(\Illuminate\Http\Request $request)
    {
        // If status is passed (like 'delivered' button click)
        if ($request->has('status')) {
            $delivery = \App\Models\Delivery::latest()->first();
            if ($delivery) {
                $delivery->update(['status' => $request->status]);
            }
            return response()->json(['status' => 'status_updated']);
        }

        // Standard GPS update
        $delivery = \App\Models\Delivery::where('status', 'transit')->first();
        if ($delivery && $request->has('lat')) {
            $delivery->update([
                'lat' => $request->lat,
                'lng' => $request->lng
            ]);
        }
        return response()->json(['status' => 'updated']);
    }

    public function getLocation()
    {
        $delivery = \App\Models\Delivery::where('status', 'transit')->first();
        if ($delivery && $delivery->lat && $delivery->lng) {
            return response()->json([
                'lat' => $delivery->lat,
                'lng' => $delivery->lng,
                'driver' => 'Driver ' . ($delivery->sppg->name ?? 'BGN')
            ]);
        }
        return response()->json(['lat' => null]);
    }
}
