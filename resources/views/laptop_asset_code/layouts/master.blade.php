<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Asset Control System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
  <script src="{{ asset('assets/js/jq-min.js') }}"></script>
  <!-- Favicons -->
  <link href="{{asset('assets/img/title.png')}}" rel="icon">
  <link href="{{asset('assets/img/title.png')}}" rel="apple-touch-icon">

  @if (empty($minimalAssets))
    <!-- Local Fonts -->
    <link href="{{ asset('assets/fonts/nunito.css') }}" rel="stylesheet">
  @endif

  <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  @if (empty($minimalAssets))
    <link href="{{asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  @endif
  <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  @if (empty($minimalAssets))
    <link href="{{asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">
  @endif

  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

  @if (empty($minimalAssets))
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  @endif
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  @if (empty($minimalAssets))
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css">
  @endif
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
  input[type="text"]::placeholder {
  color: #999; /* Change the color of the placeholder text */
  font-style: italic; /* Make the placeholder text italic */
  font-size: 13px;
}

input[type="text"],textarea,select,input[type="date"],input[type="radio"]{
  font-size: 13px;
  font-weight: 500;
  color: #012970;
  font-family: "Poppins", sans-serif;
}

.select2-container--bootstrap-5 .select2-selection {
  font-size: 13px;
  font-weight: 500;
  color: #012970;
  font-family: "Poppins", sans-serif;
  box-shadow:1px 1px 1px #333;
}

/* Define the outline animation */
.outline-animation {
    animation: outline s ease-in-out;
}


/* Keyframes for the outline animation */
@keyframes outline {
    0% {
        box-shadow: 0 0 0px rgba(0, 0, 0, 0.2);
        outline: 0px solid transparent;
    }
    50% {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        outline: 2px solid #012970; /* Adjust outline color and width as needed */
    }
    100% {
        box-shadow: 0 0 0px rgba(0, 0, 0, 0.2);
        outline: 0px solid transparent;
    }
}

.pointer{
cursor: pointer;
}

body {
    font-family: Arial, sans-serif;
}

.drop-zone {
    border: 2px dashed #ccc;
    border-radius: 8px;
    padding: 50px;
    text-align: center;
    cursor: pointer;
    height:150px;
}

.drop-text {
    font-size: 18px;
    color: #888;
}

.image-preview {
    display: flex;
    flex-wrap: wrap;
    margin-top: 20px;
}

.image-preview .image-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 10px;
}

.image-preview img {
    width: 150px;
    height: 150px;
    object-fit: cover;
}

/* Your existing CSS code */

/* Stylized Remove button */
.remove-button {
    background-color: #ff5c5c;
    color: #fff;
    border: none;
    font-size:10px;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-weight: bold;
    margin: 5px;
}

.remove-button:hover {
    background-color: #ff3333;
}

    .buttons-excel,.buttons-pdf,.buttons-csv,.buttons-colvis,.buttons-copy,.buttons-print{
    background-color:#1662e4;
    margin: 5px;
    font-size: 13px;
    }

    .custom-style {
    background-color: #FFA500; /* Set your preferred background color */
    color: #FFFFFF; /* Set your preferred text color */
    }
#fixasset_length{
  color: #012970;
  font-family: "Poppins", sans-serif;

}

#fixasset_filter,#opera_filter{
    display: none;
}

/* Ensure the table header remains fixed */
.table-responsive {
    overflow: auto;
}

/* Style for the fixed table header */
#fixasset thead,#opera thead{
    position: sticky;
    top: 0;
    z-index: 1;
    background-color: #fff; /* Background color for the fixed header */
}

#opera thead{
    position: sticky;
    top: 0;
    z-index: 1;
    background-color: #fff; /* Background color for the fixed header */
}

/* Shared data-table appearance */
main .table {
    margin-bottom: 0;
    color: #102a5c;
    font-family: "Nunito", "Poppins", sans-serif;
    font-size: 14px;
    border: 1px solid #d9dfeb;
    border-collapse: collapse !important;
    background: #fff;
}

