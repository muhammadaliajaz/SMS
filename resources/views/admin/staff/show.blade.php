@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-100">
        <!-- Header -->
        <div class="relative bg-gray-900 px-8 py-10 overflow-hidden">
             <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <svg class="h-full w-full" width="100%" height="100%" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M0 40L40 0H20L0 20M40 40V20L20 40" stroke="white" stroke-width="2"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid-pattern)"/>
                </svg>
            </div>
            
            <div class="relative flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-20 w-20 rounded-full border-4 border-yellow-400 overflow-hidden shadow-lg bg-white">
                        <img class="w-full h-full object-cover"
                             src="https://ui-avatars.com/api/?name={{ $staff->name }}&color=1F2937&background=FBBF24&size=128"
                             alt="{{ $staff->name }}" />
                    </div>
                    <div class="ml-6 text-white card-header-content">
                        <h1 class="text-3xl font-bold">{{ $staff->name }}</h1>
                        <div class="flex items-center mt-2 text-yellow-400">
                            <span class="bg-yellow-400/20 text-yellow-300 px-3 py-1 rounded-full text-sm font-bold uppercase tracking-wide border border-yellow-400/30">
                                {{ $staff->staffProfile->designation ?? 'Staff Member' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('staff.edit', $staff->id) }}" class="bg-yellow-400 text-gray-900 px-5 py-2.5 rounded-full font-bold hover:bg-yellow-500 transition shadow-lg flex items-center">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                    <a href="{{ route('staff.index') }}" class="bg-white/10 text-white border border-white/20 px-5 py-2.5 rounded-full font-bold hover:bg-white/20 transition backdrop-blur-sm">
                         Back
                    </a>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="px-8 py-8">
            
            <!-- Employee Details Section -->
            <div class="mb-10">
                <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3 mb-6 flex items-center">
                    <span class="w-2 h-8 bg-yellow-400 rounded-full mr-3"></span>
                    Employee Details
                </h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <dt class="text-xs font-bold text-gray-500 uppercase tracking-wide">Employee Code</dt>
                        <dd class="mt-1 text-sm font-bold text-gray-900 font-mono">{{ $staff->staffProfile->employee_code ?? 'N/A' }}</dd>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <dt class="text-xs font-bold text-gray-500 uppercase tracking-wide">Department</dt>
                        <dd class="mt-1 text-sm font-bold text-gray-900">{{ $staff->staffProfile->department ?? 'N/A' }}</dd>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                         <dt class="text-xs font-bold text-gray-500 uppercase tracking-wide">Joining Date</dt>
                         <dd class="mt-1 text-sm font-bold text-gray-900">{{ $staff->staffProfile->joining_date ?? 'N/A' }}</dd>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <dt class="text-xs font-bold text-gray-500 uppercase tracking-wide">Qualification</dt>
                        <dd class="mt-1 text-sm font-bold text-gray-900">{{ $staff->staffProfile->qualification ?? 'N/A' }}</dd>
                    </div>
                     <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <dt class="text-xs font-bold text-gray-500 uppercase tracking-wide">System Role</dt>
                        <dd class="mt-1">
                             <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-gray-200 text-gray-800">
                                {{ ucfirst($staff->role->name) }}
                            </span>
                        </dd>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <dt class="text-xs font-bold text-gray-500 uppercase tracking-wide">Basic Salary</dt>
                        <dd class="mt-1 text-sm font-bold text-gray-900 font-mono">{{ $staff->staffProfile->basic_salary ? '$'. number_format($staff->staffProfile->basic_salary, 2) : 'N/A' }}</dd>
                    </div>
                </dl>
            </div>

             <!-- Contact Information Section -->
             <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3 mb-6 flex items-center">
                    <span class="w-2 h-8 bg-yellow-400 rounded-full mr-3"></span>
                    Contact & Personal
                </h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-start">
                         <div class="flex-shrink-0 mr-4 mt-1">
                             <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-gray-400 border border-gray-200">
                                 <i class="fas fa-envelope text-sm"></i>
                             </div>
                         </div>
                         <div>
                            <dt class="text-xs font-bold text-gray-500 uppercase tracking-wide">Email Address</dt>
                            <dd class="mt-1 text-sm font-bold text-gray-900">{{ $staff->email }}</dd>
                         </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-start">
                        <div class="flex-shrink-0 mr-4 mt-1">
                             <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-gray-400 border border-gray-200">
                                 <i class="fas fa-phone text-sm"></i>
                             </div>
                         </div>
                         <div>
                            <dt class="text-xs font-bold text-gray-500 uppercase tracking-wide">Phone Number</dt>
                            <dd class="mt-1 text-sm font-bold text-gray-900">{{ $staff->staffProfile->phone ?? 'N/A' }}</dd>
                        </div>
                    </div>
                     <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-start">
                        <div class="flex-shrink-0 mr-4 mt-1">
                             <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-gray-400 border border-gray-200">
                                 <i class="fas fa-venus-mars text-sm"></i>
                             </div>
                         </div>
                         <div>
                            <dt class="text-xs font-bold text-gray-500 uppercase tracking-wide">Gender</dt>
                            <dd class="mt-1 text-sm font-bold text-gray-900">{{ $staff->staffProfile->gender ?? 'N/A' }}</dd>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-start col-span-1 md:col-span-2"> <!-- Spans full width on medium screens if desired, or mostly full -->
                         <div class="flex-shrink-0 mr-4 mt-1">
                             <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-gray-400 border border-gray-200">
                                 <i class="fas fa-map-marker-alt text-sm"></i>
                             </div>
                         </div>
                         <div>
                            <dt class="text-xs font-bold text-gray-500 uppercase tracking-wide">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $staff->staffProfile->address ?? 'No address provided' }}
                            </dd>
                        </div>
                    </div>
                </dl>
            </div>

        </div>
    </div>
</div>
@endsection
