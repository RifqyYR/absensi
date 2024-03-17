<?php

namespace App\Http\Controllers;

use App\Imports\ImportParentData;
use App\Models\Absence;
use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $students = Student::all();
        $todayAbsences = Absence::where('category', 'IN')->whereDate('datetime', now())->get();
        
        return view('pages.home', [
            'students' => $students,
            'absences' => $todayAbsences,
        ]);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file');
        $filename = rand(). '-' . $file->getClientOriginalName();
        $file->move('uploads', $filename);

        Excel::import(new ImportParentData, public_path('uploads/'.$filename));
        
        if (file_exists(public_path('uploads/'.$filename))) {
            unlink(public_path('uploads/'.$filename));
        }

        return redirect()->back()->with('success', 'Data berhasil diimport');
    }
}