main .table thead th {
    padding: 10px 12px !important;
    color: #142a5d;
    font-size: 13px;
    font-weight: 800;
    white-space: nowrap;
    background: #f6f4fc !important;
    border-color: #d9dfeb !important;
}

main .table tbody th,
main .table tbody td {
    padding: 10px 12px !important;
    vertical-align: middle;
    border-color: #d9dfeb !important;
    background: #fff;
}

main .table.table-hover tbody tr { transition: background-color .16s ease; }
main .table.table-hover tbody tr:hover > * { background: #f8fbff !important; }
main .table a { color: #173fba; font-weight: 700; text-decoration: none; }
main .table a:hover { color: #0d2c91; text-decoration: underline; }

main .dataTables_wrapper .dt-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin: 8px 0 12px;
}

main .dataTables_wrapper .dt-buttons .btn {
    margin: 0;
    padding: 8px 12px;
    color: #243b72;
    font-family: "Nunito", "Poppins", sans-serif;
    font-size: 13px;
    font-weight: 800;
    background: #f6f4fc;
    border: 1px solid #d9dfeb;
    border-radius: 7px;
    box-shadow: none;
}

main .dataTables_wrapper .dt-buttons .btn:hover {
    color: #fff;
    background: #2047c7;
    border-color: #2047c7;
}

main .dataTables_wrapper .dataTables_info {
    color: #64748b;
    font-family: "Nunito", "Poppins", sans-serif;
    font-size: 14px;
    font-weight: 700;
}

main .dataTables_wrapper .dataTables_paginate .paginate_button {
    margin: 0 2px;
    padding: 7px 11px !important;
    color: #2047c7 !important;
    font-family: "Nunito", "Poppins", sans-serif;
    font-weight: 800;
    background: #fff !important;
    border: 1px solid #d9dfeb !important;
    border-radius: 7px;
}

main .dataTables_wrapper .dataTables_paginate .paginate_button.current,
main .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    color: #fff !important;
    background: #2047c7 !important;
    border-color: #2047c7 !important;
}

/* Minimal table variant: keep spacing and hierarchy, remove grid lines. */
main .table,
main .table-bordered > :not(caption) > *,
main .table-bordered > :not(caption) > * > * {
    border: 0 !important;
}

main .table thead th,
main .table tbody th,
main .table tbody td {
    border: 0 !important;
}

main .dataTables_wrapper .dataTables_paginate .paginate_button {
    border: 0 !important;
    box-shadow: none !important;
}

main .dataTables_wrapper .dataTables_paginate .paginate_button:not(.current) {
    background: transparent !important;
}

/* Clean system theme */
:root {
    --system-primary: #6d28d9;
    --system-primary-dark: #5b21b6;
    --system-soft: #f7f5ff;
    --system-page: #f8f9fd;
    --system-ink: #202342;
    --system-muted: #718096;
    --system-border: #e6e7f0;
}

body {
    background: var(--system-page) !important;
    color: var(--system-ink);
}

#main {
    padding: 26px 30px;
}

.header {
    height: 64px !important;
    background: rgba(255, 255, 255, .96) !important;
    border-bottom: 1px solid var(--system-border);
    box-shadow: 0 4px 18px rgba(54, 44, 105, .06);
}

.sidebar {
    top: 64px !important;
    background: #fff !important;
    border-right: 1px solid var(--system-border);
    box-shadow: 5px 0 22px rgba(54, 44, 105, .04);
}

.sidebar-nav .nav-link {
    margin: 5px 12px;
    color: #34375b !important;
    background: transparent !important;
    border-radius: 11px;
}

.sidebar-nav .nav-link i {
    color: #8b7bbd !important;
}

.sidebar-nav .nav-link:hover,
.sidebar-nav .nav-link:hover i,
.sidebar-nav .nav-link.active,
.sidebar-nav .nav-link.active i {
    color: var(--system-primary) !important;
    background: var(--system-soft) !important;
}

.card,
.table-responsive,
.modal-content {
    border-color: var(--system-border) !important;
    border-radius: 16px !important;
    box-shadow: 0 10px 28px rgba(54, 44, 105, .06) !important;
}

