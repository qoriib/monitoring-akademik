<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = ['name', 'semester', 'academic_year'];

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
}
