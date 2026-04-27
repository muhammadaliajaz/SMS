@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Academic Subjects</h2>
            <p class="text-gray-500 mt-1">Manage curriculum subjects and codes.</p>
        </div>
        <a href="{{ route('subjects.create') }}" class="flex items-center space-x-2 bg-yellow-400 text-gray-900 px-6 py-2.5 rounded-full font-bold hover:bg-yellow-500 transition shadow-sm">
            <i class="fas fa-plus-circle text-lg"></i>
            <span>Add Subject</span>
        </a>
    </div>

    <!-- Subjects Table -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-100 bg-white">
                        <th class="px-6 py-4">Subject Name</th>
                        <th class="px-6 py-4">Code</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($subjects as $subject)
                    <tr class="hover:bg-yellow-50 transition group">
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 mr-3">
                                    <i class="fas fa-book text-xs"></i>
                                </div>
                                <span class="font-bold text-gray-800">{{ $subject->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="bg-gray-50 text-gray-600 text-xs font-mono font-bold px-2 py-1 rounded border border-gray-200">
                                {{ $subject->code ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($subject->type === 'theory')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-600">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full mr-1.5"></span>
                                    Theory
                                </span>
                            @elseif($subject->type === 'practical')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-600">
                                    <span class="w-1.5 h-1.5 bg-purple-600 rounded-full mr-1.5"></span>
                                    Practical
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    {{ ucfirst($subject->type) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('subjects.edit', $subject->id) }}" class="text-gray-500 hover:text-yellow-600 p-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this subject?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-500 hover:text-red-600 p-1" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                            No subjects found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
             {{ $subjects->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
