@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold leading-tight text-gray-800">Section Details: {{ $section->name }}</h2>
             <div class="flex space-x-2">
                <a href="{{ route('sections.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow-sm hover:bg-gray-300 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Back to List
                </a>
                <a href="{{ route('sections.edit', $section->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-sm hover:bg-indigo-700 transition">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Academic Class</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $section->academicClass->name ?? 'N/A' }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Capacity</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $section->capacity ?? 'Unlimited' }}</dd>
                </div>
            </dl>

            <div class="mt-8 border-t border-gray-100 pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Students Enrolled</h3>
                <p class="text-gray-500 italic text-sm">Student list will be available once the student module is fully linked.</p>
                {{-- 
                <!-- Placeholder for future students list -->
                <ul class="divide-y divide-gray-100 mt-4">
                    @forelse($section->students as $student)
                        <li class="py-3 flex justify-between">
                            <span class="text-gray-800">{{ $student->name }}</span>
                            <a href="{{ route('students.show', $student->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">View Profile</a>
                        </li>
                    @empty
                        <li class="text-gray-500 italic">No students enrolled yet.</li>
                    @endforelse
                </ul> 
                --}}
            </div>
        </div>
    </div>
</div>
@endsection
