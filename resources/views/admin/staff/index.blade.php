@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Staff Members</h2>
            <p class="text-gray-500 mt-1">Manage school faculty and employee records.</p>
        </div>
        <a href="{{ route('staff.create') }}" class="flex items-center space-x-2 bg-yellow-400 text-gray-900 px-6 py-2.5 rounded-full font-bold hover:bg-yellow-500 transition shadow-sm">
            <i class="fas fa-plus-circle text-lg"></i>
            <span>Add Staff</span>
        </a>
    </div>

    <!-- Staff Table -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-100 bg-white">
                        <th class="px-6 py-4">Emp Code</th>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Role / Designation</th>
                        <th class="px-6 py-4">Contact</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($staffMembers as $staff)
                    <tr class="hover:bg-yellow-50 transition group">
                        <td class="px-6 py-4 text-sm font-mono text-gray-500">
                            {{ $staff->staffProfile->employee_code ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded-full overflow-hidden">
                                     <img class="w-full h-full object-cover"
                                            src="https://ui-avatars.com/api/?name={{ $staff->name }}&color=FBBF24&background=FFFBEB"
                                            alt="" />
                                </div>
                                <div class="ml-3">
                                    <p class="font-bold text-gray-800">{{ $staff->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $staff->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-block bg-gray-100 text-gray-700 px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wide mb-1">
                                 {{ $staff->role->display_name ?? $staff->role->name }}
                            </span>
                            <div class="text-gray-500 text-xs">{{ $staff->staffProfile->designation ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $staff->staffProfile->phone ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('staff.show', $staff->id) }}" class="text-gray-500 hover:text-gray-600 p-1" title="View Profile">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('staff.edit', $staff->id) }}" class="text-gray-500 hover:text-yellow-600 p-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('staff.destroy', $staff->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this staff member?');">
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
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                            No staff members found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
             {{ $staffMembers->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
