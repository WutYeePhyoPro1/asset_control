<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Asset Control System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Favicons -->
  <link href="{{asset('assets/img/title.png')}}" rel="icon">
  <link href="{{asset('assets/img/title.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.3.1/echarts.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
<script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
<script src="{{asset('assets/vendor/echarts/echarts.min.js')}}"></script>
<script src="{{asset('assets/vendor/quill/quill.min.js')}}"></script>
<script src="{{asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
<script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>
<script src="{{asset('assets/js/main.js')}}"></script>
<script src="https://cdnjs.com/libraries/Chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>

<link href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.colVis.min.js"></script>


@yield('js')
</body>
</html>
