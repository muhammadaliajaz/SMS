@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Exam Scheduling</h2>
            <p class="text-gray-500 mt-1">Manage time tables and room allocations</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r shadow-sm flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200 border border-gray-100 overflow-hidden mb-6 transition-all hover:shadow-2xl">
        <div class="px-8 py-5 bg-gray-900 border-b border-gray-800 flex justify-between items-center relative overflow-hidden">
             <div class="relative z-10 flex items-center">
                <div class="w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center mr-4 text-gray-900 shadow-lg shadow-yellow-400/20">
                    <i class="fas fa-calendar-alt text-lg"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white tracking-wide">Schedule Examinations</h3>
                     <p class="text-gray-400 text-xs font-medium uppercase tracking-widest mt-0.5">Manage Dates, Times & Rooms</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <form action="{{ route('exam-schedules.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 ml-1">Examination <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-yellow-500 transition-colors">
                                <i class="fas fa-file-signature"></i>
                            </div>
                            <select name="exam_id" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-yellow-400 focus:ring-4 focus:ring-yellow-400/20 transition-all outline-none appearance-none cursor-pointer" required>
                                <option value="">Select Exam</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}" {{ request('exam_id') == $exam->id ? 'selected' : '' }}>
                                        {{ $exam->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 ml-1">Class <span class="text-red-500">*</span></label>
                         <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-yellow-500 transition-colors">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <select name="class_id" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-yellow-400 focus:ring-4 focus:ring-yellow-400/20 transition-all outline-none appearance-none cursor-pointer" required>
                                <option value="">Select Class</option>
                                @foreach($classes as $classItem)
                                    <option value="{{ $classItem->id }}" {{ request('class_id') == $classItem->id ? 'selected' : '' }}>
                                        {{ $classItem->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full px-6 py-3 bg-yellow-400 text-gray-900 rounded-xl hover:bg-yellow-500 hover:shadow-lg hover:shadow-yellow-400/30 focus:ring-4 focus:ring-yellow-300 font-bold transition-all transform active:scale-95 flex items-center justify-center">
                            <i class="fas fa-search mr-2"></i> Fetch Subjects
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(isset($subjects) && count($subjects) > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-semibold text-gray-800">Schedule Details</h3>
            <span class="text-sm text-gray-500">Configuring for <span class="font-medium text-indigo-600">{{ count($subjects) }} Subjects</span></span>
        </div>
        
        <form action="{{ route('exam-schedules.store') }}" method="POST">
            @csrf
            <input type="hidden" name="exam_id" value="{{ request('exam_id') }}">
            <input type="hidden" name="academic_class_id" value="{{ request('class_id') }}">

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-semibold w-1/6">Subject</th>
                            <th class="px-6 py-4 font-semibold w-1/6">Date</th>
                            <th class="px-6 py-4 font-semibold w-1/6">Time</th>
                            <th class="px-6 py-4 font-semibold w-1/6">Room</th>
                            <th class="px-6 py-4 font-semibold w-1/6">Marks (Full / Pass)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($subjects as $index => $subject)
                            @php
                                $existingSchedule = $schedules->firstWhere('subject_id', $subject->id);
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded bg-indigo-50 text-indigo-600 flex items-center justify-center mr-3 font-bold text-xs ring-1 ring-indigo-100">
                                            {{ substr($subject->name, 0, 2) }}
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $subject->name }}</span>
                                        <input type="hidden" name="schedules[{{ $index }}][subject_id]" value="{{ $subject->id }}">
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <input type="date" name="schedules[{{ $index }}][date_of_exam]" class="w-full px-3 py-1.5 rounded border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-200 text-sm outline-none transition-colors" 
                                           value="{{ $existingSchedule ? $existingSchedule->date_of_exam : old('schedules.'.$index.'.date_of_exam') }}" required>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <input type="time" name="schedules[{{ $index }}][start_time]" class="w-full px-2 py-1.5 rounded border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-200 text-sm outline-none transition-colors"
                                               value="{{ $existingSchedule ? Carbon\Carbon::parse($existingSchedule->start_time)->format('H:i') : old('schedules.'.$index.'.start_time') }}" required>
                                        <span class="text-gray-400 self-center">-</span>
                                        <input type="time" name="schedules[{{ $index }}][end_time]" class="w-full px-2 py-1.5 rounded border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-200 text-sm outline-none transition-colors"
                                               value="{{ $existingSchedule ? Carbon\Carbon::parse($existingSchedule->end_time)->format('H:i') : old('schedules.'.$index.'.end_time') }}" required>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <input type="text" name="schedules[{{ $index }}][room_no]" class="w-full px-3 py-1.5 rounded border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-200 text-sm outline-none transition-colors"
                                           value="{{ $existingSchedule ? $existingSchedule->room_no : old('schedules.'.$index.'.room_no') }}" placeholder="Room No">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <div class="relative">
                                            <input type="number" name="schedules[{{ $index }}][full_marks]" class="w-20 pl-3 pr-2 py-1.5 rounded border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-200 text-sm outline-none transition-colors"
                                                   value="{{ $existingSchedule ? $existingSchedule->full_marks : (old('schedules.'.$index.'.full_marks') ?? 100) }}" required>
                                            <span class="text-[10px] text-gray-400 absolute -top-2 left-2 bg-white px-1">Full</span>
                                        </div>
                                        <span class="text-gray-300">/</span>
                                        <div class="relative">
                                            <input type="number" name="schedules[{{ $index }}][passing_marks]" class="w-20 pl-3 pr-2 py-1.5 rounded border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-200 text-sm outline-none transition-colors"
                                                   value="{{ $existingSchedule ? $existingSchedule->passing_marks : (old('schedules.'.$index.'.passing_marks') ?? 33) }}" required>
                                            <span class="text-[10px] text-gray-400 absolute -top-2 left-2 bg-white px-1">Pass</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium transition-all shadow-md hover:shadow-lg flex items-center">
                    <i class="fas fa-save mr-2"></i> Save Schedule
                </button>
            </div>
        </form>
    </div>
    @elseif(request('exam_id') && request('class_id'))
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r shadow-sm flex items-start">
        <i class="fas fa-exclamation-triangle text-yellow-400 mt-1 mr-3 text-lg"></i>
        <div>
            <h3 class="text-yellow-800 font-medium">No Subjects Found</h3>
            <p class="text-yellow-700 text-sm mt-1">No subjects have been assigned to this class yet. Please add subjects to the class first.</p>
        </div>
    </div>
    @else
    <div class="flex flex-col items-center justify-center bg-white rounded-xl border border-dashed border-gray-300 p-12 text-center text-gray-500">
        <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
        <h3 class="text-lg font-medium text-gray-800">Ready to Schedule</h3>
        <p class="mt-1 max-w-sm">Select an exam and a class from the dropdowns above to start creating the schedule.</p>
    </div>
    @endif
</div>
@endsection
