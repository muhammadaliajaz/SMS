<?php

namespace App\Http\Controllers\Admin\Examination;

use App\Http\Controllers\Controller;
use App\Models\AcademicClass;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExamScheduleController extends Controller
{
    public function index(Request $request)
    {
        $exams = Exam::orderBy('start_date', 'desc')->get();
        $classes = AcademicClass::all();
        
        $schedules = [];
        $subjects = [];
        if($request->exam_id && $request->class_id) {
             $schedules = ExamSchedule::where('exam_id', $request->exam_id)
                ->where('academic_class_id', $request->class_id)
                ->with('subject')
                ->get();
             
             // Fetch all subjects for this class to ensure we display a row for every subject
             $subjects = Subject::where('academic_class_id', $request->class_id)->get();
        }

        return view('admin.examination.schedule.index', compact('exams', 'classes', 'schedules', 'subjects'));
    }

    public function create()
    {
        // This might be handled in index with a modal or separate page
        // For now, let's assume valid data comes from index page selection
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'academic_class_id' => 'required|exists:academic_classes,id',
            'schedules' => 'required|array',
            'schedules.*.subject_id' => 'required|exists:subjects,id',
            'schedules.*.date_of_exam' => 'required|date',
            'schedules.*.start_time' => 'required',
            'schedules.*.end_time' => 'required',
            'schedules.*.room_no' => 'nullable|string',
            'schedules.*.full_marks' => 'required|integer',
            'schedules.*.passing_marks' => 'required|integer',
        ]);

        foreach ($request->schedules as $scheduleData) {
            ExamSchedule::updateOrCreate(
                [
                    'exam_id' => $request->exam_id,
                    'academic_class_id' => $request->academic_class_id,
                    'subject_id' => $scheduleData['subject_id'],
                ],
                [
                    'date_of_exam' => $scheduleData['date_of_exam'],
                    'start_time' => $scheduleData['start_time'],
                    'end_time' => $scheduleData['end_time'],
                    'room_no' => $scheduleData['room_no'],
                    'full_marks' => $scheduleData['full_marks'],
                    'passing_marks' => $scheduleData['passing_marks'],
                ]
            );
        }

        return redirect()->back()->with('success', 'Exam schedule updated successfully.');
    }
}
