<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeeType;
use App\Models\FeePayment;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf; // If using simple view for receipt, no need for PDF package yet unless requested

class FeeController extends Controller
{
    // === Fee Payments ===

    public function index()
    {
        $payments = FeePayment::with(['student', 'feeType'])->latest()->paginate(20);
        return view('admin.fees.index', compact('payments'));
    }

    public function create(Request $request)
    {
        // If student_id is passed, pre-select
        $student_id = $request->get('student_id');
        $student = $student_id ? User::find($student_id) : null;
        
        $feeTypes = FeeType::all();
        // Fetch all students for dropdown (in real app might need AJAX search)
        $students = User::where('role_id', '!=', 1)->orderBy('name')->get(); // Exclude admin, assuming 1 is admin

        return view('admin.fees.create', compact('student', 'feeTypes', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
        ]);

        FeePayment::create($request->all());

        return redirect()->route('fees.index')->with('success', 'Payment recorded successfully.');
    }

    // === Fee Types Management ===
    // We can handle types here or in separate controller. Doing here for simplicity.

    public function indexTypes()
    {
        $types = FeeType::all();
        return view('admin.fees.types.index', compact('types'));
    }

    public function storeType(Request $request)
    {
        $request->validate(['name' => 'required|unique:fee_types,name']);
        FeeType::create($request->only('name', 'description'));
        return back()->with('success', 'Fee Type added.');
    }
    
    public function destroyType($id)
    {
        FeeType::destroy($id);
        return back()->with('success', 'Fee Type deleted.');
    }
    
     public function receipt($id)
    {
        $payment = FeePayment::with(['student', 'feeType'])->findOrFail($id);
        return view('admin.fees.receipt', compact('payment'));
    }
}
