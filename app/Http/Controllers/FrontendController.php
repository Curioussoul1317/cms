<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Place;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Display the main locations map page
     */
    public function locationsMap()
    {
        $locations = Location::active()
            ->ordered()
            ->withCount('places')
            ->get();

        return view('frontend.locations-map', compact('locations'));
    }

    /**
     * Get places for a specific location (AJAX)
     */
    public function getPlacesByLocation($id)
    {
        $location = Location::with(['activePlaces' => function($query) {
            $query->ordered();
        }])->find($id);

        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'Location not found',
                'places' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'location' => $location,
            'places' => $location->activePlaces,
            'html' => view('frontend.partials.places-cards', [
                'places' => $location->activePlaces,
                'location' => $location
            ])->render()
        ]);
    }

    /**
     * Get places by location slug (AJAX)
     */
    public function getPlacesBySlug($slug)
    {
        $location = Location::where('slug', $slug)
            ->with(['activePlaces' => function($query) {
                $query->ordered();
            }])->first();

        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'Location not found',
                'places' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'location' => $location,
            'places' => $location->activePlaces,
            'html' => view('frontend.partials.places-cards', [
                'places' => $location->activePlaces,
                'location' => $location
            ])->render()
        ]);
    }

    /**
     * Show single place details
     */
    public function showPlace(Location $location, Place $place)
    {
        return view('frontend.place-detail', compact('location', 'place'));
    }

    /**
     * Get all places (AJAX)
     */
    public function getAllPlaces()
    {
        $places = Place::with('location')
            ->active()
            ->ordered()
            ->get();

        return response()->json([
            'success' => true,
            'places' => $places,
            'html' => view('frontend.partials.places-cards', [
                'places' => $places,
                'location' => null
            ])->render()
        ]);
    }
}