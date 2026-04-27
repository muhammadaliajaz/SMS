@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between items-center mb-6">
             <div>
                <h2 class="text-2xl font-semibold leading-tight text-gray-800">Student Profile</h2>
                <p class="text-gray-500 text-sm mt-1">Admission No: {{ $student->studentProfile->admission_number ?? 'N/A' }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('students.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow-sm hover:bg-gray-300 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Back to List
                </a>
                <a href="{{ route('students.edit', $student->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-sm hover:bg-indigo-700 transition">
                    <i class="fas fa-edit mr-2"></i>Edit Profile
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Sidebar / Key Info -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6 text-center border-b border-gray-100">
                         <div class="relative w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden border-4 border-indigo-50">
                            <img class="object-cover w-full h-full" 
                                 src="https://ui-avatars.com/api/?name={{ $student->name }}&size=200&background=4f46e5&color=fff" 
                                 alt="{{ $student->name }}">
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">{{ $student->name }}</h3>
                        <p class="text-indigo-600 font-medium">{{ $student->email }}</p>
                        <div class="mt-4 flex justify-center space-x-2">
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Active</span>
                             <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">Student</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-gray-500 text-sm">Class</span>
                            <span class="font-medium text-gray-900">{{ $student->studentProfile->academicClass->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-gray-500 text-sm">Section</span>
                            <span class="font-medium text-gray-900">{{ $student->studentProfile->section->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 text-sm">Joined</span>
                            <span class="font-medium text-gray-900">{{ $student->studentProfile->admission_date ? \Carbon\Carbon::parse($student->studentProfile->admission_date)->format('M d, Y') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Details -->
            <div class="md:col-span-2 space-y-6">
                <!-- Personal Details -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-medium text-gray-900">Personal Details</h3>
                    </div>
                    <div class="p-6">
                         <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $student->studentProfile->dob ?? 'N/A' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Gender</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($student->studentProfile->gender ?? 'N/A') }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Address</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $student->studentProfile->address ?? 'N/A' }}</dd>
                            </div>
                         </dl>
                    </div>
                </div>

                <!-- Family & Contact -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-medium text-gray-900">Family & Contact</h3>
                    </div>
                    <div class="p-6">
                         <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Father's Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $student->studentProfile->father_name ?? 'N/A' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Mother's Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $student->studentProfile->mother_name ?? 'N/A' }}</dd>
                            </div>
                             <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Emergency Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $student->studentProfile->phone ?? 'N/A' }}</dd>
                            </div>
                         </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
