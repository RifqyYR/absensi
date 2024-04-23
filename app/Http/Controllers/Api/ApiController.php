<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudenParentResource;
use App\Models\Absence;
use App\Models\StudentParent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $user = StudentParent::where('phone_number', $request->phone_number)->first();

        if ($user == null) {
            return response(new StudenParentResource(false, 400, 'User tidak ditemukan', null), 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response(new StudenParentResource(false, 400, 'Password salah', null), 400);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        $user->update(['api_token' => $token]);

        return new StudenParentResource(true, 200, 'Login berhasil', $user);
    }

    private function checkUserAndToken(Request $request)
    {
        $user = Auth::user();

        $user = Auth::user();

        if (!$user || $user->api_token == null) {
            return response(new StudenParentResource(false, 401, 'Sesi telah berakhir', null), 401);
        }

        $headerToken = str_replace('Bearer ', '', $request->header('Authorization'));

        if ($user->api_token != $headerToken) {
            return response(new StudenParentResource(false, 401, 'Token tidak valid', null), 401);
        }

        return $user;
    }

    public function getUser(Request $request)
    {
        $user = $this->checkUserAndToken($request);

        if ($user instanceof Response) {
            return $user;
        }

        return new StudenParentResource(true, 200, 'User ditemukan', $user->makeHidden('api_token'));
    }

    public function logout(Request $request)
    {
        $loggedInUser = $this->checkUserAndToken($request);

        if ($loggedInUser instanceof Response) {
            return $loggedInUser;
        }

        $user = StudentParent::find($loggedInUser->id);
        $user->update(['api_token' => null]);

        return new StudenParentResource(true, 200, 'Logout berhasil', null);
    }

    public function getChildTodayAbsence(Request $request)
    {
        $loggedInUser = $this->checkUserAndToken($request);

        if ($loggedInUser instanceof Response) {
            return $loggedInUser;
        }

        $absences = collect();
        foreach ($loggedInUser->students as $student) {
            $studentAbsences = Absence::with('student')
                ->where('student_id', $student->id)
                ->whereDate('datetime', now())
                ->get();
            $absences = $absences->push($studentAbsences);
        }

        $absences = $absences->flatten();

        return new StudenParentResource(true, 200, 'Berhasil mendapatkan data absensi hari ini', $absences);
    }

    public function getChildren(Request $request)
    {
        $loggedInUser = $this->checkUserAndToken($request);

        if ($loggedInUser instanceof Response) {
            return $loggedInUser;
        }

        $loggedInUser->load('students');

        return new StudenParentResource(true, 200, 'Berhasil mendapatkan data absensi', $loggedInUser->students);
    }

    public function getChildAbsenceHistoryDetail(string $id, Request $request)
    {
        $loggedInUser = $this->checkUserAndToken($request);

        if ($loggedInUser instanceof Response) {
            return $loggedInUser;
        }

        if (!$loggedInUser->students->contains('id', $id)) {
            return new StudenParentResource(false, 400, 'Data tidak ditemukan', null);
        }

        $absences = Absence::where('student_id', $id)->get();

        return new StudenParentResource(true, 200, 'Berhasil mendapatkan data absensi', $absences);
    }

    public function getViolationHistory(Request $request)
    {
        $loggedInUser = $this->checkUserAndToken($request);

        if ($loggedInUser instanceof Response) {
            return $loggedInUser;
        }

        $loggedInUser->load('students');

        $violationPoints = $loggedInUser->students->map(function ($student) {
            return [
                'name' => $student->name,
                'violation_points' => $student->violation_points,
            ];
        });

        return new StudenParentResource(true, 200, 'Berhasil mendapatkan data pelanggaran', $violationPoints);
    }

    public function changePassword(Request $request)
    {
        $loggedInUser = $this->checkUserAndToken($request);
        $data = $request->all();

        if ($loggedInUser instanceof Response) {
            return $loggedInUser;
        }

        if (!isset($data['new_password'])) {
            return new StudenParentResource(false, 400, 'Data tidak lengkap', null);
        }

        $user = StudentParent::find($loggedInUser->id);

        $user->update(['password' => Hash::make($request->new_password)]);

        return new StudenParentResource(true, 200, 'Berhasil mengubah password', null);
    }
}
