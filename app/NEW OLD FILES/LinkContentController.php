<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\SubCategory;
use App\Models\LinkContent;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Storage;

class LinkContentController extends Controller
{
    public function index($type, $id)
    {
       
        $model = $this->getModel($type, $id);
        
        if (!$model) {
            return redirect()->route('categories.hierarchy')->with('error', 'Not found.');
        }
        
        $model->load(['contents' => function($query) {
            $query->orderBy('order');
        }]); 

        if ($type === 'link') {
            $model->load('subCategory.mainCategory'); 
        }else{ 
        }
         
     return view('link-contents.index', compact('model', 'type' ));
    }

    public function create(Request $request, $type, $id)
    {
         
        $templates = config('templates');
        $templateName = $request->get('template');
        
        $model = $this->getModel($type, $id);
        
        if (!$model) {
            return redirect()->route('categories.hierarchy')->with('error', 'Not found.');
        }
        
        if ($templateName && !isset($templates[$templateName])) {
            return redirect()->route('link-contents.create', ['type' => $type, 'id' => $id])
                ->with('error', 'Invalid template selected.');
        }

        $template = $templateName ? $templates[$templateName] : null;
        
        return view('link-contents.create', compact('model', 'type', 'templates', 'template', 'templateName'));
    }

    // public function store(Request $request, $type, $id)
    // { 
    //     $model = $this->getModel($type, $id);
        
    //     if (!$model) {
    //         return redirect()->route('categories.hierarchy')->with('error', 'Not found.');
    //     }

    //     $templateName = $request->input('template');
    //     $template = config('templates.' . $templateName);
        
    //     if (!$template) {
    //         return redirect()->back()->withInput()->with('error', 'Invalid template selected.');
    //     }
        
    //     // Build validation rules
    //     $rules = ['template' => 'required|string', 'data' => 'nullable|array'];
        
    //     foreach ($template['fields'] as $field) {
    //         if ($field['type'] === 'file') {
    //             if ($field['required'] ?? false) {
    //                 $rules[$field['name']] = 'required|file|max:10240';
    //             } else {
    //                 $rules[$field['name']] = 'nullable|file|max:10240';
    //             }
                
    //             if (!empty($field['accept'])) {
    //                 if (str_contains($field['accept'], 'image')) {
    //                     $rules[$field['name']] .= '|mimes:jpg,jpeg,png,gif,webp,svg';
    //                 } elseif (str_contains($field['accept'], 'pdf') || str_contains($field['accept'], '.pdf')) {
    //                     $rules[$field['name']] .= '|mimes:pdf,doc,docx,xls,xlsx,txt';
    //                 }
    //             }
    //         } elseif ($field['type'] === 'repeater') {
    //             continue;
    //         } else {
    //             $fieldRule = [];
    //             if ($field['required'] ?? false) {
    //                 $fieldRule[] = 'required';
    //             } else {
    //                 $fieldRule[] = 'nullable';
    //             }
                
    //             if ($field['type'] === 'url') {
    //                 $fieldRule[] = 'url';
    //             } elseif ($field['type'] === 'email') {
    //                 $fieldRule[] = 'email';
    //             }
                
    //             if (!empty($fieldRule)) {
    //                 $rules['data.' . $field['name']] = implode('|', $fieldRule);
    //             }
    //         }
    //     }
        
    //     $validated = $request->validate($rules);
    //     $data = $request->input('data', []);
        
    //     // Handle file uploads
    //     foreach ($template['fields'] as $field) {
    //         if ($field['type'] === 'file' && $request->hasFile($field['name'])) {
    //             $file = $request->file($field['name']);
    //             $path = $file->store('link-contents/' . $type . '/' . $id, 'public');
    //             $data[$field['name']] = $path;
    //             $data[$field['name'] . '_original_name'] = $file->getClientOriginalName();
    //         }
    //     }
        
    //     // Create content using polymorphic relationship
    //     $model->contents()->create([
    //         'template_name' => $templateName,
    //         'data' => $data,
    //         'order' => $model->contents()->max('order') + 1,
    //         'link_id' => $type === 'link' ? $id : null,
    //     ]);
        
