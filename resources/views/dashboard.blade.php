@extends('laptop_asset_code.layouts.master')
@section('content')
    <div class="pagetitle">
      <h1>Asset Control System</h1><br>
      <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}" style="color:blue;">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{route('laptop_asset_code.index')}}" style="color:#000;">Asset</a></li>
          <li class="breadcrumb-item"><a href="{{route('laptop_asset_code.create')}}" style="color:#000;">Add New</a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    @if(Session::has('success'))
      <div class="alert alert-success alert-dismissible fade show outline-animation" role="alert" style="width: 300px; float: right; z-index: 1000; position: absolute; top: 15%; right: 2%;" id="toast">
      <h4 class="alert-heading" style="font-size: 18px; font-weight: 500; color: #012970; font-family: Poppins, sans-serif;">Success</h4><hr>
          <p class="mb-0" style="font-size: 18px; font-weight: 500; color: #012970; font-family: Poppins, sans-serif;">
          {{ Session::get('success') }}
                      @php
                          Session::forget('success');
                      @endphp
          </p>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show outline-animation" role="alert" style="width: 300px; float: right; z-index: 1000; position: absolute; top: 15%; right: 2%;" id="toast">
      <h4 class="alert-heading" style="font-size: 18px; font-weight: 500; color: #012970; font-family: Poppins, sans-serif;">Error Message</h4><hr>
          <p class="mb-0" style="font-size: 18px; font-weight: 500; color: #012970; font-family: Poppins, sans-serif;">
          @foreach ($errors->all() as $error)
                   {{ $error }}
                @endforeach
          </p>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    <section class="section">
      <div class="row">
           <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>
            <script src="https://code.highcharts.com/modules/export-data.js"></script>
            <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <div class="col-lg-6">
            <div class="card">
            <div class="card-body">

            <h5 class="card-title">By Department</h5>
            <div class="col-md-12" style="border:1px solid blue;border-radius:20px;">
            <div id="container-bar-department"></div>
            </div>

            </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
            <div class="card-body">

            <h5 class="card-title">By Branch</h5>
            <div class="col-md-12" style="border:1px solid blue;border-radius:20px;">


            <div id="container-bar-branch"></div>
            </div>

            </div>
            </div>
        </div>
</div>
</section>


@endsection
@section('js')
<script>
    // JavaScript to handle the display and hiding of the toast
    document.addEventListener('DOMContentLoaded', function() {
        const toast = document.getElementById('toast');
        if (toast.innerText) {
            toast.style.display = 'block';
            setTimeout(() => {
                toast.style.display = 'none';
            }, 5000); // Hide the toast after 3 seconds
        }
    });

</script>
<script>
    function deleteRecord(id) {
            console.log(id);
              $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/employee_benefic/delete_record/" + id,
                type: 'DELETE',
                data: {

                    "id": id,
                }
            });

            setTimeout(function() {
                window.location.reload(); // Reload the page on success
            }, 1000);
        }

        $("input[type='file']").change(function() {
    var fileInput = $(this)[0];
    var imagePreview = $("#image_preview")[0];

    if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            imagePreview.innerHTML = '<img src="' + e.target.result + '" style="max-width: 100%; max-height: 100%;">';
        };

        reader.readAsDataURL(fileInput.files[0]);
        var fileName = fileInput.files[0].name;
        $("#file_name").text(fileName);
    } else {
        imagePreview.innerHTML = ''; // Clear the image preview
        $("#file_name").text(""); // Clear the file name
    }
});

$(document).ready(function () {

$('#branches').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your  branch',
});

$('#branches1').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your  branch',
});

$('#branchescode').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your branch code',
});

$('#department').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your department',
});

$('#department1').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your department',
});

});
</script>
<?php
$departments = App\Models\LaptopAssetCode::whereNotNull('department')->distinct('department')->pluck('department');

$departmentLaptopCounts = [];
$departmentPhoneCounts = [];

foreach ($departments as $department) {
    $laptopCount = App\Models\LaptopAssetCode::where('department', $department)->whereNotNull('laptop_asset_code')->count();
    $phoneCount = App\Models\LaptopAssetCode::where('department', $department)->whereNotNull('handset_asset_code')->count();

    $departmentLaptopCounts[] = $laptopCount;
    $departmentPhoneCounts[] = $phoneCount;
}
//---------------------------------------------------------------------
$branches = App\Models\LaptopAssetCode::whereNotNull('branch_name')->distinct('branch_name')->pluck('branch_name');

$branchLaptopCounts = [];
$branchPhoneCounts = [];

foreach ($branches as $branch) {
    $laptopCount = App\Models\LaptopAssetCode::where('branch_name', $branch)->whereNotNull('laptop_asset_code')->count();
    $phoneCount = App\Models\LaptopAssetCode::where('branch_name', $branch)->whereNotNull('handset_asset_code')->count();

    $branchLaptopCounts[] = $laptopCount;
    $branchPhoneCounts[] = $phoneCount;
}

 ?>

<script type="text/javascript">

Highcharts.chart('container-bar-department', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: {!! json_encode($departments) !!}
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        column: {
            borderRadius: '25%',
            colors: ['#007bff', '#ff0000'],
            dataLabels: {
                enabled: true,
                format: '{point.y}', // Display the value on top of the bar
                style: {
                    color: 'black'
                }
            }
        }
    },
    series: [{
        name: 'Laptop',
        data: {!! json_encode($departmentLaptopCounts) !!}
    },{
        name: 'Phone',
        data: {!! json_encode($departmentPhoneCounts) !!}
    }]
});

Highcharts.chart('container-bar-branch', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: {!! json_encode($branches) !!}
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        column: {
            borderRadius: '25%',
            colors: ['#007bff', '#ff0000'],
            dataLabels: {
                enabled: true,
                format: '{point.y}', // Display the value on top of the bar
                style: {
                    color: 'black'
                }
            }
        }
    },
    series: [{
        name: 'Laptop',
        data: {!! json_encode($branchLaptopCounts) !!}
    },{
        name: 'Phone',
        data: {!! json_encode($branchPhoneCounts) !!}
    }]
});
</script>
@endsection
