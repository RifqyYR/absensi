<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Violation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4();
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function violationPoint()
    {
        return $this->belongsTo(ViolationPoint::class);
    }
}
