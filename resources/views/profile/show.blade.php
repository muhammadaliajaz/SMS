@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800">My Profile</h2>
        <p class="text-gray-500 mt-1">Manage your account settings and preferences.</p>
    </div>

    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gray-50 px-8 py-6 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                 <span class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center mr-3 text-sm">
                    <i class="fas fa-user-circle"></i>
                </span>
                Profile Information
            </h3>
            <p class="mt-1 text-sm text-gray-500 ml-11">Update your account's profile information and email address.</p>
        </div>
        
        <div class="p-8">
            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                            class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                            class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white">
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Section -->
                    <div class="pt-8 mt-8 border-t border-gray-100">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                             <span class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center mr-3 text-sm">
                                <i class="fas fa-lock"></i>
                            </span>
                            Change Password
                        </h4>
                        <p class="text-sm text-gray-500 mb-6 ml-11">Ensure your account is using a long, random password to stay secure.</p>
                        
                        <div class="space-y-6 ml-11">
                            <div>
                                <label for="password" class="block text-sm font-bold text-gray-700 mb-2">New Password</label>
                                <input type="password" name="password" id="password" 
                                    class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                    class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white">
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 flex justify-end">
                        <button type="submit" class="bg-yellow-400 text-gray-900 px-8 py-3 rounded-full font-bold hover:bg-yellow-500 transition shadow-sm flex items-center">
                            <i class="fas fa-save mr-2"></i> Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
