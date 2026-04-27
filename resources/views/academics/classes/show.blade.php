@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold leading-tight text-gray-800">Class Details: {{ $class->name }}</h2>
            <div class="flex space-x-2">
                <a href="{{ route('classes.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow-sm hover:bg-gray-300 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Back to List
                </a>
                <a href="{{ route('classes.edit', $class->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-sm hover:bg-indigo-700 transition">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Sections List -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Sections</h3>
                    <a href="{{ route('sections.create') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Add Section</a>
                </div>
                <ul class="divide-y divide-gray-100">
                    @forelse($class->sections as $section)
                        <li class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                            <div>
                                <span class="text-sm font-medium text-gray-900">{{ $section->name }}</span>
                                <span class="text-xs text-gray-500 ml-2">(Capacity: {{ $section->capacity ?? 'N/A' }})</span>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('sections.edit', $section->id) }}" class="text-gray-400 hover:text-indigo-600">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </li>
                    @empty
                        <li class="px-6 py-4 text-sm text-gray-500 italic">No sections created for this class yet.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Stats or Students Placeholder -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-medium text-gray-900">Overview</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Total Sections</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ $class->sections->count() }}</dd>
                        </div>
                         <!-- Add Student count later when relation exists -->
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
