<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

<!-- Custom styles for this template-->
<link href="{{ url('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">

<link href="{{ url('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

{{-- DataTables --}}
<link href="//cdn.datatables.net/2.0.1/css/dataTables.dataTables.min.css" rel="stylesheet">

<!-- Custom fonts for this template-->
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<link rel="stylesheet" href="{{ url('backend/css/pagination.css') }}" type="text/css" id="paginationjs-style" />

{{-- Toastr --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .btn-dark-blue {
        background-color: #0C2D57 !important;
        border: #0C2D57 !important;
        color: #ffffff !important;
    }

    .btn-dark-blue:hover {
        background-color: #103c77 !important;
        border: #103c77 !important;
        color: #ffffff !important;
    }

    .btn-orange {
        background-color: #FC6736 !important;
        border: #FC6736 !important;
        color: #ffffff !important;
    }

    .btn-orange:hover {
        background-color: #e15728 !important;
        border: #e15728 !important;
        color: #ffffff !important;
    }

    .select2-container .select2-selection--single {
        height: 38px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }

    .custom-link {
        text-decoration: none;
        color: black;
    }

    .custom-link:hover {
        text-decoration: underline;
        font-weight: bold;
    }

    .font {
        height: 450px;
        width: 250px;
        position: relative;
        border-radius: 15px;
        border: 1px solid #0C2D57;
    }

    .top {
        height: 30%;
        width: 100%;
        background-color: #0C2D57;
        position: relative;
        z-index: 5;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .bottom {
        height: 70%;
        width: 100%;
        background-color: white;
        position: absolute;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
    }

    .top img {
        height: 100px;
        width: 100px;
        /* background-color: #e6ebe0; */
        border-radius: 10px;
        position: absolute;
        top: 60px;
        left: 75px;
    }

    .bottom p {
        position: relative;
        top: 60px;
        text-align: center;
        text-transform: capitalize;
        font-weight: bold;
        font-size: 20px;
        text-emphasis: spacing;
    }

    .bottom .desi {
        font-size: 12px;
        color: grey;
        font-weight: normal;
    }

    .bottom .no {
        font-size: 15px;
        font-weight: normal;
    }

    .barcode img {
        height: 120px;
        width: 120px;
        text-align: center;
        margin: 5px;
    }

    .barcode {
        text-align: center;
        position: relative;
        top: 70px;
    }

    @media print {
        body * {
            visibility: hidden;
        }

        .id-card,
        .id-card * {
            visibility: visible;
        }

        .id-card {
            position: absolute;
            left: 0;
            right: 0;
            top: 30vh;
            bottom: 0;
            margin: auto;
            transform: scale(1.5);
        }
    }

    .card-absence-on-time {
        display: flex;
        align-items: center;
        border-radius: 100px;
        box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
        background: #367E18;
        color: white;
    }

    .card-absence-late {
        display: flex;
        align-items: center;
        border-radius: 100px;
        box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
        background: #FF0000;
        color: white;
    }
</style>
