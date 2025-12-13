<?php

 

namespace App\Http\Controllers;

use App\Models\VacancyLocation;
use Illuminate\Http\Request;

class VacancyLocationController extends Controller
{
    public function index()
    {
        $locations = VacancyLocation::withCount('vacancies')->get();
        return view('vacancies.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('vacancies.locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'location_name' => 'required|string|max:255|unique:mysql_cms.vacancylocations,location_name',
            'is_active' => 'nullable|boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['created_by'] = auth()->id();
        VacancyLocation::create($validated);

        return redirect()->route('vacancylocations.index')
            ->with('success', 'Location created successfully.');
    }

    public function edit(VacancyLocation $vacancylocation)
    {
        return view('vacancies.locations.edit', compact('vacancylocation'));
    }

    public function update(Request $request, VacancyLocation $vacancylocation)
    {
        $validated = $request->validate([
            'location_name' => 'required|string|max:255|unique:mysql_cms.vacancylocations,location_name,' . $vacancylocation->id,
            'is_active' => 'nullable|boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['updated_by'] = auth()->id();
        $vacancylocation->update($validated);

        return redirect()->route('vacancylocations.index')
            ->with('success', 'Location updated successfully.');
    }

    public function destroy(VacancyLocation $vacancylocation)
    {
        $vacancylocation->delete();

        return redirect()->route('vacancylocations.index')
            ->with('success', 'Location deleted successfully.');
    }
}