<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Card - {{ $exam->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none !important; }
            .page-break { page-break-after: always; }
            body { background: white; -webkit-print-color-adjust: exact; }
            .shadow-lg { box-shadow: none !important; }
        }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-8">

    <!-- Print Controls -->
    <div class="fixed top-4 right-4 z-50 no-print flex space-x-3">
        <button onclick="window.print()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-indigo-700 transition-colors flex items-center">
            <i class="fas fa-print mr-2"></i> Print Reports
        </button>
        <button onclick="window.close()" class="bg-gray-600 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-gray-700 transition-colors">
            Close
        </button>
    </div>

    @foreach($reportCards as $index => $card)
    <!-- Report Card Container -->
    <div class="max-w-[210mm] mx-auto bg-white shadow-lg rounded-xl overflow-hidden mb-8 page-break relative">
        <!-- Watermark -->
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-[0.03]">
             <i class="fas fa-graduation-cap text-[400px]"></i>
        </div>

        <!-- Header -->
        <div class="p-8 border-b-4 border-yellow-400 relative z-10 bg-gray-50">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <!-- Placeholder Logo -->
                    <div class="h-20 w-20 bg-gray-900 rounded-full flex items-center justify-center text-yellow-400 mr-5 border-4 border-white shadow-lg">
                        <i class="fas fa-school text-3xl"></i>
                    </div>
                    <div>
                <h1 class="text-2xl font-bold text-gray-900 uppercase tracking-wide">EMS</h1>
                <p class="text-sm text-gray-500">Pakpattan, Pakistan.</p>
                <p class="text-xs text-gray-400 mt-1"><i class="fas fa-phone mr-1"></i> +92 3026572894 &bull; <i class="fas fa-envelope mx-1"></i> chaudharyaliajaz@gmail.com</p>
                <div class="inline-block bg-yellow-400 text-gray-900 text-xs font-bold px-2 py-0.5 rounded uppercase tracking-wider mt-1">Report Card</div>
            </div>
                <div class="text-right">
                    <h2 class="text-xl font-bold text-gray-900 uppercase tracking-wide">{{ $exam->name }}</h2>
                    <p class="text-gray-700 font-medium">{{ $exam->term ?? 'Term Report' }}</p>
                    <p class="text-sm text-gray-500 mt-1">Date: {{ \Carbon\Carbon::now()->format('d M, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Student Details -->
        <div class="p-8 bg-gray-50 border-b border-gray-100 relative z-10">
            <div class="grid grid-cols-2 gap-x-12 gap-y-4">
                <div class="flex border-b border-gray-200 pb-2">
                    <span class="text-gray-500 w-32 font-medium">Student Name:</span>
                    <span class="text-gray-900 font-bold text-lg">{{ $card->student->user->name ?? $card->student->first_name }}</span>
                </div>
                <div class="flex border-b border-gray-200 pb-2">
                    <span class="text-gray-500 w-32 font-medium">Admission No:</span>
                    <span class="text-gray-900 font-semibold">{{ $card->student->admission_number }}</span>
                </div>
                <div class="flex border-b border-gray-200 pb-2">
                    <span class="text-gray-500 w-32 font-medium">Class:</span>
                    <span class="text-gray-900 font-semibold">{{ $class->name }}</span>
                </div>
                <div class="flex border-b border-gray-200 pb-2">
                    <span class="text-gray-500 w-32 font-medium">Roll No:</span>
                    <span class="text-gray-900 font-semibold">{{ $card->student->roll_number ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Marks Table -->
        <div class="p-8 relative z-10 min-h-[400px]">
             <table class="w-full border-collapse">
                <thead>
                    <tr class="text-left text-sm uppercase tracking-wider text-gray-900 bg-yellow-400">
                        <th class="px-4 py-3 font-bold rounded-l-lg border-y border-l border-yellow-500">Subject</th>
                        <th class="px-4 py-3 font-bold text-center border-y border-yellow-500">Full Marks</th>
                        <th class="px-4 py-3 font-bold text-center border-y border-yellow-500">Pass Marks</th>
                        <th class="px-4 py-3 font-bold text-center border-y border-yellow-500">Obtained</th>
                        <th class="px-4 py-3 font-bold text-center border-y border-yellow-500">Result</th>
                        <th class="px-4 py-3 font-bold rounded-r-lg border-y border-r border-yellow-500">Remarks</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($card->subjects as $subject)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $subject['subject'] }}</td>
                        <td class="px-4 py-3 text-center">{{ $subject['full_marks'] }}</td>
                        <td class="px-4 py-3 text-center">{{ $subject['passing_marks'] }}</td>
                        <td class="px-4 py-3 text-center font-bold {{ $subject['is_fail'] ? 'text-red-600' : 'text-gray-900' }}">
                            {{ number_format($subject['obtained_marks'], 1) }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($subject['is_fail'])
                                <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full font-bold">FAIL</span>
                            @else
                                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-bold">PASS</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm italic text-gray-500">{{ $subject['remarks'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Summary -->
            <div class="mt-8 flex justify-end">
                <div class="w-1/2 bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Performance Summary</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                             <span class="text-gray-600">Total Marks:</span>
                             <span class="font-bold text-gray-900">{{ number_format($card->total_obtained, 1) }} <span class="text-gray-400 font-normal">/ {{ $card->total_full }}</span></span>
                        </div>
                        <div class="flex justify-between">
                             <span class="text-gray-600">Percentage:</span>
                             <span class="font-bold text-gray-900">{{ $card->percentage }}%</span>
                        </div>
                         <div class="flex justify-between items-center text-lg mt-2 pt-2 border-t border-gray-200">
                             <span class="font-bold text-gray-900">Final Result:</span>
                             <span class="font-bold px-3 py-1 rounded {{ str_contains($card->result, 'FAIL') ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                 {{ $card->result }}
                             </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer / Signatures -->
        <div class="px-8 pb-12 pt-4 relative z-10">
            <div class="flex justify-between items-end mt-12">
                <div class="text-center">
                    <div class="w-40 border-b-2 border-gray-400 mb-2"></div>
                    <p class="text-sm font-bold text-gray-600 uppercase">Class Teacher</p>
                </div>
                <div class="text-center">
                    <div class="px-4 py-2 border-2 border-gray-900 rounded-lg opacity-50 mb-2">
                        <span class="text-gray-900 font-bold text-sm tracking-widest uppercase">Official Seal</span>
                    </div>
                </div>
                <div class="text-center">
                    <div class="w-40 border-b-2 border-gray-400 mb-2"></div>
                    <p class="text-sm font-bold text-gray-600 uppercase">Principal</p>
                </div>
            </div>
             <p class="text-center text-gray-400 text-xs mt-12 italic">This is a computer-generated document.</p>
        </div>
    </div>
    @endforeach

</body>
</html>
