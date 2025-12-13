<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PlaceController extends Controller
{
    /**
     * Display a listing of places (Admin)
     */
    public function index(Request $request)
    {
        $query = Place::with('location')->ordered();

        if ($request->has('location_id') && $request->location_id) {
            $query->where('location_id', $request->location_id);
        }

        $places = $query->paginate(10);
        $locations = Location::ordered()->get();

        return view('admin.places.index', compact('places', 'locations'));
    }

    /**
     * Show the form for creating a new place
     */
    public function create()
    {
        $locations = Location::active()->ordered()->get();
        
        return view('admin.places.create', compact('locations'));
    }

    /**
     * Store a newly created place
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'location_id' => 'required|exists:mysql_cms.locations,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:mysql_cms.places',
            'opening_hours' => 'nullable|array',
            'opening_hours.*.days' => 'required_with:opening_hours|array',
            'opening_hours.*.open' => 'nullable|string',
            'opening_hours.*.close' => 'nullable|string',
            'opening_hours.*.closed' => 'nullable|boolean',
            'phone_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('places', 'public');
        }

        // Process opening hours from form
        if ($request->has('hours')) {
            $validated['opening_hours'] = $this->processOpeningHours($request->input('hours'));
        }
        $validated['created_by'] = auth()->id();
        Place::create($validated);

        return redirect()->route('admin.places.index')
            ->with('success', 'Place created successfully.');
    }

    /**
     * Display the specified place (Admin)
     */
    public function show(Place $place)
    {
        $place->load('location');
        
        return view('admin.places.show', compact('place'));
    }

    /**
     * Show the form for editing the specified place
     */
    public function edit(Place $place)
    {
        $locations = Location::active()->ordered()->get();
        
        return view('admin.places.edit', compact('place', 'locations'));
    }

    /**
     * Update the specified place
     */
    public function update(Request $request, Place $place)
    {
        $validated = $request->validate([
            'location_id' => 'required|exists:mysql_cms.locations,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:mysql_cms.places,slug,' . $place->id,
            'opening_hours' => 'nullable|array',
            'phone_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($place->image) {
                Storage::disk('public')->delete($place->image);
            }
            $validated['image'] = $request->file('image')->store('places', 'public');
        }

        // Process opening hours from form
        if ($request->has('hours')) {
            $validated['opening_hours'] = $this->processOpeningHours($request->input('hours'));
        }
        $validated['updated_by'] = auth()->id();
        $place->update($validated);

        return redirect()->route('admin.places.index')
            ->with('success', 'Place updated successfully.');
    }

    /**
     * Remove the specified place
     */
    public function destroy(Place $place)
    {
        // Delete image if exists
        if ($place->image) {
            Storage::disk('public')->delete($place->image);
        }

        $place->delete();

        return redirect()->route('admin.places.index')
            ->with('success', 'Place deleted successfully.');
    }

    /**
     * Process opening hours from form input
     */
    private function processOpeningHours(array $hours): array
    {
        $processed = [];

        foreach ($hours as $schedule) {
            if (!empty($schedule['days'])) {
                $entry = [
                    'days' => $schedule['days'],
                ];

                if (isset($schedule['closed']) && $schedule['closed']) {
                    $entry['closed'] = true;
                } else {
                    $entry['open'] = $schedule['open'] ?? '09:00';
                    $entry['close'] = $schedule['close'] ?? '17:00';
                }

                $processed[] = $entry;
            }
        }

        return $processed;
    }
}