    //     return redirect()->route('link-contents.index', ['type' => $type, 'id' => $id])
    //         ->with('success', 'Content added successfully!');
    // }
    // public function store(Request $request, $type, $id)
    // { 
    //     $model = $this->getModel($type, $id);
        
    //     if (!$model) {
    //         return redirect()->route('categories.hierarchy')->with('error', 'Not found.');
    //     }
    
    //     $templateName = $request->input('template');
    //     $template = config('templates.' . $templateName);
        
    //     if (!$template) {
    //         return redirect()->back()->withInput()->with('error', 'Invalid template selected.');
    //     }
        
    //     // Build validation rules
    //     $rules = ['template' => 'required|string', 'data' => 'nullable|array'];
        
    //     foreach ($template['fields'] as $field) {
    //         if ($field['type'] === 'file') {
    //             if ($field['required'] ?? false) {
    //                 $rules[$field['name']] = 'required|file|max:10240';
    //             } else {
    //                 $rules[$field['name']] = 'nullable|file|max:10240';
    //             }
                
    //             if (!empty($field['accept'])) {
    //                 if (str_contains($field['accept'], 'image')) {
    //                     $rules[$field['name']] .= '|mimes:jpg,jpeg,png,gif,webp,svg';
    //                 } elseif (str_contains($field['accept'], 'pdf') || str_contains($field['accept'], '.pdf')) {
    //                     $rules[$field['name']] .= '|mimes:pdf,doc,docx,xls,xlsx,txt';
    //                 }
    //             }
    //         } elseif ($field['type'] === 'repeater') {
    //             // Add validation for repeater fields
    //             foreach ($field['fields'] as $repeaterField) {
    //                 if ($repeaterField['type'] === 'file') {
    //                     $rules['data.' . $field['name'] . '.*.'. $repeaterField['name']] = 'nullable|file|max:10240';
                        
    //                     if (!empty($repeaterField['accept'])) {
    //                         if (str_contains($repeaterField['accept'], '.svg')) {
    //                             $rules['data.' . $field['name'] . '.*.'. $repeaterField['name']] .= '|mimes:svg';
    //                         } elseif (str_contains($repeaterField['accept'], 'image')) {
    //                             $rules['data.' . $field['name'] . '.*.'. $repeaterField['name']] .= '|mimes:jpg,jpeg,png,gif,webp,svg';
    //                         }
    //                     }
    //                 } else {
    //                     $fieldRule = [];
    //                     if ($repeaterField['required'] ?? false) {
    //                         $fieldRule[] = 'required';
    //                     } else {
    //                         $fieldRule[] = 'nullable';
    //                     }
                        
    //                     if (!empty($fieldRule)) {
    //                         $rules['data.' . $field['name'] . '.*.'. $repeaterField['name']] = implode('|', $fieldRule);
    //                     }
    //                 }
    //             }
    //         } else {
    //             $fieldRule = [];
    //             if ($field['required'] ?? false) {
    //                 $fieldRule[] = 'required';
    //             } else {
    //                 $fieldRule[] = 'nullable';
    //             }
                
    //             if ($field['type'] === 'url') {
    //                 $fieldRule[] = 'url';
    //             } elseif ($field['type'] === 'email') {
    //                 $fieldRule[] = 'email';
    //             }
                
    //             if (!empty($fieldRule)) {
    //                 $rules['data.' . $field['name']] = implode('|', $fieldRule);
    //             }
    //         }
    //     }
        
    //     $validated = $request->validate($rules);
    //     $data = $request->input('data', []);
        
    //     // Handle top-level file uploads
    //     foreach ($template['fields'] as $field) {
    //         if ($field['type'] === 'file' && $request->hasFile($field['name'])) {
    //             $file = $request->file($field['name']);
    //             $path = $file->store('link-contents/' . $type . '/' . $id, 'public');
    //             $data[$field['name']] = $path;
    //             $data[$field['name'] . '_original_name'] = $file->getClientOriginalName();
    //         }
            
