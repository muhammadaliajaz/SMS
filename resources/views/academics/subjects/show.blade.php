@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold leading-tight text-gray-800">Subject Details: {{ $subject->name }}</h2>
            <div class="flex space-x-2">
                <a href="{{ route('subjects.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow-sm hover:bg-gray-300 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Back to List
                </a>
                <a href="{{ route('subjects.edit', $subject->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-sm hover:bg-indigo-700 transition">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden p-6 max-w-2xl">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Subject Name</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $subject->name }}</dd>
                </div>
                
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Subject Code</dt>
                    <dd class="mt-1 text-lg font-mono text-gray-900">{{ $subject->code ?? 'N/A' }}</dd>
                </div>

                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Type</dt>
                    <dd class="mt-1">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $subject->type === 'theory' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($subject->type) }}
                        </span>
                    </dd>
                </div>
                
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                         {{-- Add description field to DB later if needed --}}
                        <p class="italic text-gray-400">No additional description available.</p>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection
