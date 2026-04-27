@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white shadow-xl rounded-lg overflow-hidden border border-gray-100">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Collect Fee</h2>
            <a href="{{ route('fees.index') }}" class="text-sm text-gray-600 hover:text-indigo-600">
                <i class="fas fa-history mr-1"></i> Payment History
            </a>
        </div>
        
        <form action="{{ route('fees.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Student</label>
                <select name="student_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border bg-white">
                    <option value="">-- Search Student --</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}" {{ (isset($student) && $student->id == $s->id) ? 'selected' : '' }}>
                            {{ $s->name }} ({{ $s->email }})
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500">Select the student who is making the payment.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fee Category</label>
                    <select name="fee_type_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border bg-white">
                        <option value="">Select Category</option>
                        @foreach($feeTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                     <label class="block text-sm font-medium text-gray-700 mb-2">Amount</label>
                     <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                          <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" name="amount" required min="0" step="0.01" class="block w-full rounded-md border-gray-300 pl-7 pr-12 focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border" placeholder="0.00">
                      </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Date</label>
                    <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                    <select name="payment_method" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border bg-white">
                        <option value="Cash">Cash</option>
                        <option value="Card">Card</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Online">Online</option>
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Remarks (Optional)</label>
                <textarea name="remarks" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border"></textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 text-white px-6 py-2.5 rounded-md hover:bg-green-700 transition font-medium shadow-md flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> Record Payment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
