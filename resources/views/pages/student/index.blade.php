@extends('layouts.main')

@section('content')
    @php
        $classList = [];

        foreach ($students as $student) {
            $classList[] = $student['class'];
        }

        $uniqueClasses = array_unique($classList);
    @endphp
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-black">Data Siswa</h1>
            <div class="buttons">
                <button type="button" data-toggle="modal" data-target="#studentViolationModal"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm btn-orange"><i
                        class="fas fa-times-circle fa-sm text-white"></i> Form Pelanggaran</button>
                <button data-toggle="modal" data-target="#printIdCardByClassModal" type="button"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm ms-1"><i
                        class="fas fa-id-card fa-sm text-white"></i> Print Id Card</button>
                <a href="{{ route('student-data.create') }}"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm btn-dark-blue ms-1"><i
                        class="fas fa-graduation-cap fa-sm text-white"></i> Tambah Data</a>
            </div>
        </div>

        <!-- DataTales Example -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Tanggal Lahir</th>
                        <th>Angkatan</th>
                        <th>Orang Tua</th>
                        <th>Tanggal Diubah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nama</th>
                        <th>Tanggal Lahir</th>
                        <th>Angkatan</th>
                        <th>Orang Tua</th>
                        <th>Tanggal Diubah</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @if (count($students) > 0)
                        @foreach ($students as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('student-data.detail', $item->uuid) }}" class="custom-link">
                                        {{ $item->name }}
                                    </a>
                                </td>
                                <td>{{ Carbon\Carbon::parse($item->born_date)->locale('id')->isoFormat('D MMMM Y') }}</td>
                                <td>{{ $item->generation }}</td>
                                <td>{{ $item->parent->name }}</td>
                                <td>
                                    {{ $item->updated_at->format('d/m/Y H:i:s') }}
                                </td>
                                <td class="text-nowrap">
                                    <div class="d-flex flex-column">
                                        <div class="align-items-center d-grip gap-4 mx-auto">
                                            {{-- Edit Button --}}
                                            <a href="{{ route('student-data.edit', $item->uuid) }}"><button type="button"
                                                    class="btn btn-sm btn-warning">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                        viewBox="0 0 512 512">
                                                        <style>
                                                            svg {
                                                                fill: #ffffff
                                                            }
                                                        </style>
                                                        <path
                                                            d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
                                                    </svg>
                                                </button>
                                            </a>

                                            {{-- Delete Button --}}
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteStudentDataModal"
                                                onclick="hapusDataSiswa('{{ $item->uuid }}')">
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
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Delete Student Data Modal --}}
    <div class="modal fade" id="deleteStudentDataModal" tabindex="-1" role="dialog"
        aria-labelledby="student-data-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-danger" id="student-data-modal-label">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-delete">Batal</button>
                    <a id="deleteStudentDataLink">
                        <button type="button" class="btn btn-danger">Hapus</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Student Violation Modal --}}
    <div class="modal fade" id="studentViolationModal" role="dialog" aria-labelledby="student-violation-modal-label"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('student-violation') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="student-violation-modal-label">Form Pelanggaran Siswa
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="student_id">Nama Siswa</label>
                            <select class="form-select select2 large-select2 @error('student_id') is-invalid @enderror"
                                name="student_id" id="student_id">
                                <option value="" selected disabled></option>
                                @foreach ($students as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="violation_id">Pelanggaran</label>
                            <select class="form-select select2 large-select2 @error('violation_id') is-invalid @enderror"
                                name="violation_id" id="violation_id">
                                <option value="" selected disabled></option>
                                @foreach ($violations as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('violation_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            id="btn-delete">Batal</button>
                        <button type="submit" class="btn btn-orange">Kirim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Print Id Card Class Modal --}}
    <div class="modal fade" id="printIdCardByClassModal" tabindex="-1" role="dialog"
        aria-labelledby="print-id-card-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('student-data.print-id-cards') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="print-id-card-modal-label">Print Id Card Berdasarkan Kelas
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="class_id">Kelas</label>
                            <select class="form-select select2 large-select2 @error('class_id') is-invalid @enderror"
                                name="class_id" id="class_id">
                                <option value="" selected disabled></option>
                                @foreach ($uniqueClasses as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            id="btn-delete">Batal</button>
                        <button type="submit" class="btn btn-primary">Pilih</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
