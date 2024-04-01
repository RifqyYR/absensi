<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(StudentParent::class);
    }
    
    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    public function violations()
    {
        return $this->hasMany(Violation::class);
    }
}
