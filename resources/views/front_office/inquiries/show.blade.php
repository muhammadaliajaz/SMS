@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold leading-tight text-gray-800">Inquiry Details</h2>
            <a href="{{ route('inquiries.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow-sm hover:bg-gray-300 transition">
                <i class="fas fa-arrow-left mr-2"></i>Back to List
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
             <div class="p-6 border-b border-gray-100 flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">{{ $inquiry->name }}</h3>
                    <p class="mt-1 text-sm text-gray-500">Received on {{ $inquiry->inquiry_date->format('F j, Y') }}</p>
                </div>
                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                    {{ $inquiry->status === 'open' ? 'bg-green-100 text-green-800' : 
                       ($inquiry->status === 'closed' ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800') }}">
                    {{ ucfirst($inquiry->status) }}
                </span>
            </div>
            
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Contact Info -->
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Contact Information</h4>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $inquiry->email ?? 'N/A' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $inquiry->phone }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Follow-up Info -->
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Staff Actions</h4>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Follow-up Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($inquiry->follow_up_date)
                                    {{ $inquiry->follow_up_date->format('F j, Y') }}
                                @else
                                    <span class="text-gray-400 italic">Not scheduled</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                 <!-- Message -->
                <div class="md:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Message</h4>
                    <div class="bg-gray-50 rounded-lg p-4 text-sm text-gray-800 whitespace-pre-line border border-gray-100">
                        {{ $inquiry->message ?? 'No message content.' }}
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                <a href="{{ route('inquiries.edit', $inquiry->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-edit mr-2"></i> Edit Inquiry
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
