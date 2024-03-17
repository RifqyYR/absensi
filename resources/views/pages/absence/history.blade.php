@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-black">Riwayat Absensi</h1>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah Absensi Masuk</th>
                        <th>Jumlah Absensi Pulang</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah Absensi Masuk</th>
                        <th>Jumlah Absensi Pulang</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($absences as $date => $absencesForDate)
                        <tr>
                            <td>
                                <a href="{{ route('absence-history.detail', $date) }}" class="custom-link">
                                    {{ Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                </a>
                            </td>
                            <td>{{ isset($absencesForDate['IN']) ? count($absencesForDate['IN']) : 0 }}</td>
                            <td>{{ isset($absencesForDate['OUT']) ? count($absencesForDate['OUT']) : 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
