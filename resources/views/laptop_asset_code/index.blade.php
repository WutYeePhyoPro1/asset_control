@extends('laptop_asset_code.layouts.master')
@section('content')
    <div class="pagetitle">
      <h1>Asset Control System</h1><br>
      {{-- <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}" style="color:#000;">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{route('laptop_asset_code.create')}}" style="color:#000;">Add New</a></li>
        </ol>
      </nav> --}}
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

    @if(Session::has('failures'))
<div class="alert alert-danger alert-dismissible fade show outline-animation" role="alert" style="width: 1000px; z-index: 1000; position: absolute; top: 15%; right: 2%;" id="toast">
    <button type="button" class="btn-close" aria-label="Close" onclick="closeAlert()"></button>
    <table class="table table-sm mb-0 table-striped table-bordered display no-wrap">
        <tr class="bg-danger" style="color:#000;">
            <th class="px-2 py-2">Row</th>
            <th class="px-2 py-2">Errors</th>
            <th class="px-2 py-2">Value</th>
        </tr>
        @foreach (session()->get('failures') as $validation)
        <tr style="color:#000;">
            <td class="px-2 py-2">{{ $validation->row() }}</td>
            <td class="px-2 py-2">
                <ul>
                    @foreach ($validation->errors() as $e)
                    <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </td>
            <td class="px-2 py-2">
                {{ $validation->values()[$validation->attribute()] }}
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endif

<script>
    function closeAlert() {
        var alertDiv = document.getElementById("toast");
        alertDiv.style.display = "none";
    }
</script>


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

        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">

            {{-- <h5 class="card-title">Laptop Asset Code</h5> --}}
          <!-- Default Tabs -->
          {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
                <font class="card-title" style="font-size: 15px;">Laptop Asset</font></button>
            </li>
            <!-- <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
              <font class="card-title" style="font-size: 15px;"><i class="bi bi-plus-square-fill" style="font-size: 20px;"></i>&nbsp; Add New</font></button>
            </li> -->

          </ul>
          <br> --}}