    //         // Handle repeater field file uploads
    //         if ($field['type'] === 'repeater' && isset($data[$field['name']]) && is_array($data[$field['name']])) {
    //             foreach ($data[$field['name']] as $index => $repeaterItem) {
    //                 foreach ($field['fields'] as $repeaterField) {
    //                     if ($repeaterField['type'] === 'file') {
    //                         // Check if file exists in the request
    //                         $fileKey = 'data.' . $field['name'] . '.' . $index . '.' . $repeaterField['name'];
                            
    //                         if ($request->hasFile($fileKey)) {
    //                             $file = $request->file($fileKey);
    //                             $path = $file->store('link-contents/' . $type . '/' . $id . '/repeater', 'public');
    //                             $data[$field['name']][$index][$repeaterField['name']] = $path;
    //                             $data[$field['name']][$index][$repeaterField['name'] . '_original_name'] = $file->getClientOriginalName();
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }
        
    //     // Create content using polymorphic relationship
    //     $model->contents()->create([
    //         'template_name' => $templateName,
    //         'data' => $data,
    //         'order' => $model->contents()->max('order') + 1,
    //         'link_id' => $type === 'link' ? $id : null,
    //     ]);
        
    //     return redirect()->route('link-contents.index', ['type' => $type, 'id' => $id])
    //         ->with('success', 'Content added successfully!');
    // }

    public function store(Request $request, $type, $id)
{ 
    $model = $this->getModel($type, $id);
    
    if (!$model) {
        return redirect()->route('categories.hierarchy')->with('error', 'Not found.');
    }

    $templateName = $request->input('template');
    $template = config('templates.' . $templateName);
    
    if (!$template) {
        return redirect()->back()->withInput()->with('error', 'Invalid template selected.');
    }
    
    // Build validation rules (same as before with nested repeater support)
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
        } elseif ($field['type'] === 'repeater') {
            // Validate repeater fields
            $this->addRepeaterValidationRules($rules, $field, 'data.' . $field['name']);
        } else {
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
    
    // Handle top-level file uploads
    foreach ($template['fields'] as $field) {
        if ($field['type'] === 'file' && $request->hasFile($field['name'])) {
            $file = $request->file($field['name']);
            $path = $file->store('link-contents/' . $type . '/' . $id, 'public');
            $data[$field['name']] = $path;
            $data[$field['name'] . '_original_name'] = $file->getClientOriginalName();
        }
        
        // Handle repeater field file uploads (including nested)
        if ($field['type'] === 'repeater' && isset($data[$field['name']]) && is_array($data[$field['name']])) {
            $data[$field['name']] = $this->processRepeaterFileUploads(
                $request, 
                $field, 
                $data[$field['name']], 
                'data.' . $field['name'],
                'link-contents/' . $type . '/' . $id . '/repeater'
            );
        }
    }
    
    // Create content using polymorphic relationship
    $model->contents()->create([
        'template_name' => $templateName,
        'data' => $data,
        'order' => $model->contents()->max('order') + 1,
        'link_id' => $type === 'link' ? $id : null,
    ]);
    
    return redirect()->route('link-contents.index', ['type' => $type, 'id' => $id])
        ->with('success', 'Content added successfully!');
}

// Helper method for recursive repeater validation
private function addRepeaterValidationRules(&$rules, $field, $prefix)
{
    foreach ($field['fields'] as $repeaterField) {
        if ($repeaterField['type'] === 'file') {
            $rules[$prefix . '.*.'. $repeaterField['name']] = 'nullable|file|max:10240';
            
            if (!empty($repeaterField['accept'])) {
                if (str_contains($repeaterField['accept'], '.svg')) {
                    $rules[$prefix . '.*.'. $repeaterField['name']] .= '|mimes:svg';
                } elseif (str_contains($repeaterField['accept'], 'image')) {
                    $rules[$prefix . '.*.'. $repeaterField['name']] .= '|mimes:jpg,jpeg,png,gif,webp,svg';
                }
            }
        } elseif ($repeaterField['type'] === 'repeater') {
            // Handle nested repeater (recursive)
            $this->addRepeaterValidationRules($rules, $repeaterField, $prefix . '.*.' . $repeaterField['name']);
        } else {
            $fieldRule = [];
            if ($repeaterField['required'] ?? false) {
                $fieldRule[] = 'required';
            } else {
                $fieldRule[] = 'nullable';
            }
            
            if (!empty($fieldRule)) {
                $rules[$prefix . '.*.'. $repeaterField['name']] = implode('|', $fieldRule);
            }
        }
    }
}

