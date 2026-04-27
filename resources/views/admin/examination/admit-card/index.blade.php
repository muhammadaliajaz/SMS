@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Exam Admit Cards</h2>
            <p class="text-gray-500 mt-1">Generate and print examination gate passes</p>
        </div>
    </div>

    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-3 text-lg"></i>
                <p class="text-red-700 font-medium">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200 border border-gray-100 overflow-hidden mb-8 transition-all hover:shadow-2xl">
        <div class="px-8 py-6 bg-gray-900 border-b border-gray-80 flex justify-between items-center relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="text-xl font-bold text-white tracking-wide">Select Criteria</h3>
                <p class="text-gray-400 text-xs mt-1 font-medium opacity-80 uppercase tracking-widest">Filter Students for Admit Cards</p>
            </div>
            <div class="relative z-10 w-12 h-12 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center text-yellow-400 shadow-inner ring-1 ring-white/10">
                <i class="fas fa-id-card text-xl"></i>
            </div>
        </div>
        
        <div class="p-8">
            <form action="{{ route('admit-cards.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Exam Selection -->
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 ml-1">Select Examination <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-yellow-500 transition-colors">
                                <i class="fas fa-file-signature"></i>
                            </div>
                            <select name="exam_id" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-yellow-400 focus:ring-4 focus:ring-yellow-400/20 transition-all outline-none appearance-none cursor-pointer" required>
                                <option value="">-- Choose Exam --</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}" {{ (isset($selected_exam) && $selected_exam->id == $exam->id) ? 'selected' : '' }}>
                                        {{ $exam->name }} {{ $exam->term ? '('.$exam->term.')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Class Selection -->
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 ml-1">Select Class <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-yellow-500 transition-colors">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <select name="class_id" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-yellow-400 focus:ring-4 focus:ring-yellow-400/20 transition-all outline-none appearance-none cursor-pointer" required>
                                <option value="">-- Choose Class --</option>
                                @foreach($classes as $classItem)
                                    <option value="{{ $classItem->id }}" {{ (isset($selected_class) && $selected_class->id == $classItem->id) ? 'selected' : '' }}>
                                        {{ $classItem->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-end">
                     <button type="submit" class="px-8 py-3.5 bg-yellow-400 text-gray-900 rounded-xl hover:shadow-lg hover:shadow-yellow-400/30 ring-offset-2 focus:ring-4 focus:ring-yellow-300 font-bold shadow-md transform active:scale-95 transition-all flex items-center">
                        <i class="fas fa-search mr-2"></i> Search Students
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(isset($students) && count($students) > 0)
    <div class="bg-white rounded-xl shadow-lg shadow-gray-200 border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Student List</h3>
                <p class="text-sm text-gray-500">Class: {{ $selected_class->name }} | Exam: {{ $selected_exam->name }}</p>
            </div>
            
            <!-- Generate All Button -->
            <form action="{{ route('admit-cards.generate') }}" method="POST" target="_blank">
                @csrf
                <input type="hidden" name="exam_id" value="{{ $selected_exam->id }}">
                <input type="hidden" name="class_id" value="{{ $selected_class->id }}">
                <button type="submit" class="bg-gray-900 text-white px-5 py-2.5 rounded-xl hover:bg-gray-800 transition-all shadow-md hover:shadow-lg flex items-center font-bold">
                    <i class="fas fa-print mr-2"></i> Generate All Cards
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                        <th class="px-6 py-4">Roll No</th>
                        <th class="px-6 py-4">Admission No</th>
                        <th class="px-6 py-4">Student Name</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($students as $student)
                    <tr class="hover:bg-yellow-50 transition-colors group">
                        <td class="px-6 py-4 text-gray-600 font-medium">{{ $student->roll_number ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-600 font-medium">{{ $student->admission_number }}</td>
                        <td class="px-6 py-4">
                            <span class="text-gray-900 font-bold group-hover:text-yellow-700 transition-colors">{{ $student->user->name ?? $student->first_name }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admit-cards.generate') }}" method="POST" target="_blank" class="inline-block">
                                @csrf
                                <input type="hidden" name="exam_id" value="{{ $selected_exam->id }}">
                                <input type="hidden" name="class_id" value="{{ $selected_class->id }}">
                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                <button type="submit" class="text-gray-500 hover:text-gray-900 hover:bg-gray-100 px-3 py-1.5 rounded-lg font-medium text-sm transition-all border border-transparent hover:border-gray-200">
                                    <i class="fas fa-print mr-1"></i> Print Card
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @elseif(isset($students))
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                <i class="fas fa-user-graduate text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800">No Students Found</h3>
            <p class="text-gray-500 mt-2">There are no students enrolled in {{ $selected_class->name }} yet.</p>
        </div>
    @endif
</div>
@endsection
