<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\SubCategory;
use App\Models\LinkContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    /**
     * Show create form for content (works for both Link and SubCategory)
     */
    public function create(Request $request, $type, $id)
    {  
        $templates = config('templates');
        $templateName = $request->get('template');
        
        // Get the parent model (Link or SubCategory)
        $parent = $this->getParentModel($type, $id);
        
        if (!$parent) {
            return redirect()->back()->with('error', 'Parent not found.');
        }
        
        if ($templateName && !isset($templates[$templateName])) {
            return redirect()->route('content.create', ['type' => $type, 'id' => $id])
                ->with('error', 'Invalid template selected.');
        }

        $template = $templateName ? $templates[$templateName] : null;
        
        return view('contents.create', compact('parent', 'type', 'templates', 'template', 'templateName'));
    }

    /**
     * Store content
     */
    public function store(Request $request, $type, $id)
    {
        return("kj");
        $parent = $this->getParentModel($type, $id);
        
        if (!$parent) {
            return redirect()->back()->with('error', 'Parent not found.');
        }

        $templateName = $request->input('template');
        $template = config('templates.' . $templateName);
        
        if (!$template) {
            return redirect()->back()->withInput()->with('error', 'Invalid template selected.');
        }
        
        // Validation
        $rules = ['template' => 'required|string', 'data' => 'nullable|array'];
        
        foreach ($template['fields'] as $field) {
            if ($field['type'] === 'file') {
                if ($field['required'] ?? false) {
                    $rules[$field['name']] = 'required|file|max:10240';
                } else {
                    $rules[$field['name']] = 'nullable|file|max:10240';
                }
                
                if (!empty($field['accept'])) {
                    if (str_contains($field['accept'], 'image')) {
                        $rules[$field['name']] .= '|mimes:jpg,jpeg,png,gif,webp,svg';
                    } elseif (str_contains($field['accept'], 'pdf') || str_contains($field['accept'], '.pdf')) {
                        $rules[$field['name']] .= '|mimes:pdf,doc,docx,xls,xlsx,txt';
                    }
                }
            } elseif ($field['type'] !== 'repeater') {
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
        $data = $request->input('data', []);
        
        // Handle file uploads
        foreach ($template['fields'] as $field) {
            if ($field['type'] === 'file' && $request->hasFile($field['name'])) {
                $file = $request->file($field['name']);
                $path = $file->store('contents/' . $type . '/' . $id, 'public');
                $data[$field['name']] = $path;
                $data[$field['name'] . '_original_name'] = $file->getClientOriginalName();
            }
        }
        
        // Create content using polymorphic relationship
        $parent->contents()->create([
            'template_name' => $templateName,
            'data' => $data,
            'order' => $parent->contents()->max('order') + 1,
            'link_id' => $type === 'link' ? $id : null, // Keep for backward compatibility
        ]);
        
        return redirect()->route('content.index', ['type' => $type, 'id' => $id])
            ->with('success', 'Content added successfully!');
    }

    /**
     * Show all contents for a parent
     */
    public function index($type, $id)
    {
        $parent = $this->getParentModel($type, $id);
        
        if (!$parent) {
            return redirect()->back()->with('error', 'Parent not found.');
        }
        
        return view('contents.index', compact('parent', 'type'));
    }

    /**
     * Edit content
     */
    public function edit($type, $id, LinkContent $content)
    {
        $parent = $this->getParentModel($type, $id);
        
        if (!$parent) {
            return redirect()->back()->with('error', 'Parent not found.');
        }

        $templateName = $content->template_name;
        $template = config("templates.{$templateName}");
        
        if (!$template) {
            return redirect()->route('content.index', ['type' => $type, 'id' => $id])
                ->with('error', 'Template not found.');
        }

        return view('contents.edit', compact('parent', 'type', 'content', 'templateName', 'template'));
    }

    /**
     * Update content
     */
    public function update(Request $request, $type, $id, LinkContent $content)
    {
        $parent = $this->getParentModel($type, $id);
        
        if (!$parent) {
            return redirect()->back()->with('error', 'Parent not found.');
        }

        $templateName = $content->template_name;
        $template = config('templates.' . $templateName);
        
        if (!$template) {
            return redirect()->back()->withInput()->with('error', 'Invalid template configuration.');
        }
        
        // Validation
        $rules = ['data' => 'nullable|array'];
        
        foreach ($template['fields'] as $field) {
            if ($field['type'] === 'file') {
                $rules[$field['name']] = 'nullable|file|max:10240';
                
                if (!empty($field['accept'])) {
                    if (str_contains($field['accept'], 'image')) {
                        $rules[$field['name']] .= '|mimes:jpg,jpeg,png,gif,webp,svg';
                    } elseif (str_contains($field['accept'], 'pdf') || str_contains($field['accept'], '.pdf')) {
                        $rules[$field['name']] .= '|mimes:pdf,doc,docx,xls,xlsx,txt';
                    }
                }
            } elseif ($field['type'] !== 'repeater') {
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
        $data = $request->input('data', []);
        
        // Handle file uploads
        foreach ($template['fields'] as $field) {
            if ($field['type'] === 'file') {
                if ($request->hasFile($field['name'])) {
                    if (!empty($content->data[$field['name']])) {
                        Storage::disk('public')->delete($content->data[$field['name']]);
                    }
                    
                    $file = $request->file($field['name']);
                    $path = $file->store('contents/' . $type . '/' . $id, 'public');
                    $data[$field['name']] = $path;
                    $data[$field['name'] . '_original_name'] = $file->getClientOriginalName();
                } else {
                    if (!empty($content->data[$field['name']])) {
                        $data[$field['name']] = $content->data[$field['name']];
                        if (!empty($content->data[$field['name'] . '_original_name'])) {
                            $data[$field['name'] . '_original_name'] = $content->data[$field['name'] . '_original_name'];
                        }
                    }
                }
            }
        }
        
        $content->update(['data' => $data]);
        
        return redirect()->route('content.index', ['type' => $type, 'id' => $id])
            ->with('success', 'Content updated successfully!');
    }

    /**
     * Delete content
     */
    public function destroy($type, $id, LinkContent $content)
    {
        $template = config('templates.' . $content->template_name);
        
        if ($template && isset($template['fields'])) {
            foreach ($template['fields'] as $field) {
                if ($field['type'] === 'file' && !empty($content->data[$field['name']])) {
                    Storage::disk('public')->delete($content->data[$field['name']]);
                }
            }
        }
        
        $content->delete();
        
        return redirect()->route('content.index', ['type' => $type, 'id' => $id])
            ->with('success', 'Content deleted successfully!');
    }

    /**
     * Update content order
     */
    public function updateOrder(Request $request, $type, $id)
    {
        $parent = $this->getParentModel($type, $id);
        
        if (!$parent) {
            return response()->json(['success' => false, 'message' => 'Parent not found'], 404);
        }

        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:link_contents,id'
        ]);

        foreach ($validated['order'] as $index => $contentId) {
            LinkContent::where('id', $contentId)
                ->where('contentable_type', get_class($parent))
                ->where('contentable_id', $id)
                ->update(['order' => $index]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully'
        ]);
    }

    /**
     * Get parent model based on type
     */
    private function getParentModel($type, $id)
    {
        switch ($type) {
            case 'link':
                return Link::find($id);
            case 'sub-category':
                return SubCategory::find($id);
            default:
                return null;
        }
    }
}