<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'group_id',
        'paid_amount',
        'remark',
        'created_by',
        'payment_method_id',
        'payment_month'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function payment_methods()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
