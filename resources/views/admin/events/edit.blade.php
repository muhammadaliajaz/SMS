@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Event</h2>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('events.update', $event->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Event Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm p-2 border" required>
                </div>

                <!-- Type -->
                 <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Event Type</label>
                    <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm p-2 border">
                        <option value="academic" {{ $event->type == 'academic' ? 'selected' : '' }}>Academic</option>
                        <option value="sports" {{ $event->type == 'sports' ? 'selected' : '' }}>Sports</option>
                        <option value="cultural" {{ $event->type == 'cultural' ? 'selected' : '' }}>Cultural</option>
                        <option value="holiday" {{ $event->type == 'holiday' ? 'selected' : '' }}>Holiday</option>
                        <option value="meeting" {{ $event->type == 'meeting' ? 'selected' : '' }}>Meeting</option>
                    </select>
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm p-2 border">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date & Time</label>
                        <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm p-2 border" required>
                    </div>

                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date & Time</label>
                        <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date', optional($event->end_date)->format('Y-m-d\TH:i')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm p-2 border">
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm p-2 border">{{ old('description', $event->description) }}</textarea>
                </div>

                <div class="flex justify-end pt-4">
                    <a href="{{ route('events.index') }}" class="mr-3 bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">Cancel</a>
                    <button type="submit" class="bg-yellow-400 text-gray-900 px-4 py-2 rounded-md font-bold hover:bg-yellow-500 transition">Update Event</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
