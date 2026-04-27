@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8 py-8">
    
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Fee Structure</h2>
            <p class="text-gray-500 mt-1">Manage fee categories and descriptions.</p>
        </div>
        <a href="{{ route('fees.index') }}" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-full font-medium hover:bg-gray-50 transition shadow-sm">
            <i class="fas fa-arrow-left mr-2"></i> Back to Transactions
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Create Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-8">
                <div class="px-6 py-4 bg-gray-900 border-b border-gray-800">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-yellow-400 flex items-center justify-center text-gray-900">
                             <i class="fas fa-plus"></i>
                        </div>
                        <h3 class="font-bold text-white">Add Category</h3>
                    </div>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('fees.types.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Category Name</label>
                            <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white" placeholder="e.g. Annual Tuition">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-yellow-400 focus:ring-yellow-400 transition bg-gray-50 focus:bg-white placeholder-gray-400" placeholder="Optional details..."></textarea>
                        </div>
                        
                        <button type="submit" class="w-full bg-yellow-400 text-gray-900 font-bold py-3 px-4 rounded-xl hover:bg-yellow-500 transition shadow-lg shadow-yellow-400/20 transform hover:-translate-y-0.5">
                            Create Category
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- List -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-700">Existing Categories</h3>
                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-bold">{{ $types->count() }} Types</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-100 bg-white">
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Description</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($types as $type)
                            <tr class="hover:bg-yellow-50 transition group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-2 h-8 bg-yellow-400 rounded-full mr-3 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        <span class="text-sm font-bold text-gray-800">{{ $type->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-500 line-clamp-2">{{ $type->description ?? '-' }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('fees.types.destroy', $type->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-full bg-gray-100 text-gray-400 hover:bg-red-100 hover:text-red-500 transition flex items-center justify-center">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                                            <i class="fas fa-layer-group text-2xl text-gray-300"></i>
                                        </div>
                                        <p>No fee categories defined yet.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
