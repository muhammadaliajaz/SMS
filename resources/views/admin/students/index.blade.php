@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <!-- Header -->
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Students</h2>
                <p class="text-gray-500 mt-1">Manage student records and admissions.</p>
            </div>
            <a href="{{ route('students.create') }}" class="flex items-center space-x-2 bg-yellow-400 text-gray-900 px-6 py-2.5 rounded-full font-bold hover:bg-yellow-500 transition shadow-sm">
                <i class="fas fa-plus-circle text-lg"></i>
                <span>Admit Student</span>
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Students -->
            <div class="bg-gray-900 rounded-2xl p-6 shadow-sm relative overflow-hidden text-white">
                <div class="relative z-10">
                    <p class="text-sm font-semibold text-gray-400 mb-1">Total Students</p>
                    <h3 class="text-3xl font-bold mb-2">{{ $totalStudents }}</h3>
                </div>
                <div class="absolute right-4 top-4 opacity-10">
                    <i class="fas fa-users text-6xl text-white"></i>
                </div>
            </div>

            <!-- Boys -->
            <div class="bg-white rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 mb-1">Boys</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $totalMale }}</h3>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl text-blue-500">
                        <i class="fas fa-mars text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Girls -->
            <div class="bg-white rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 mb-1">Girls</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $totalFemale }}</h3>
                    </div>
                    <div class="p-3 bg-pink-50 rounded-xl text-pink-500">
                        <i class="fas fa-venus text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="bg-white rounded-2xl p-4 shadow-sm mb-6">
             <form method="GET" action="{{ route('students.index') }}" class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="relative w-full max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-search text-gray-300"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, adm no, phone..." class="w-full pl-10 pr-4 py-2 border-none ring-1 ring-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none bg-gray-50 text-sm">
                </div>
                
                <div class="flex space-x-2">
                    <button type="submit" class="px-4 py-2 bg-yellow-400 text-gray-900 rounded-lg text-sm font-bold hover:bg-yellow-500 transition shadow-sm">
                        <i class="fas fa-search mr-2"></i> Search
                    </button>
                    
                    @if(request('search'))
                        <a href="{{ route('students.index') }}" class="px-4 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-medium hover:bg-red-100 transition">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                            <th class="px-6 py-4">Adm. No</th>
                            <th class="px-6 py-4">Student Name</th>
                            <th class="px-6 py-4">Class</th>
                            <th class="px-6 py-4">Contact</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($students as $student)
                        <tr class="hover:bg-yellow-50 transition group">
                            <td class="px-6 py-4 text-sm font-mono text-gray-500">
                                #{{ $student->studentProfile->admission_number ?? '--' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500 mr-3">
                                        {{ substr($student->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $student->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $student->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    {{ $student->studentProfile->academicClass->name ?? 'N/A' }} 
                                    <span class="text-gray-400 mx-1">•</span> 
                                    {{ $student->studentProfile->section->name ?? '' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $student->studentProfile->phone ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-right">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('students.show', $student->id) }}" class="text-gray-500 hover:text-gray-600 p-1" title="View Profile">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('students.edit', $student->id) }}" class="text-gray-500 hover:text-yellow-600 p-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this student?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-500 hover:text-red-600 p-1" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                No students found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $students->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>
@endsection
