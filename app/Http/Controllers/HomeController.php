<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudentAttendance;
use App\Models\FeePayment;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 1. Top Stats
        $totalStudents = User::students()->count();
        $totalTeachers = User::staff()->count();
        
        // Fees (Using Total Collected for now as Arrears calculation requires Fee Demand system)
        $totalFees = FeePayment::sum('amount');
        
        // Attendance Today
        $today = Carbon::today();
        $attendanceQuery = StudentAttendance::where('attendance_date', $today->format('Y-m-d'));
        
        $presentToday = (clone $attendanceQuery)->where('status', 'present')->count();
        $absentToday = (clone $attendanceQuery)->where('status', 'absent')->count();
        $lateToday = (clone $attendanceQuery)->where('status', 'late')->count();
        $excusedToday = (clone $attendanceQuery)->where('status', 'excused')->count();
        
        // Present Percentage
        $presentPercentage = $totalStudents > 0 ? round(($presentToday / $totalStudents) * 100, 1) : 0;

        // Fees Percentage (Estimated Target: $500 per student)
        $estimatedRevenue = $totalStudents * 500; 
        $feePercentage = $estimatedRevenue > 0 ? round(($totalFees / $estimatedRevenue) * 100, 1) : 0;
        $feePercentage = min($feePercentage, 100); // Cap at 100%

        // 2. Recent Enrollments
        $recentEnrollments = User::whereHas('role', function($q) { $q->where('name', 'student'); })
                                ->with('studentProfile')
                                ->latest()
                                ->take(5)
                                ->get();

        return view('home', compact(
            'totalStudents', 
            'totalTeachers', 
            'totalFees', 
            'presentToday', 
            'absentToday', 
            'lateToday', 
            'presentPercentage', 
            'recentEnrollments',
            'feePercentage'
        ));
    }
    public function getStats(Request $request)
    {
        $month = $request->input('month') + 1; // JS months are 0-11, PHP 1-12
        $year = $request->input('year');

        $totalStudents = User::students()->count();

        // 1. Attendance for the Month (Average P% of the month or Total Present Count / Total Possible)
        // Let's use Total Present / (Total Students * Days with Attendance)
        $monthlyAttendance = StudentAttendance::whereYear('attendance_date', $year)
                                              ->whereMonth('attendance_date', $month);
        
        $presentCount = (clone $monthlyAttendance)->where('status', 'present')->count();
        // Total possible based on records created (assuming records represent school days)
        $totalRecords = $monthlyAttendance->count(); 
        
        $presentPercentage = $totalRecords > 0 ? round(($presentCount / $totalRecords) * 100, 1) : 0;


        // 2. Fees for the Month
        // Collected in this month
        $collectedInMonth = FeePayment::whereYear('payment_date', $year)
                                      ->whereMonth('payment_date', $month)
                                      ->sum('amount');
        
        // Estimated Revenue for One Month (Total Students * 500)
        $estimatedRevenue = $totalStudents * 500;
        $feePercentage = $estimatedRevenue > 0 ? round(($collectedInMonth / $estimatedRevenue) * 100, 1) : 0;
        $feePercentage = min($feePercentage, 100);

        return response()->json([
            'feePercentage' => $feePercentage,
            'presentPercentage' => $presentPercentage
        ]);
    }
}
