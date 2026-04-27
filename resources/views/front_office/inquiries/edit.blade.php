@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-lg overflow-hidden border border-gray-100">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Edit Inquiry</h2>
            <a href="{{ route('inquiries.index') }}" class="text-sm text-gray-600 hover:text-indigo-600">
                <i class="fas fa-arrow-left mr-1"></i> Back to Inquiries
            </a>
        </div>

        <form method="POST" action="{{ route('inquiries.update', $inquiry->id) }}" class="p-6 sm:p-8">
            @csrf
            @method('PUT')

            <!-- Contact Information -->
            <div class="mb-8">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4 border-l-4 border-indigo-500 pl-3">
                    Contact Details
                </h3>
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <div class="mt-1">
                            <input type="text" name="name" id="name" value="{{ old('name', $inquiry->name) }}" required 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border">
                        </div>
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                        <div class="mt-1">
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $inquiry->phone) }}" required 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border">
                        </div>
                        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <div class="mt-1">
                            <input type="email" name="email" id="email" value="{{ old('email', $inquiry->email) }}" 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border">
                        </div>
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Inquiry Status & Dates -->
            <div class="mb-8 border-t border-gray-200 pt-8">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4 border-l-4 border-amber-500 pl-3">
                    Status & Schedule
                </h3>
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <div class="mt-1">
                            <select id="status" name="status" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border bg-white">
                                <option value="open" {{ old('status', $inquiry->status) == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="closed" {{ old('status', $inquiry->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                <option value="converted" {{ old('status', $inquiry->status) == 'converted' ? 'selected' : '' }}>Converted</option>
                            </select>
                        </div>
                        @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                         <label for="inquiry_date" class="block text-sm font-medium text-gray-700">Inquiry Date</label>
                         <div class="mt-1">
                            <input type="date" name="inquiry_date" id="inquiry_date" 
                                value="{{ old('inquiry_date', $inquiry->inquiry_date ? $inquiry->inquiry_date->format('Y-m-d') : '') }}" required 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border">
                        </div>
                        @error('inquiry_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="follow_up_date" class="block text-sm font-medium text-gray-700">Follow-up Date</label>
                        <div class="mt-1">
                           <input type="date" name="follow_up_date" id="follow_up_date" 
                               value="{{ old('follow_up_date', $inquiry->follow_up_date ? $inquiry->follow_up_date->format('Y-m-d') : '') }}" 
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border">
                       </div>
                       @error('follow_up_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                   </div>
                </div>
            </div>

            <!-- Message -->
            <div class="mb-8 border-t border-gray-200 pt-8">
                 <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4 border-l-4 border-slate-500 pl-3">
                    Remarks
                </h3>
                <div>
                     <label for="message" class="block text-sm font-medium text-gray-700">Message / Notes</label>
                     <div class="mt-1">
                         <textarea name="message" id="message" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border">{{ old('message', $inquiry->message) }}</textarea>
                     </div>
                     @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-5 border-t border-gray-200">
                <div class="flex justify-end">
                    <a href="{{ route('inquiries.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Inquiry
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
