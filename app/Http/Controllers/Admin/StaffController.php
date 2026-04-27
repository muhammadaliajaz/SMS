<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\StaffProfile;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch users who have a staff profile
        $staffMembers = User::staff()
                        ->has('staffProfile')
                        ->with(['staffProfile', 'role'])
                        ->latest()
                        ->paginate(10);
                        
        return view('admin.staff.index', compact('staffMembers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get roles suitable for staff. Excluding 'student', 'parent', 'front_office' if desired, 
        // or just show all non-student/parent ones.
        $roles = Role::whereNotIn('name', ['student', 'parent', 'admin'])->get();
        return view('admin.staff.create', compact('roles'));
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
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
            
            // Profile Data
            'employee_code' => 'required|string|unique:staff_profiles',
            'designation' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'joining_date' => 'required|date',
            'basic_salary' => 'nullable|numeric|min:0',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'gender' => 'required|in:Male,Female,Other',
        ]);

        DB::beginTransaction();

        try {
            // 1. Create User
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role_id' => $validatedData['role_id'],
            ]);

            // 2. Create Profile
            $profile = new StaffProfile();
            $profile->user_id = $user->id;
            $profile->employee_code = $validatedData['employee_code'];
            $profile->designation = $validatedData['designation'];
            $profile->department = $validatedData['department'];
            $profile->qualification = $validatedData['qualification'];
            $profile->joining_date = $validatedData['joining_date'];
            $profile->basic_salary = $validatedData['basic_salary'];
            $profile->phone = $validatedData['phone'];
            $profile->address = $validatedData['address'];
            $profile->gender = $validatedData['gender'];
            $profile->save();

            DB::commit();

            return redirect()->route('staff.index')->with('success', 'Staff member added successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error adding staff: ' . $e->getMessage());
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
        $staff = User::with(['staffProfile', 'role'])->findOrFail($id);
        return view('admin.staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staff = User::with('staffProfile')->findOrFail($id);
        $roles = Role::whereNotIn('name', ['student', 'parent', 'admin'])->get();
        return view('admin.staff.edit', compact('staff', 'roles'));
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
        $staff = User::findOrFail($id);
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $staff->id,
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'basic_salary' => 'nullable|numeric|min:0',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:Male,Female,Other',
        ]);
        
        // Update User
        $staff->name = $validatedData['name'];
        if($request->filled('password')) {
             $request->validate(['password' => 'min:6|confirmed']);
             $staff->password = Hash::make($request->password);
        }
        $staff->email = $validatedData['email'];
        $staff->role_id = $validatedData['role_id'];
        $staff->save();

        // Update Profile
        $staff->staffProfile->update([
            'phone' => $validatedData['phone'] ?? null,
            'designation' => $validatedData['designation'] ?? null,
            'department' => $validatedData['department'] ?? null,
            'qualification' => $validatedData['qualification'] ?? null,
            'joining_date' => $validatedData['joining_date'] ?? null,
            'basic_salary' => $validatedData['basic_salary'] ?? null,
            'address' => $validatedData['address'] ?? null,
            'gender' => $validatedData['gender'] ?? null,
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staff = User::findOrFail($id);
        $staff->delete();
        
        return redirect()->route('staff.index')->with('success', 'Staff record deleted.');
    }
}
