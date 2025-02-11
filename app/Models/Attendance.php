<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }}
