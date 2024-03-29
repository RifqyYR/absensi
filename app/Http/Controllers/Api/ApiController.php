<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudenParentResource;
use App\Models\Absence;
use App\Models\StudentParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $user = StudentParent::where('phone_number', $request->phone_number)->first();

        if ($user == null) {
            return new StudenParentResource(false, 'User tidak ditemukan', null);
        }

        if (!Hash::check($request->password, $user->password)) {
            return new StudenParentResource(false, 'Password salah', null);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        $user->update(['api_token' => $token]);

        return new StudenParentResource(true, 'Login berhasil', $user);
    }

    private function checkUserAndToken(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->api_token == null) {
            return new StudenParentResource(false, 'Sesi telah berakhir', null);
        }

        $headerToken = str_replace('Bearer ', '', $request->header('Authorization'));

        if ($user->api_token != $headerToken) {
            return new StudenParentResource(false, 'Token tidak valid', null);
        }

        return $user;
    }

    public function getUser(Request $request)
    {
        $user = $this->checkUserAndToken($request);

        if ($user instanceof StudenParentResource) {
            return $user;
        }

        return new StudenParentResource(true, 'User ditemukan', $user->makeHidden('api_token'));
    }

    public function logout(Request $request)
    {
        $loggedInUser = $this->checkUserAndToken($request);

        if ($loggedInUser instanceof StudenParentResource) {
            return $loggedInUser;
        }

        $user = StudentParent::find($loggedInUser->id);
        $user->update(['api_token' => null]);

        return new StudenParentResource(true, 'Logout berhasil', null);
    }

    public function getChildTodayAbsence(Request $request)
    {
        $loggedInUser = $this->checkUserAndToken($request);

        if ($loggedInUser instanceof StudenParentResource) {
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

        return new StudenParentResource(true, 'Berhasil mendapatkan data absensi hari ini', $absences);
    }

    public function getChildren(Request $request)
    {
        $loggedInUser = $this->checkUserAndToken($request);

        if ($loggedInUser instanceof StudenParentResource) {
            return $loggedInUser;
        }

        $loggedInUser->load('students');

        return new StudenParentResource(true, 'Berhasil mendapatkan data absensi', $loggedInUser->students);
    }

    public function getChildAbsenceHistoryDetail(string $id, Request $request)
    {
        $loggedInUser = $this->checkUserAndToken($request);

        if ($loggedInUser instanceof StudenParentResource) {
            return $loggedInUser;
        }

        if (!$loggedInUser->students->contains('id', $id)) {
            return new StudenParentResource(false, 'Data tidak ditemukan', null);
        }

        $absences = Absence::with('student')->where('student_id', $id)->get();

        return new StudenParentResource(true, 'Berhasil mendapatkan data absensi', $absences);
    }

    public function getViolationHistory(Request $request)
    {
        $loggedInUser = $this->checkUserAndToken($request);

        if ($loggedInUser instanceof StudenParentResource) {
            return $loggedInUser;
        }

        $loggedInUser->load('students');

        $violationPoints = $loggedInUser->students->map(function ($student) {
            return [
                'name' => $student->name,
                'violation_points' => $student->violation_points,
            ];
        });

        return new StudenParentResource(true, 'Berhasil mendapatkan data pelanggaran', $violationPoints);
    }

    public function changePassword(Request $request)
    {
        $loggedInUser = $this->checkUserAndToken($request);
        $data = $request->all();

        if ($loggedInUser instanceof StudenParentResource) {
            return $loggedInUser;
        }

        if (!isset($data['new_password']) || !isset($data['confirm_new_password'])) {
            return new StudenParentResource(false, 'Data tidak lengkap', null);
        }

        if ($data['new_password'] != $data['confirm_new_password']) {
            return new StudenParentResource(false, 'Password baru dan konfirmasi password tidak sama', null);
        }

        $user = StudentParent::find($loggedInUser->id);

        $user->update(['password' => Hash::make($request->new_password)]);

        return new StudenParentResource(true, 'Berhasil mengubah password', null);
    }
}