<div class="tab-content pt-2" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">


        <div class="card">
            <div class="card-body">
            <div class="row g-3">
            <div class="col-md-10 col-lg-10"></div>
            <div class="col-md-2 col-lg-2">

            <div>
                <button class="btn">
                    <a href="{{route('laptop_asset_code.create')}}">
                    <i class="bi bi-plus-square-fill" style="color:##1c88fc;font-size:33px;"></i></a></button>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#import" type="button">
            <font class="card-title" style="color:#fff;font-size: 13px;">
            <i class="ri-file-excel-2-line" style="font-size: 12px;"></i> Excel Import</font></button>
            </div><hr>

            </div>
            </div>

            <form method="POST" action="{{route('employee_benefic.search')}}">
              @csrf
            <div class="row g-3">
                    <div class="col-md-2 col-lg-2">
                      <label for="validationCustom01" class="form-label card-title" style="font-size: 12px;padding:0px;">Document No</label>
                      <input type="text" class="form-control" id="validationCustom01" name="doc_no"  style="box-shadow:1px 1px 1px #333;">
                    </div>

                    <div class="col-md-2 col-lg-2">
                      <label for="validationCustom01" class="form-label card-title" style="font-size: 12px;padding:0px;">Employee Name</label>
                      <input type="text" class="form-control" id="validationCustom01" name="empname"  style="box-shadow:1px 1px 1px #333;">
                    </div>

                    <div class="col-md-2 col-lg-2">
                      <label for="validationCustom01" class="form-label card-title" style="font-size: 12px;padding:0px;">Employee ID</label>
                      <input type="text" class="form-control" id="validationCustom01" name="empcode"  style="box-shadow:1px 1px 1px #333;">
                    </div>

                    <div class="col-md-2 col-lg-2">
                      <label for="validationCustom01" class="form-label card-title" style="font-size: 12px;padding:0px;">Department</label>
                      <select class="form-control" id="department1" name="department">
                          <option value="">Select Your Department</option>
                            @foreach($departments as $department)
                            <option value="{{$department->name}}">{{$department->name}}</option>
                            @endforeach
                      </select>
                    </div>

                    <div class="col-md-2 col-lg-2">
                      <label for="validationCustom01" class="form-label card-title" style="font-size: 12px;padding:0px;">Branch</label>
                      <select class="form-control" id="branches1" name="branch">
                          <option value="">Select Your Branch</option>
                          <option value="0">All Branch</option>
                            @foreach($branches as $branch)
                            <option value="{{$branch->branch_name}}">{{$branch->branch_name}}</option>
                            @endforeach
                      </select>
                    </div>

                    <div class="col-md-2 col-lg-2">
                      <label for="validationCustom01" class="form-label card-title" style="font-size: 12px;padding:0px;">By Department/Employee</label>
                      <select class="form-control" id="dept" name="type">
                          <option value="">By Department/Employee</option>
                          <option value="Dept">By Department</option>
                          <option value="Emp">By Employee</option>
                      </select>
                    </div>

                    <div class="col-md-2 col-lg-2">
                      <label for="validationCustom01" class="form-label card-title" style="font-size: 12px;padding:0px;">Laptop/Handset/Phone(No)<i class="ri-information-fill" style="font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="You can search laptop asset code or handset asset code or sim number."></i></label>
                      <input type="text" class="form-control" id="validationCustom01" placeholder="Asset code Laptop/Handset/Phone(No)" name="laptop"  style="box-shadow:1px 1px 1px #333;">
                    </div>

                    <div class="col-md-2 col-lg-2">
                    <label for="validationCustom01" class="form-label" style="font-size: 12px;padding:0px;"><br></label><br>
                    <button class="btn btn-primary" type="submit"> <font class="card-title" style="color:#fff;font-size: 13px;">Search</font></button>

                    </div>

            </div>
            </form>

            <div class="modal fade" id="import" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" style="font-weight: 500;color: #012970;font-family: Poppins, sans-serif;"><i class="ri-file-excel-2-line" style="font-size: 20px;"></i> Excel Import</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <h5 style="font-size:15px;;font-weight: 500;color: #012970;font-family: Poppins, sans-serif;">
                      <a href="{{asset('assets/img/assetcontrolExcel.xlsx')}}" download><u>Download Sample Excel File</u></a></h5>
                      <form action="{{route('excel_import')}}" class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                   <br>
                    <label for="my_import">

                    <i class="bi bi-upload btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Employee asset code import excel click the button."></i>

                    </label>
                    <input type="file" id="my_import" style="display: none;" name="file" required />
                    <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        Please import your excel file.
                    </div>

                    <div id="file_name" class="file-name" style="font-size: 13px;font-weight: 500;color: #012970;font-family: Poppins, sans-serif;margin-top:10px;"></div>

                    <!-- <div id="excel_preview" class="excel-preview"></div> -->

                    <!-- <div id="file_name" style="font-size: 15px;font-weight: 500;color: #012970;font-family:Poppins, sans-serif;color:red;"></div> -->

                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" style="font-weight: 500;color: #fff;font-family: Poppins, sans-serif;">Import</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="font-weight: 500;color: #fff;font-family: Poppins, sans-serif;">Close</button>

                    </form>
                    </div>
                  </div>
                </div>
              </div><!-- End Vertically centered Modal-->
            <br>
            <form action="/limit_rows" method="get">
                <label for="per_page" style="font-weight: 500;color: #000;font-family: Poppins, sans-serif;font-size:13px;">Showing Rows:</label>
                <select name="per_page" id="per_page">
                    <option value=""></option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="100">100</option>
                </select>
            </form>
            <div class="table-responsive" style="margin: 10px;">
              <table class="table table-sm card-title table-hover table-bordered table-fix" style="font-size: 15px;" id="myTable">
                <thead>
                  <tr class="table-primary" style="text-wrap: nowrap">
                    <th scope="col">#</th>
                    <th scope="col">Action</th>
                    <th scope="col">Document No</th>
                    <th scope="col">Employee Name</th>
                    <th scope="col">By Dep/Emp</th>
                    <th scope="col">Department</th>
                    <th scope="col">Branch Code</th>
                    {{-- <th scope="col">Branch</th> --}}
                    <th scope="col">Laptop Asset Code</th>
                    <th scope="col">Handset Asset Code</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Receipt Date</th>
                  </tr>
                </thead>
                <tbody>
                  @php($no=1)
                  @foreach($datas as $data)
                  <tr style="text-wrap: nowrap">
                    <th scope="row">{{$no}}.</th>
                    <td><center>
                    @if(Auth::user()->type=='superadmin')<i class="bi bi-trash-fill pointer" data-bs-toggle="modal" data-bs-target="#del{{ $data->id }}" style="font-size: 15px;"></i> | @endif
                      <a href="{{route('laptop_asset_code.show',$data->id)}}"><i class="bi bi-eye-fill pointer"></i></a></center>
                    </td>
                    <td><a href="{{route('laptop_asset_code.show',$data->id)}}" style="text-decoration:none;color:#000">{{$data->doc_no}}</a></td>
                    <td>
                        <a href="{{route('laptop_asset_code.show',$data->id)}}" style="text-decoration:none;color:#000">
                            @if($data->emp_name==null)
                            -
                            @else
                            {{$data->emp_name}}
                            @endif
                        </a>
                    </td>
                    <td><a href="{{route('laptop_asset_code.show',$data->id)}}" style="text-decoration:none;color:#000">
                    @if($data->type=='Dept')
                    By Department
                    @else
                    By Employee
                    @endif
                  </a></td>
                    {{-- <td><a href="{{route('laptop_asset_code.show',$data->id)}}" style="text-decoration:none;color:#000">{{$data->emp_code}}</a></td> --}}
                    <td><a href="{{route('laptop_asset_code.show',$data->id)}}" style="text-decoration:none;color:#000">{{$data->department}}</a></td>
                    <td><a href="{{route('laptop_asset_code.show',$data->id)}}" style="text-decoration:none;color:#000">{{$data->branch_code}} ({{$data->branch_name}})</a></td>
					{{-- <td><a href="{{route('laptop_asset_code.show',$data->id)}}" style="text-decoration:none;color:#000">{{$data->branch_name}}</a></td> --}}
                    <td data-bs-toggle="tooltip" data-bs-placement="top" title="{{$data->laptop_asset_name}}">
                        @if($data->laptop_asset_code==null)
                        -
                        @else
                        {{$data->laptop_asset_code}}
                        @endif

                    </td>
                    <td data-bs-toggle="tooltip" data-bs-placement="top" title="{{$data->handset_asset_name}}">
                        @if($data->handset_asset_code==null)
                        -
                        @else
                        {{$data->handset_asset_code}}
                        @endif

                    </td>
                    <td data-bs-toggle="tooltip" data-bs-placement="top" title="{{$data->sim_name}}">
                        @if($data->sim_phone=='09' || $data->sim_phone==null)
                        -
                        @else
                        {{$data->sim_phone}}
                        @endif

                    </td>
                    <td>{{$data->receipt_date}}</td>
                  </tr>
                @php($no++)

                                                <div class="modal fade" id="del{{ $data->id }}"
                                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12 col-12">
                                                                                <center>
                                                                                    <img
                                                                                        src="https://img.icons8.com/external-kmg-design-outline-color-kmg-design/52/000000/external-warning-maps-navigation-kmg-design-outline-color-kmg-design.png" />
                                                                                    <p style="color:#000;">Do you want to
                                                                                        delete?</p>
                                                                                    <i class="bi bi-x-circle btn btn-danger"
                                                                                        onclick='deleteRecord("{{ $data->id }}")'
                                                                                        style="font-size:20px;color:fff;width:200px;">
                                                                                        Yes, delete it!</i>
                                                                                    <button type="button"
                                                                                        class="btn btn-light-secondary"
                                                                                        data-bs-dismiss="modal">
                                                                                        <i
                                                                                            class="bx bx-x d-block d-sm-none"></i>
                                                                                        <span
                                                                                            class="d-none d-sm-block">Cancel</span>
                                                                                    </button>
                                                                                </center>
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                @endforeach
                </tbody>
              </table>
              <!-- End small tables -->

           <p class="card-title">
           {{$datas->links('pagination::bootstrap-5')}}
           </p>

              </div>
            </div>
          </div>
        </div>

          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

          </div>
        </div>
     </div>
   </div>
 </div>
