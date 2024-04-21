<?php

namespace App\Console\Commands;

use App\Http\Controllers\StudentController;
use App\Models\Student;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateQRCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-q-r-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $students = Student::all();
        $controller = new StudentController;
        
        foreach ($students as $student) {
            $dir = 'public/qrcodes/' . $student->generation;
            if (!Storage::disk('local')->exists($dir . '/' . $student->uuid . '.png')) {
                $controller->generateQR($student->uuid, $student->generation);
            }
        }
    }
}
