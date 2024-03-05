<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'generation',
        'parent_id',
    ];

    public static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid7();
        });
    }

    public function parent()
    {
        return $this->belongsTo(StudentParent::class);
    }

    
}
