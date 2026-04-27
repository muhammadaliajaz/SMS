@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-6 py-8">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
                <p class="text-gray-500 mt-1">Welcome back, {{ Auth::user()->name }}</p>
            </div>
            <div>
                <a href="{{ route('students.create') }}" class="flex items-center space-x-2 bg-yellow-400 text-gray-900 px-6 py-2.5 rounded-full font-semibold hover:bg-yellow-500 transition shadow-sm">
                    <i class="fas fa-plus-circle text-lg"></i>
                    <span>Enroll Student</span>
                </a>
            </div>
        </div>

        <!-- Top Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <!-- Total Students (Yellow) -->
            <div class="bg-yellow-400 rounded-2xl p-6 shadow-sm relative overflow-hidden text-gray-900">
                <div class="relative z-10">
                    <p class="text-sm font-semibold opacity-80 mb-1">Total Students</p>
                    <h3 class="text-4xl font-bold mb-2">{{ $totalStudents }}</h3>
                    <p class="text-xs font-medium flex items-center opacity-75">
                        <i class="fas fa-arrow-up mr-1"></i> 12% from last month
                    </p>
                </div>
                <div class="absolute right-4 top-4 opacity-10">
                    <i class="fas fa-graduation-cap text-8xl"></i>
                </div>
            </div>

            <!-- Total Teachers -->
            <div class="bg-white rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 mb-1">Total Teachers</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $totalTeachers }}</h3>
                    </div>
                    <div class="p-3 bg-pink-50 rounded-xl text-pink-500">
                        <i class="fas fa-chalkboard-user text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-4">- No change</p>
            </div>

            <!-- Total Funds (Fees) -->
            <div class="bg-white rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 mb-1">Total Fees Collected</p>
                        <h3 class="text-3xl font-bold text-gray-800">${{ number_format($totalFees / 1000, 1) }}K</h3>
                    </div>
                    <div class="p-3 bg-yellow-50 rounded-xl text-yellow-500">
                        <i class="fas fa-wallet text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-green-500 mt-4 flex items-center">
                    <i class="fas fa-arrow-up mr-1"></i> 8% increase
                </p>
            </div>

            <!-- Present Today -->
            <div class="bg-white rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 mb-1">Present Today</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $presentPercentage }}%</h3>
                    </div>
                    <div class="p-3 bg-green-50 rounded-xl text-green-500">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-green-500 mt-4 flex items-center">
                     <i class="fas fa-arrow-up mr-1"></i> 3% from yesterday
                </p>
            </div>
        </div>

        <!-- Middle Section: Attendance & Calendar -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            
            <!-- Left Column: Attendance Overview & Recent Enrollments -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Attendance Overview -->
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Attendance Overview</h3>
                        <div class="bg-gray-100 text-gray-600 px-3 py-1 rounded-lg text-sm font-medium flex items-center cursor-pointer">
                            Today <i class="fas fa-chevron-down ml-2 text-xs"></i>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Present -->
                        <div class="bg-green-50 rounded-xl p-4 text-center">
                            <h4 class="text-2xl font-bold text-green-600 mb-1">{{ $presentToday }}</h4>
                            <p class="text-sm text-gray-500 font-medium">Present</p>
                        </div>
                        <!-- Absent -->
                        <div class="bg-red-50 rounded-xl p-4 text-center">
                            <h4 class="text-2xl font-bold text-red-600 mb-1">{{ $absentToday }}</h4>
                            <p class="text-sm text-gray-500 font-medium">Absent</p>
                        </div>
                        <!-- Early Exit/Late (Using Late here) -->
                        <div class="bg-orange-50 rounded-xl p-4 text-center">
                            <h4 class="text-2xl font-bold text-orange-600 mb-1">{{ $lateToday }}</h4>
                            <p class="text-sm text-gray-500 font-medium">Late</p>
                        </div>
                        <!-- Staff (Mock or 0) -->
                        <div class="bg-blue-50 rounded-xl p-4 text-center">
                            <h4 class="text-2xl font-bold text-blue-600 mb-1">{{ $totalTeachers }}</h4>
                            <p class="text-sm text-gray-500 font-medium">Staff</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Enrollments -->
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Recent Enrollments</h3>
                        <a href="{{ route('students.index') }}" class="text-sm text-orange-500 font-semibold hover:underline">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                    <th class="pb-3 pl-2">Student</th>
                                    <th class="pb-3">Email</th>
                                    <th class="pb-3">Role</th>
                                    <th class="pb-3 text-right pr-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($recentEnrollments as $student)
                                <tr class="text-sm text-gray-700 hover:bg-gray-50 transition">
                                    <td class="py-4 pl-2 font-medium flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center font-bold mr-3 text-xs">
                                            {{ substr($student->name, 0, 1) }}
                                        </div>
                                        {{ $student->name }}
                                    </td>
                                    <td class="py-4 text-gray-500">{{ $student->email }}</td>
                                    <td class="py-4">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            {{ ucfirst($student->role->name) }}
                                        </span>
                                    </td>
                                    <td class="py-4 text-right pr-2">
                                        <a href="#" class="text-gray-400 hover:text-indigo-600"><i class="fas fa-ellipsis-v"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-gray-400">No recent enrollments.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm h-fit" x-data="app()" x-init="initDate()">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center space-x-2">
                        <button class="text-gray-400 hover:text-gray-600 focus:outline-none" @click="prevMonth()"><i class="fas fa-chevron-left"></i></button>
                        <button class="text-gray-400 hover:text-gray-600 focus:outline-none" @click="nextMonth()"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800" x-text="month_names[month] + ' ' + year"></h3>
                    <div class="space-x-1">
                        <span class="text-xs px-2 py-1 bg-gray-100 rounded text-gray-600 cursor-pointer" @click="initDate()">Today</span>
                    </div>
                </div>
                
                <div class="grid grid-cols-7 text-center text-xs text-gray-400 mb-2 font-semibold">
                    <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
                </div>
                <div class="grid grid-cols-7 text-center text-sm gap-y-4">
                    <template x-for="blank in blankdays">
                        <div></div>
                    </template>
                    <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                        <div>
                            <span class="block w-8 h-8 mx-auto flex items-center justify-center rounded-full cursor-pointer transition"
                                :class="isToday(date) ? 'bg-yellow-400 text-gray-900 font-bold shadow-sm' : 'text-gray-700 hover:bg-gray-50'">
                                <span x-text="date"></span>
                            </span>
                        </div>
                    </template>
                </div>

                <div class="mt-8 border-t border-gray-100 pt-6">
                     <h4 class="font-bold text-gray-800 mb-4">Quick Stats</h4>
                     <div class="flex justify-around">
                        <div class="text-center">
                            <div class="relative w-16 h-16 mx-auto mb-2 flex items-center justify-center">
                                <svg class="w-full h-full transform -rotate-90">
                                    <circle cx="32" cy="32" r="28" stroke="currentColor" stroke-width="4" fill="transparent" class="text-gray-100"/>
                                    <circle cx="32" cy="32" r="28" stroke="currentColor" stroke-width="4" fill="transparent" class="text-yellow-400" stroke-dasharray="175.9" :stroke-dashoffset="175.9 * (1 - (feePercentage / 100))"/>
                                </svg>
                                <span class="absolute text-sm font-bold text-gray-700" x-text="feePercentage + '%'"></span>
                            </div>
                            <span class="text-xs text-gray-500">Fees</span>
                        </div>
                        <div class="text-center">
                             <div class="relative w-16 h-16 mx-auto mb-2 flex items-center justify-center">
                                <svg class="w-full h-full transform -rotate-90">
                                    <circle cx="32" cy="32" r="28" stroke="currentColor" stroke-width="4" fill="transparent" class="text-gray-100"/>
                                    <circle cx="32" cy="32" r="28" stroke="currentColor" stroke-width="4" fill="transparent" class="text-green-500" stroke-dasharray="175.9" :stroke-dashoffset="175.9 * (1 - (presentPercentage / 100))"/>
                                </svg>
                                <span class="absolute text-sm font-bold text-gray-700" x-text="presentPercentage + '%'"></span>
                            </div>
                            <span class="text-xs text-gray-500">Attendance</span>
                        </div>
                     </div>
                </div>
            </div>

