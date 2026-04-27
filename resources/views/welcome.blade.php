<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'EMS') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        yellow: {
                            400: '#FBBF24',
                            500: '#F59E0B',
                        },
                        gray: {
                            900: '#111827',
                            800: '#1F2937',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-white text-gray-800 antialiased font-sans">
    
    <!-- Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-white/90 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full border-2 border-yellow-400 flex items-center justify-center bg-gray-900">
                         <div class="w-4 h-4 bg-yellow-400 rounded-full"></div>
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-gray-900">EMS</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#home" class="text-sm font-bold text-gray-600 hover:text-yellow-500 transition uppercase tracking-wide">Home</a>
                    <a href="#features" class="text-sm font-bold text-gray-600 hover:text-yellow-500 transition uppercase tracking-wide">Features</a>
                    <a href="#about" class="text-sm font-bold text-gray-600 hover:text-yellow-500 transition uppercase tracking-wide">About</a>
                    <a href="#contact" class="text-sm font-bold text-gray-600 hover:text-yellow-500 transition uppercase tracking-wide">Contact</a>
                </div>

                <!-- Auth Buttons -->
                <div>
                    @if (Route::has('login'))
                        <div class="flex items-center gap-4">
                            @auth
                                <a href="{{ url('/home') }}" class="px-6 py-2.5 bg-yellow-400 text-gray-900 font-bold rounded-full shadow-lg shadow-yellow-400/20 hover:bg-yellow-500 transition transform hover:-translate-y-0.5">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="hidden sm:block text-sm font-bold text-gray-900 hover:text-yellow-500 transition">Log in</a>
                                <a href="{{ route('login') }}" class="px-6 py-2.5 bg-gray-900 text-white font-bold rounded-full hover:bg-gray-800 transition transform hover:-translate-y-0.5 shadow-lg border border-gray-800">
                                    Admin Portal
                                </a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div id="home" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-gray-50">
        <!-- Abstract Shapes -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-yellow-400/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 rounded-full bg-gray-900/5 blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-4xl mx-auto">
                <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-yellow-100 text-yellow-800 text-xs font-bold uppercase tracking-widest mb-8 border border-yellow-200">
                    <span class="w-2 h-2 rounded-full bg-yellow-500 mr-2 animate-pulse"></span>
                    Next Generation School Management
                </span>
                <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-gray-900 mb-8 leading-tight">
                    Manage Your School <br>
                    <span class="relative inline-block text-yellow-500">
                        With Excellence
                        <svg class="absolute w-full h-3 -bottom-1 left-0 text-yellow-200 -z-10" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0 50 Q 50 100 100 50" stroke="currentColor" stroke-width="20" fill="none" /></svg>
                    </span>
                </h1>
                <p class="text-xl text-gray-500 mb-10 leading-relaxed max-w-2xl mx-auto">
                    Streamline administration, empower teachers, and connect with students using our premium, cloud-based platform designed for modern education.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-yellow-400 text-gray-900 font-bold rounded-full shadow-xl shadow-yellow-400/30 hover:bg-yellow-500 transition transform hover:-translate-y-1 text-lg flex items-center justify-center">
                        Get Started <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    <a href="#features" class="px-8 py-4 bg-white text-gray-900 font-bold rounded-full shadow-md border border-gray-200 hover:bg-gray-50 transition transform hover:-translate-y-1 text-lg flex items-center justify-center">
                        Learn More
                    </a>
                </div>
            </div>
            
            <!-- Dashboard Preview Mockup -->
            <div class="mt-20 relative rounded-2xl bg-gray-900 p-2 shadow-2xl ring-1 ring-gray-900/10 sm:p-4 mx-auto max-w-5xl transform rotate-1 hover:rotate-0 transition duration-500">
                 <div class="relative rounded-xl bg-gray-800/50 overflow-hidden aspect-[16/9] flex items-center justify-center border border-gray-700">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-columns text-3xl text-gray-500"></i>
                        </div>
                        <p class="text-gray-400 text-lg">Admin Dashboard Preview</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-yellow-500 font-bold tracking-widest uppercase text-sm mb-3">Core Features</h2>
                <h3 class="text-4xl font-extrabold text-gray-900">Everything You Need</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Feature 1 -->
                <div class="group p-10 rounded-[2rem] bg-gray-50 hover:bg-gray-900 hover:text-white transition-all duration-300 border border-gray-100 hover:border-gray-800 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:bg-yellow-400 group-hover:text-gray-900 transition-colors">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4">Student Management</h4>
                    <p class="text-gray-500 group-hover:text-gray-400 leading-relaxed font-medium">
                        Comprehensive profiles, attendance tracking, and performance analytics for every student.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="group p-10 rounded-[2rem] bg-gray-50 hover:bg-gray-900 hover:text-white transition-all duration-300 border border-gray-100 hover:border-gray-800 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gray-200 text-gray-700 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:bg-yellow-400 group-hover:text-gray-900 transition-colors">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4">Staff Administration</h4>
                    <p class="text-gray-500 group-hover:text-gray-400 leading-relaxed font-medium">
                        Streamlined HR processes, payroll management, and teacher scheduling tools.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="group p-10 rounded-[2rem] bg-gray-50 hover:bg-gray-900 hover:text-white transition-all duration-300 border border-gray-100 hover:border-gray-800 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:bg-yellow-400 group-hover:text-gray-900 transition-colors">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4">Finance & Fees</h4>
                    <p class="text-gray-500 group-hover:text-gray-400 leading-relaxed font-medium">
                        Track tuition payments, generate receipts, and manage school finances effortlessly.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic Stats Section -->
    <div id="about" class="py-24 bg-gray-900 text-white relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" width="100%" height="100%" fill="none">
                <defs>
                    <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M0 40L40 0H20L0 20M40 40V20L20 40" stroke="white" stroke-width="2"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid-pattern)"/>
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
             <div class="text-center mb-16">
                <h2 class="text-yellow-400 font-bold tracking-widest uppercase text-sm mb-3">Our Impact</h2>
                <h3 class="text-3xl font-extrabold">Growing Every Day</h3>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-12 text-center divide-x divide-gray-800/50">
                <div class="p-4">
                    <div class="text-5xl font-extrabold mb-2 text-white">{{ $stats['students'] ?? '0' }}</div>
                    <div class="text-yellow-400 font-bold uppercase tracking-wide text-xs">Students Enrolled</div>
                </div>
                <div class="p-4">
                    <div class="text-5xl font-extrabold mb-2 text-white">{{ $stats['staff'] ?? '0' }}</div>
                    <div class="text-yellow-400 font-bold uppercase tracking-wide text-xs">Certified Staff</div>
                </div>
                <div class="p-4">
                    <div class="text-5xl font-extrabold mb-2 text-white">100%</div>
                    <div class="text-yellow-400 font-bold uppercase tracking-wide text-xs">Digitization</div>
                </div>
                <div class="p-4">
                    <div class="text-5xl font-extrabold mb-2 text-white">24/7</div>
                    <div class="text-yellow-400 font-bold uppercase tracking-wide text-xs">Platform Uptime</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer id="contact" class="bg-white pt-20 pb-10 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-full border-2 border-yellow-400 flex items-center justify-center bg-gray-900">
                             <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                        </div>
                        <span class="font-bold text-xl text-gray-900">EMS</span>
                    </div>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">
                        Empowering educational institutions with cutting-edge technology for a smarter future.
                    </p>
                     <div class="flex gap-4">
                        <a href="#" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-yellow-400 hover:text-gray-900 transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-yellow-400 hover:text-gray-900 transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-yellow-400 hover:text-gray-900 transition"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-bold text-gray-900 mb-6 text-sm uppercase tracking-wider">Navigation</h4>
                    <ul class="space-y-3 text-sm text-gray-500 font-medium">
                        <li><a href="#home" class="hover:text-yellow-500 transition">Home</a></li>
                        <li><a href="#features" class="hover:text-yellow-500 transition">Features</a></li>
                        <li><a href="#about" class="hover:text-yellow-500 transition">About Us</a></li>
                        <li><a href="#contact" class="hover:text-yellow-500 transition">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-gray-900 mb-6 text-sm uppercase tracking-wider">Contact</h4>
                    <ul class="space-y-4 text-sm text-gray-500 font-medium">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt mt-1 text-yellow-500"></i>
                            <span>Pakpattan, Pakistan.</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone text-yellow-500"></i>
                            <span>+92 3026572894</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-yellow-500"></i>
                            <span>chaudharyaliajaz@gmail.com</span>
                        </li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold text-gray-900 mb-6 text-sm uppercase tracking-wider">Newsletter</h4>
                    <div class="flex">
                        <input type="email" placeholder="Enter email" class="flex-1 bg-gray-50 border border-gray-200 rounded-l-lg px-4 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-yellow-400 focus:border-yellow-400">
                        <button class="bg-gray-900 text-white px-4 py-2 rounded-r-lg hover:bg-gray-800 transition">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-400 font-medium">© {{ date('Y') }} EMS. All rights reserved.</p>
                <div class="flex gap-6 text-sm font-medium text-gray-400">
                    <a href="#" class="hover:text-gray-900 transition">Privacy Policy</a>
                    <a href="#" class="hover:text-gray-900 transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