// Helper method for recursive repeater file uploads
private function processRepeaterFileUploads($request, $field, $repeaterData, $prefix, $storagePath)
{
    foreach ($repeaterData as $index => $repeaterItem) {
        foreach ($field['fields'] as $repeaterField) {
            if ($repeaterField['type'] === 'file') {
                $fileKey = $prefix . '.' . $index . '.' . $repeaterField['name'];
                
                if ($request->hasFile($fileKey)) {
                    $file = $request->file($fileKey);
                    $path = $file->store($storagePath, 'public');
                    $repeaterData[$index][$repeaterField['name']] = $path;
                    $repeaterData[$index][$repeaterField['name'] . '_original_name'] = $file->getClientOriginalName();
                }
            } elseif ($repeaterField['type'] === 'repeater') {
                // Handle nested repeater (recursive)
                if (isset($repeaterItem[$repeaterField['name']]) && is_array($repeaterItem[$repeaterField['name']])) {
                    $repeaterData[$index][$repeaterField['name']] = $this->processRepeaterFileUploads(
                        $request,
                        $repeaterField,
                        $repeaterItem[$repeaterField['name']],
                        $prefix . '.' . $index . '.' . $repeaterField['name'],
                        $storagePath . '/nested'
                    );
                }
            }
        }
    }
    
    return $repeaterData;
}
    
    public function edit($type, $id, LinkContent $linkContent)
    {
        $model = $this->getModel($type, $id);
        
        if (!$model) {
            return redirect()->route('categories.hierarchy')->with('error', 'Not found.');
        }

        $templateName = $linkContent->template_name;
        $template = config("templates.{$templateName}");
        
        if (!$template) {
            return redirect()->route('link-contents.index', ['type' => $type, 'id' => $id])
                ->with('error', 'Template not found.');
        }

        return view('link-contents.edit', compact('model', 'type', 'linkContent', 'templateName', 'template'));
    }

    // public function update(Request $request, $type, $id, LinkContent $linkContent)
    // {
    //     $model = $this->getModel($type, $id);
        
    //     if (!$model) {
    //         return redirect()->route('categories.hierarchy')->with('error', 'Not found.');
    //     }

    //     $templateName = $linkContent->template_name;
    //     $template = config('templates.' . $templateName);
        
    //     if (!$template) {
    //         return redirect()->back()->withInput()->with('error', 'Invalid template configuration.');
    //     }
        
    //     $rules = ['data' => 'nullable|array'];
        
    //     foreach ($template['fields'] as $field) {
    //         if ($field['type'] === 'file') {
    //             $rules[$field['name']] = 'nullable|file|max:10240';
                
    //             if (!empty($field['accept'])) {
    //                 if (str_contains($field['accept'], 'image')) {
    //                     $rules[$field['name']] .= '|mimes:jpg,jpeg,png,gif,webp,svg';
    //                 } elseif (str_contains($field['accept'], 'pdf') || str_contains($field['accept'], '.pdf')) {
    //                     $rules[$field['name']] .= '|mimes:pdf,doc,docx,xls,xlsx,txt';
    //                 }
    //             }
    //         } elseif ($field['type'] === 'repeater') {
    //             continue;
    //         } else {
    //             $fieldRule = [];
    //             if ($field['required'] ?? false) {
    //                 $fieldRule[] = 'required';
    //             } else {
    //                 $fieldRule[] = 'nullable';
    //             }
                
    //             if ($field['type'] === 'url') {
    //                 $fieldRule[] = 'url';
    //             } elseif ($field['type'] === 'email') {
    //                 $fieldRule[] = 'email';
    //             }
                
    //             if (!empty($fieldRule)) {
    //                 $rules['data.' . $field['name']] = implode('|', $fieldRule);
    //             }
    //         }
    //     }
        
    //     try {
    //         $validated = $request->validate($rules);
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         return redirect()->back()->withInput()->withErrors($e->errors())
    //             ->with('error', 'Please fix the validation errors.');
    //     }
        
    //     $data = $request->input('data', []);
        
    //     // Handle file uploads
    //     foreach ($template['fields'] as $field) {
    //         if ($field['type'] === 'file') {
    //             if ($request->hasFile($field['name'])) {
    //                 if (!empty($linkContent->data[$field['name']])) {
    //                     Storage::disk('public')->delete($linkContent->data[$field['name']]);
    //                 }
                    
    //                 $file = $request->file($field['name']);
    //                 $path = $file->store('link-contents/' . $type . '/' . $id, 'public');
    //                 $data[$field['name']] = $path;
    //                 $data[$field['name'] . '_original_name'] = $file->getClientOriginalName();
    //             } else {
    //                 if (!empty($linkContent->data[$field['name']])) {
    //                     $data[$field['name']] = $linkContent->data[$field['name']];
    //                     if (!empty($linkContent->data[$field['name'] . '_original_name'])) {
    //                         $data[$field['name'] . '_original_name'] = $linkContent->data[$field['name'] . '_original_name'];
    //                     }
    //                 }
    //             }
    //         }
    //     }
        
    //     $linkContent->update(['data' => $data]);
        
    //     return redirect()->route('link-contents.index', ['type' => $type, 'id' => $id])
    //         ->with('success', 'Content updated successfully!');
    // }
   
