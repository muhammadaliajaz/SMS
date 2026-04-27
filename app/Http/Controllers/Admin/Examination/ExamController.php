<?php

namespace App\Http\Controllers\Admin\Examination;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::orderBy('start_date', 'desc')->get();
        return view('admin.examination.exam.index', compact('exams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'term' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'note' => 'nullable|string',
        ]);

        Exam::create($request->all());

        return redirect()->back()->with('success', 'Exam created successfully.');
    }

    public function update(Request $request, $id)
    {
        $exam = Exam::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'term' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'note' => 'nullable|string',
        ]);

        $exam->update($request->all());

        return redirect()->back()->with('success', 'Exam updated successfully.');
    }

    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();

        return redirect()->back()->with('success', 'Exam deleted successfully.');
    }
}
