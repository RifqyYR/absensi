<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class StudentParent extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'username',
        'password',
        'phone_number'
    ];

    public static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid7();
        });
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'parent_id', 'id');
    }

    protected $casts = [
        'password' => 'hashed',
    ];
}
