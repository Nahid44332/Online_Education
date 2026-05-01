<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;

class PaymentController extends Controller
{
    
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function createPayment($student_id)
    {
        $student = Student::find($student_id);
        return view('backend.payment.create', compact('student_id'));        
    }

   public function paymentStore(Request $request, $student_Id)
{

    $student = Student::find($student_Id);

    $payment = new Payment();
    $payment->student_id = $student_Id;
    $payment->course_id = $student->course_id;
    $payment->amount = $request->amount;
    $payment->method = $request->method;
    $payment->transaction_id = $request->transaction_id;
    $payment->payment_date = $request->payment_date;
    $payment->note = $request->note;

    $payment->save();

      // প্রথম payment হলে student active (1) করে দাও
    if ($student->status != 1) {
        $student->status = 1; // 1 = Active
        $student->save();
    }

    Toastr()->success('Payment Added Successfully!');
    return redirect('/admin/payment/list');
}


    public function paymentList()
    {
        $payments = Payment::with('student', 'course')->get();
        return view('backend.payment.payment-list', compact('payments'));
    }

    public function paymentPrint($id)
    {
         $payment = Payment::with('student', 'course')->findOrFail($id);
        return view('backend.payment.payment-print', compact('payment'));
    }

    public function paymentDelete($id)
    {
        $paymentDelete = Payment::find($id);

        $paymentDelete->delete();
        toastr()->success('Payment Delete Successfully.');
        return redirect()->back();
    }

    public function getStudentPayments($id)
{
    $student = Student::with('payments.course')->findOrFail($id);

    return response()->json($student);
}

}
