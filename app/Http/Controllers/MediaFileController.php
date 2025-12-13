<?php

namespace App\Http\Controllers;
 

use App\Models\MediaFile;
use App\Models\MediaCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaFileController extends Controller
{
    public function index()
    {
        $files = MediaFile::with('category')->recent()->paginate(20);
        return view('mediacenter.files.index', compact('files'));
    }

    public function create()
    {
        $categories = MediaCategory::active()->ordered()->get();
        return view('mediacenter.files.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mediacategory_id' => 'required|exists:mysql_cms.mediacategories,id',
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'reference_number' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:10240', // 10MB max
            'is_active' => 'nullable|boolean'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $filePath = $file->store('mediafiles', 'public');
            
            $validated['file_path'] = $filePath;
            $validated['file_name'] = $originalName;
            $validated['file_size'] = round($file->getSize() / 1024); // Convert to KB
        }

        $validated['is_active'] = $request->has('is_active'); 
        $validated['created_by'] = auth()->id();
        MediaFile::create($validated);

        return redirect()->route('mediafiles.index')
            ->with('success', 'Media file uploaded successfully.');
    }

    public function edit(MediaFile $mediafile)
    {
        $categories = MediaCategory::active()->ordered()->get();
        return view('mediacenter.files.edit', compact('mediafile', 'categories'));
    }

    public function update(Request $request, MediaFile $mediafile)
    {
        $validated = $request->validate([
            'mediacategory_id' => 'required|exists:mysql_cms.mediacategories,id',
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'reference_number' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf|max:10240',
            'is_active' => 'nullable|boolean'
        ]);

        if ($request->hasFile('file')) {
            // Delete old file
            if ($mediafile->file_path) {
                Storage::disk('public')->delete($mediafile->file_path);
            }

            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $filePath = $file->store('mediafiles', 'public');
            
            $validated['file_path'] = $filePath;
            $validated['file_name'] = $originalName;
            $validated['file_size'] = round($file->getSize() / 1024);
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['updated_by'] = auth()->id();
        $mediafile->update($validated);

        return redirect()->route('mediafiles.index')
            ->with('success', 'Media file updated successfully.');
    }

    public function destroy(MediaFile $mediafile)
    {
        if ($mediafile->file_path) {
            Storage::disk('public')->delete($mediafile->file_path);
        }

        $mediafile->delete();

        return redirect()->route('mediafiles.index')
            ->with('success', 'Media file deleted successfully.');
    }

    public function download(MediaFile $mediafile)
    {
        if ($mediafile->file_path && Storage::disk('public')->exists($mediafile->file_path)) {
            return Storage::disk('public')->download($mediafile->file_path, $mediafile->file_name);
        }

        return back()->with('error', 'File not found.');
    }
}