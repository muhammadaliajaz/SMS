<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\Role;
use App\Models\AcademicClass;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Base query for students
        $query = User::students();

        // Search Filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('studentProfile', function($sq) use ($search) {
                      $sq->where('admission_number', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        // Stats (Calculate BEFORE text filtering if stats should show global totals, 
        // OR calculate AFTER if stats should reflect search results. 
        // Typically stats show TOTALs, so we do separate queries for stats or clone the base query before search).
        
        // For efficiency, let's keep stats global (ignoring search)
        // For efficiency, let's keep stats global (ignoring search)
        $totalStudents = User::students()->count();
        $totalMale = User::students()->whereHas('studentProfile', function($q) {
            $q->where('gender', 'Male');
        })->count();
        $totalFemale = User::students()->whereHas('studentProfile', function($q) {
            $q->where('gender', 'Female');
        })->count();

        $students = $query->with(['studentProfile', 'studentProfile.academicClass', 'studentProfile.section'])
                        ->latest()
                        ->paginate(10)
                        ->appends($request->all());
                        
        return view('admin.students.index', compact('students', 'totalStudents', 'totalMale', 'totalFemale'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = AcademicClass::all();
        $sections = Section::all(); // Ideally filtered by class via AJAX, but loading all for now.
        return view('admin.students.create', compact('classes', 'sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // User Data
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users', // Email optional for students? Usually required for login.
            'password' => 'required|string|min:6|confirmed',
            
            // Profile Data
            'admission_number' => 'required|string|unique:student_profiles',
            'admission_date' => 'required|date',
            'academic_class_id' => 'required|exists:academic_classes,id',
            'section_id' => 'required|exists:sections,id',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // 1. Create User
            $studentRole = Role::where('name', 'student')->firstOrFail();
            
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'], // null if not provided
                'password' => Hash::make($validatedData['password']),
                'role_id' => $studentRole->id,
            ]);

            // 2. Create Profile
            $profile = new StudentProfile();
            $profile->user_id = $user->id;
            $profile->admission_number = $validatedData['admission_number'];
            $profile->admission_date = $validatedData['admission_date'];
            $profile->academic_class_id = $validatedData['academic_class_id'];
            $profile->section_id = $validatedData['section_id'];
            $profile->dob = $validatedData['dob'];
            $profile->gender = $validatedData['gender'];
            $profile->father_name = $validatedData['father_name'];
            $profile->mother_name = $validatedData['mother_name'];
            $profile->phone = $validatedData['phone'];
            $profile->address = $validatedData['address'];

            // Auto-assign Roll Number
            $maxRoll = StudentProfile::where('academic_class_id', $validatedData['academic_class_id'])
                                     ->where('section_id', $validatedData['section_id'])
                                     ->max(DB::raw('CAST(roll_number AS UNSIGNED)'));
            
            $profile->roll_number = $maxRoll ? $maxRoll + 1 : 1;

            $profile->save();

            DB::commit();

            return redirect()->route('students.index')->with('success', 'Student admitted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error admitting student: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = User::with('studentProfile')->findOrFail($id);
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = User::with('studentProfile')->findOrFail($id);
        $classes = AcademicClass::all();
        $sections = Section::all();
        return view('admin.students.edit', compact('student', 'classes', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $student = User::findOrFail($id);
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $student->id,
            
            'academic_class_id' => 'required|exists:academic_classes,id',
            'section_id' => 'required|exists:sections,id',
            'phone' => 'nullable|string|max:20',
        ]);
        
        // Update User
        $student->name = $validatedData['name'];
        if($request->filled('password')) {
             $request->validate(['password' => 'min:6|confirmed']);
             $student->password = Hash::make($request->password);
        }
        $student->email = $validatedData['email'];
        $student->save();

        // Update Profile
        $profile = $student->studentProfile;
        
        // Check if class/section changed to re-assign roll number
        if ($profile->academic_class_id != $validatedData['academic_class_id'] || 
            $profile->section_id != $validatedData['section_id']) {
            
            $maxRoll = StudentProfile::where('academic_class_id', $validatedData['academic_class_id'])
                                     ->where('section_id', $validatedData['section_id'])
                                     ->max(DB::raw('CAST(roll_number AS UNSIGNED)'));
            
            $profile->roll_number = $maxRoll ? $maxRoll + 1 : 1;
        }

        $profile->update([
            'academic_class_id' => $validatedData['academic_class_id'],
            'section_id' => $validatedData['section_id'],
            'phone' => $validatedData['phone'],
            // Add other fields as needed for update
        ]);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = User::findOrFail($id);
        // Cascading delete should handle profile if configured in DB, but normally we delete relationships.
        // In migration we set onDelete('cascade') for user_id in profiles, so deleting user deletes profile.
        $student->delete();
        
        return redirect()->route('students.index')->with('success', 'Student record deleted.');
    }
}
