<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('pages.student.index', [
            'students' => $students
        ]);
    }

    public function create()
    {
        return view('pages.student.create');
    }

    public function store(Request $request)
    {
        
    }
}
