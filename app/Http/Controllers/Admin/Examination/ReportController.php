<?php

namespace App\Http\Controllers\Admin\Examination;

use App\Http\Controllers\Controller;
use App\Models\AcademicClass;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\Mark;
use App\Models\StudentProfile;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $exams = Exam::orderBy('start_date', 'desc')->get();
        $classes = AcademicClass::all();
        $students = null;
        $selected_exam = null;
        $selected_class = null;

        if ($request->exam_id && $request->class_id) {
            $selected_exam = Exam::find($request->exam_id);
            $selected_class = AcademicClass::find($request->class_id);

            if ($selected_class) {
                $students = StudentProfile::where('academic_class_id', $selected_class->id)
                    ->with('user')
                    ->get();
            }
        }
        
        return view('admin.examination.report.index', compact('exams', 'classes', 'students', 'selected_exam', 'selected_class'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'class_id' => 'required|exists:academic_classes,id',
            'student_id' => 'nullable|exists:student_profiles,id',
        ]);

        $exam = Exam::findOrFail($request->exam_id);
        $class = AcademicClass::findOrFail($request->class_id);
        
        // fetch subjects and schedule for this class/exam to know full marks
        $schedules = ExamSchedule::where('exam_id', $exam->id)
            ->where('academic_class_id', $class->id)
            ->with('subject')
            ->get();

        if ($schedules->isEmpty()) {
            return back()->with('error', 'No exam schedule found for this class and exam. Please schedule the exam first.');
        }

        $query = StudentProfile::where('academic_class_id', $class->id)->with('user');

        if ($request->student_id) {
            $query->where('id', $request->student_id);
        }

        $students = $query->get();

        if ($students->isEmpty()) {
            return back()->with('error', 'No students found for this class.');
        }

        // Process data for each student
        $reportCards = [];

        foreach ($students as $student) {
            $studentMarks = Mark::where('exam_id', $exam->id)
                ->where('student_id', $student->id)
                ->get()
                ->keyBy('subject_id');

            $subjectsData = [];
            $totalFullMarks = 0;
            $totalObtainedUpdate = 0;
            $failedSubjects = 0;

            foreach ($schedules as $schedule) {
                $markRecord = $studentMarks->get($schedule->subject_id);
                $obtained = $markRecord ? $markRecord->marks_obtained : 0; // Treat missing as 0 or absent
                
                // Determine grade/remarks (Simple logic for now)
                $isFail = $obtained < $schedule->passing_marks;
                if ($isFail) {
                    $failedSubjects++;
                }

                $subjectsData[] = [
                    'subject' => $schedule->subject->name,
                    'full_marks' => $schedule->full_marks,
                    'passing_marks' => $schedule->passing_marks,
                    'obtained_marks' => $obtained,
                    'is_fail' => $isFail,
                    'remarks' => $markRecord ? $markRecord->remarks : '-'
                ];

                $totalFullMarks += $schedule->full_marks;
                $totalObtainedUpdate += $obtained;
            }

            $percentage = $totalFullMarks > 0 ? ($totalObtainedUpdate / $totalFullMarks) * 100 : 0;
            
            // Overall Result
            $result = "PASS";
            if ($failedSubjects > 0) {
                $result = "FAIL ($failedSubjects subjects)";
            }

            $reportCards[] = (object) [
                'student' => $student,
                'subjects' => $subjectsData,
                'total_full' => $totalFullMarks,
                'total_obtained' => $totalObtainedUpdate,
                'percentage' => number_format($percentage, 2),
                'result' => $result,
                'failed_count' => $failedSubjects
            ];
        }

        return view('admin.examination.report.card', compact('exam', 'class', 'reportCards'));
    }
}
