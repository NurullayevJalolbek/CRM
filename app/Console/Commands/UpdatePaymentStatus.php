<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;

class UpdatePaymentStatus extends Command
{
    protected $signature = 'payment:update-status';

    protected $description = 'Update payment status of students';

    public function handle()
    {
        // Fetch students whose payment status is true
        $students = Student::where('payment_status', true)->get();

        // Update the payment status to false for these students
        foreach ($students as $student) {
            $student->update(['payment_status' => false]);
        }

        $this->info('Payment status updated successfully.');
    }
}
