@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-black">Riwayat Pelanggaran Siswa</h1>
        </div>
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="text-black fw-bold">{{ $student->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <span><strong class="text-danger">Total Poin Pelanggaran:
                                {{ $student->violation_points }}</strong></span>
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered table-striped table-sm" id="dataTable" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pelanggaran</th>
                                        <th>Jenis Pelanggaran</th>
                                        <th>Poin</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Pelanggaran</th>
                                        <th>Jenis Pelanggaran</th>
                                        <th>Poin</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($violations as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->violationPoint->name }}</td>
                                            <td>
                                                @if ($item->violationPoint->category == 'ATTITUDE')
                                                    Sikap dan Perilaku
                                                @elseif ($item->violationPoint->category == 'DISCIPLINE')
                                                    Kerajinan
                                                @else
                                                    Kerapihan
                                                @endif
                                            </td>
                                            <td>{{ $item->violationPoint->points }}</td>
                                            <td>{{ Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('D MMMM Y') }}
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <div class="align-items-center d-grip gap-4">
                                                        {{-- Delete Button --}}
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-toggle="modal" data-target="#deleteViolationDataModal"
                                                            onclick="hapusDataPelanggaran('{{ $item->uuid }}')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                                viewBox="0 0 448 512">
                                                                <style>
                                                                    svg {
                                                                        fill: #ffffff
                                                                    }
                                                                </style>
                                                                <path
                                                                    d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Violation Data Modal --}}
    <div class="modal fade" id="deleteViolationDataModal" tabindex="-1" role="dialog"
        aria-labelledby="violation-data-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-danger" id="violation-data-modal-label">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-delete">Batal</button>
                    <a id="deleteViolationDataLink">
                        <button type="button" class="btn btn-danger">Hapus</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
