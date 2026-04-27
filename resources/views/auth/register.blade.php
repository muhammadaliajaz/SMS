<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EMS') }} - Register</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50 relative overflow-hidden">
        
        <!-- Background Elements -->
        <div class="absolute top-0 left-0 -ml-20 -mt-20 w-80 h-80 rounded-full bg-yellow-400/10 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 -mr-20 -mb-20 w-80 h-80 rounded-full bg-gray-900/5 blur-3xl"></div>

        <div class="max-w-md w-full space-y-8 relative z-10 bg-white p-10 rounded-3xl shadow-xl border border-gray-100">
            <div>
                 <div class="mx-auto w-12 h-12 rounded-full border-2 border-yellow-400 flex items-center justify-center bg-gray-900 mb-6">
                    <div class="w-5 h-5 bg-yellow-400 rounded-full"></div>
                </div>
                <h2 class="mt-2 text-center text-3xl font-extrabold text-gray-900">
                    Create Account
                </h2>
                <p class="mt-2 text-center text-sm text-gray-500">
                    Join us to manage your institution
                </p>
            </div>
            
            <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input id="name" name="name" type="text" autocomplete="name" required 
                            class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm transition bg-gray-50 focus:bg-white" 
                            placeholder="John Doe" value="{{ old('name') }}">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                            class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm transition bg-gray-50 focus:bg-white" 
                            placeholder="you@example.com" value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required 
                            class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm transition bg-gray-50 focus:bg-white" 
                            placeholder="••••••••">
                        @error('password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input id="password-confirm" name="password_confirmation" type="password" autocomplete="new-password" required 
                            class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm transition bg-gray-50 focus:bg-white" 
                            placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-full text-gray-900 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 transition shadow-lg shadow-yellow-400/20">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-user-plus text-gray-800 group-hover:text-gray-900"></i>
                        </span>
                        Create Account
                    </button>
                </div>

                <div class="text-center mt-4">
                     <p class="text-sm text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="font-medium text-yellow-600 hover:text-yellow-500">
                            Sign in
                        </a>
                    </p>
                </div>
            </form>
        </div>
        
        <div class="absolute bottom-6 w-full text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
