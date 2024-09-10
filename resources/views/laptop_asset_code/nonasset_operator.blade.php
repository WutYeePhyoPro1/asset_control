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


<div class="tab-content pt-2" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

        <div class="card">
            <div class="card-body">
            <div class="row g-3">
            <div class="col-md-10 col-lg-10">
                <h5 class="card-title" style="padding-top: 20px;">Non Asset Code Operator</h5></div>
            <div class="col-md-2 col-lg-2">

            <div>
                <button class="btn">
                    <a href="{{route('laptop_asset_code.create_non_op')}}">
                    <i class="bi bi-plus-square-fill" style="color:##1c88fc;font-size:33px;"></i></a></button>

                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#import_non" type="button">
                        <font class="card-title" style="color:#fff;font-size: 13px;">
                        <i class="ri-file-excel-2-line" style="font-size: 12px;"></i> Excel Import</font></button>
                          <!--------------------------------excel import-------------------------------------------------------------->
  <div class="modal fade" id="import_non" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-weight: 500;color: #012970;font-family: Poppins, sans-serif;"><i class="ri-file-excel-2-line" style="font-size: 20px;"></i> Excel Import</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5 style="font-size:15px;;font-weight: 500;color: #012970;font-family: Poppins, sans-serif;">
          <a href="{{asset('assets/img/nonassetoperatorimport.xlsx')}}" download><u>Download Sample Excel File</u></a></h5>
          <form action="{{route('nonassetoperator.import')}}" class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
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
            </div><hr>

            </div>
            </div>

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

            <form id="clear">
                <div class="row"  style="text-wrap: nowrap">

                    <div class="col-md-3" id="filter_col2" data-column="2">
                        <label class="form-label card-title" style="font-size: 15px;">Document No:</label>
                        <input type="text" class="form-control column_filter" placeholder="Enter Doc No" id="col2_filter" style="border:1px solid #1c1c1d;">
                    </div>

                    <div class="col-md-3" id="filter_col3" data-column="3">
                        <label for="validationCustom03" class="form-label card-title" style="font-size: 15px;">Branch</label>
                        <select class="form-select column_filter" id="col3_filter" name="branchcode">
                                <option value="">Select Your Branch</option>
                                @foreach($branches as $branch)
                                <option value="{{$branch->branch_name}} ({{$branch->branch_code}})">{{$branch->branch_name}} ({{$branch->branch_code}})</option>
                                @endforeach
                        </select>
                    </div>

        <div class="col-md-3" id="filter_col4" data-column="4">
            <label for="validationCustom03" class="form-label card-title" style="font-size: 15px;">Department</label>
            <select class="form-select column_filter" aria-label="Default select example" id="col4_filter" name="department">
                <option value="">Select Your Department</option>
                    @foreach($departments as $department)
                    <option value="{{$department->name}}">{{$department->name}}</option>
                    @endforeach
            </select>
        </div>


        <div class="col-md-3" id="filter_col5" data-column="5">
            <label class="form-label card-title" style="font-size: 15px;">Employee ID</label>
            <input type="text" class="form-control column_filter" placeholder="Enter Emp ID" id="col5_filter" style="border:1px solid #1c1c1d;">
        </div>


        <div class="col-md-3" id="filter_col6" data-column="6">
            <label class="form-label card-title" style="font-size: 15px;">Employee Name</label>
            <input type="text" class="form-control column_filter" placeholder="Enter Emp Name" id="col6_filter" style="border:1px solid #1c1c1d;">
        </div>


        <div class="col-md-3" id="filter_col7" data-column="7">
            <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Select Operator</label>
            <select class="form-select column_filter" aria-label="Default select example" id="col7_filter" name="department">
                <option value="">Select Your Operator</option>
                <option value="ATOM">ATOM</option>
                <option value="Ooredoo">Ooredoo</option>
                <option value="MPT">MPT</option>
                <option value="Mytel">Mytel</option>
            </select>
        </div>

        <div class="col-md-3" id="filter_col8" data-column="8">
            <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Phone </label>
            <input type="text" class="form-control column_filter" placeholder="Enter Asset Code" id="col8_filter" style="border:1px solid #0d0d0e;">
        </div>

        <div class="col-md-3" id="filter_col9" data-column="9">
            <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Select Contract</label>
            <select class="form-select column_filter" aria-label="Default select example" id="col9_filter" name="department">
                <option value="">Select Your Contract</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Clear</label>
            <a class="nav-link collapsed" href="{{route('laptop_asset_code.fix_asset')}}">
            <button class="btn btn-primary" style="font-weight: 500; color: #fff; font-family: Poppins, sans-serif;">All</button>
            </a>
        </div>

                </div>
            </form>

            <div class="table-responsive" style="margin: 10px;">
                <div class="table-responsive" style="margin: 10px;">
                    @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
              <table class="table table-sm card-title table-hover table-bordered table-fix" style="font-size: 15px;" id="fixasset">
                <thead>

                  <tr class="table-primary" style="text-wrap: nowrap">
                    <th scope="col">#</th>
                    <th scope="col">Action</th>
                    <th scope="col">Document No</th>
                    <th scope="col">Branch</th>
                    <th scope="col">Department</th>
                    <th scope="col">Employee ID</th>
                    <th scope="col">Employee Name</th>
                    <th scope="col">Contract</th>
                    <th scope="col">Remark</th>
                    <th scope="col">Created Date</th>
                  </tr>
                </thead>
                <tbody>
                  @php($no=1)
                  @foreach($nonoperators as $data)
                  <tr style="text-wrap: nowrap">
                    <th scope="row">{{$no}}.</th>
                    <td>
                        <center>
                        @if(Auth::user()->type=='superadmin' || Auth::user()->type=='Manager')<i class="bi bi-trash-fill pointer" data-bs-toggle="modal" data-bs-target="#del{{ $data->id }}" style="font-size: 15px;"></i> | @endif
                        <a href="{{ route('detail_non_asset_detail',$data->doc_no) }}"><i class="bi bi-eye-fill pointer"></i></a>
                        | <a href="" data-bs-toggle="modal" data-bs-target="#move{{ $data->id }}">Move</a>
                    </center>
                    </td>
                    <td>{{ $data->doc_no }}</td>
                    <td>{{ $data->branch }}</td>
                    <td>{{ $data->department }}</td>
                    <td>
                        {{-- {{ getnonRemark($data->doc_no)->emp_id  }} --}}

                        @foreach(getnonRemark208($data->doc_no) as $nonremark)
                        {{$nonremark->emp_id}}
                        @endforeach
                    </td>
                    <td>
                        {{-- {{ getnonRemark($data->doc_no)->name  }} --}}
                        @foreach(getnonRemark208($data->doc_no) as $nonremark)
                        {{$nonremark->name}}
                        @endforeach
                    </td>

                    <td>
                        {{-- {{ getnonRemark($data->doc_no)->contract }} --}}
                        @foreach(getnonRemark208($data->doc_no) as $nonremark)
                        {{$nonremark->contract}}
                        @endforeach
                    </td>
                    <td>
                        {{-- {{ getnonRemark($data->doc_no)->remark }} --}}
                        @foreach(getnonRemark208($data->doc_no) as $nonremark)
                        {{$nonremark->remark}}
                        @endforeach

                    </td>
                    <td>{{ $data->created_at }}</td>
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


                                                        <div class="modal fade" id="move{{ $data->id }}"
                                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12 col-12">
                                                                            <form action="{{route('asset.move',$data->id)}}" method="post">
                                                                            @METHOD('PUT')
                                                                             @csrf
                                                                     <h5>Move To Fix asset</h5>
                                                                     Doc: No {{ $data->doc_no }}
                                                                     <hr>
                                                                     <label>Asset Code</label><br><br>
                                                                     <input type="hidden" class="form-control" placeholder="Enter Asset Code" style="border:1px solid #1c1c1d;" name="none_code" value="{{$data->doc_no}}">
                                                                        <input type="text" class="form-control" placeholder="Enter Asset Code" style="border:1px solid #1c1c1d;" name="asset_code" value="{{request()->asset_code}}" required>
                                                                        <hr>
                                                                         <button type="submit" class="btn btn-primary" style="font-weight: 500; color: #fff; font-family: Poppins, sans-serif;">Move</button>
                                                                        </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                @endforeach
                </tbody>
              </table>

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
                url: "/non_asset_operator/delete_record/" + id,
                type: 'DELETE',
                data: {

                    "id": id,
                }
            });

            setTimeout(function() {
                window.location.reload(); // Reload the page on success
            }, 1000);
        }


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
        $('#per_page').change(function () {
            // Automatically submit the form when the user selects an option
            $(this).closest('form').submit();
        });
    });


</script>
<script>
$(document).ready(function() {
    var table = $('#fixasset').DataTable({
        // "lengthMenu": [10, 20, 50, 100, 200],
        // "pageLength": 20,
        "deferRender": true,
        "lengthChange": false,
        "searching": true,
        "searchHighlight": true,

        buttons: [

            {
                extend: 'excel',
                text: 'Export to Excel',

            },

            {
                extend: 'csv',
                text: 'Export to CSV'
            },

            'colvis'
        ],


    });


    table.buttons().container().appendTo('#fixasset_wrapper .col-md-6:eq(0)');

    function filterColumn ( i ) {


        $('#fixasset').DataTable().column( i ).search(
            $('#col'+i+'_filter').val()
        ).draw();
        }

        $(document).ready(function() {
        $('#fixasset').DataTable();

        $('input.global_filter').on( 'keyup click', function () {
            filterGlobal();
        } );

        $('input.column_filter').on( 'keyup click', function () {
            filterColumn( $(this).parents('div').attr('data-column') );
        } );
        } );

        $('select.column_filter').on('change', function () {
            filterColumn( $(this).parents('div').attr('data-column') );
        } );
        });


</script>
@endsection
