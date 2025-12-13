<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\LinkContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LinkContentController extends Controller
{
    public function index(Link $link)
    {
        $link->load(['contents' => function($query) {
            $query->orderBy('order');
        }, 'subCategory.mainCategory']);
        
        return view('link-contents.index', compact('link'));
    }

    public function selectTemplate(Link $link)
    {
        $templates = config('templates');
        return view('link-contents.select-template', compact('link', 'templates'));
    }

    public function create(Link $link, Request $request)
    {
        $templates = config('templates');
        $templateName = $request->get('template');
        
        if ($templateName && !isset($templates[$templateName])) {
            return redirect()->route('link-contents.create', $link)
                ->with('error', 'Invalid template selected.');
        }

        $template = $templateName ? $templates[$templateName] : null;
        
        return view('link-contents.create', compact('link', 'templates', 'template', 'templateName'));
    }

    public function store(Request $request, Link $link)
    {
        // Get template configuration
        $templateName = $request->input('template');
        $template = config('templates.' . $templateName);
        
        // Check if template exists
        if (!$template) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Invalid template selected.');
        }
        
        // Build validation rules
        $rules = [
            'template' => 'required|string',
            'data' => 'nullable|array',
        ];
        
        // Add validation rules for each field
        foreach ($template['fields'] as $field) {
            if ($field['type'] === 'file') {
                // File upload validation
                if ($field['required'] ?? false) {
                    $rules[$field['name']] = 'required|file|max:10240'; // 10MB max
                } else {
                    $rules[$field['name']] = 'nullable|file|max:10240';
                }
                
                // Add specific mime type validation
                if (!empty($field['accept'])) {
                    if (str_contains($field['accept'], 'image')) {
                        $rules[$field['name']] .= '|mimes:jpg,jpeg,png,gif,webp,svg';
                    } elseif (str_contains($field['accept'], 'pdf') || str_contains($field['accept'], '.pdf')) {
                        $rules[$field['name']] .= '|mimes:pdf,doc,docx,xls,xlsx,txt';
                    }
                }
            } elseif ($field['type'] === 'repeater') {
                // Skip repeater validation here, handle nested fields
                continue;
            } else {
                // Regular field validation
                $fieldRule = [];
                
                if ($field['required'] ?? false) {
                    $fieldRule[] = 'required';
                } else {
                    $fieldRule[] = 'nullable';
                }
                
                if ($field['type'] === 'url') {
                    $fieldRule[] = 'url';
                } elseif ($field['type'] === 'email') {
                    $fieldRule[] = 'email';
                }
                
                if (!empty($fieldRule)) {
                    $rules['data.' . $field['name']] = implode('|', $fieldRule);
                }
            }
        }
        
        $validated = $request->validate($rules);
        
        // Prepare data array
        $data = $request->input('data', []);
        
        // Handle file uploads
        foreach ($template['fields'] as $field) {
            if ($field['type'] === 'file' && $request->hasFile($field['name'])) {
                $file = $request->file($field['name']);
                
                // Store file in public disk
                $path = $file->store('link-contents/' . $link->id, 'public');
                
                // Save the path and original filename in data
                $data[$field['name']] = $path;
                $data[$field['name'] . '_original_name'] = $file->getClientOriginalName();
            }
        }
        
        // Create the content - using template_name field
        $content = $link->contents()->create([
            'template_name' => $templateName,  // Changed from 'template' to 'template_name'
            'data' => $data,
            'order' => $link->contents()->max('order') + 1,
        ]);
        
        // return redirect()
        //     ->route('links.show', $link)
        //     ->with('success', 'Content added successfully!');
            return redirect()->route('link-contents.index', $link)
            ->with('success', 'Content added successfully.');
    } 
     
    public function edit(Link $link, LinkContent $linkContent)
    {
        $templateName = $linkContent->template_name;  // Changed from 'template' to 'template_name'
        $template = config("templates.{$templateName}");
        
        if (!$template) {
            return redirect()->route('links.show', $link)
                ->with('error', 'Template not found.');
        }

        return view('link-contents.edit', compact('link', 'linkContent', 'templateName', 'template'));
    }

    public function update(Request $request, Link $link, LinkContent $linkContent)
{
    // Get template configuration - using template_name field
    $templateName = $linkContent->template_name;
    $template = config('templates.' . $templateName);
    
    // Check if template exists
    if (!$template) {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Invalid template configuration.');
    }
    
    // Build validation rules
    $rules = [
        'data' => 'nullable|array',
    ];
    
    // Add validation rules for each field
    foreach ($template['fields'] as $field) {
        if ($field['type'] === 'file') {
            // File upload validation (optional on update)
            $rules[$field['name']] = 'nullable|file|max:10240';
            
            // Add specific mime type validation
            if (!empty($field['accept'])) {
                if (str_contains($field['accept'], 'image')) {
                    $rules[$field['name']] .= '|mimes:jpg,jpeg,png,gif,webp,svg';
                } elseif (str_contains($field['accept'], 'pdf') || str_contains($field['accept'], '.pdf')) {
                    $rules[$field['name']] .= '|mimes:pdf,doc,docx,xls,xlsx,txt';
                }
            }
        } elseif ($field['type'] === 'repeater') {
            // Skip repeater validation
            continue;
        } else {
            // Regular field validation
            $fieldRule = [];
            
            if ($field['required'] ?? false) {
                $fieldRule[] = 'required';
            } else {
                $fieldRule[] = 'nullable';
            }
            
            if ($field['type'] === 'url') {
                $fieldRule[] = 'url';
            } elseif ($field['type'] === 'email') {
                $fieldRule[] = 'email';
            }
            
            if (!empty($fieldRule)) {
                $rules['data.' . $field['name']] = implode('|', $fieldRule);
            }
        }
    }
    
    // Validate with error messages
    try {
        $validated = $request->validate($rules);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()
            ->back()
            ->withInput()
            ->withErrors($e->errors())
            ->with('error', 'Please fix the validation errors.');
    }
    
    // Prepare data array
    $data = $request->input('data', []);
    
    // Handle file uploads
    foreach ($template['fields'] as $field) {
        if ($field['type'] === 'file') {
            if ($request->hasFile($field['name'])) {
                // Delete old file if exists
                if (!empty($linkContent->data[$field['name']])) {
                    Storage::disk('public')->delete($linkContent->data[$field['name']]);
                }
                
                // Store new file
                $file = $request->file($field['name']);
                $path = $file->store('link-contents/' . $link->id, 'public');
                
                // Save the path and original filename
                $data[$field['name']] = $path;
                $data[$field['name'] . '_original_name'] = $file->getClientOriginalName();
            } else {
                // Keep existing file path if no new file uploaded
                if (!empty($linkContent->data[$field['name']])) {
                    $data[$field['name']] = $linkContent->data[$field['name']];
                    if (!empty($linkContent->data[$field['name'] . '_original_name'])) {
                        $data[$field['name'] . '_original_name'] = $linkContent->data[$field['name'] . '_original_name'];
                    }
                }
            }
        }
    }
    
    // Update the content
    $linkContent->update([
        'data' => $data,
    ]);
    
    // return redirect()
    //     ->route('links.show', $link)
    //     ->with('success', 'Content updated successfully!');
            return redirect()->route('link-contents.index', $link)
            ->with('success', 'Content updated successfully.');
}
   
    public function destroy(Link $link, LinkContent $content)
    {
        // Get template configuration - using template_name field
        $template = config('templates.' . $content->template_name);  // Changed from 'template' to 'template_name'
        
        // Delete associated files if template exists
        if ($template && isset($template['fields'])) {
            foreach ($template['fields'] as $field) {
                if ($field['type'] === 'file' && !empty($content->data[$field['name']])) {
                    Storage::disk('public')->delete($content->data[$field['name']]);
                }
            }
        }
        
        $content->delete();
        
        return redirect()
            ->route('links.show', $link)
            ->with('success', 'Content deleted successfully!');
    }
    
    public function updateOrder(Request $request, Link $link)
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:link_contents,id'
        ]);

        foreach ($validated['order'] as $index => $contentId) {
            LinkContent::where('id', $contentId)
                ->where('link_id', $link->id)
                ->update(['order' => $index]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully'
        ]);
    }
}