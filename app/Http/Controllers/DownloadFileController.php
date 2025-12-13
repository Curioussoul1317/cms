<?php

 

namespace App\Http\Controllers;

use App\Models\DownloadFile;
use App\Models\DownloadCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DownloadFileController extends Controller
{
    public function index()
    {
        $files = DownloadFile::with('category')->recent()->paginate(20);
        return view('downloads.files.index', compact('files'));
    }

    public function create()
    {
        $categories = DownloadCategory::active()->ordered()->get();
        return view('downloads.files.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'downloadcategory_id' => 'required|exists:mysql_cms.downloadcategories,id',
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'eng_file' => 'nullable|file|mimes:pdf|max:10240',
            'dhivehi_file' => 'nullable|file|mimes:pdf|max:10240',
            'is_active' => 'nullable|boolean'
        ]);

        if ($request->hasFile('eng_file')) {
            $validated['eng_file'] = $request->file('eng_file')->store('downloads/english', 'public');
        }

        if ($request->hasFile('dhivehi_file')) {
            $validated['dhivehi_file'] = $request->file('dhivehi_file')->store('downloads/dhivehi', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['created_by'] = Auth::id();

        DownloadFile::create($validated);

        return redirect()->route('downloadfiles.index')
            ->with('success', 'Download file created successfully.');
    }

    public function edit(DownloadFile $downloadfile)
    {
        $categories = DownloadCategory::active()->ordered()->get();
        return view('downloads.files.edit', compact('downloadfile', 'categories'));
    }

    public function update(Request $request, DownloadFile $downloadfile)
    {
        $validated = $request->validate([
            'downloadcategory_id' => 'required|exists:mysql_cms.downloadcategories,id',
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'eng_file' => 'nullable|file|mimes:pdf|max:10240',
            'dhivehi_file' => 'nullable|file|mimes:pdf|max:10240',
            'is_active' => 'nullable|boolean'
        ]);

        if ($request->hasFile('eng_file')) {
            if ($downloadfile->eng_file) {
                Storage::disk('public')->delete($downloadfile->eng_file);
            }
            $validated['eng_file'] = $request->file('eng_file')->store('downloads/english', 'public');
        }

        if ($request->hasFile('dhivehi_file')) {
            if ($downloadfile->dhivehi_file) {
                Storage::disk('public')->delete($downloadfile->dhivehi_file);
            }
            $validated['dhivehi_file'] = $request->file('dhivehi_file')->store('downloads/dhivehi', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['updated_by'] = Auth::id();

        $downloadfile->update($validated);

        return redirect()->route('downloadfiles.index')
            ->with('success', 'Download file updated successfully.');
    }

    public function destroy(DownloadFile $downloadfile)
    {
        if ($downloadfile->eng_file) {
            Storage::disk('public')->delete($downloadfile->eng_file);
        }
        if ($downloadfile->dhivehi_file) {
            Storage::disk('public')->delete($downloadfile->dhivehi_file);
        }

        $downloadfile->delete();

        return redirect()->route('downloadfiles.index')
            ->with('success', 'Download file deleted successfully.');
    }

    public function downloadEnglish(DownloadFile $downloadfile)
    {
        if ($downloadfile->eng_file && Storage::disk('public')->exists($downloadfile->eng_file)) {
            return Storage::disk('public')->download($downloadfile->eng_file);
        }

        return back()->with('error', 'File not found.');
    }

    public function downloadDhivehi(DownloadFile $downloadfile)
    {
        if ($downloadfile->dhivehi_file && Storage::disk('public')->exists($downloadfile->dhivehi_file)) {
            return Storage::disk('public')->download($downloadfile->dhivehi_file);
        }

        return back()->with('error', 'File not found.');
    }
}