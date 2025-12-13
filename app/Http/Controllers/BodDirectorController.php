<?php

namespace App\Http\Controllers;

use App\Models\BodDirector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BodDirectorController extends Controller
{
    public function index()
    {
        $directors = BodDirector::ordered()->paginate(10);
        return view('bod.index', compact('directors'));
    }

    public function create()
    {
        return view('bod.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);
    
        try {
            $data = [
                'name' => $request->name,
                'title' => $request->title,
                'description' => $request->description,
                'order' => $request->order ?? 0,
                'is_active' => $request->has('is_active'),
                'created_by' => auth()->id(),
            ];
    
            // Handle image upload
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('bod/directors', 'public');
            }
    
            BodDirector::create($data);
    
            return redirect()->route('bod.index')->with('success', 'Director added successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error adding director: ' . $e->getMessage())->withInput();
        }
    }

    public function show(BodDirector $bod)
    {
        $directors = BodDirector::active()->ordered()->get();
        return view('bod.show', compact('directors'));
    }

    public function edit(BodDirector $bod)
    {
        return view('bod.edit', compact('bod'));
    }

    public function update(Request $request, BodDirector $bod)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $data = [
                'name' => $request->name,
                'title' => $request->title,
                'description' => $request->description,
                'order' => $request->order ?? 0,
                'is_active' => $request->has('is_active'),
                'updated_by' => auth()->id(), 
            ];

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($bod->image) {
                    Storage::disk('public')->delete($bod->image);
                }
                $data['image'] = $request->file('image')->store('bod/directors', 'public');
            }

            $bod->update($data);

            return redirect()->route('bod.index')->with('success', 'Director updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating director: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(BodDirector $bod)
    {
        try {
            // Delete image
            if ($bod->image) {
                Storage::disk('public')->delete($bod->image);
            }

            $bod->delete();
            return redirect()->route('bod.index')->with('success', 'Director deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting director: ' . $e->getMessage());
        }
    }
}