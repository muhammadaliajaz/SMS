@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800">System Settings</h2>
        <p class="text-gray-500 mt-1">Configure global application preferences.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-100 bg-gray-50">
            <h3 class="text-xl font-bold text-gray-800">General Configuration</h3>
            <p class="mt-1 text-sm text-gray-500">Update your school's basic information.</p>
        </div>
        
        <div class="p-8">
            <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 gap-6">
                    <!-- Logo Upload -->
                    <div class="flex items-center space-x-6">
                        <div class="shrink-0">
                            @if(isset($settings['school_logo']) && $settings['school_logo'])
                                <img class="h-20 w-20 object-cover rounded-full border border-gray-200" src="{{ asset($settings['school_logo']) }}" alt="School Logo">
                            @else
                                <div class="h-20 w-20 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                    <i class="fas fa-camera text-2xl"></i>
                                </div>
                            @endif
                        </div>
                        <label class="block">
                            <span class="sr-only">Choose profile photo</span>
                            <input type="file" name="school_logo" class="block w-full text-sm text-slate-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0
                              file:text-sm file:font-semibold
                              file:bg-yellow-50 file:text-yellow-700
                              hover:file:bg-yellow-100 transition
                            "/>
                        </label>
                    </div>

                    <!-- School Name -->
                    <div>
                        <label for="school_name" class="block text-sm font-semibold text-gray-700 mb-2">School Name</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-school text-gray-400"></i>
                            </div>
                            <input type="text" name="school_name" id="school_name" value="{{ old('school_name', $settings['school_name']) }}" class="pl-10 block w-full rounded-lg border-gray-200 focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm p-3 transition" placeholder="EMS">
                        </div>
                        @error('school_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                     <div>
                        <label for="school_address" class="block text-sm font-semibold text-gray-700 mb-2">School Address</label>
                        <div class="relative rounded-md shadow-sm">
                             <div class="absolute inset-y-0 left-0 pl-3 pt-3 pointer-events-none">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                            <textarea name="school_address" id="school_address" rows="2" class="pl-10 block w-full rounded-lg border-gray-200 focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm p-3 transition" placeholder="Pakpattan, Pakistan.">{{ old('school_address', $settings['school_address']) }}</textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Phone -->
                        <div>
                            <label for="school_phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                            <input type="text" name="school_phone" value="{{ old('school_phone', $settings['school_phone']) }}" class="block w-full rounded-lg border-gray-200 focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm p-3 transition" placeholder="+92 3026572894">
                        </div>
                        <!-- Email -->
                        <div>
                            <label for="school_email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                             <input type="email" name="school_email" value="{{ old('school_email', $settings['school_email']) }}" class="block w-full rounded-lg border-gray-200 focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm p-3 transition" placeholder="chaudharyaliajaz@gmail.com">
                        </div>
                    </div>

                    <!-- Current Session -->
                    <div>
                        <label for="session" class="block text-sm font-semibold text-gray-700 mb-2">Current Academic Session</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                            <select name="session" id="session" class="pl-10 block w-full rounded-lg border-gray-200 focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm p-3 transition bg-white">
                                <option value="2024-2025" {{ old('session', $settings['session']) == '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                                <option value="2025-2026" {{ old('session', $settings['session']) == '2025-2026' ? 'selected' : '' }}>2025-2026</option>
                                <option value="2026-2027" {{ old('session', $settings['session']) == '2026-2027' ? 'selected' : '' }}>2026-2027</option>
                            </select>
                        </div>
                         @error('session')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-sm text-sm font-bold text-gray-900 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition">
                            Save Configuration
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
