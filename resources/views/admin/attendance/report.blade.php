@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Monthly Report</h2>
        <p class="text-gray-500 mt-1">View student attendance records by month.</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-8">
        <form action="{{ route('attendance.report') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-6 items-end">
            <div>
                <label for="class_id" class="block text-sm font-semibold text-gray-700 mb-2">Class</label>
                <select name="class_id" id="class_id" class="w-full rounded-lg border-gray-200 bg-gray-50 focus:border-yellow-400 focus:ring-yellow-400 p-2.5 transition text-sm">
                    <option value="">Select Class</option>
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ $class_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="section_id" class="block text-sm font-semibold text-gray-700 mb-2">Section</label>
                <select name="section_id" id="section_id" class="w-full rounded-lg border-gray-200 bg-gray-50 focus:border-yellow-400 focus:ring-yellow-400 p-2.5 transition text-sm">
                    <option value="">Select Section</option>
                     @foreach(\App\Models\Section::all() as $s)
                         <option value="{{ $s->id }}" {{ $section_id == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                     @endforeach
                </select>
            </div>
            <div>
                <label for="month" class="block text-sm font-semibold text-gray-700 mb-2">Month</label>
                <select name="month" id="month" class="w-full rounded-lg border-gray-200 bg-gray-50 focus:border-yellow-400 focus:ring-yellow-400 p-2.5 transition text-sm">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 10)) }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label for="year" class="block text-sm font-semibold text-gray-700 mb-2">Year</label>
                <select name="year" id="year" class="w-full rounded-lg border-gray-200 bg-gray-50 focus:border-yellow-400 focus:ring-yellow-400 p-2.5 transition text-sm">
                    @for($y = date('Y') - 1; $y <= date('Y') + 1; $y++)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <button type="submit" class="w-full bg-gray-900 text-white px-4 py-2.5 rounded-lg font-bold hover:bg-black transition shadow-sm">
                    Generate Report
                </button>
            </div>
        </form>
    </div>
    
    <!-- Report Table -->
    @if($class_id && $section_id && count($students) > 0)
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="sticky left-0 z-10 bg-gray-50 px-4 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-gray-200">
                                Student Name
                            </th>
                            @for($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $dateLoop = \Carbon\Carbon::createFromDate($year, $month, $day);
                                    $isWeekend = $dateLoop->isWeekend();
                                @endphp
                                <th scope="col" class="px-1 py-3 text-center text-[10px] font-bold uppercase tracking-wider w-8 {{ $isWeekend ? 'bg-gray-100 text-gray-400' : 'text-gray-500' }}">
                                    {{ $day }}<br><span class="opacity-50">{{ substr($dateLoop->format('D'), 0, 1) }}</span>
                                </th>
                            @endfor
                            <th scope="col" class="px-2 py-3 text-center text-xs font-bold text-green-600 uppercase tracking-wider border-l border-gray-100">
                                P
                            </th>
                            <th scope="col" class="px-2 py-3 text-center text-xs font-bold text-red-600 uppercase tracking-wider">
                                A
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-50">
                        @foreach($students as $student)
                            @php
                                $p_count = 0;
                                $a_count = 0;
                            @endphp
                            <tr class="hover:bg-yellow-50 transition-colors">
                                <td class="sticky left-0 z-10 bg-white px-4 py-2 whitespace-nowrap text-sm font-bold text-gray-800 border-r border-gray-100 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)]">
                                    {{ $student->name }}
                                </td>
                                @for($day = 1; $day <= $daysInMonth; $day++)
                                    @php
                                        $status = $attendanceData[$student->id][$day] ?? '-';
                                        $label = '-';
                                        $bgClass = '';
                                        $textClass = 'text-gray-200';
                                        
                                        if($status == 'present') {
                                            $textClass = 'text-green-600 font-bold';
                                            $bgClass = 'bg-green-50';
                                            $label = 'P';
                                            $p_count++;
                                        } elseif($status == 'absent') {
                                            $textClass = 'text-red-500 font-bold';
                                            $bgClass = 'bg-red-50';
                                            $label = 'A';
                                            $a_count++;
                                        } elseif($status == 'late') {
                                            $textClass = 'text-yellow-600 font-bold';
                                            $bgClass = 'bg-yellow-50';
                                            $label = 'L';
                                            $p_count++; 
                                        } elseif($status == 'excused') {
                                            $textClass = 'text-blue-500 font-bold';
                                            $bgClass = 'bg-blue-50';
                                            $label = 'E';
                                        }
                                        
                                        $dateLoop = \Carbon\Carbon::createFromDate($year, $month, $day);
                                        if($dateLoop->isWeekend() && $status == '-') {
                                            $bgClass = 'bg-gray-50';
                                        }
                                    @endphp
                                    <td class="px-0 py-2 text-center text-xs border-r border-dashed border-gray-100 {{ $bgClass }} {{ $textClass }}">
                                        {{ $label }}
                                    </td>
                                @endfor
                                <td class="px-2 py-2 text-center text-sm font-bold text-green-600 border-l border-gray-100 bg-gray-50/50">
                                    {{ $p_count }}
                                </td>
                                <td class="px-2 py-2 text-center text-sm font-bold text-red-500">
                                    {{ $a_count }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @elseif(request('class_id'))
        <div class="p-12 text-center text-gray-400 bg-white rounded-2xl border border-dashed border-gray-200">
            <div class="mb-3">
                 <i class="fas fa-search text-4xl text-gray-200"></i>
            </div>
            <p>No students found matching your criteria.</p>
        </div>
    @endif
</div>
@endsection
