@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Academic Classes</h2>
            <p class="text-gray-500 mt-1">Manage grade levels and student groups.</p>
        </div>
        <a href="{{ route('classes.create') }}" class="flex items-center space-x-2 bg-yellow-400 text-gray-900 px-6 py-2.5 rounded-full font-bold hover:bg-yellow-500 transition shadow-sm">
            <i class="fas fa-plus-circle text-lg"></i>
            <span>Add New Class</span>
        </a>
    </div>

    <!-- Classes Table -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-100 bg-white">
                        <th class="px-6 py-4">Class Name</th>
                        <th class="px-6 py-4">Sections</th>
                        <th class="px-6 py-4">Students</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($classes as $class)
                    <tr class="hover:bg-yellow-50 transition group">
                        <td class="px-6 py-4 text-sm font-bold text-gray-800">
                            {{ $class->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <span class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full text-xs font-semibold">
                                {{ $class->sections_count ?? $class->sections->count() }} Sections
                            </span>
                        </td>
                         <td class="px-6 py-4 text-sm text-gray-400">
                            <!-- Placeholder -->
                            <span class="italic">0 Students</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('classes.edit', $class->id) }}" class="text-gray-500 hover:text-yellow-600 p-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this class?');">
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
                            No classes found. Add one to get started.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
             {{ $classes->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
