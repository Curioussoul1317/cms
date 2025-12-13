<?php

namespace App\Http\Controllers;

use App\Models\CorprofilePage;
use App\Models\CorprofileObjective;
use App\Models\CorprofileStrategy;
use App\Models\CorprofileValue;
use App\Models\CorprofilePrinciple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CorprofileController extends Controller
{
    
    public function index()
    {
        $page = CorprofilePage::first();
      
        if (!$page) {
            $page = CorprofilePage::create([
                'created_by' => auth()->id(),
            ]);
    
            return redirect()->route('corprofile.edit', $page->id)
                ->with('success', 'Profile created. Now fill in the sections below.');
        }
    
     
        return redirect()->route('corprofile.edit', $page->id);
    }

    // public function create()
    // {
    //     return view('corprofile.create');
    // }

 

    public function edit(CorprofilePage $corprofile)
    {
        $corprofile->load(['objectives', 'strategies', 'values', 'principles']);
        return view('corprofile.edit', compact('corprofile'));
    }

    /**
     * Update Basic Info (Video & Description)
     */
    public function updateBasicInfo(Request $request, CorprofilePage $corprofile)
    {
        $validated = $request->validate([
            'video' => 'nullable|file|mimetypes:video/mp4,video/mpeg,video/quicktime|max:51200',
            'description' => 'nullable|string',
        ]);

        $data = [
            'description' => $request->description,
            'updated_by' => auth()->id(),
        ];

        if ($request->hasFile('video')) {
            if ($corprofile->video) {
                Storage::disk('public')->delete($corprofile->video);
            }
            $data['video'] = $request->file('video')->store('corprofile/videos', 'public');
        }

        $corprofile->update($data);

        return back()->with('success', 'Basic information updated successfully!');
    }

    /**
     * Update Vision Section
     */
    public function updateVision(Request $request, CorprofilePage $corprofile)
    {
        $validated = $request->validate([
            'vision_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'vision_text' => 'nullable|string',
        ]);

        $data = [
            'vision_text' => $request->vision_text,
            'updated_by' => auth()->id(),
        ];

        if ($request->hasFile('vision_image')) {
            if ($corprofile->vision_image) {
                Storage::disk('public')->delete($corprofile->vision_image);
            }
            $data['vision_image'] = $request->file('vision_image')->store('corprofile/images', 'public');
        }

        $corprofile->update($data);

        return back()->with('success', 'Vision updated successfully!');
    }

    /**
     * Update Mission Section
     */
    public function updateMission(Request $request, CorprofilePage $corprofile)
    {
        $validated = $request->validate([
            'mission_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'mission_text' => 'nullable|string',
        ]);

        $data = [
            'mission_text' => $request->mission_text,
            'updated_by' => auth()->id(),
        ];

        if ($request->hasFile('mission_image')) {
            if ($corprofile->mission_image) {
                Storage::disk('public')->delete($corprofile->mission_image);
            }
            $data['mission_image'] = $request->file('mission_image')->store('corprofile/images', 'public');
        }

        $corprofile->update($data);

        return back()->with('success', 'Mission updated successfully!');
    }

    /**
     * Update Objectives Section
     */
    public function updateObjectives(Request $request, CorprofilePage $corprofile)
    {
        $validated = $request->validate([
            'objectives_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'objectives.*.title' => 'required|string|max:255',
            'objectives.*.description' => 'nullable|string',
        ]);

        if ($request->hasFile('objectives_image')) {
            if ($corprofile->objectives_image) {
                Storage::disk('public')->delete($corprofile->objectives_image);
            }
            $corprofile->objectives_image = $request->file('objectives_image')->store('corprofile/images', 'public');
        }

        $corprofile->updated_by = auth()->id();
        $corprofile->save();

        // Delete existing and recreate
        $corprofile->objectives()->delete();

        if ($request->has('objectives')) {
            foreach ($request->objectives as $index => $objective) {
                if (!empty($objective['title'])) {
                    CorprofileObjective::create([
                        'corprofile_page_id' => $corprofile->id,
                        'title' => $objective['title'],
                        'description' => $objective['description'] ?? null,
                        'order' => $index,
                        'created_by' => auth()->id(),
                    ]);
                }
            }
        }

        return back()->with('success', 'Objectives updated successfully!');
    }

    /**
     * Update Strategies Section
     */
    public function updateStrategies(Request $request, CorprofilePage $corprofile)
    {
        $validated = $request->validate([
            'strategies_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'strategies.*' => 'required|string',
        ]);

        if ($request->hasFile('strategies_image')) {
            if ($corprofile->strategies_image) {
                Storage::disk('public')->delete($corprofile->strategies_image);
            }
            $corprofile->strategies_image = $request->file('strategies_image')->store('corprofile/images', 'public');
        }

        $corprofile->updated_by = auth()->id();
        $corprofile->save();

        // Delete existing and recreate
        $corprofile->strategies()->delete();

        if ($request->has('strategies')) {
            foreach ($request->strategies as $index => $text) {
                if (!empty($text)) {
                    CorprofileStrategy::create([
                        'corprofile_page_id' => $corprofile->id,
                        'text' => $text,
                        'order' => $index,
                        'created_by' => auth()->id(),
                    ]);
                }
            }
        }

        return back()->with('success', 'Strategies updated successfully!');
    }

    /**
     * Update Values Section
     */
    public function updateValues(Request $request, CorprofilePage $corprofile)
    {
        $validated = $request->validate([
            'values_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'values.*' => 'required|string',
        ]);

        if ($request->hasFile('values_image')) {
            if ($corprofile->values_image) {
                Storage::disk('public')->delete($corprofile->values_image);
            }
            $corprofile->values_image = $request->file('values_image')->store('corprofile/images', 'public');
        }

        $corprofile->updated_by = auth()->id();
        $corprofile->save();

        // Delete existing and recreate
        $corprofile->values()->delete();

        if ($request->has('values')) {
            foreach ($request->values as $index => $text) {
                if (!empty($text)) {
                    CorprofileValue::create([
                        'corprofile_page_id' => $corprofile->id,
                        'text' => $text,
                        'order' => $index,
                        'created_by' => auth()->id(),
                    ]);
                }
            }
        }

        return back()->with('success', 'Values updated successfully!');
    }

    /**
     * Update Principles Section
     */
    public function updatePrinciples(Request $request, CorprofilePage $corprofile)
    {
        $validated = $request->validate([
            'principles_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'principles.*' => 'required|string',
        ]);

        if ($request->hasFile('principles_image')) {
            if ($corprofile->principles_image) {
                Storage::disk('public')->delete($corprofile->principles_image);
            }
            $corprofile->principles_image = $request->file('principles_image')->store('corprofile/images', 'public');
        }

        $corprofile->updated_by = auth()->id();
        $corprofile->save();

        // Delete existing and recreate
        $corprofile->principles()->delete();

        if ($request->has('principles')) {
            foreach ($request->principles as $index => $text) {
                if (!empty($text)) {
                    CorprofilePrinciple::create([
                        'corprofile_page_id' => $corprofile->id,
                        'text' => $text,
                        'order' => $index,
                        'created_by' => auth()->id(),
                    ]);
                }
            }
        }

        return back()->with('success', 'Principles updated successfully!');
    }

    /**
     * Delete profile
     */
    public function destroy(CorprofilePage $corprofile)
    {
        // Delete files
        if ($corprofile->video) Storage::disk('public')->delete($corprofile->video);
        if ($corprofile->vision_image) Storage::disk('public')->delete($corprofile->vision_image);
        if ($corprofile->mission_image) Storage::disk('public')->delete($corprofile->mission_image);
        if ($corprofile->objectives_image) Storage::disk('public')->delete($corprofile->objectives_image);
        if ($corprofile->strategies_image) Storage::disk('public')->delete($corprofile->strategies_image);
        if ($corprofile->values_image) Storage::disk('public')->delete($corprofile->values_image);
        if ($corprofile->principles_image) Storage::disk('public')->delete($corprofile->principles_image);

        $corprofile->delete();

        return redirect()->route('corprofile.index')->with('success', 'Profile deleted successfully!');
    }
}