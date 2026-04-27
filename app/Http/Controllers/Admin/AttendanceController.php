<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicClass;
use App\Models\Section;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\StudentAttendance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $classes = AcademicClass::all();
        return view('admin.attendance.index', compact('classes'));
    }

    public function create(Request $request)
    {
        $class_id = $request->get('class_id');
        $section_id = $request->get('section_id');
        $date = $request->get('date');

        if (!$class_id || !$section_id || !$date) {
            return redirect()->route('attendance.index')->with('error', 'Please select Class, Section and Date.');
        }

        $class = AcademicClass::findOrFail($class_id);
        $section = Section::findOrFail($section_id);

        $students = User::whereHas('studentProfile', function($q) use ($class_id, $section_id) {
            $q->where('academic_class_id', $class_id)
              ->where('section_id', $section_id);
        })->with('studentProfile')->orderBy('name')->get();

        $attendances = StudentAttendance::where('academic_class_id', $class_id)
            ->where('section_id', $section_id)
            ->where('attendance_date', $date)
            ->get()
            ->keyBy('student_id');

        return view('admin.attendance.create', compact('students', 'class', 'section', 'date', 'attendances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:academic_classes,id',
            'section_id' => 'required|exists:sections,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'in:present,absent,late,excused',
        ]);

        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $date = $request->date;
        $attendances = $request->attendance;
        $remarks = $request->remarks ?? [];

        DB::beginTransaction();

        try {
            foreach ($attendances as $student_id => $status) {
                StudentAttendance::updateOrCreate(
                    [
                        'student_id' => $student_id,
                        'attendance_date' => $date,
                    ],
                    [
                        'academic_class_id' => $class_id,
                        'section_id' => $section_id,
                        'status' => $status,
                        'remarks' => $remarks[$student_id] ?? null,
                    ]
                );
            }

            DB::commit();
            return redirect()->route('attendance.index')->with('success', 'Attendance saved successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error saving attendance: ' . $e->getMessage());
        }
    }

    public function report(Request $request)
    {
        $classes = AcademicClass::all();
        
        $class_id = $request->get('class_id');
        $section_id = $request->get('section_id');
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        $students = [];
        $attendanceData = [];
        $daysInMonth = 0;
        $class = null;
        $section = null;

        if ($class_id && $section_id) {
            $class = AcademicClass::find($class_id);
            $section = Section::find($section_id);
            $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

            // Fetch students
            $students = User::whereHas('studentProfile', function($q) use ($class_id, $section_id) {
                $q->where('academic_class_id', $class_id)
                  ->where('section_id', $section_id);
            })->orderBy('name')->get();

            // Fetch attendance for the whole month
            $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth()->format('Y-m-d');
            $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth()->format('Y-m-d');

            $records = StudentAttendance::where('academic_class_id', $class_id)
                ->where('section_id', $section_id)
                ->whereBetween('attendance_date', [$startOfMonth, $endOfMonth])
                ->get();

            // Structure: $attendanceData[student_id][day] = status
            foreach ($records as $record) {
                $day = (int) Carbon::parse($record->attendance_date)->format('j');
                $attendanceData[$record->student_id][$day] = $record->status;
            }
        }

        return view('admin.attendance.report', compact('classes', 'students', 'attendanceData', 'daysInMonth', 'year', 'month', 'class_id', 'section_id', 'class', 'section'));
    }
}
