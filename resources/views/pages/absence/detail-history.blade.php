@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-black">History Absensi
                {{ Carbon\Carbon::parse(request()->route()->parameters['date'])->locale('id')->isoFormat('D MMMM Y') }}</h1>
        </div>

        <div class="table-responsive">
            <form action="{{ route('absence-history.update') }}" method="post">
                @csrf
                <div class="text-end">
                    <button class="btn btn-sm btn-primary mb-2 btn-dark-blue" type="button" id="btnUpdateStatus" disabled
                        data-toggle="modal" data-target="#updateAbsenceDataModal">Update
                        Status</button>
                </div>
                <table class="table table-bordered table-striped table-sm" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Checkbox</th>
                            <th>Nama</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Checkbox</th>
                            <th>Nama</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($absences as $item)
                            <tr onclick="toggleCheckbox(event, '{{ $item->id }}')">
                                <td><input type="checkbox" id="checkbox{{ $item->id }}" name="ids[]"
                                        value="{{ $item->id }}" name="ids[]" value="{{ $item->id }}"></td>
                                <td>{{ $item->student->name }}</td>
                                <td>{{ $item->time }}</td>
                                <td>
                                    @if ($item->status == 'PRESENT')
                                        <span class="badge bg-success">Hadir</span>
                                    @elseif($item->status == 'LATE')
                                        <span class="badge bg-danger">Terlambat</span>
                                    @elseif($item->status == 'PERMIT')
                                        <span class="badge bg-info">Izin</span>
                                    @elseif($item->status == 'ABSENT')
                                        <span class="badge bg-warning">Tidak Absen</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->category == 'IN')
                                        Masuk
                                    @else
                                        Pulang                                        
                                    @endif
                                </td>
                                <td class="action-col">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="align-items-center d-grip gap-4">
                                            {{-- Delete Button --}}
                                            <button type="button" class="btn btn-danger btn-sm mx-auto action-col"
                                                data-toggle="modal" data-target="#deleteAbsenceDataModal"
                                                onclick="hapusDataAbsensi('{{ $item->uuid }}')">
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

                {{-- Update Status Modal --}}
                <div class="modal fade" id="updateAbsenceDataModal" tabindex="-1" role="dialog"
                    aria-labelledby="update-data-modal-label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold text-black" id="update-data-modal-label">Edit
                                    Status Absensi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <select class="form-select" name="status">
                                    <option value="PRESENT">Hadir</option>
                                    <option value="LATE">Terlambat</option>
                                    <option value="PERMIT">Izin</option>
                                    <option value="ABSENT">Tidak Absen</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Ubah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete Status Modal --}}
    <div class="modal fade" id="deleteAbsenceDataModal" tabindex="-1" role="dialog"
        aria-labelledby="absence-data-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-danger" id="absence-data-modal-label">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-delete">Batal</button>
                    <a id="deleteAbsenceDataLink">
                        <button type="button" class="btn btn-danger">Hapus</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
