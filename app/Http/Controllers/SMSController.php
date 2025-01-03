<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SMSController extends Controller
{

    public function create()
    {
        $students = Student::where('status', 'active')->get();
        $groups = Group::where('status', 1)->get();
        return view('admin.sms.create', compact('groups', 'students'))->with('user', auth()->user());
    }


    public function sendSmsToStudent(Request $request)
    {
        $groupId = $request->input('group_id');
        $group = Group::with('subject')->find($groupId);
        $subjectName = $group->subject->name;
        $messageContent = $request->input('message');
    
        // Get the current year and month in 'Y-m' format
        $currentYearMonth = date('Y-m');
    
        // Fetch students for the selected group with their numbers and names
        $students = Student::where('status', 'active') // Filter active students
            ->whereHas('groups', function ($query) use ($groupId) {
                $query->where('group_id', $groupId);
            })
            ->with(['payments' => function ($query) use ($currentYearMonth, $groupId) {
                $query->where('payment_month', $currentYearMonth)
                    ->where('group_id', $groupId);
            }])
            ->get();
    
        $eskizApiEmail = env('ESKIZ_API_EMAIL');
        $eskizApiPassword = env('ESKIZ_API_PASSWORD');
        $eskizApiEndpoint = env('ESKIZ_API_ENDPOINT');
    
        // Authenticate with Eskiz API
        $authResponse = Http::post("$eskizApiEndpoint/auth/login", [
            'email' => $eskizApiEmail,
            'password' => $eskizApiPassword,
        ]);
    
        if (!$authResponse->successful()) {
            return redirect()->back()->with('error', 'Failed to authenticate with Eskiz API.');
        }
    
        $authToken = $authResponse->json()['data']['token'];
    
        foreach ($students as $student) {
            $studentId = $student->id;
            $studentName = $student->name;
            $studentNumber = str_replace(['+', '-', ' '], '', $student->parent_number);
    
            // Get the group price for the student's group
            $groupPrice = $student->groups->where('id', $groupId)->first()->price;
    
            // Calculate the total paid amount for the current month
            $totalPaidAmount = $student->payments->where('group_id', $groupId)
                ->where('payment_month', $currentYearMonth)
                ->sum('paid_amount');
    
            // Check if the total paid amount is less than the group price
            if ($totalPaidAmount < $groupPrice) {
                $message = 'Assalomu aleykum '. $studentName . 'ning ota-onasi, Iltimos ' . $subjectName . ' kursiga joriy oy uchuni to\'\lov qilishni unutmang. Xurmat bilan CAMELOT o\'quv markazi!';
                $mobilePhone = str_replace(['+', '-', ' '], '', $studentNumber);
    
                // Send SMS using Eskiz API
                $response = Http::withToken($authToken)
                    ->post("$eskizApiEndpoint/message/sms/send", [
                        'mobile_phone' => $mobilePhone,
                        'message' => $message,
                    ]);
    
                if (!$response->successful()) {
                    Log::error('Failed to send SMS to ' . $studentName . ': ' . $response->body());
                }
            }
        }
    
        return redirect()->back()->with('success', 'SMS successfully sent to students with pending payments for the current month in the selected group.');
    }
    
    

}
