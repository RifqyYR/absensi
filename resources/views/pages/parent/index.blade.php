@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-black">Data Orang Tua Siswa</h1>
            <a href="{{ route('parent-data.create') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm btn-dark-blue"><i
                    class="fas fa-user fa-sm text-white"></i> Tambah Data</a>
        </div>

        <!-- DataTales Example -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Nomor Telepon</th>
                        <th>Anak</th>
                        <th>Tanggal Diubah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nama</th>
                        <th>Nomor Telepon</th>
                        <th>Anak</th>
                        <th>Tanggal Diubah</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($parents as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->phone_number == null ? 'Tidak Ada' : $item->phone_number }}</td>
                            <td>
                                @if ($item->students->count() > 0)
                                    @foreach ($item->students as $child)
                                        {{ $loop->last ? $child->name : $child->name . ', ' }}
                                    @endforeach
                                @else
                                    Tidak ada
                                @endif
                            </td>
                            <td>
                                {{ $item->updated_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="text-nowrap">
                                <div class="d-flex flex-column">
                                    <div class="align-items-center d-grip gap-4">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('parent-data.edit', $item->uuid) }}"><button type="button"
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
                                            data-target="#deleteParentDataModal"
                                            onclick="hapusDataOrangTua('{{ $item->uuid }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
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

    <div class="modal fade" id="deleteParentDataModal" tabindex="-1" role="dialog"
        aria-labelledby="parent-data-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-danger" id="parent-data-modal-label">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-delete">Batal</button>
                    <a id="deleteParentDataLink">
                        <button type="button" class="btn btn-danger">Hapus</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
