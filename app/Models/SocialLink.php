<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'social_id');
    }
}
