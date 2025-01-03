<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'number',
        'subject_id'
    ];
    
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
