<!-- Bootstrap core JavaScript-->
<script src="{{ url('backend/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ url('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ url('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

{{-- ChartJS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Custom scripts for all pages-->
<script src="{{ url('backend/js/sb-admin-2.js') }}"></script>
<script src="{{ url('backend/js/chart-area-demo.js') }}"></script>

{{-- DataTables --}}
<script src="//cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
{{-- <script src="{{ url('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}

{{-- Toastr --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    @if (session()->has('success'))
        toastr.success('{{ session('success') }}', 'BERHASIL!');
    @elseif (session()->has('error'))
        toastr.error('{{ session('error') }}', 'GAGAL!');
    @endif

    $(document).ready(function() {
        $('#dataTable').DataTable();
        $('.select2').select2({
            width: '100%'
        });
    });

    $('.editable-select').editableSelect();

    function hapusDataOrangTua(id) {
        const link = document.getElementById('deleteParentDataLink');
        link.href = "/data-orang-tua/hapus/" + id;
    }

    function hapusDataSiswa(id) {
        const link = document.getElementById('deleteStudentDataLink');
        link.href = "/data-siswa/hapus/" + id;
    }

    function validateInput(input) {
        input.value = input.value.replace(/\D/g, '');
        input.value = input.value.replace(/^0+/, '');
    }
</script>