//     public function update(Request $request, $type, $id, LinkContent $linkContent)
// {
//     $model = $this->getModel($type, $id);
    
//     if (!$model) {
//         return redirect()->route('categories.hierarchy')->with('error', 'Not found.');
//     }

//     $templateName = $linkContent->template_name;
//     $template = config('templates.' . $templateName);
    
//     if (!$template) {
//         return redirect()->back()->withInput()->with('error', 'Invalid template configuration.');
//     }
    
//     $rules = ['data' => 'nullable|array'];
    
//     foreach ($template['fields'] as $field) {
//         if ($field['type'] === 'file') {
//             $rules[$field['name']] = 'nullable|file|max:10240';
            
//             if (!empty($field['accept'])) {
//                 if (str_contains($field['accept'], 'image')) {
//                     $rules[$field['name']] .= '|mimes:jpg,jpeg,png,gif,webp,svg';
//                 } elseif (str_contains($field['accept'], 'pdf') || str_contains($field['accept'], '.pdf')) {
//                     $rules[$field['name']] .= '|mimes:pdf,doc,docx,xls,xlsx,txt';
//                 }
//             }
//         } elseif ($field['type'] === 'repeater') {
//             // Add validation for repeater fields
//             foreach ($field['fields'] as $repeaterField) {
//                 if ($repeaterField['type'] === 'file') {
//                     $rules['data.' . $field['name'] . '.*.'. $repeaterField['name']] = 'nullable|file|max:10240';
                    
//                     if (!empty($repeaterField['accept'])) {
//                         if (str_contains($repeaterField['accept'], '.svg')) {
//                             $rules['data.' . $field['name'] . '.*.'. $repeaterField['name']] .= '|mimes:svg';
//                         } elseif (str_contains($repeaterField['accept'], 'image')) {
//                             $rules['data.' . $field['name'] . '.*.'. $repeaterField['name']] .= '|mimes:jpg,jpeg,png,gif,webp,svg';
//                         }
//                     }
//                 } else {
//                     $fieldRule = [];
//                     if ($repeaterField['required'] ?? false) {
//                         $fieldRule[] = 'required';
//                     } else {
//                         $fieldRule[] = 'nullable';
//                     }
                    
