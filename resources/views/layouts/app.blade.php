<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EMS') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS (CDN for immediate usage) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#4f46e5',
                        secondary: '#64748b',
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js for interactivity -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        
        /* Custom Scrollbar for Sidebar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #111111; 
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #333;
            border-radius: 20px;
        }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb {
            background-color: #444;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-[#111111] text-gray-400 transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 flex flex-col font-sans">
            <!-- Logo -->
            <div class="flex items-center px-6 h-20">
                <div class="w-8 h-8 rounded-full border-2 border-yellow-400 flex items-center justify-center mr-3">
                     <div class="w-4 h-4 bg-yellow-400 rounded-full"></div>
                </div>
                <span class="text-xl font-bold text-gray-100 tracking-wide">EMS</span>
            </div>
            
            <nav class="flex-1 overflow-y-auto mt-2 px-4 space-y-6 pb-10 custom-scrollbar">
                
                <!-- Main -->
                <div>
                    <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Main</p>
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('home') ? 'bg-[#2a261c] text-yellow-500' : 'hover:text-gray-100 hover:bg-gray-800' }}">
                        <i class="fas fa-th-large w-5 h-5 mr-3 {{ request()->routeIs('home') ? 'text-yellow-500' : '' }}"></i>
                        Dashboard
                    </a>
                </div>

                <!-- Campus -->
                <div>
                    <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Campus</p>
                    <div class="space-y-1">
                        <!-- Classes -->
                        <a href="{{ route('classes.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('classes.*') ? 'bg-[#2a261c] text-yellow-500' : 'hover:text-gray-100 hover:bg-gray-800' }}">
                            <i class="fas fa-door-open w-5 h-5 mr-3"></i>
                            Classes
                        </a>

                        <!-- Sections -->
                        <a href="{{ route('sections.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('sections.*') ? 'bg-[#2a261c] text-yellow-500' : 'hover:text-gray-100 hover:bg-gray-800' }}">
                            <i class="fas fa-layer-group w-5 h-5 mr-3"></i>
                            Sections
                        </a>

                        <!-- Subjects -->
                        <a href="{{ route('subjects.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('subjects.*') ? 'bg-[#2a261c] text-yellow-500' : 'hover:text-gray-100 hover:bg-gray-800' }}">
                            <i class="fas fa-book w-5 h-5 mr-3"></i>
                            Subjects
                        </a>

                        <!-- Students -->
                        <a href="{{ route('students.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('students.*') ? 'bg-[#2a261c] text-yellow-500' : 'hover:text-gray-100 hover:bg-gray-800' }}">
                            <i class="fas fa-user-graduate w-5 h-5 mr-3"></i>
                            Students
                        </a>

                        <!-- Staff -->
                        <a href="{{ route('staff.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('staff.*') ? 'bg-[#2a261c] text-yellow-500' : 'hover:text-gray-100 hover:bg-gray-800' }}">
                            <i class="fas fa-users w-5 h-5 mr-3"></i>
                            Staff
                        </a>

                        <!-- Attendance -->
                        <a href="{{ route('attendance.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('attendance.*') && !request()->routeIs('attendance.report') ? 'bg-[#2a261c] text-yellow-500' : 'hover:text-gray-100 hover:bg-gray-800' }}">
                            <i class="fas fa-user-check w-5 h-5 mr-3"></i>
                            Attendance
                        </a>

                        <!-- Events -->
                         <a href="{{ route('events.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md hover:bg-[#222222] hover:text-white transition {{ request()->routeIs('events.*') ? 'bg-[#222222] text-white' : 'text-gray-400' }}">
                            <i class="fas fa-calendar-alt w-5 h-5 mr-3"></i>
                            Events
                        </a>
                    </div>
                </div>

                <!-- Examination -->
                <div>
                    <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Examination</p>
                    <div class="space-y-1">
                        <a href="{{ route('exams.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('exams.*') ? 'bg-[#2a261c] text-yellow-500' : 'hover:text-gray-100 hover:bg-gray-800' }}">
                            <i class="fas fa-clipboard-list w-5 h-5 mr-3"></i>
                            Exams List
                        </a>
                        <a href="{{ route('exam-schedules.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('exam-schedules.*') ? 'bg-[#2a261c] text-yellow-500' : 'hover:text-gray-100 hover:bg-gray-800' }}">
                            <i class="fas fa-calendar-check w-5 h-5 mr-3"></i>
                            Exam Schedule
                        </a>
                        <a href="{{ route('marks.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('marks.*') ? 'bg-[#2a261c] text-yellow-500' : 'hover:text-gray-100 hover:bg-gray-800' }}">
                            <i class="fas fa-marker w-5 h-5 mr-3"></i>
                            Marks Register
                        </a>
                        <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('reports.*') ? 'bg-[#2a261c] text-yellow-500' : 'hover:text-gray-100 hover:bg-gray-800' }}">
                            <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                            Result Card
                        </a>
                        <a href="{{ route('admit-cards.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admit-cards.*') ? 'bg-[#2a261c] text-yellow-500' : 'hover:text-gray-100 hover:bg-gray-800' }}">
                            <i class="fas fa-id-card w-5 h-5 mr-3"></i>
                            Admit Card
                        </a>
                    </div>
                </div>

                <!-- Finance -->
                <div>
                    <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Finance</p>
                    <div class="space-y-1">
                        <!-- Fee Management -->
                        <a href="{{ route('fees.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('fees.index') || request()->routeIs('fees.create') || request()->routeIs('fees.edit') ? 'bg-[#2a261c] text-yellow-500' : 'hover:text-gray-100 hover:bg-gray-800' }}">
                            <i class="fas fa-wallet w-5 h-5 mr-3"></i>
                            Fee Transactions
                        </a>
                        <a href="{{ route('fees.types.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('fees.types.*') ? 'bg-[#2a261c] text-yellow-500' : 'hover:text-gray-100 hover:bg-gray-800' }}">
                            <i class="fas fa-list-ul w-5 h-5 mr-3"></i>
                            Fee Structure
                        </a>
                    </div>
                </div>

                <!-- Reports -->
                 <div>
                    <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Reports</p>
                    <div class="space-y-1">
                         <a href="{{ route('attendance.report') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('attendance.report') ? 'bg-[#2a261c] text-yellow-500' : 'hover:text-gray-100 hover:bg-gray-800' }}">
                            <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                            Attendance Report
                        </a>
                         <a href="{{ route('inquiries.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('inquiries.*') ? 'bg-[#2a261c] text-yellow-500' : 'hover:text-gray-100 hover:bg-gray-800' }}">
                            <i class="fas fa-envelope-open-text w-5 h-5 mr-3"></i>
                            Inquiries
                        </a>
                    </div>
                </div>
                
                <!-- System -->
                 <div>
                    <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">System</p>
                    <div class="space-y-1">
                        <a href="{{ route('settings.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('settings.*') ? 'bg-[#2a261c] text-yellow-500' : 'hover:text-gray-100 hover:bg-gray-800' }}">
                             <i class="fas fa-cogs w-5 h-5 mr-3"></i>
                            Settings
                        </a>
                    </div>
                </div>

            </nav>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="flex items-center justify-between h-16 bg-white shadow px-6 z-10">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <h1 class="text-xl font-semibold text-gray-800">
                    {{ config('app.name') }}
                </h1>

                <div class="flex items-center space-x-6">
                    <!-- Global Search -->
                    <div class="relative text-gray-400 focus-within:text-yellow-600 hidden md:block">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="search" name="q" class="py-2 text-sm text-gray-900 bg-gray-100 rounded-lg pl-10 focus:outline-none focus:bg-white focus:ring-2 focus:ring-yellow-400 placeholder-gray-400" placeholder="Search..." autocomplete="off">
                    </div>

                    <!-- Notification Dropdown -->
                    <div x-data="{ notificationOpen: false }" class="relative">
                        <button @click="notificationOpen = !notificationOpen" class="relative text-gray-500 hover:text-yellow-500 transition focus:outline-none">
                            <i class="fas fa-bell text-xl"></i>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="absolute top-0 right-0 -mt-1 -mr-1 flex h-3 w-3">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                </span>
                            @endif
                        </button>

                        <div x-show="notificationOpen" @click.away="notificationOpen = false" class="absolute right-0 z-20 w-80 mt-2 bg-white rounded-md shadow-xl border border-gray-100 overflow-hidden" x-cloak>
                            <div class="px-4 py-3 border-b flex justify-between items-center bg-gray-50">
                                <span class="text-sm font-semibold text-gray-700">Notifications</span>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <a href="{{ route('notifications.readAll') }}" class="text-xs text-yellow-600 hover:text-yellow-700 font-medium">Mark all read</a>
                                @endif
                            </div>
                            
                            <div class="max-h-64 overflow-y-auto">
                                @forelse(auth()->user()->unreadNotifications as $notification)
                                    <div class="px-4 py-3 border-b hover:bg-gray-50 transition relative group">
                                         <p class="text-sm text-gray-800 font-medium">{{ $notification->data['message'] ?? 'New Notification' }}</p>
                                         <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                         
                                         <!-- Mark as Read Button -->
                                         <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="absolute top-3 right-3 hidden group-hover:block">
                                            @csrf
                                            <button type="submit" class="text-gray-400 hover:text-green-500" title="Mark as Read">
                                                <i class="fas fa-check"></i>
                                            </button>
                                         </form>
                                    </div>
                                @empty
                                    <div class="px-4 py-6 text-center text-gray-500 text-sm">
                                        No new notifications
                                    </div>
                                @endforelse
                            </div>
                            <div class="px-4 py-2 bg-gray-50 text-center border-t">
                                <a href="#" class="text-xs text-gray-500 hover:text-gray-700">View all notifications</a>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="h-6 w-px bg-gray-200 hidden md:block" aria-hidden="true"></div>

                    <!-- Profile Dropdown -->
                    @guest
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-primary mr-4">Login</a>
                    @else
                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = !dropdownOpen" class="relative z-10 block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none">
                                <img class="object-cover w-full h-full" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=primary&color=fff" alt="Your avatar">
                            </button>
                            <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 z-20 w-48 mt-2 py-2 bg-white rounded-md shadow-xl border border-gray-100" x-cloak>
                                <div class="px-4 py-2 text-sm text-gray-500 border-b">
                                    {{ Auth::user()->name }}
                                </div>
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-500 hover:text-white">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-indigo-500 hover:text-white">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                 @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
