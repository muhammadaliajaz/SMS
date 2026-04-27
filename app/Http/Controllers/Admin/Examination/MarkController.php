<?php

namespace App\Http\Controllers\Admin\Examination;

use App\Http\Controllers\Controller;
use App\Models\AcademicClass;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\Mark;
use App\Models\StudentProfile;
use App\Models\Subject;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    public function index(Request $request)
    {
        $exams = Exam::orderBy('start_date', 'desc')->get();
        $classes = AcademicClass::all();
        
        $students = [];
        $schedule = null;

        if ($request->exam_id && $request->class_id && $request->subject_id) {
            $students = StudentProfile::where('academic_class_id', $request->class_id)
                ->with(['user']) 
                ->get();
            
            $schedule = ExamSchedule::where('exam_id', $request->exam_id)
                ->where('academic_class_id', $request->class_id)
                ->where('subject_id', $request->subject_id)
                ->first();
        }

        return view('admin.examination.marks.index', compact('exams', 'classes', 'students', 'schedule'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'subject_id' => 'required|exists:subjects,id',
            'marks' => 'required|array',
            'marks.*.student_id' => 'required|exists:student_profiles,id',
            'marks.*.marks_obtained' => 'nullable|numeric',
            'marks.*.remarks' => 'nullable|string',
        ]);

        foreach ($request->marks as $markData) {
            if (isset($markData['marks_obtained'])) {
                 Mark::updateOrCreate(
                    [
                        'exam_id' => $request->exam_id,
                        'student_id' => $markData['student_id'],
                        'subject_id' => $request->subject_id,
                    ],
                    [
                        'marks_obtained' => $markData['marks_obtained'],
                        'remarks' => $markData['remarks'] ?? null,
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Marks updated successfully.');
    }
}
