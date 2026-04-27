@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Exam Management</h2>
            <p class="text-gray-500 mt-1">Create and manage examination terms</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r shadow-sm flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm">
             <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                <h3 class="text-red-800 font-medium">There were some problems with your input</h3>
            </div>
            <ul class="list-disc list-inside text-red-700 text-sm ml-6">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Exam List -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-xl shadow-gray-200 border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl">
                <div class="px-8 py-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center backdrop-blur-xl">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <span class="w-2 h-8 bg-yellow-400 rounded-full mr-3"></span>
                        Examination List
                    </h3>
                    <span class="px-4 py-1.5 text-xs font-bold uppercase tracking-wider bg-yellow-100 text-yellow-800 rounded-lg border border-yellow-200 shadow-sm">{{ $exams->count() }} Records</span>
                </div>
                
                @if($exams->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-500 text-xs uppercase tracking-wider">
                                <th class="px-8 py-4 font-bold text-gray-600">Name / Term</th>
                                <th class="px-8 py-4 font-bold text-gray-600">Schedule</th>
                                <th class="px-8 py-4 font-bold text-gray-600">Note</th>
                                <th class="px-8 py-4 font-bold text-right text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($exams as $exam)
                            <tr class="hover:bg-yellow-50 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center">
                                        <div class="h-12 w-12 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300 shadow-sm border border-yellow-100">
                                            <i class="fas fa-file-signature text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800 text-lg group-hover:text-yellow-700 transition-colors">{{ $exam->name }}</p>
                                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest">{{ $exam->term ?? 'No Term' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="text-sm space-y-1.5">
                                        <div class="flex items-center text-gray-600 font-medium bg-gray-50 w-fit px-2 py-1 rounded-md border border-gray-200">
                                            <i class="fas fa-calendar-alt w-4 mr-2 text-yellow-500"></i>
                                            {{ $exam->start_date ? \Carbon\Carbon::parse($exam->start_date)->format('M d, Y') : 'N/A' }}
                                        </div>
                                        <div class="flex items-center text-gray-600 font-medium bg-gray-50 w-fit px-2 py-1 rounded-md border border-gray-200">
                                            <i class="fas fa-flag-checkered w-4 mr-2 text-gray-400"></i>
                                            {{ $exam->end_date ? \Carbon\Carbon::parse($exam->end_date)->format('M d, Y') : 'N/A' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="relative group/note cursor-help">
                                        <p class="text-sm text-gray-500 truncate max-w-xs">{{ $exam->note ?? '-' }}</p>
                                        @if($exam->note)
                                        <div class="absolute left-0 bottom-full mb-2 hidden group-hover/note:block z-10 w-64 p-3 bg-gray-900 text-white text-xs rounded-lg shadow-xl">
                                            {{ $exam->note }}
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-right space-x-2">
                                    <button class="edit-btn inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white border border-gray-200 text-gray-400 hover:text-yellow-600 hover:border-yellow-400 hover:bg-yellow-50 transition-all shadow-sm hover:shadow-md transform hover:-translate-y-0.5" 
                                            data-id="{{ $exam->id }}"
                                            data-name="{{ $exam->name }}"
                                            data-term="{{ $exam->term }}"
                                            data-start="{{ $exam->start_date }}"
                                            data-end="{{ $exam->end_date }}"
                                            data-note="{{ $exam->note }}"
                                            title="Edit">
                                        <i class="fas fa-pencil-alt text-sm"></i>
                                    </button>
                                    
                                    <form action="{{ route('exams.destroy', $exam->id) }}" method="POST" class="d-inline inline-block" onsubmit="return confirm('Are you sure you want to delete this exam? This will delete all related schedules and marks.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white border border-gray-200 text-gray-400 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all shadow-sm hover:shadow-md transform hover:-translate-y-0.5" title="Delete">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="p-16 text-center">
                    <div class="inline-flex h-24 w-24 items-center justify-center rounded-full bg-yellow-50 text-yellow-400 mb-6 shadow-inner animate-pulse">
                        <i class="fas fa-clipboard-list text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">No exams created yet</h3>
                    <p class="mt-2 text-gray-500 max-w-sm mx-auto">Get started by creating a new examination entry from the form on the right.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Add/Edit Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-xl shadow-gray-200 border border-gray-100 sticky top-6 overflow-hidden">
                <div class="px-6 py-5 bg-gray-900 border-b border-gray-800 text-white flex justify-between items-center shadow-lg relative overflow-hidden">
                    <div class="relative z-10 flex items-center">
                         <div class="w-8 h-8 rounded-full bg-yellow-400 flex items-center justify-center mr-3 text-gray-900 shadow-lg shadow-yellow-400/20">
                            <i class="fas fa-plus text-sm"></i>
                         </div>
                         <h3 class="font-bold text-lg tracking-wide text-white" id="form-title">Create Exam</h3>
                    </div>
                </div>
                
                <div class="p-6 relative">
                    <form action="{{ route('exams.store') }}" method="POST" id="exam-form">
                        @csrf
                        <div id="method-field"></div>
                        
                        <div class="space-y-5">
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Exam Name <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-yellow-500 transition-colors">
                                        <i class="fas fa-heading"></i>
                                    </div>
                                    <input type="text" name="name" id="name" class="pl-10 w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-yellow-400 focus:ring-4 focus:ring-yellow-400/20 transition-all outline-none" placeholder="e.g. Mid Term 2024" required>
                                </div>
                            </div>
                            
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Term / Session</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-yellow-500 transition-colors">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                    <input type="text" name="term" id="term" class="pl-10 w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-yellow-400 focus:ring-4 focus:ring-yellow-400/20 transition-all outline-none" placeholder="e.g. First Term">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="group">
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5 ml-1">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-yellow-400 focus:ring-4 focus:ring-yellow-400/20 transition-all outline-none text-sm">
                                </div>
                                <div class="group">
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5 ml-1">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-yellow-400 focus:ring-4 focus:ring-yellow-400/20 transition-all outline-none text-sm">
                                </div>
                            </div>
                            
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Note (Optional)</label>
                                <textarea name="note" id="note" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-yellow-400 focus:ring-4 focus:ring-yellow-400/20 transition-all outline-none resize-none" placeholder="Add any specific details..."></textarea>
                            </div>
                            
                            <div class="pt-2 flex items-center space-x-3">
                                <button type="submit" class="flex-1 bg-yellow-400 text-gray-900 px-4 py-3 rounded-xl hover:bg-yellow-500 hover:shadow-lg hover:shadow-yellow-400/30 ring-offset-2 focus:ring-4 focus:ring-yellow-300 font-bold transition-all transform active:scale-95 flex justify-center items-center" id="save-btn">
                                    <i class="fas fa-check-circle mr-2"></i> <span>Create Exam</span>
                                </button>
                                <button type="button" class="hidden flex-1 bg-white border border-gray-200 text-gray-700 px-4 py-3 rounded-xl hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 font-bold transition-colors" id="cancel-btn">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editBtns = document.querySelectorAll('.edit-btn');
        const form = document.getElementById('exam-form');
        const formTitle = document.getElementById('form-title');
        const saveBtn = document.getElementById('save-btn');
        const cancelBtn = document.getElementById('cancel-btn');
        const methodField = document.getElementById('method-field');

        const nameInput = document.getElementById('name');
        const termInput = document.getElementById('term');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const noteInput = document.getElementById('note');

        editBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                formTitle.textContent = 'Edit Exam';
                saveBtn.textContent = 'Update Exam';
                saveBtn.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
                saveBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                
                cancelBtn.classList.remove('hidden');
                
                form.action = `/admin/exams/${id}`; 
                methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';

                nameInput.value = this.dataset.name;
                termInput.value = this.dataset.term;
                startDateInput.value = this.dataset.start;
                endDateInput.value = this.dataset.end;
                noteInput.value = this.dataset.note;
                
                // Scroll to top of form on mobile
                if(window.innerWidth < 1024) {
                    form.scrollIntoView({behavior: 'smooth'});
                }
            });
        });

        cancelBtn.addEventListener('click', function() {
            formTitle.textContent = 'Add New Exam';
            saveBtn.textContent = 'Create Exam';
             saveBtn.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
            saveBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            
            cancelBtn.classList.add('hidden');
            form.action = "{{ route('exams.store') }}";
            methodField.innerHTML = '';
            form.reset();
        });
    });
</script>
@endsection
