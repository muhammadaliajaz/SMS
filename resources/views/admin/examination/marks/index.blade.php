@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Marks Register</h2>
            <p class="text-gray-500 mt-1">Enter and manage student marks</p>
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
                    <i class="fas fa-edit text-lg"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white tracking-wide">Enter Student Marks</h3>
                     <p class="text-gray-400 text-xs font-medium uppercase tracking-widest mt-0.5">Select Subject to Input Grades</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <form action="{{ route('marks.index') }}" method="GET">
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
                            <select name="class_id" id="class_id" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-yellow-400 focus:ring-4 focus:ring-yellow-400/20 transition-all outline-none appearance-none cursor-pointer" required onchange="this.form.submit()">
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
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 ml-1">Subject <span class="text-red-500">*</span></label>
                        <div class="flex relative shadow-sm rounded-xl">
                             <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 z-10 transition-colors">
                                <i class="fas fa-book"></i>
                            </div>
                            <select name="subject_id" class="flex-1 pl-11 pr-4 py-3 rounded-l-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-yellow-400 focus:ring-4 focus:ring-yellow-400/20 transition-all outline-none appearance-none cursor-pointer" required>
                                <option value="">Select Subject</option>
                                @if(isset($classes) && request('class_id'))
                                    @php
                                        // Inline check - ideally better in Controller but simpler here for quick fix
                                    @endphp
                                    @foreach(\App\Models\Subject::where('academic_class_id', request('class_id'))->get() as $sub)
                                        <option value="{{ $sub->id }}" {{ request('subject_id') == $sub->id ? 'selected' : '' }}>
                                            {{ $sub->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                             <div class="absolute top-1/2 right-20 transform -translate-y-1/2 pointer-events-none text-gray-400 z-10">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                            <button type="submit" class="px-6 bg-yellow-400 text-gray-900 rounded-r-xl hover:bg-yellow-500 hover:shadow-lg hover:shadow-yellow-400/30 ring-offset-2 focus:ring-4 focus:ring-yellow-300 font-bold transition-all flex items-center justify-center">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(isset($students) && count($students) > 0)
        @if($schedule)
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r shadow-sm mb-6 flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-info-circle text-blue-500 mr-3 text-lg"></i>
                <div>
                     <p class="text-blue-800 font-semibold">Marks Configuration</p>
                     <p class="text-blue-600 text-sm">Full Marks: {{ $schedule->full_marks }} • Passing Marks: {{ $schedule->passing_marks }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-lg font-semibold text-gray-800">Student Marks</h3>
                <span class="text-sm text-gray-500">Entering marks for <span class="font-medium text-yellow-600">{{ count($students) }} Students</span></span>
            </div>
            
            <form action="{{ route('marks.store') }}" method="POST">
                @csrf
                <input type="hidden" name="exam_id" value="{{ request('exam_id') }}">
                <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                <th class="px-6 py-4 font-semibold w-24">Roll No</th>
                                <th class="px-6 py-4 font-semibold w-24">Adm No</th>
                                <th class="px-6 py-4 font-semibold">Student Name</th>
                                <th class="px-6 py-4 font-semibold w-48">Obtained Marks</th>
                                <th class="px-6 py-4 font-semibold">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($students as $index => $student)
                                @php
                                    $mark = \App\Models\Mark::where('exam_id', request('exam_id'))
                                        ->where('subject_id', request('subject_id'))
                                        ->where('student_id', $student->id)
                                        ->first();
                                    
                                    $marksObtained = $mark ? $mark->marks_obtained : '';
                                    if($marksObtained !== '') {
                                        $marksObtained = floatval($marksObtained); // Remove trailing zeros
                                    }
                                    
                                    $isFail = $marksObtained !== '' && $marksObtained < $schedule->passing_marks;
                                @endphp
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-mono font-bold text-gray-700">
                                        {{ $student->roll_number ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-mono text-gray-500">
                                        {{ $student->admission_number }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center mr-3 text-xs font-bold">
                                                {{ substr($student->user->name ?? $student->first_name, 0, 1) }}
                                            </div>
                                            <span class="font-medium text-gray-900">{{ $student->user->name ?? $student->first_name }}</span>
                                            <input type="hidden" name="marks[{{ $index }}][student_id]" value="{{ $student->id }}">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="relative">
                                            <input type="number" step="0.01" name="marks[{{ $index }}][marks_obtained]" 
                                                   class="w-full px-3 py-2 rounded border {{ $isFail ? 'border-red-300 bg-red-50 text-red-900 focus:ring-red-200' : 'border-gray-300 focus:border-yellow-500 focus:ring-yellow-200' }} focus:ring-2 transition-colors outline-none" 
                                                   value="{{ $marksObtained }}" 
                                                   max="{{ $schedule->full_marks }}"
                                                   placeholder="0-{{ $schedule->full_marks }}">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="marks[{{ $index }}][remarks]" class="w-full px-3 py-2 rounded border border-gray-300 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-colors outline-none text-sm" 
                                               value="{{ $mark ? $mark->remarks : '' }}" placeholder="Optional...">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-yellow-500 text-gray-900 rounded-lg hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 font-medium transition-all shadow-md hover:shadow-lg flex items-center">
                        <i class="fas fa-save mr-2"></i> Save Marks Register
                    </button>
                </div>
            </form>
        </div>
        @else
        <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-r shadow-sm">
            <div class="flex items-center mb-2">
                <i class="fas fa-calendar-times text-red-500 mr-3 text-xl"></i>
                <h3 class="text-red-800 font-semibold text-lg">Exam Not Scheduled</h3>
            </div>
            <p class="text-red-700">The selected subject has not been scheduled for this exam yet. Please go to the <strong>Exam Schedule</strong> page to define marks and date first.</p>
            <div class="mt-4">
                <a href="{{ route('exam-schedules.index', ['exam_id' => request('exam_id'), 'class_id' => request('class_id')]) }}" class="inline-flex items-center text-red-700 font-medium hover:underline">
                    Go to Schedule <i class="fas fa-arrow-right ml-2 text-sm"></i>
                </a>
            </div>
        </div>
        @endif
    @elseif(request('exam_id') && request('class_id') && request('subject_id'))
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r shadow-sm flex items-start">
            <i class="fas fa-user-slash text-yellow-400 mt-1 mr-3 text-lg"></i>
            <div>
                <h3 class="text-yellow-800 font-medium">No Students Found</h3>
                <p class="text-yellow-700 text-sm mt-1">There are no students enrolled in this class.</p>
            </div>
        </div>
    @else
        @if(!request('exam_id'))
        <div class="flex flex-col items-center justify-center bg-white rounded-xl border border-dashed border-gray-300 p-12 text-center text-gray-500">
            <i class="fas fa-edit text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-800">Ready to Enter Marks</h3>
            <p class="mt-1 max-w-sm">Select criteria above to load the student list and marks register.</p>
        </div>
        @endif
    @endif
</div>
@endsection