//                     if (!empty($fieldRule)) {
//                         $rules['data.' . $field['name'] . '.*.'. $repeaterField['name']] = implode('|', $fieldRule);
//                     }
//                 }
//             }
//         } else {
//             $fieldRule = [];
//             if ($field['required'] ?? false) {
//                 $fieldRule[] = 'required';
//             } else {
//                 $fieldRule[] = 'nullable';
//             }
            
//             if ($field['type'] === 'url') {
//                 $fieldRule[] = 'url';
//             } elseif ($field['type'] === 'email') {
//                 $fieldRule[] = 'email';
//             }
            
//             if (!empty($fieldRule)) {
//                 $rules['data.' . $field['name']] = implode('|', $fieldRule);
//             }
//         }
//     }
    
//     try {
//         $validated = $request->validate($rules);
//     } catch (\Illuminate\Validation\ValidationException $e) {
//         return redirect()->back()->withInput()->withErrors($e->errors())
//             ->with('error', 'Please fix the validation errors.');
//     }
    
//     $data = $request->input('data', []);
    
//     // Handle top-level file uploads
//     foreach ($template['fields'] as $field) {
//         if ($field['type'] === 'file') {
//             if ($request->hasFile($field['name'])) {
//                 // Delete old file if exists
//                 if (!empty($linkContent->data[$field['name']])) {
//                     Storage::disk('public')->delete($linkContent->data[$field['name']]);
//                 }
                
//                 // Upload new file
//                 $file = $request->file($field['name']);
//                 $path = $file->store('link-contents/' . $type . '/' . $id, 'public');
//                 $data[$field['name']] = $path;
//                 $data[$field['name'] . '_original_name'] = $file->getClientOriginalName();
//             } else {
//                 // Keep existing file
//                 if (!empty($linkContent->data[$field['name']])) {
//                     $data[$field['name']] = $linkContent->data[$field['name']];
//                     if (!empty($linkContent->data[$field['name'] . '_original_name'])) {
//                         $data[$field['name'] . '_original_name'] = $linkContent->data[$field['name'] . '_original_name'];
//                     }
//                 }
//             }
//         }
        
//         // Handle repeater field file uploads
//         if ($field['type'] === 'repeater' && isset($data[$field['name']]) && is_array($data[$field['name']])) {
//             $oldRepeaterData = $linkContent->data[$field['name']] ?? [];
            
//             foreach ($data[$field['name']] as $index => $repeaterItem) {
//                 foreach ($field['fields'] as $repeaterField) {
//                     if ($repeaterField['type'] === 'file') {
//                         $fileKey = 'data.' . $field['name'] . '.' . $index . '.' . $repeaterField['name'];
                        
//                         // Check if new file is uploaded
//                         if ($request->hasFile($fileKey)) {
//                             // Delete old file if exists
//                             if (isset($oldRepeaterData[$index][$repeaterField['name']])) {
//                                 Storage::disk('public')->delete($oldRepeaterData[$index][$repeaterField['name']]);
//                             }
                            
//                             // Upload new file
//                             $file = $request->file($fileKey);
//                             $path = $file->store('link-contents/' . $type . '/' . $id . '/repeater', 'public');
//                             $data[$field['name']][$index][$repeaterField['name']] = $path;
//                             $data[$field['name']][$index][$repeaterField['name'] . '_original_name'] = $file->getClientOriginalName();
//                         } else {
//                             // Keep existing file if available
//                             if (isset($oldRepeaterData[$index][$repeaterField['name']])) {
//                                 $data[$field['name']][$index][$repeaterField['name']] = $oldRepeaterData[$index][$repeaterField['name']];
                                
//                                 if (isset($oldRepeaterData[$index][$repeaterField['name'] . '_original_name'])) {
//                                     $data[$field['name']][$index][$repeaterField['name'] . '_original_name'] = 
//                                         $oldRepeaterData[$index][$repeaterField['name'] . '_original_name'];
//                                 }
//                             }
//                         }
//                     }
//                 }
//             }
            
