@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-100">
        <div class="bg-gray-50 px-8 py-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">New Staff Registration</h2>
            <a href="{{ route('staff.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition flex items-center">
                 <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <form method="POST" action="{{ route('staff.store') }}" class="p-8">
            @csrf

            <!-- Section 1 -->
            <div class="mb-10">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                     <span class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center mr-3 text-sm">
                        <i class="fas fa-user-shield"></i>
                    </span>
                    Account & Role
                </h3>
                <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                             class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white" />
                        @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-1">
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                            class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white" />
                        @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-1">
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" id="password" required 
                             class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white" />
                        @error('password') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-1">
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required 
                             class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white" />
                    </div>
                    
                     <div class="sm:col-span-2">
                         <label for="role_id" class="block text-sm font-bold text-gray-700 mb-2">Role <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="role_id" name="role_id" required 
                                 class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white appearance-none">
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                             <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                        @error('role_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                     </div>
                </div>
            </div>

            <!-- Section 2 -->
             <div class="mb-10 border-t border-gray-100 pt-8">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                    <span class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center mr-3 text-sm">
                        <i class="fas fa-briefcase"></i>
                    </span>
                    Employment Details
                </h3>
                 <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-2">
                     <div class="sm:col-span-1">
                        <label for="employee_code" class="block text-sm font-bold text-gray-700 mb-2">Employee Code <span class="text-red-500">*</span></label>
                        <input type="text" name="employee_code" id="employee_code" value="{{ old('employee_code') }}" required 
                            class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white" />
                        @error('employee_code') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                     </div>
                     
                     <div class="sm:col-span-1">
                         <label for="designation" class="block text-sm font-bold text-gray-700 mb-2">Designation <span class="text-red-500">*</span></label>
                        <input type="text" name="designation" id="designation" value="{{ old('designation') }}" required 
                              class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white" />
                         @error('designation') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                     </div>
                     
                     <div class="sm:col-span-1">
                         <label for="joining_date" class="block text-sm font-bold text-gray-700 mb-2">Joining Date <span class="text-red-500">*</span></label>
                         <input type="date" name="joining_date" id="joining_date" value="{{ old('joining_date') }}" required 
                              class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white" />
                         @error('joining_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                     </div>
                     
                     <div class="sm:col-span-1">
                        <label for="department" class="block text-sm font-bold text-gray-700 mb-2">Department</label>
                        <input type="text" name="department" id="department" value="{{ old('department') }}" 
                             class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white" />
                        @error('department') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-1">
                        <label for="qualification" class="block text-sm font-bold text-gray-700 mb-2">Qualification</label>
                        <input type="text" name="qualification" id="qualification" value="{{ old('qualification') }}" 
                             class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white" />
                        @error('qualification') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-1">
                        <label for="basic_salary" class="block text-sm font-bold text-gray-700 mb-2">Basic Salary</label>
                        <input type="number" step="0.01" name="basic_salary" id="basic_salary" value="{{ old('basic_salary') }}" 
                             class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white" />
                        @error('basic_salary') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="address" class="block text-sm font-bold text-gray-700 mb-2">Address</label>
                        <textarea name="address" id="address" rows="3" class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white">{{ old('address') }}</textarea>
                        @error('address') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                 </div>
            </div>

            <!-- Section 3 -->
            <div class="mb-10 border-t border-gray-100 pt-8">
                 <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                    <span class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center mr-3 text-sm">
                        <i class="fas fa-id-card"></i>
                    </span>
                    Personal Information
                </h3>
                  <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-2">
                      <div class="sm:col-span-1">
                           <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Phone <span class="text-red-500">*</span></label>
                           <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required 
                                 class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white" />
                           @error('phone') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                      </div>
                      
                      <div class="sm:col-span-1">
                           <label for="gender" class="block text-sm font-bold text-gray-700 mb-2">Gender <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select id="gender" name="gender" required 
                                    class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white appearance-none">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                      </div>
                  </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end">
                <a href="{{ route('staff.index') }}" class="px-6 py-3 rounded-full border border-gray-200 text-gray-700 font-bold hover:bg-gray-50 transition mr-4">
                    Cancel
                </a>
                <button type="submit" class="bg-yellow-400 text-gray-900 px-8 py-3 rounded-full font-bold hover:bg-yellow-500 transition shadow-sm flex items-center">
                    <i class="fas fa-check mr-2"></i> Create Record
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
