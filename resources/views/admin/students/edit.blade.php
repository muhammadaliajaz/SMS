@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-lg overflow-hidden border border-gray-100">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Edit Student Profile</h2>
            <a href="{{ route('students.index') }}" class="text-sm text-gray-600 hover:text-indigo-600">
                <i class="fas fa-arrow-left mr-1"></i> Back to List
            </a>
        </div>

        <form method="POST" action="{{ route('students.update', $student->id) }}" class="p-6 sm:p-8">
            @csrf
            @method('PUT')

            <!-- Section 1: Login Details -->
            <div class="mb-8">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4 border-l-4 border-indigo-500 pl-3">
                    Account Details
                </h3>
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="text" name="name" id="name" value="{{ old('name', $student->name) }}" required 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border">
                        </div>
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <div class="mt-1">
                            <input type="email" name="email" id="email" value="{{ old('email', $student->email) }}" 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border">
                        </div>
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Academic Details -->
            <div class="mb-8 border-t border-gray-200 pt-8">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4 border-l-4 border-emerald-500 pl-3">
                    Academic Details
                </h3>
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-2">
                        <label for="admission_number" class="block text-sm font-medium text-gray-700">Admission No</label>
                        <div class="mt-1">
                            <input type="text" name="admission_number" id="admission_number" value="{{ old('admission_number', $student->studentProfile->admission_number ?? '') }}" 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border bg-gray-50 text-gray-500" readonly>
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="academic_class_id" class="block text-sm font-medium text-gray-700">Class <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <select id="academic_class_id" name="academic_class_id" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border bg-white">
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ (old('academic_class_id', $student->studentProfile->academic_class_id) == $class->id) ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('academic_class_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="section_id" class="block text-sm font-medium text-gray-700">Section <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <select id="section_id" name="section_id" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border bg-white">
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}" {{ (old('section_id', $student->studentProfile->section_id) == $section->id) ? 'selected' : '' }}>
                                        {{ $section->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('section_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Section 3: Personal Details -->
            <div class="mb-8 border-t border-gray-200 pt-8">
                 <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4 border-l-4 border-amber-500 pl-3">
                    Personal Details
                </h3>
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-2">
                        <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <div class="mt-1">
                            <input type="date" name="dob" id="dob" value="{{ old('dob', $student->studentProfile->dob ?? '') }}" 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border">
                        </div>
                        @error('dob') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                        <div class="mt-1">
                            <select id="gender" name="gender" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border bg-white">
                                <option value="Male" {{ (old('gender', $student->studentProfile->gender ?? '') == 'Male') ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ (old('gender', $student->studentProfile->gender ?? '') == 'Female') ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ (old('gender', $student->studentProfile->gender ?? '') == 'Other') ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                        <div class="mt-1">
                             <input type="text" name="phone" id="phone" value="{{ old('phone', $student->studentProfile->phone ?? '') }}" 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="father_name" class="block text-sm font-medium text-gray-700">Father's Name</label>
                        <div class="mt-1">
                            <input type="text" name="father_name" id="father_name" value="{{ old('father_name', $student->studentProfile->father_name ?? '') }}" 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="mother_name" class="block text-sm font-medium text-gray-700">Mother's Name</label>
                        <div class="mt-1">
                            <input type="text" name="mother_name" id="mother_name" value="{{ old('mother_name', $student->studentProfile->mother_name ?? '') }}" 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border">
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <div class="mt-1">
                            <textarea id="address" name="address" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md p-2.5">{{ old('address', $student->studentProfile->address ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-5 border-t border-gray-200">
                <div class="flex justify-end">
                    <a href="{{ route('students.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Student
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
