@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold leading-tight text-gray-800">Admission Inquiries</h2>
            <a href="{{ route('inquiries.create') }}" class="px-4 py-2 bg-amber-500 text-white rounded-lg shadow-md hover:bg-amber-600 transition focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                <i class="fas fa-plus mr-2"></i>New Inquiry
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden border border-gray-200">
                <table class="min-w-full leading-normal">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name / Contact</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Message</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($inquiries as $inquiry)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-5 text-sm text-gray-600">
                                {{ $inquiry->inquiry_date }}
                            </td>
                            <td class="px-5 py-5 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap font-semibold">{{ $inquiry->name }}</p>
                                <p class="text-gray-500 text-xs">{{ $inquiry->phone }}</p>
                                <p class="text-gray-500 text-xs">{{ $inquiry->email }}</p>
                            </td>
                            <td class="px-5 py-5 text-sm text-gray-600">
                                {{ Str::limit($inquiry->message, 50) }}
                            </td>
                            <td class="px-5 py-5 text-sm">
                                @if($inquiry->status == 'open')
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Open</span>
                                @elseif($inquiry->status == 'closed')
                                    <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded">Closed</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ ucfirst($inquiry->status) }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-5 text-sm">
                                <div class="flex space-x-2">
                                    <a href="{{ route('inquiries.show', $inquiry->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 p-2 rounded hover:bg-blue-100 transition" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('inquiries.edit', $inquiry->id) }}" class="text-amber-600 hover:text-amber-900 bg-amber-50 p-2 rounded hover:bg-amber-100 transition" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('inquiries.destroy', $inquiry->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this inquiry?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded hover:bg-red-100 transition" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-5 py-5 bg-white text-sm text-center text-gray-500 italic">
                                No inquiries found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                 {{ $inquiries->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>
@endsection