//             // Clean up deleted repeater items (if any items were removed)
//             if (count($oldRepeaterData) > count($data[$field['name']])) {
//                 foreach ($oldRepeaterData as $oldIndex => $oldItem) {
//                     if (!isset($data[$field['name']][$oldIndex])) {
//                         // This item was deleted, remove its files
//                         foreach ($field['fields'] as $repeaterField) {
//                             if ($repeaterField['type'] === 'file' && !empty($oldItem[$repeaterField['name']])) {
//                                 Storage::disk('public')->delete($oldItem[$repeaterField['name']]);
//                             }
//                         }
//                     }
//                 }
//             }
//         }
//     }
    
//     $linkContent->update(['data' => $data]);
    
//     return redirect()->route('link-contents.index', ['type' => $type, 'id' => $id])
//         ->with('success', 'Content updated successfully!');
// }

public function update(Request $request, $type, $id, LinkContent $linkContent)
{
    $model = $this->getModel($type, $id);
    
    if (!$model) {
        return redirect()->route('categories.hierarchy')->with('error', 'Not found.');
    }

    $templateName = $linkContent->template_name;
    $template = config('templates.' . $templateName);
    
    if (!$template) {
        return redirect()->back()->withInput()->with('error', 'Invalid template configuration.');
    }
    
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
        } elseif ($field['type'] === 'repeater') {
            $this->addRepeaterValidationRules($rules, $field, 'data.' . $field['name']);
        } else {
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
    
    try {
        $validated = $request->validate($rules);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withInput()->withErrors($e->errors())
            ->with('error', 'Please fix the validation errors.');
    }
    
    $data = $request->input('data', []);
    
    // Handle top-level file uploads
    foreach ($template['fields'] as $field) {
        if ($field['type'] === 'file') {
            if ($request->hasFile($field['name'])) {
                if (!empty($linkContent->data[$field['name']])) {
                    Storage::disk('public')->delete($linkContent->data[$field['name']]);
                }
                
                $file = $request->file($field['name']);
                $path = $file->store('link-contents/' . $type . '/' . $id, 'public');
                $data[$field['name']] = $path;
                $data[$field['name'] . '_original_name'] = $file->getClientOriginalName();
            } else {
                if (!empty($linkContent->data[$field['name']])) {
                    $data[$field['name']] = $linkContent->data[$field['name']];
                    if (!empty($linkContent->data[$field['name'] . '_original_name'])) {
                        $data[$field['name'] . '_original_name'] = $linkContent->data[$field['name'] . '_original_name'];
                    }
                }
            }
        }
        
        // Handle repeater field file uploads (including nested)
        if ($field['type'] === 'repeater' && isset($data[$field['name']]) && is_array($data[$field['name']])) {
            $oldRepeaterData = $linkContent->data[$field['name']] ?? [];
            
            $data[$field['name']] = $this->updateRepeaterFileUploads(
                $request,
                $field,
                $data[$field['name']],
                $oldRepeaterData,
                'data.' . $field['name'],
                'link-contents/' . $type . '/' . $id . '/repeater'
            );
            
            // Clean up deleted items
            $this->cleanupDeletedRepeaterFiles($field, $oldRepeaterData, $data[$field['name']]);
        }
    }
    
    $linkContent->update(['data' => $data]);
    
    return redirect()->route('link-contents.index', ['type' => $type, 'id' => $id])
        ->with('success', 'Content updated successfully!');
}

