@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <!-- Top Bar -->
    <div class="flex justify-between items-center mb-6 max-w-5xl mx-auto">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Mark Attendance</h2>
            <p class="text-gray-500 mt-1">
                {{ $class->name }} • {{ $section->name }} • {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}
            </p>
        </div>
        <a href="{{ route('attendance.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition flex items-center bg-white px-4 py-2 rounded-full shadow-sm">
            <i class="fas fa-arrow-left mr-2"></i> Change Selection
        </a>
    </div>

    <div class="max-w-5xl mx-auto bg-white shadow-sm rounded-2xl overflow-hidden">
        <form action="{{ route('attendance.store') }}" method="POST">
            @csrf
            <input type="hidden" name="class_id" value="{{ $class->id }}">
            <input type="hidden" name="section_id" value="{{ $section->id }}">
            <input type="hidden" name="date" value="{{ $date }}">

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-50">
                    <thead class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-3 bg-white border-b border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <span class="text-sm font-semibold text-gray-500 mr-2">Quick Actions:</span>
                                    <button type="button" onclick="markAll('present')" class="text-xs font-bold bg-green-50 text-green-600 px-3 py-1.5 rounded-lg hover:bg-green-100 transition border border-green-200">
                                        <i class="fas fa-check mr-1"></i> Mark All Present
                                    </button>
                                    <button type="button" onclick="markAll('absent')" class="text-xs font-bold bg-red-50 text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-100 transition border border-red-200">
                                        <i class="fas fa-times mr-1"></i> Mark All Absent
                                    </button>
                                    <button type="button" onclick="resetAll()" class="text-xs font-bold bg-gray-50 text-gray-500 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition border border-gray-200">
                                        <i class="fas fa-undo mr-1"></i> Reset
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Student Name
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Remarks
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-50">
                        @forelse($students as $student)
                            @php
                                $status = isset($attendances[$student->id]) ? $attendances[$student->id]->status : 'present';
                                $remark = isset($attendances[$student->id]) ? $attendances[$student->id]->remarks : '';
                            @endphp
                            <tr class="hover:bg-yellow-50 transition group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-800">{{ $student->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $student->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex justify-center space-x-2 bg-gray-50 inline-flex rounded-lg p-1">
                                        <!-- Present -->
                                        <label class="cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="present" {{ $status == 'present' ? 'checked' : '' }} class="peer sr-only">
                                            <div class="px-3 py-1.5 rounded-md text-xs font-bold text-gray-500 peer-checked:bg-green-500 peer-checked:text-white transition">P</div>
                                        </label>
                                        <!-- Absent -->
                                        <label class="cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="absent" {{ $status == 'absent' ? 'checked' : '' }} class="peer sr-only">
                                            <div class="px-3 py-1.5 rounded-md text-xs font-bold text-gray-500 peer-checked:bg-red-500 peer-checked:text-white transition">A</div>
                                        </label>
                                        <!-- Late -->
                                        <label class="cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="late" {{ $status == 'late' ? 'checked' : '' }} class="peer sr-only">
                                            <div class="px-3 py-1.5 rounded-md text-xs font-bold text-gray-500 peer-checked:bg-yellow-500 peer-checked:text-white transition">L</div>
                                        </label>
                                        <!-- Excused -->
                                        <label class="cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="excused" {{ $status == 'excused' ? 'checked' : '' }} class="peer sr-only">
                                            <div class="px-3 py-1.5 rounded-md text-xs font-bold text-gray-500 peer-checked:bg-blue-500 peer-checked:text-white transition">E</div>
                                        </label>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="text" name="remarks[{{ $student->id }}]" value="{{ $remark }}" placeholder="Add note..." class="w-full text-sm border-none bg-gray-50 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:bg-white transition px-3 py-2">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-400">
                                    No students found in this class.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end">
                <button type="submit" class="bg-yellow-400 text-gray-900 px-8 py-3 rounded-full font-bold hover:bg-yellow-500 transition shadow-sm flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    Save Attendance
                </button>
            </div>
        </form>
    </div>
</div>
</div>

<script>
    function markAll(status) {
        const radios = document.querySelectorAll(`input[type="radio"][value="${status}"]`);
        radios.forEach(radio => {
            radio.checked = true;
        });
    }

    function resetAll() {
        const radios = document.querySelectorAll('input[type="radio"]');
        radios.forEach(radio => {
            radio.checked = false;
        });
    }
</script>
@endsection
