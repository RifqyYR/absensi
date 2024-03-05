<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'date',
        'time',
        'datetime',
        'status',
    ];

    public static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid7();
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
