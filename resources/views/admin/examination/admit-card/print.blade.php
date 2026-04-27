<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admit Card - {{ $exam->name }}</title>
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
<body class="bg-gray-100 min-h-screen p-8 flex flex-col items-center font-sans text-gray-800">

    <!-- Print Controls -->
    <div class="fixed top-4 right-4 z-50 no-print flex space-x-3">
        <button onclick="window.print()" class="bg-black text-white px-5 py-2.5 rounded hover:bg-gray-800 transition-colors flex items-center font-medium text-sm">
            <i class="fas fa-print mr-2"></i> Print
        </button>
        <button onclick="window.close()" class="bg-white text-gray-800 border border-gray-300 px-5 py-2.5 rounded hover:bg-gray-50 transition-colors font-medium text-sm">
            Close
        </button>
    </div>

    @foreach($students as $student)
    <!-- Admit Card Container -->
    <div class="w-[210mm] bg-white shadow-sm mb-10 page-break p-12 relative" style="min-height: 297mm;"> <!-- A4 Size -->
        
        <!-- Header -->
        <div class="flex justify-between items-start mb-12">
            <div class="flex items-center gap-4">
                 <div class="w-16 h-16 bg-gray-900 text-white flex items-center justify-center rounded-full text-2xl font-bold">
                    <i class="fas fa-university"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900">EMS</h1>
                    <p class="text-sm text-gray-500 font-medium">Pakpattan, Pakistan.</p>
                    <p class="text-xs text-gray-400 mt-1"><i class="fas fa-phone mr-1"></i> +92 3026572894 &bull; <i class="fas fa-envelope mx-1"></i> chaudharyaliajaz@gmail.com</p>
                </div>
            </div>
            <div class="text-right">
                <span class="inline-block bg-gray-100 text-gray-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2">Admit Card</span>
                <h2 class="text-xl font-bold text-gray-900">{{ $exam->name }}</h2>
                <p class="text-sm text-gray-500">{{ $exam->term ?? 'Term Examination' }} &bull; {{ date('Y') }}</p>
            </div>
        </div>

        <!-- Student Info & Photo -->
        <div class="flex justify-between items-start mb-12">
             <div class="grid grid-cols-2 gap-x-12 gap-y-6 text-sm w-3/4">
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider font-semibold mb-1">Student Name</p>
                    <p class="font-bold text-gray-900 text-lg">{{ $student->user->name ?? $student->first_name }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider font-semibold mb-1">Roll Number</p>
                    <p class="font-bold text-gray-900 text-lg">{{ $student->roll_number ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider font-semibold mb-1">Class / Section</p>
                    <p class="font-medium text-gray-900">{{ $class->name }} - {{ $student->section->name ?? 'A' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider font-semibold mb-1">Admission No</p>
                    <p class="font-medium text-gray-900">{{ $student->admission_number }}</p>
                </div>
             </div>
             
             <!-- Photo -->
             <div class="w-32 h-40 bg-gray-50 border border-gray-200 rounded flex items-center justify-center">
                 <div class="text-center text-gray-300">
                     <i class="fas fa-camera text-2xl mb-2"></i>
                     <p class="text-[10px] uppercase font-bold">Photo</p>
                 </div>
             </div>
        </div>

        <!-- Schedule -->
        <div class="mb-12">
            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Examination Schedule</h3>
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100">
                        <th class="py-3 font-semibold">Date & Day</th>
                        <th class="py-3 font-semibold">Time</th>
                        <th class="py-3 font-semibold">Subject</th>
                        <th class="py-3 font-semibold text-right">Invigilator</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($schedules as $schedule)
                    <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50">
                        <td class="py-4">
                            <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($schedule->date_of_exam)->format('d M, Y') }}</span>
                            <span class="text-gray-400 text-xs ml-2">{{ \Carbon\Carbon::parse($schedule->date_of_exam)->format('l') }}</span>
                        </td>
                        <td class="py-4 font-mono text-xs">
                             {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                        </td>
                        <td class="py-4 font-bold text-gray-900">
                            {{ $schedule->subject->name }}
                        </td>
                        <td class="py-4 text-right">
                            <div class="inline-block w-24 h-6 border-b border-gray-200"></div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="mt-auto">
            <div class="bg-gray-50 p-6 rounded-lg mb-8">
                <p class="text-xs font-bold text-gray-900 uppercase mb-2">Instructions</p>
                <ul class="text-xs text-gray-600 space-y-1 list-disc list-inside">
                    <li>Bring this card to the exam hall.</li>
                    <li>Arrive 15 minutes early.</li>
                    <li>No electronic devices allowed.</li>
                </ul>
            </div>

            <div class="flex justify-between items-end pt-8 border-t border-gray-100">
                <div class="text-center">
                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-8">Student</p>
                </div>
                <div class="text-center">
                    <div class="h-10 mb-2"></div> <!-- Stamp space -->
                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Controller of Exams</p>
                </div>
            </div>
        </div>

    </div>
    @endforeach

</body>
</html>
