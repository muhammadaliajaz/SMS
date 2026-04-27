<?php

namespace App\Http\Controllers\Academics;

use App\Http\Controllers\Controller;
use App\Models\AcademicClass;
use Illuminate\Http\Request;

class AcademicClassController extends Controller
{
    public function index()
    {
        $classes = AcademicClass::withCount('sections')->paginate(10);
        return view('academics.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('academics.classes.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:academic_classes',
        ]);

        AcademicClass::create($validatedData);

        return redirect()->route('classes.index')->with('success', 'Class created successfully.');
    }

    public function show(AcademicClass $class)
    {
        $class->load('sections'); // Eager load sections
        return view('academics.classes.show', compact('class'));
    }

    public function edit(AcademicClass $class)
    {
        return view('academics.classes.edit', ['academicClass' => $class]);
    }

    public function update(Request $request, AcademicClass $class)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:academic_classes,name,' . $class->id,
        ]);

        $class->update($validatedData);

        return redirect()->route('classes.index')->with('success', 'Class updated successfully.');
    }

    public function destroy(AcademicClass $class)
    {
        $class->delete();
        return redirect()->route('classes.index')->with('success', 'Class deleted successfully.');
    }
}