.btn-primary,
.btn-info,
.back-to-top {
    background-color: var(--system-primary) !important;
    border-color: var(--system-primary) !important;
}

.btn-primary:hover,
.btn-primary:focus,
.btn-info:hover,
.back-to-top:hover {
    background-color: var(--system-primary-dark) !important;
    border-color: var(--system-primary-dark) !important;
}

.form-control,
.form-select,
.select2-container--bootstrap-5 .select2-selection {
    color: var(--system-ink) !important;
    background-color: #fff !important;
    border-color: #dfe1ed !important;
    border-radius: 10px !important;
    box-shadow: none !important;
}

.form-control:focus,
.form-select:focus,
.select2-container--bootstrap-5.select2-container--focus .select2-selection {
    border-color: #a78bfa !important;
    box-shadow: 0 0 0 .2rem rgba(109, 40, 217, .12) !important;
}

main .table thead th {
    color: #40356e !important;
    background: var(--system-soft) !important;
    border-color: var(--system-border) !important;
}

main .table a {
    color: var(--system-primary) !important;
}

main .table a:hover {
    color: var(--system-primary-dark) !important;
}

main .dataTables_wrapper .dt-buttons .btn,
main .dataTables_wrapper .dataTables_paginate .paginate_button {
    color: #554486 !important;
    background: #fff !important;
    border-color: var(--system-border) !important;
}

main .dataTables_wrapper .dt-buttons .btn:hover,
main .dataTables_wrapper .dataTables_paginate .paginate_button.current,
main .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    color: #fff !important;
    background: var(--system-primary) !important;
    border-color: var(--system-primary) !important;
}

</style>
</head>

<body>
@include('laptop_asset_code/parts/header')
<main id="main" class="main">

    @yield('content')

</main>
@include('laptop_asset_code/parts/footer')

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<!-- Vendor JS Files -->
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
@if (empty($minimalAssets))
  <script src="{{asset('assets/vendor/quill/quill.min.js')}}"></script>
  <script src="{{asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>
@endif
<script src="{{asset('assets/js/main.js')}}"></script>
@if (empty($minimalAssets))
  <script src="{{asset('assets/js/select2.full.min.js')}}"></script>
  <script src="{{asset('assets/js/selectize.min.js')}}"></script>
@endif

<link rel="stylesheet" href="{{ asset('assets/css/buttons.bootstrap5.min.css') }}">

<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>

<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>

<script src="{{asset('assets/js/dataTables.buttons.min.js')}}"></script>

<script src="{{asset('assets/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/jszip.min.js')}}"></script>
<script src="{{asset('assets/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/js/buttons.colVis.min.js')}}"></script>
@if (empty($minimalAssets))
  <script src="{{asset('assets/js/pdfmake.min.js')}}"></script>
  <script src="{{asset('assets/js/vfs_fonts.js')}}"></script>
  <script src="{{asset('assets/js/buttons.print.min.js')}}"></script>
@endif


<script>
  $(document).ready(function () {
    function setPhoneInput(input) {
      var phone = $(input);
      var digits = phone.val().replace(/\D/g, '');
      var number = digits === '' ? '' :
        (digits.indexOf('09') === 0 ? digits : '09' + digits);

      phone.attr('type', 'tel');
      phone.attr('inputmode', 'numeric');
      phone.attr('maxlength', '11');
      phone.attr('minlength', '11');
      phone.attr('pattern', '09([0-9]{9})?');
      phone.attr('title', 'Phone number must start with 09 and contain 11 digits.');
      phone.val(number.substring(0, 11));
    }

    $('input[name="phone"], input[name="phone[]"]').each(function () {
      setPhoneInput(this);
    });

    $(document).on('input', 'input[name="phone"], input[name="phone[]"]', function () {
      setPhoneInput(this);
    });

    $(document).on('click', '#addbtn, #addbtn1', function () {
      setTimeout(function () {
        $('input[name="phone"], input[name="phone[]"]').each(function () {
          setPhoneInput(this);
        });
      }, 50);
    });
  });
</script>


@yield('js')
</body>
</html>
