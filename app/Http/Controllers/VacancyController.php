<?php

 
namespace App\Http\Controllers;

use App\Models\Vacancy;
use App\Models\VacancyLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VacancyController extends Controller
{
    public function index()
    {
        $vacancies = Vacancy::with('location')->recent()->paginate(20);
        return view('vacancies.index', compact('vacancies'));
    }

    public function show(Request $request)
    {
        $search = $request->get('search');
        
        $vacancies = Vacancy::with('location')
            ->search($search)
            ->recent()
            ->get();

        return view('vacancies.show', compact('vacancies', 'search'));
    }

    public function create()
    {
        $locations = VacancyLocation::active()->get();
        return view('vacancies.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'posted_date' => 'required|date',
            'due_date' => 'required|date|after:posted_date',
            'salary' => 'required|string|max:255',
            'vacancylocation_id' => 'required|exists:mysql_cms.vacancylocations,id',
            'url' => 'nullable|url|max:255',
        ]);

        $validated['created_by'] = Auth::id();

        Vacancy::create($validated);

        return redirect()->route('vacancies.index')
            ->with('success', 'Vacancy created successfully.');
    }

    public function edit(Vacancy $vacancy)
    {
        $locations = VacancyLocation::active()->get();
        return view('vacancies.edit', compact('vacancy', 'locations'));
    }

    public function update(Request $request, Vacancy $vacancy)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'posted_date' => 'required|date',
            'due_date' => 'required|date|after:posted_date',
            'salary' => 'required|string|max:255',
            'vacancylocation_id' => 'required|exists:mysql_cms.vacancylocations,id',
            'url' => 'nullable|url|max:255',
        ]);

        $validated['updated_by'] = Auth::id();

        $vacancy->update($validated);

        return redirect()->route('vacancies.index')
            ->with('success', 'Vacancy updated successfully.');
    }

    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();

        return redirect()->route('vacancies.index')
            ->with('success', 'Vacancy deleted successfully.');
    }
}