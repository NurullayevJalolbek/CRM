<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Payment;
use App\Models\SocialLink;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MainController extends Controller
{

    public function index()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $formattedMonth = sprintf('%02d', $currentMonth); // Format month with leading zero if needed
        $paymentMonth = "{$currentYear}-{$formattedMonth}"; // Construct formatted payment month (e.g., '2024-03')

        $monthlyPayments = Payment::where('payment_month', $paymentMonth)
            ->sum('paid_amount');

        $totalGroups = Group::where('status', 1)->count();
        $students = Student::where('status', 'active')->count();
        $teachers = User::role('teacher')->count();
        $socialLinks = SocialLink::withCount('students')->get();


        $user = auth()->user();
        $groups = $user->groups()
            ->where('status', 1)
            ->with(['students' => function ($query) {
                $query->where('status', 'active');
            }])
            ->get();

        $distinctStudentIds = $groups->flatMap->students->pluck('id')->unique();
        $totalStudentsCount = $distinctStudentIds->count();
        $groupNumber = $groups->count();

        $teacherId = $user->id;
        $monthlyTeacherPayments = Payment::where('payment_month', $paymentMonth) // Use 'payment_month' instead of 'created_at'
            ->whereHas('group', function ($query) use ($teacherId) {
                $query->where('user_id', $teacherId); // Assuming 'user_id' is the teacher's ID in groups
            })
            ->sum('paid_amount');




        return view('admin.dashboard', compact('user', 'totalGroups', 'students', 'teachers', 'monthlyPayments', 'socialLinks', 'currentYear', 'currentMonth', 'totalStudentsCount', 'groupNumber', 'monthlyTeacherPayments'))->with('user', $user);
    }

    public function monthlyPayments(Request $request)
    {
        $currentYear = now()->year;
        $monthlyPayments = Payment::where('payment_month', 'like', "$currentYear-%")
            ->get()
            ->groupBy(function ($payment) {
                // Convert payment_month string to DateTime object
                $paymentMonth = \DateTime::createFromFormat('Y-m', $payment->payment_month);
                // Return formatted month name
                return $paymentMonth->format('F');
            })
            ->map(function ($group) {
                return $group->sum('paid_amount');
            });
        return response()->json($monthlyPayments);
    }



    public function yearlyPayments()
    {
        $yearlyPayments = Payment::selectRaw('SUBSTRING(payment_month, 1, 4) as year, SUM(paid_amount) as total_amount')
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        return response()->json($yearlyPayments);
    }
}
