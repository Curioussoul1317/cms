<?php

namespace App\Http\Controllers;

use App\Models\CorprofilePage;
use App\Models\CorprofileObjective;
use App\Models\CorprofileStrategy;
use App\Models\CorprofileValue;
use App\Models\CorprofilePrinciple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CorprofileController extends Controller
{
    public function index()
    {
        $pages = CorprofilePage::with(['objectives', 'strategies', 'values', 'principles'])
            ->latest()
            ->paginate(10);
        
        return view('corprofile.index', compact('pages'));
    }

    public function create()
    {
        return view('corprofile.create');
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'video' => 'nullable|file|mimetypes:video/mp4,video/mpeg,video/quicktime|max:51200',
    //         'description' => 'nullable|string',
            
    //         'vision_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    //         'vision_text' => 'nullable|string',
            
    //         'mission_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    //         'mission_text' => 'nullable|string',
            
    //         'objectives_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    //         'objectives.*.title' => 'required|string|max:255',
    //         'objectives.*.description' => 'nullable|string',
            
    //         'strategies_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    //         'strategies.*' => 'required|string',
            
    //         'values_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    //         'values.*' => 'required|string',
            
    //         'principles_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    //         'principles.*' => 'required|string',
    //     ]);

    //     DB::beginTransaction();
    //     try {
    //         $data = [
    //             'description' => $request->description,
    //             'vision_text' => $request->vision_text,
    //             'mission_text' => $request->mission_text,
    //         ];

    //         // Handle file uploads
    //         if ($request->hasFile('video')) {
    //             $data['video'] = $request->file('video')->store('corprofile/videos', 'public');
    //         }
    //         if ($request->hasFile('vision_image')) {
    //             $data['vision_image'] = $request->file('vision_image')->store('corprofile/images', 'public');
    //         }
    //         if ($request->hasFile('mission_image')) {
    //             $data['mission_image'] = $request->file('mission_image')->store('corprofile/images', 'public');
    //         }
    //         if ($request->hasFile('objectives_image')) {
    //             $data['objectives_image'] = $request->file('objectives_image')->store('corprofile/images', 'public');
    //         }
    //         if ($request->hasFile('strategies_image')) {
    //             $data['strategies_image'] = $request->file('strategies_image')->store('corprofile/images', 'public');
    //         }
    //         if ($request->hasFile('values_image')) {
    //             $data['values_image'] = $request->file('values_image')->store('corprofile/images', 'public');
    //         }
    //         if ($request->hasFile('principles_image')) {
    //             $data['principles_image'] = $request->file('principles_image')->store('corprofile/images', 'public');
    //         }

    //         $page = CorprofilePage::create($data);

    //         // Create objectives
    //         if ($request->has('objectives')) {
    //             foreach ($request->objectives as $index => $objective) {
    //                 CorprofileObjective::create([
    //                     'corprofile_page_id' => $page->id,
    //                     'title' => $objective['title'],
    //                     'description' => $objective['description'] ?? null,
    //                     'order' => $index,
    //                 ]);
    //             }
    //         }

    //         // Create strategies
    //         if ($request->has('strategies')) {
    //             foreach ($request->strategies as $index => $text) {
    //                 CorprofileStrategy::create([
    //                     'corprofile_page_id' => $page->id,
    //                     'text' => $text,
    //                     'order' => $index,
    //                 ]);
    //             }
    //         }

    //         // Create values
    //         if ($request->has('values')) {
    //             foreach ($request->values as $index => $text) {
    //                 CorprofileValue::create([
    //                     'corprofile_page_id' => $page->id,
    //                     'text' => $text,
    //                     'order' => $index,
    //                 ]);
    //             }
    //         }

    //         // Create principles
    //         if ($request->has('principles')) {
    //             foreach ($request->principles as $index => $text) {
    //                 CorprofilePrinciple::create([
    //                     'corprofile_page_id' => $page->id,
    //                     'text' => $text,
    //                     'order' => $index,
    //                 ]);
    //             }
    //         }

    //         DB::commit();
    //         return redirect()->route('corprofile.index')->with('success', 'Corporate Profile created successfully!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return back()->with('error', 'Error creating profile: ' . $e->getMessage())->withInput();
    //     }
    // }

    public function store(Request $request)
{
    
    $validated = $request->validate([
        'video' => 'nullable|file|mimetypes:video/mp4,video/mpeg,video/quicktime|max:51200',
        'description' => 'nullable|string',
        
        'vision_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        'vision_text' => 'nullable|string',
        
        'mission_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        'mission_text' => 'nullable|string',
        
        'objectives_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        'objectives.*.title' => 'required|string|max:255',
        'objectives.*.description' => 'nullable|string',
        
        'strategies_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        'strategies.*' => 'required|string',
        
        'values_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        'values.*' => 'required|string',
        
        'principles_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        'principles.*' => 'required|string',
    ]);
    dd('Validation passed', $validated);
    DB::beginTransaction();
    try {
        $data = [
            'description' => $request->description,
            'vision_text' => $request->vision_text,
            'mission_text' => $request->mission_text,
            'created_by' => auth()->id(),
        ];

        // Handle file uploads
        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('corprofile/videos', 'public');
        }
        if ($request->hasFile('vision_image')) {
            $data['vision_image'] = $request->file('vision_image')->store('corprofile/images', 'public');
        }
        if ($request->hasFile('mission_image')) {
            $data['mission_image'] = $request->file('mission_image')->store('corprofile/images', 'public');
        }
        if ($request->hasFile('objectives_image')) {
            $data['objectives_image'] = $request->file('objectives_image')->store('corprofile/images', 'public');
        }
        if ($request->hasFile('strategies_image')) {
            $data['strategies_image'] = $request->file('strategies_image')->store('corprofile/images', 'public');
        }
        if ($request->hasFile('values_image')) {
            $data['values_image'] = $request->file('values_image')->store('corprofile/images', 'public');
        }
        if ($request->hasFile('principles_image')) {
            $data['principles_image'] = $request->file('principles_image')->store('corprofile/images', 'public');
        }

        $page = CorprofilePage::create($data);

        // Create objectives
        if ($request->has('objectives')) {
            foreach ($request->objectives as $index => $objective) {
                CorprofileObjective::create([
                    'corprofile_page_id' => $page->id,
                    'title' => $objective['title'],
                    'description' => $objective['description'] ?? null,
                    'order' => $index,
                    'created_by' => auth()->id(),
                ]);
            }
        }

        // Create strategies
        if ($request->has('strategies')) {
            foreach ($request->strategies as $index => $text) {
                CorprofileStrategy::create([
                    'corprofile_page_id' => $page->id,
                    'text' => $text,
                    'order' => $index,
                    'created_by' => auth()->id(),
                ]);
            }
        }

        // Create values
        if ($request->has('values')) {
            foreach ($request->values as $index => $text) {
                CorprofileValue::create([
                    'corprofile_page_id' => $page->id,
                    'text' => $text,
                    'order' => $index,
                    'created_by' => auth()->id(),
                ]);
            }
        }

        // Create principles
        if ($request->has('principles')) {
            foreach ($request->principles as $index => $text) {
                CorprofilePrinciple::create([
                    'corprofile_page_id' => $page->id,
                    'text' => $text,
                    'order' => $index,
                    'created_by' => auth()->id(),
                ]);
            }
        }

        DB::commit();
        return redirect()->route('corprofile.index')->with('success', 'Corporate Profile created successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Error creating profile: ' . $e->getMessage())->withInput();
    }
}
    public function show(CorprofilePage $corprofile)
    {
        $corprofile->load(['objectives', 'strategies', 'values', 'principles']);
        return view('corprofile.show', compact('corprofile'));
    }

    public function edit(CorprofilePage $corprofile)
    {
        $corprofile->load(['objectives', 'strategies', 'values', 'principles']);
        return view('corprofile.edit', compact('corprofile'));
    }

    public function update(Request $request, CorprofilePage $corprofile)
    {
        $validated = $request->validate([
            'video' => 'nullable|file|mimetypes:video/mp4,video/mpeg,video/quicktime|max:51200',
            'description' => 'nullable|string',
            
            'vision_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'vision_text' => 'nullable|string',
            
            'mission_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'mission_text' => 'nullable|string',
            
            'objectives_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'objectives.*.title' => 'required|string|max:255',
            'objectives.*.description' => 'nullable|string',
            
            'strategies_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'strategies.*' => 'required|string',
            
            'values_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'values.*' => 'required|string',
            
            'principles_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'principles.*' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'description' => $request->description,
                'vision_text' => $request->vision_text,
                'mission_text' => $request->mission_text,
            ];

            // Handle file uploads and delete old files
            if ($request->hasFile('video')) {
                if ($corprofile->video) {
                    Storage::disk('public')->delete($corprofile->video);
                }
                $data['video'] = $request->file('video')->store('corprofile/videos', 'public');
            }
            if ($request->hasFile('vision_image')) {
                if ($corprofile->vision_image) {
                    Storage::disk('public')->delete($corprofile->vision_image);
                }
                $data['vision_image'] = $request->file('vision_image')->store('corprofile/images', 'public');
            }
            if ($request->hasFile('mission_image')) {
                if ($corprofile->mission_image) {
                    Storage::disk('public')->delete($corprofile->mission_image);
                }
                $data['mission_image'] = $request->file('mission_image')->store('corprofile/images', 'public');
            }
            if ($request->hasFile('objectives_image')) {
                if ($corprofile->objectives_image) {
                    Storage::disk('public')->delete($corprofile->objectives_image);
                }
                $data['objectives_image'] = $request->file('objectives_image')->store('corprofile/images', 'public');
            }
            if ($request->hasFile('strategies_image')) {
                if ($corprofile->strategies_image) {
                    Storage::disk('public')->delete($corprofile->strategies_image);
                }
                $data['strategies_image'] = $request->file('strategies_image')->store('corprofile/images', 'public');
            }
            if ($request->hasFile('values_image')) {
                if ($corprofile->values_image) {
                    Storage::disk('public')->delete($corprofile->values_image);
                }
                $data['values_image'] = $request->file('values_image')->store('corprofile/images', 'public');
            }
            if ($request->hasFile('principles_image')) {
                if ($corprofile->principles_image) {
                    Storage::disk('public')->delete($corprofile->principles_image);
                }
                $data['principles_image'] = $request->file('principles_image')->store('corprofile/images', 'public');
            }

            $corprofile->update($data);

            // Update objectives
            $corprofile->objectives()->delete();
            if ($request->has('objectives')) {
                foreach ($request->objectives as $index => $objective) {
                    CorprofileObjective::create([
                        'corprofile_page_id' => $corprofile->id,
                        'title' => $objective['title'],
                        'description' => $objective['description'] ?? null,
                        'order' => $index,
                    ]);
                }
            }

            // Update strategies
            $corprofile->strategies()->delete();
            if ($request->has('strategies')) {
                foreach ($request->strategies as $index => $text) {
                    CorprofileStrategy::create([
                        'corprofile_page_id' => $corprofile->id,
                        'text' => $text,
                        'order' => $index,
                    ]);
                }
            }

            // Update values
            $corprofile->values()->delete();
            if ($request->has('values')) {
                foreach ($request->values as $index => $text) {
                    CorprofileValue::create([
                        'corprofile_page_id' => $corprofile->id,
                        'text' => $text,
                        'order' => $index,
                    ]);
                }
            }

            // Update principles
            $corprofile->principles()->delete();
            if ($request->has('principles')) {
                foreach ($request->principles as $index => $text) {
                    CorprofilePrinciple::create([
                        'corprofile_page_id' => $corprofile->id,
                        'text' => $text,
                        'order' => $index,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('corprofile.index')->with('success', 'Corporate Profile updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating profile: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(CorprofilePage $corprofile)
    {
        try {
            // Delete all associated files
            if ($corprofile->video) {
                Storage::disk('public')->delete($corprofile->video);
            }
            if ($corprofile->vision_image) {
                Storage::disk('public')->delete($corprofile->vision_image);
            }
            if ($corprofile->mission_image) {
                Storage::disk('public')->delete($corprofile->mission_image);
            }
            if ($corprofile->objectives_image) {
                Storage::disk('public')->delete($corprofile->objectives_image);
            }
            if ($corprofile->strategies_image) {
                Storage::disk('public')->delete($corprofile->strategies_image);
            }
            if ($corprofile->values_image) {
                Storage::disk('public')->delete($corprofile->values_image);
            }
            if ($corprofile->principles_image) {
                Storage::disk('public')->delete($corprofile->principles_image);
            }

            $corprofile->delete();
            return redirect()->route('corprofile.index')->with('success', 'Corporate Profile deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting profile: ' . $e->getMessage());
        }
    }
}