<script>
    function app() {
        return {
            month: '',
            year: '',
            no_of_days: [],
            blankdays: [],
            days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            month_names: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            
            // Dynamic Stats
            feePercentage: {{ $feePercentage ?? 0 }},
            presentPercentage: {{ $presentPercentage ?? 0 }},

            initDate() {
                let today = new Date();
                this.month = today.getMonth();
                this.year = today.getFullYear();
                this.getNoOfDays();
                this.fetchStats();
            },

            isToday(date) {
                const today = new Date();
                const d = new Date(this.year, this.month, date);
                return today.toDateString() === d.toDateString();
            },

            getNoOfDays() {
                let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                let dayOfWeek = new Date(this.year, this.month).getDay(); 

                this.blankdays = new Array(dayOfWeek).fill('');
                this.no_of_days = new Array(daysInMonth).fill('').map((_, i) => i + 1);
            },

            nextMonth() {
                this.month++;
                if (this.month > 11) {
                    this.month = 0;
                    this.year++;
                }
                this.getNoOfDays();
                this.fetchStats();
            },

            prevMonth() {
                this.month--;
                if (this.month < 0) {
                    this.month = 11;
                    this.year--;
                }
                this.getNoOfDays();
                this.fetchStats();
            },
            
            fetchStats() {
                fetch(`{{ route('dashboard.stats') }}?month=${this.month}&year=${this.year}`)
                    .then(response => response.json())
                    .then(data => {
                        this.feePercentage = data.feePercentage;
                        this.presentPercentage = data.presentPercentage;
                    })
                    .catch(error => console.error('Error fetching stats:', error));
            }
        }
    }
</script>
            
        </div>
    </div>
</div>
@endsection
