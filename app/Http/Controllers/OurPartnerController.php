<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
  
use App\Models\OurPartner; 
use Illuminate\Support\Facades\Storage;

class OurPartnerController extends Controller
{
    public function index()
    {
        $partners = OurPartner::ordered()->get();
        return view('ourpartners.index', compact('partners'));
    }

    public function show()
    {
        $partners = OurPartner::active()->ordered()->get();
        return view('ourpartners.show', compact('partners'));
    }

    public function create()
    {
        return view('ourpartners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('ourpartners', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? true : false;
        $validated['created_by'] = auth()->id();
        OurPartner::create($validated);

        return redirect()->route('ourpartners.index')
            ->with('success', 'Partner added successfully.');
    }

    public function edit(OurPartner $ourpartner)
    {
        return view('ourpartners.edit', compact('ourpartner'));
    }

    public function update(Request $request, OurPartner $ourpartner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($ourpartner->image) {
                Storage::disk('public')->delete($ourpartner->image);
            }
            $validated['image'] = $request->file('image')->store('ourpartners', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? true : false;
        $validated['updated_by'] = auth()->id();
        $ourpartner->update($validated);

        return redirect()->route('ourpartners.index')
            ->with('success', 'Partner updated successfully.');
    }

    public function destroy(OurPartner $ourpartner)
    {
        if ($ourpartner->image) {
            Storage::disk('public')->delete($ourpartner->image);
        }

        $ourpartner->delete();

        return redirect()->route('ourpartners.index')
            ->with('success', 'Partner deleted successfully.');
    }
}