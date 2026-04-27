@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Class Sections</h2>
            <p class="text-gray-500 mt-1">Organize classes into manageable sections.</p>
        </div>
        <a href="{{ route('sections.create') }}" class="flex items-center space-x-2 bg-yellow-400 text-gray-900 px-6 py-2.5 rounded-full font-bold hover:bg-yellow-500 transition shadow-sm">
            <i class="fas fa-plus-circle text-lg"></i>
            <span>Create Section</span>
        </a>
    </div>

    <!-- Sections Table -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-100 bg-white">
                        <th class="px-6 py-4">Class</th>
                        <th class="px-6 py-4">Section Name</th>
                        <th class="px-6 py-4">Capacity</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($sections as $section)
                    <tr class="hover:bg-yellow-50 transition group">
                        <td class="px-6 py-4 text-sm font-semibold text-gray-700">
                            {{ $section->academicClass->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-lg text-xs font-bold border border-yellow-200">
                                {{ $section->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 font-mono">
                            {{ $section->capacity }}
                        </td>
                        <td class="px-6 py-4 text-sm text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('sections.edit', $section->id) }}" class="text-gray-500 hover:text-yellow-600 p-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('sections.destroy', $section->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this section?');">
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
                            No sections found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
             {{ $sections->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
