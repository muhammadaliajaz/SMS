@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white shadow-sm rounded-2xl overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800">Student Attendance</h2>
            <p class="text-gray-500 text-sm mt-1">Select class and section to mark attendance.</p>
        </div>

        <div class="p-8">
            <form action="{{ route('attendance.create') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="class_id" class="block text-sm font-semibold text-gray-700 mb-2">Class</label>
                        <select name="class_id" id="class_id" required class="w-full rounded-lg border-gray-200 bg-gray-50 focus:border-yellow-400 focus:ring-yellow-400 p-3 transition">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="section_id" class="block text-sm font-semibold text-gray-700 mb-2">Section</label>
                        <select name="section_id" id="section_id" required class="w-full rounded-lg border-gray-200 bg-gray-50 focus:border-yellow-400 focus:ring-yellow-400 p-3 transition">
                            <option value="">Select Section</option>
                            @foreach(\App\Models\Section::all() as $section)
                                 <option value="{{ $section->id }}">{{ $section->name }}</option>
                             @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">Date</label>
                        <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}" required class="w-full rounded-lg border-gray-200 bg-gray-50 focus:border-yellow-400 focus:ring-yellow-400 p-3 transition">
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-yellow-400 text-gray-900 px-8 py-3 rounded-full font-bold hover:bg-yellow-500 transition shadow-sm flex items-center">
                        <span>Fetch Students</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