</div>
</section>

@endsection
@section('js')
<script>
    function closeAlert() {
        var alertDiv = document.getElementById("toast");
        alertDiv.style.display = "none";
    }
</script>
<script>
    // JavaScript to handle the display and hiding of the toast
    document.addEventListener('DOMContentLoaded', function() {
        const toast = document.getElementById('toast');
        if (toast.innerText) {
            toast.style.display = 'block';
            setTimeout(() => {
                toast.style.display = 'none';
            }, 6000); // Hide the toast after 3 seconds
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

$("input[type='file']").change(function() {
    var fileInput = $(this)[0];

    if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            // Display the selected Excel file preview using an <embed> or other suitable element
            var excelPreview = $("#excel_preview")[0];
            excelPreview.innerHTML = '<embed src="' + e.target.result + '" style="width: 100%; height: 400px;">';
        };

        reader.readAsDataURL(fileInput.files[0]);
        var fileName = fileInput.files[0].name;

        // Display the selected file name
        $("#file_name").text(fileName);
    } else {
        // Clear the file preview and file name if no file is selected
        $("#excel_preview").empty();
        $("#file_name").empty();
    }
});


$(document).ready(function () {

$('#branches').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your  branch',
    width: '100%'
});

$('#branches1').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your  branch',
    width: '100%'
});

$('#dept').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your  Department or Branch',
    width: '100%'
});


$('#branchescode').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your branch code',
    width: '100%'
});

$('#department').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your department',
    width: '100%'
});

$('#department1').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your department',
    width: '100%'
});

});



    $(document).ready(function () {
        $('#per_page').change(function () {
            // Automatically submit the form when the user selects an option
            $(this).closest('form').submit();
        });
    });


</script>
@endsection
