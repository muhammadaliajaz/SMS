<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $payment->id }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        yellow: {
                            400: '#FBBF24',
                            500: '#F59E0B',
                        },
                        gray: {
                            900: '#111827',
                            800: '#1F2937',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; }
            .shadow-lg { box-shadow: none; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8 font-sans text-gray-800">

    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl overflow-hidden print:shadow-none print:rounded-none">
        
        <!-- Header -->
        <div class="bg-gray-900 px-8 py-6 flex justify-between items-center print:bg-gray-900 print:text-white">
            <div class="flex items-center gap-3">
                 <div class="w-10 h-10 rounded-full border-2 border-yellow-400 flex items-center justify-center bg-gray-800">
                     <div class="w-4 h-4 bg-yellow-400 rounded-full"></div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-wide">EMS SCHOOL</h1>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Official Payment Receipt</p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-yellow-400 font-bold text-xl">PAID</div>
                <p class="text-gray-400 text-sm">Receipt #{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8">
            <!-- Info Grid -->
            <div class="grid grid-cols-2 gap-8 mb-8">
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Billed To</h3>
                    <div class="text-lg font-bold text-gray-900">{{ $payment->student->name }}</div>
                    <div class="text-sm text-gray-500">{{ $payment->student->email }}</div>
                    <div class="text-sm text-gray-500 mt-1">Student ID: {{ $payment->student->code ?? 'N/A' }}</div>
                </div>
                <div class="text-right">
                     <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Payment Details</h3>
                    <div class="text-sm font-bold text-gray-900"><span class="text-gray-500 font-normal">Date:</span> {{ $payment->payment_date->format('d M, Y') }}</div>
                    <div class="text-sm font-bold text-gray-900"><span class="text-gray-500 font-normal">Method:</span> {{ $payment->payment_method }}</div>
                </div>
            </div>

            <!-- Table -->
            <table class="w-full mb-8">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="text-left text-gray-500 uppercase tracking-wider text-xs font-bold py-3 px-4 rounded-l-lg">Description</th>
                        <th class="text-right text-gray-500 uppercase tracking-wider text-xs font-bold py-3 px-4 rounded-r-lg">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr>
                        <td class="py-4 px-4 text-gray-800 font-medium">{{ $payment->feeType->name }}</td>
                        <td class="py-4 px-4 text-right text-gray-800 font-bold">${{ number_format($payment->amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Total -->
            <div class="flex justify-end border-t border-gray-100 pt-6">
                <div class="w-1/2">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-500 text-sm">Subtotal</span>
                        <span class="font-bold text-gray-900">${{ number_format($payment->amount, 2) }}</span>
                    </div>
                     <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-500 text-sm">Tax (0%)</span>
                        <span class="font-bold text-gray-900">$0.00</span>
                    </div>
                    <div class="flex justify-between items-center border-t border-dashed border-gray-200 pt-4">
                        <span class="text-gray-900 font-bold text-lg">Total Paid</span>
                        <span class="text-yellow-500 font-extrabold text-2xl">${{ number_format($payment->amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Remarks -->
            @if($payment->remarks)
            <div class="mt-8 bg-yellow-50 border border-yellow-100 p-4 rounded-lg">
                <h4 class="text-yellow-800 font-bold text-xs uppercase tracking-wide mb-1">Remarks</h4>
                <p class="text-sm text-yellow-900">{{ $payment->remarks }}</p>
            </div>
            @endif

            <!-- Footer -->
            <div class="mt-12 pt-8 border-t border-gray-100 text-center">
                <p class="text-gray-400 text-xs mb-2">Thank you for your timely payment.</p>
                <p class="text-gray-300 text-[10px] uppercase">Generated by EMS System • {{ date('Y-m-d H:i:s') }}</p>
            </div>
        </div>
    </div>
    
    <div class="max-w-3xl mx-auto mt-6 text-center no-print">
        <button onclick="window.print()" class="bg-yellow-400 text-gray-900 px-8 py-3 rounded-full font-bold shadow-lg hover:bg-yellow-500 transition transform hover:-translate-y-0.5 flex items-center justify-center mx-auto gap-2">
            <i class="fas fa-print"></i> Print Receipt
        </button>
        <p class="mt-4 text-sm text-gray-500"><a href="{{ route('fees.index') }}" class="hover:text-gray-900 underline">Return to Dashboard</a></p>
    </div>

</body>
</html>
