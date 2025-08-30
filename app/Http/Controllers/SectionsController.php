<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Services\SectionService;

class SectionsController extends Controller
{
    public function __construct(private SectionService $sectionService)
    {

    }

    public function index()
    {
        $sections = Section::all(); // Get all sections, not just 5
        $totalSections = Section::count();
        $topParentSections = Section::whereNull('parent')->orderByDesc('id')->limit(5)->get();

    return view('sections', compact('sections', 'totalSections', 'topParentSections'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'section' => 'required|string|max:255',
            'parent_id' => 'nullable|integer',
        ]);

        $status = $this->sectionService->store($request);

        if ($status) {
            return redirect()->back()->with('success', 'Section added successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add section. Contact Admin');
        }
    }

}
