<?php

namespace App\Http\Controllers;
 

use App\Models\DownloadCategory;
use Illuminate\Http\Request;

class DownloadsSectionController extends Controller
{
    public function index()
    {
        $categories = DownloadCategory::active()
            ->ordered()
            ->with(['activeDownloadFiles' => function($query) {
                $query->orderBy('date', 'desc');
            }])
            ->get();

        return view('downloads.show', compact('categories'));
    }
}