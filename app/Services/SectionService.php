<?php

namespace App\Services;

use App\Models\Section;
use Illuminate\Support\Collection;

class SectionService
{
    /**
     * Create a new section
     */

public function store($request)
{
    try {
        // Check depth limit on server side as well
        if ($request->parent_id && $request->parent_id != 0) {
            $parentSection = Section::find($request->parent_id);
            if ($parentSection) {
                $depth = $this->calculateDepth($parentSection);

                if ($depth >= 3) {
                    return redirect()->back()->with('error', 'Cannot create sections deeper than 4 levels. Great grandchildren are the maximum depth allowed.');
                }
            }
        }

        // Convert parent_id to appropriate value for database
        $parentValue = ($request->parent_id && $request->parent_id != 0) ? $request->parent_id : 0;

        Section::create([
            'section' => $request->section,
            'parent' => $parentValue,
        ]);

        return true;

    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Error creating section: ' . $e->getMessage(), [
            'section_name' => $request->section,
            'parent_id' => $request->parent_id,
            'error' => $e->getMessage()
        ]);

        return false;
    }
}


    private function calculateDepth($section, $depth = 0)
    {
        if (!$section || $section->parent == 0) {
            return $depth;
        }

        $parentSection = Section::find($section->parent);
        return $this->calculateDepth($parentSection, $depth + 1);
    }
}
