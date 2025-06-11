<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['nisn', 'name', 'class'];

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }
}
