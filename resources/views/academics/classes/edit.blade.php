@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-100">
        <div class="bg-gray-50 px-8 py-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Edit Class</h2>
            <a href="{{ route('classes.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <div class="p-8">
            <form method="POST" action="{{ route('classes.update', $academicClass->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Class Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $academicClass->name) }}" required 
                        class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white" />
                    @error('name') 
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p> 
                    @enderror
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-yellow-400 text-gray-900 px-6 py-3 rounded-full font-bold hover:bg-yellow-500 transition shadow-sm flex items-center">
                        <i class="fas fa-save mr-2"></i> Update Class
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
