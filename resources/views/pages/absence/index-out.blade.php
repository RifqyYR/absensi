@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-black">Absensi Pulang</h1>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <div class="card-header mb-4">
                        {{ Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </div>
                    <div class="card-body">
                        <form id="barcodeForm" action="{{ route('absence.out.process') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <input id="barcodeInput" type="text" name="barcode" autofocus
                                    style="position: absolute; opacity: 0;" autocomplete="off" onblur="this.focus()">
                            </div>
                        </form>
                        <h4 class="mt-4">Jumlah Siswa Telah Absen:</h4>
                        <h1 class="fw-bold mb-4 text-center">{{ count($absences) }} / {{ count($students) }}</h1>
                    </div>
                    <div class="card-footer text-center mt-4">
                        <span id="liveClock" class="fs-5 fw-bold"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                @if (count($absences) != 0)
                    @foreach ($absences as $item)
                        <div
                            class="{{ $item->status == 'PRESENT' ? 'card-absence-on-time' : 'card-absence-late' }} px-3 py-2 mb-2">
                            <div class="content">
                                <div class="name fw-bold">{{ $item->student->name }}</div>
                            </div>
                            <div class="time ms-auto fw-bold">
                                {{ $item->time }}
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center">
                        Belum Ada Absensi
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
