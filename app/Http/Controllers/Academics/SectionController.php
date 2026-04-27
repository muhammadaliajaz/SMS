<?php

namespace App\Http\Controllers\Academics;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\AcademicClass;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::with('academicClass')->paginate(10);
        return view('academics.sections.index', compact('sections'));
    }

    public function create()
    {
        $classes = AcademicClass::all();
        return view('academics.sections.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'academic_class_id' => 'required|exists:academic_classes,id',
            'capacity' => 'nullable|integer|min:1',
        ]);

        Section::create($validatedData);

        return redirect()->route('sections.index')->with('success', 'Section created successfully.');
    }

    public function show(Section $section)
    {
        $section->load('academicClass');
        return view('academics.sections.show', compact('section'));
    }

    public function edit(Section $section)
    {
        $classes = AcademicClass::all();
        return view('academics.sections.edit', compact('section', 'classes'));
    }

    public function update(Request $request, Section $section)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'academic_class_id' => 'required|exists:academic_classes,id',
            'capacity' => 'nullable|integer|min:1',
        ]);

        $section->update($validatedData);

        return redirect()->route('sections.index')->with('success', 'Section updated successfully.');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('sections.index')->with('success', 'Section deleted successfully.');
    }
}