// Helper method for updating repeater files (recursive)
private function updateRepeaterFileUploads($request, $field, $newData, $oldData, $prefix, $storagePath)
{
    foreach ($newData as $index => $repeaterItem) {
        foreach ($field['fields'] as $repeaterField) {
            if ($repeaterField['type'] === 'file') {
                $fileKey = $prefix . '.' . $index . '.' . $repeaterField['name'];
                
                if ($request->hasFile($fileKey)) {
                    // Delete old file if exists
                    if (isset($oldData[$index][$repeaterField['name']])) {
                        Storage::disk('public')->delete($oldData[$index][$repeaterField['name']]);
                    }
                    
                    // Upload new file
                    $file = $request->file($fileKey);
                    $path = $file->store($storagePath, 'public');
                    $newData[$index][$repeaterField['name']] = $path;
                    $newData[$index][$repeaterField['name'] . '_original_name'] = $file->getClientOriginalName();
                } else {
                    // Keep existing file
                    if (isset($oldData[$index][$repeaterField['name']])) {
                        $newData[$index][$repeaterField['name']] = $oldData[$index][$repeaterField['name']];
                        
                        if (isset($oldData[$index][$repeaterField['name'] . '_original_name'])) {
                            $newData[$index][$repeaterField['name'] . '_original_name'] = 
                                $oldData[$index][$repeaterField['name'] . '_original_name'];
                        }
                    }
                }
            } elseif ($repeaterField['type'] === 'repeater') {
                // Handle nested repeater (recursive)
                if (isset($repeaterItem[$repeaterField['name']]) && is_array($repeaterItem[$repeaterField['name']])) {
                    $oldNestedData = $oldData[$index][$repeaterField['name']] ?? [];
                    
                    $newData[$index][$repeaterField['name']] = $this->updateRepeaterFileUploads(
                        $request,
                        $repeaterField,
                        $repeaterItem[$repeaterField['name']],
                        $oldNestedData,
                        $prefix . '.' . $index . '.' . $repeaterField['name'],
                        $storagePath . '/nested'
                    );
                }
            }
        }
    }
    
    return $newData;
}

// Helper method to cleanup deleted repeater files (recursive)
private function cleanupDeletedRepeaterFiles($field, $oldData, $newData)
{
    if (count($oldData) > count($newData)) {
        foreach ($oldData as $oldIndex => $oldItem) {
            if (!isset($newData[$oldIndex])) {
                // This item was deleted, remove its files
                foreach ($field['fields'] as $repeaterField) {
                    if ($repeaterField['type'] === 'file' && !empty($oldItem[$repeaterField['name']])) {
                        Storage::disk('public')->delete($oldItem[$repeaterField['name']]);
                    } elseif ($repeaterField['type'] === 'repeater' && !empty($oldItem[$repeaterField['name']])) {
                        // Recursively cleanup nested repeater
                        $this->cleanupDeletedRepeaterFiles($repeaterField, $oldItem[$repeaterField['name']], []);
                    }
                }
            }
        }
    }
}

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
        
        return redirect()->route('link-contents.index', ['type' => $type, 'id' => $id])
            ->with('success', 'Content deleted successfully!');
    }
    
    public function updateOrder(Request $request, $type, $id)
    {
        $model = $this->getModel($type, $id);
        
        if (!$model) {
            return response()->json(['success' => false], 404);
        }

        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:link_contents,id'
        ]);

        foreach ($validated['order'] as $index => $contentId) {
            LinkContent::where('id', $contentId)
                ->where('contentable_type', get_class($model))
                ->where('contentable_id', $id)
                ->update(['order' => $index]);
        }

        return response()->json(['success' => true, 'message' => 'Order updated successfully']);
    }

    /**
     * Get model based on type
     */
    private function getModel($type, $id)
    {
        return match($type) {
            'link' => Link::find($id),
            'sub-category' => SubCategory::find($id),
            default => null,
        };
    }


    public function approveModel($type, $id)
{
    $model = $this->getModel($type, $id);
    
    if (!$model) {
        return redirect()->back()->with('error', 'Model not found.');
    }
    
    // Approve the model
    $model->is_approved = true;
    $model->save();
    
    return redirect()->back()->with('success', ucfirst($type) . ' has been approved successfully.');
}

public function unapproveModel($type, $id)
{
    $model = $this->getModel($type, $id);
    
    if (!$model) {
        return redirect()->back()->with('error', 'Model not found.');
    }
    
    // Unapprove the model
    $model->is_approved = false;
    $model->save();
    
    return redirect()->back()->with('success', ucfirst($type) . ' has been unapproved successfully.');
}


    public function toggleApproval($type, $id, LinkContent $linkContent)
{
    // Toggle the approval status
    $linkContent->is_approved = !$linkContent->is_approved;
    $linkContent->save();

    $status = $linkContent->is_approved ? 'approved' : 'unapproved';
    
    return redirect()->back()->with('success', "Link content has been {$status} successfully.");
}
}