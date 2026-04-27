<?php

namespace App\Http\Controllers\Admin\Examination;

use App\Http\Controllers\Controller;
use App\Models\AcademicClass;
use App\Models\Exam;
use App\Models\StudentProfile;
use App\Models\ExamSchedule;
use Illuminate\Http\Request;

class AdmitCardController extends Controller
{
    /**
     * Display the filter form and list of students for admit card generation.
     */
    public function index(Request $request)
    {
        $exams = Exam::latest()->get();
        $classes = AcademicClass::all();
        $students = null;
        $selected_exam = null;
        $selected_class = null;

        if ($request->has('exam_id') && $request->has('class_id')) {
            $request->validate([
                'exam_id' => 'required|exists:exams,id',
                'class_id' => 'required|exists:academic_classes,id',
            ]);

            $selected_exam = Exam::findOrFail($request->exam_id);
            $selected_class = AcademicClass::findOrFail($request->class_id);

            // Fetch students for the selected class
            // Ideally we should filter by section too if needed, but for now just class
            $students = StudentProfile::with('user')
                ->where('academic_class_id', $request->class_id)
                ->get();
        }

        return view('admin.examination.admit-card.index', compact('exams', 'classes', 'students', 'selected_exam', 'selected_class'));
    }

    /**
     * Generate the admit card (Gate Pass) for printing.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'class_id' => 'required|exists:academic_classes,id',
            'student_id' => 'nullable|exists:student_profiles,id', // Optional: if null, generate for all
        ]);

        $exam = Exam::findOrFail($request->exam_id);
        $class = AcademicClass::findOrFail($request->class_id);
        
        // Fetch Exam Schedule for this class
        $schedules = ExamSchedule::with('subject')
            ->where('exam_id', $exam->id)
            ->where('academic_class_id', $class->id)
            ->orderBy('date_of_exam')
            ->orderBy('start_time')
            ->get();

        if ($schedules->isEmpty()) {
            return back()->with('error', 'No exam schedule found for this class and exam. Please schedule the exam first.');
        }

        $query = StudentProfile::with('user')
            ->where('academic_class_id', $class->id);

        if ($request->has('student_id') && $request->student_id) {
            $query->where('id', $request->student_id);
        }

        $students = $query->get();

        if ($students->isEmpty()) {
            return back()->with('error', 'No students found to generate admit cards.');
        }

        return view('admin.examination.admit-card.print', compact('exam', 'class', 'schedules', 'students'));
    }
}
