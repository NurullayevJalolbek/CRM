<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Group;
use App\Models\PaymentMethod;
use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch payments with related models
        $payments = Payment::with(['student', 'group', 'createdBy', 'payment_methods'])
            ->orderBy('created_at', 'desc')
            ->paginate(150); // Adjust the number as per your desired pagination size
    
        // Fetch only active groups
        $groups = Group::where('status', 1)->get();
    
        return view('admin.payment.index', compact('payments', 'groups'))->with('user', auth()->user());
    }


    public function unpaid(Request $request)
    {
        $groups = Group::where('status', 1)
            ->with('user') // Include the user (teacher) relationship
            ->join('users', 'groups.user_id', '=', 'users.id') // Join with the 'users' table (teachers)
            ->orderBy('users.name') // Order by the teacher's name
            ->orderBy('groups.name') // Then order by the group's name
            ->select('groups.*') // Select only the group fields
            ->get();
    
        $groupId = $request->input('group_id');
        $paymentMonth = $request->input('payment_month', date('Y-m'));
        [$year, $month] = explode('-', $paymentMonth);
    
        $formattedMonth = sprintf('%02d', $month);
        $formattedYearMonth = "{$year}-{$formattedMonth}";
    
        $query = Student::where('status', 'active');
    
        if ($groupId) {
            $query->whereHas('groups', function ($query) use ($groupId) {
                $query->where('group_id', $groupId);
            });
        }
        
        // Filter for students who haven't fully paid for the selected month
        $query->whereDoesntHave('payments', function ($paymentQuery) use ($formattedYearMonth) {
            $paymentQuery->where('payment_month', $formattedYearMonth)
                ->where('status', 'paid'); // Only exclude those who have 'paid' status
        });
        
        $students = $query->with([
            'groups',
            'payments' => function ($query) use ($formattedYearMonth) {
                $query->where('payment_month', $formattedYearMonth);
            }
        ])
        ->paginate(1000); // Paginate the results
    
        return view('admin.payment.unpaid', compact('students', 'groups', 'groupId', 'formattedYearMonth', 'paymentMonth'))
            ->with('user', auth()->user());
    }



    public function show($student_id)
    {
        $student = Student::findOrFail($student_id);

        $payments = Payment::where('student_id', $student_id)->latest()->paginate(20);
        $paymentMethods = PaymentMethod::all();

        // Define month names array
        $monthNames = [
            1 => 'Yanvar',
            2 => 'Fevral',
            3 => 'Mart',
            4 => 'Aprel',
            5 => 'May',
            6 => 'Iyun',
            7 => 'Iyul',
            8 => 'Avgust',
            9 => 'Sentyabr',
            10 => 'Oktyabr',
            11 => 'Noyabr',
            12 => 'Dekabr'
        ];

        // Convert payment months to text names
        $payments->transform(function ($payment) use ($monthNames) {
            if (!empty($payment->payment_month)) {
                list($paymentYear, $paymentMonth) = explode('-', $payment->payment_month);
                if (isset($monthNames[(int) $paymentMonth])) {
                    $payment->payment_month_text = $paymentYear . ' ' . $monthNames[(int) $paymentMonth];
                } else {
                    $payment->payment_month_text = 'Invalid Month';
                }
            } else {
                $payment->payment_month_text = 'Empty Month';
            }
            return $payment;
        });


        return view('admin.payment.add_payment', compact('payments', 'student', 'paymentMethods', 'monthNames'))->with('user', auth()->user());
    }




    public function create(StorePaymentRequest $request, $id)
    {
        $student = Student::findOrFail($id);
        $validatedData = $request->validated();

        $payment = new Payment();

        $payment->group_id = $validatedData['group_id'];
        $payment->paid_amount = $validatedData['paid_amount'];
        $payment->payment_method_id = $validatedData['payment_method_id'];
        $payment->remark = $validatedData['remark'];
        $payment->payment_month = $validatedData['payment_month'];
        $payment->created_by = auth()->id();
        $payment->student_id = $id;

        $payment->save();

        // Check if the checkbox is checked
        if ($request->has('change_status')) {
            // Update payment_status to true
            $student->update(['payment_status' => true]);
        } else {
            // Update payment_status to false
            $student->update(['payment_status' => false]);
        }

        return redirect()->route('payments.show', ['id' => $student->id])->with('success', 'To\'lov muvofaqiyatli amalga oshirildi!');
    }



    public function fetchReceiptInfo(Request $request)
    {
        // Retrieve the receipt information based on the receipt ID
        $receiptId = $request->input('receiptId');
        $receipt = Payment::with(['student', 'group'])->find($receiptId); // Load student and group relationships

        // Check if the receipt exists
        if ($receipt) {
            // Return the receipt information as JSON response
            return response()->json([
                'id' => $receipt->id,
                'student_name' => $receipt->student->name,
                'payment_method' => $receipt->payment_methods->name,
                'group_name' => $receipt->group->name,
                'group_price' => $receipt->group->price,
                'group_teacher' => $receipt->group->user->name,
                'paid_amount' => $receipt->paid_amount,
                'created_at' => $receipt->created_at->format('Y-m-d , H:i'),
                'payment_month' => $receipt->payment_month, // Include payment month
            ]);
        } else {
            // If the receipt is not found, return a JSON response with an error message
            return response()->json(['error' => 'Receipt not found'], 404);
        }
    }


    public function printReceipt($id)
    {
        $payment = Payment::findOrFail($id);
        return view('admin.payment.print', compact('payment'))->with('user', auth()->user());
    }


    public function history(Request $request)
    {
        $subjects = Subject::all();
        $groups = Group::where('status', 1)->get();
        $groupId = $request->input('group_id');
        $year = $request->input('year');
        $month = $request->input('month');


        if (!$year || !$month) {
            $students = Student::all();
            return view('admin.payment.history', compact('year', 'month', 'subjects', 'groups', 'students'))->with('user', auth()->user());
        }

        // Check if year and month are provided
        $group = Group::findOrFail($groupId);
        $formattedMonth = sprintf('%02d', $month); // Format month with leading zero if needed
        $formattedYearMonth = "{$year}-{$formattedMonth}"; // Construct formatted year-month (e.g., '2024-03')

        // Eager load students and their payments for the selected group and formatted year-month
        $students = Student::where('status', 'active')->whereHas('groups', function ($query) use ($groupId) {
            $query->where('group_id', $groupId);
        })->with([
                    'payments' => function ($query) use ($formattedYearMonth, $groupId) {
                        $query->where('payment_month', $formattedYearMonth)
                            ->where('group_id', $groupId); // Filter payments by the selected group
                    }
                ])->get();

        return view('admin.payment.history', compact('students', 'year', 'month', 'group', 'subjects', 'groups', 'groupId'))->with('user', auth()->user());
    }

    public function updatePaymentStatus(Request $request)
    {
        $paymentId = $request->input('payment_id');
        $payment = Payment::find($paymentId);
    
        if (!$payment) {
            return redirect()->back()->with('error', 'Payment not found');
        }
    
        // Assuming the select input name is 'payment_status' in your form
        $paymentStatus = $request->input('payment_status');
    
        // Validate the payment status value (optional)
        if ($paymentStatus !== '0' && $paymentStatus !== '1') {
            return redirect()->back()->with('error', 'Invalid payment status value');
        }
    
        $payment->payment_status = $paymentStatus;
        $payment->save();
    
        return redirect()->back()->with('success', 'To\'lov statusi muvofaqiyatli yangilandi');
    }


    public function delete($id) 
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return redirect()->back()->with('success', 'To\'lov muvaffaqiyatli o\'chirildi');

    }


    public function search(Request $request)
    {
        // Retrieve search parameters from request
        $paymentId = $request->input('payment_id');
        $groupId = $request->input('group_id');
        $paymentMonth = $request->input('payment_month');

        // Query payments based on search criteria
        $query = Payment::query();

        if ($paymentId) {
            $query->where('id', $paymentId);
        }

        if ($groupId) {
            $query->where('group_id', $groupId);
        }

        if ($paymentMonth) {
            $query->where('payment_month', $paymentMonth);
        }

        $payments = $query->paginate(40); // Adjust pagination as needed

        // Retrieve all groups for the dropdown
        $groups = Group::all();

        return view('admin.payment.index', compact('payments', 'groups'))->with('user', auth()->user());
    }
    
    
    


}
