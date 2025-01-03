<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }


    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
