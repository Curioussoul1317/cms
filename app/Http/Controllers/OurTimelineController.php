<?php

namespace App\Http\Controllers; 

use App\Models\OurTimelineItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OurTimelineController extends Controller
{
    public function index()
    {
        $items = OurTimelineItem::orderBy('year', 'desc')
            ->orderBy('date', 'desc')
            ->orderBy('order', 'asc')
            ->get();
        
        return view('ourtimeline.index', compact('items'));
    }

    public function show()
    {
        $timelineItems = OurTimelineItem::orderBy('year', 'desc')
            ->orderBy('date', 'desc')
            ->orderBy('order', 'asc')
            ->get();
        
        // Group by year
        $groupedByYear = $timelineItems->groupBy('year');
        
        return view('ourtimeline.show', compact('groupedByYear'));
    }

    public function create()
    {
        return view('ourtimeline.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:1900|max:2100',
            'date' => 'required|date',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer',
            
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('ourtimeline', 'public');
        }

        $validated['created_by'] = auth()->id();
        OurTimelineItem::create($validated);

        return redirect()->route('ourtimeline.index')
            ->with('success', 'Timeline item created successfully.'); 
    }

    public function edit(OurTimelineItem $ourtimeline)
    {
        return view('ourtimeline.edit', compact('ourtimeline'));
    }

    public function update(Request $request, OurTimelineItem $ourtimeline)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:1900|max:2100',
            'date' => 'required|date',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($ourtimeline->image) {
                Storage::disk('public')->delete($ourtimeline->image);
            }
            $validated['image'] = $request->file('image')->store('ourtimeline', 'public');
        }

        $validated['updated_by'] = auth()->id();
        $ourtimeline->update($validated);

        return redirect()->route('ourtimeline.index')
            ->with('success', 'Timeline item updated successfully.');
    }

    public function destroy(OurTimelineItem $ourtimeline)
    {
        if ($ourtimeline->image) {
            Storage::disk('public')->delete($ourtimeline->image);
        }

        $ourtimeline->delete();

        return redirect()->route('ourtimeline.index')
            ->with('success', 'Timeline item deleted successfully.');
    }
}