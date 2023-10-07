@extends('laptop_asset_code.layouts.master')
@section('content')
    <div class="pagetitle">
      <h1>Employee Asset Control System</h1><br>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('home')}}" style="color:#000;">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{route('laptop_asset_code.index')}}" style="color:#000;">Back</a></li>
          <!-- <li class="breadcrumb-item">New</li>
          <li class="breadcrumb-item active">Back</li> -->
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
    <section class="section profile">
      <div class="row">
        <div class="col-xl-2">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
              @if($datas->file==null)
              <img src="{{asset('assets/img/acc.png')}}" alt="Profile" class="rounded-circle">
              @else
              <img src="{{asset('storage/emp_profile/'.$datas->file)}}" alt="Profile" class="rounded-circle">
              @endif
              <h2>{{$datas->emp_name}}</h2>
              <h3>{{$datas->department}}</h3>
              
            </div>
          </div>

        </div>

        <div class="col-xl-10">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview" style="font-size: 18px;font-weight: 500;color: #012970;font-family:Poppins, sans-serif;">Overview</button>
                </li>

                @if(Auth::user()->type=='superadmin')
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit" style="font-size: 18px;font-weight: 500;color: #012970;font-family:Poppins, sans-serif;">Edit Employee </button>
                </li>
                @endif

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview"  style="font-size: 15px;font-weight: 500;color: #012970;font-family:Poppins, sans-serif;">
       
                  <h5 class="card-title">Employee Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Document No</div>
                    <div class="col-lg-9 col-md-8">{{$datas->doc_no}}</div>
                  </div>

                  <div class="row">
                  <div class="col-lg-3 col-md-4">
                  @if($datas->type=='Dept')
                      By Department
                      @else
                      By Employee
                  @endif
                  </div>
                    <div class="col-lg-9 col-md-8">
                    </div>
                  </div>

                  <h5 class="card-title" style="font-size: 15px; color:blue;">Employee Infomation</h5>
                  @if($datas->type=='Emp')
               
                  <div class="row">
                    <div class="col-lg-3 col-md-4">Employee Name</div>
                    <div class="col-lg-9 col-md-8">{{$datas->emp_name}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Employee ID</div>
                    <div class="col-lg-9 col-md-8">{{$datas->emp_code}}</div>
                  </div>
                  @endif


                  <div class="row">
                    <div class="col-lg-3 col-md-4">Department</div>
                    <div class="col-lg-9 col-md-8">{{$datas->department}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Branch Code</div>
                    <div class="col-lg-9 col-md-8">{{$datas->branch_code}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Branch Name</div>
                    <div class="col-lg-9 col-md-8">{{$datas->branch_name}}</div>
                  </div>

                  <h5 class="card-title" style="font-size: 15px; color:blue;">Asset Infomation</h5>

                  @if($datas->asset_type=='lp')

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Laptop Asset Code</div>
                    <div class="col-lg-9 col-md-8">{{$datas->laptop_asset_code}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Laptop Asset Name</div>
                    <div class="col-lg-9 col-md-8">{{$datas->laptop_asset_name}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Handset Asset Code</div>
                    <div class="col-lg-9 col-md-8">{{$datas->handset_asset_name}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Operator</div>
                    <div class="col-lg-9 col-md-8">{{$datas->sim_name}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Phone Number</div>
                    <div class="col-lg-9 col-md-8">{{$datas->sim_phone}}</div>
                  </div>
                  @elseif($datas->asset_type=='laptop')
                  <div class="row">
                    <div class="col-lg-3 col-md-4">Laptop Asset Code</div>
                    <div class="col-lg-9 col-md-8">{{$datas->laptop_asset_code}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Laptop Asset Name</div>
                    <div class="col-lg-9 col-md-8">{{$datas->laptop_asset_name}}</div>
                  </div>

                  @else
                  <div class="row">
                    <div class="col-lg-3 col-md-4">Handset Asset Code</div>
                    <div class="col-lg-9 col-md-8">{{$datas->handset_asset_name}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Operator</div>
                    <div class="col-lg-9 col-md-8">{{$datas->sim_name}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Phone Number</div>
                    <div class="col-lg-9 col-md-8">{{$datas->sim_phone}}</div>
                  </div>

                  @endif


                  <h5 class="card-title" style="font-size: 15px; color:blue;">Receipt Infomation</h5>
                  <div class="row">
                    <div class="col-lg-3 col-md-4">Receipt Date</div>
                    <div class="col-lg-9 col-md-8">{{$datas->receipt_date}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Receipt type</div>
                    <div class="col-lg-9 col-md-8">{{$datas->receipt_type}}</div>
                  </div>

                  <h5 class="card-title">Remark</h5>
                  <p class="small fst-italic">
                    {{$datas->remark}}
                  </p>


                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                      <!-- Custom Styled Validation -->
      <div class="row">
        <div class="col-lg-12">
          <div class="card"  style="margin-bottom: 5px;border:1px solid lightgray;padding:10px;border-radius:30px;">
            <div class="card-body" style="padding:20px;">
                  <form action="{{route('laptop_asset_code.update',$datas->id)}}" class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
                  @METHOD('PUT')
                  @csrf
                  <div class="row g-3">
<!-- 
                  <div class="row">

                    <div class="form-check col-md-2 col-lg-2">
                      <input class="form-check-input" type="radio" name="type" id="gridRadios1" value="{{$datas->type}}">
                      <label class="form-check-label" for="gridRadios1" style="font-size: 15px;font-weight: 500;color: #012970;font-family: Poppins, sans-serif;">
                       By Employee
                      </label>
                      <p class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        Please choose your employee or department.
                        </p>
                    </div>
                    <div class="form-check col-md-2 col-lg-2">
                      <input class="form-check-input" type="radio" name="type" id="gridRadios2" value="{{$datas->type}}">
                      <label class="form-check-label" for="gridRadios2" style="font-size: 15px;font-weight: 500;color: #012970;font-family: Poppins, sans-serif;">
                        By Department
                      </label>
                    </div>
                  
                  </div><br><br><hr> -->

                    <div class="col-md-4 col-lg-4">
                      <input type="hidden" class="form-control"  name="userid" value="1">
                      <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;color:blue;">Employee Information</label><br>
                   
                      <div class="row">
                      <div class="col-md-6">
                      <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">Document No</label>
                      <input type="text" class="form-control" id="validationCustom01" name="doc_no"  value="{{$datas->doc_no}}" style="box-shadow:1px 1px 1px #333;" readonly>
                      </div>
                      <div class="col-md-6">
                      <label for="validationCustom03" class="form-label card-title" style="font-size: 15px;">Department/Employee</label>
                      <select class="form-control" name="type" style="box-shadow:1px 1px 1px #333;">
                          <option value="{{$datas->type}}" selected>
                            @if($datas->type=='Emp')
                            By Employee
                            @else
                            By Department
                            @endif
                          </option>
                          <option value="Emp">By Employee</option>
                          <option value="Dept">By Department</option>
                      </select>
                      </div>
                      </div>
                    
               
                      <label for="validationCustom02" class="form-label card-title" style="font-size: 15px;">Employee ID</label>
                      <input type="text" class="form-control" id="empID" name="empcode" value="{{$datas->emp_code}}" style="box-shadow:1px 1px 1px #333;">

                      <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">Employee name</label>
                      <input type="text" class="form-control" id="employee_name" name="empname"  value="{{$datas->emp_name}}" style="box-shadow:1px 1px 1px #333;">

                      <label for="validationCustom03" class="form-label card-title" style="font-size: 15px;">Department</label>
                      <select class="form-control" id="department" name="department" required>
                          <option value="{{$datas->department}}">{{$datas->department}}</option>
                            @foreach($departments as $department)
                            <option value="{{$department->name}}">{{$department->name}}</option>
                            @endforeach
                      </select>

                      <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        Please enter your Department.
                      </div>
            
                      <label for="validationCustom03" class="form-label card-title" style="font-size: 15px;">Branch Code</label>
                      <select class="form-control" id="branchescode" name="branchcode" required>
                          <option value="{{$datas->branch_code}}">{{$datas->branch_code}}</option>
                            @foreach($branches as $branch)
                            <option value="{{$branch->branch_code}}">{{$branch->branch_code}}</option>
                            @endforeach
                      </select>
                      <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        Please enter your branch code.
                      </div>
           
                      <label for="validationCustom04" class="form-label card-title" style="font-size: 15px;">Branch Name</label>
                     
                      <select class="form-control" id="branches" name="branchname" required>
                          <option value="{{$datas->branch_name}}">{{$datas->branch_name}}</option>
                      </select>
                      <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        Please enter your branch name.
                      </div>
                      <br>
                      <div class="row g-3">
                    <div class="col-md-6 col-lg-6">
                    <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">
                    <i class="ri-information-fill" style="font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="We can accept file types as jpg, png, gif,webp or jpeg."></i> Employee Profile</label>
                    <label for="my_file">
                    <i class="bi bi-upload btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Employee profile click the button."></i>
                    </label>
                    <input type="file" id="my_file" style="display: none;" value="{{$datas->file}}" name="file" />
                 
                    </div>
                    <div class="col-md-6 col-lg-6">
                    <div id="image_preview" style="width: 100px;"></div>
                    <!-- <div id="file_name" style="font-size: 15px;font-weight: 500;color: #012970;font-family:Poppins, sans-serif;color:red;"></div> -->
                    </div>
               
                    </div>
                      <br>
                      
                    </div>
                  
                  
                    <div class="col-md-4 col-lg-4">
                      <h5 class="card-title" style="font-size: 15px; color:blue;">Asset Infomation</h5>
                      <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Asset Type</label>
                      <select class="form-select" aria-label="Default select example" id="elementSelector" name="assettype" style="box-shadow:1px 1px 1px #333;">
                          <option value="{{$datas->asset_type}}" selected>
                            @if($datas->asset_type=='lp')
                            Laptop and Phone
                            @elseif($datas->asset_type=='laptop')
                            Laptop
                            @else
                            Phone
                            @endif
                          </option>
                          <option value="laptop">Laptop</option>
                          <option value="phone">Phone</option>
                          <option value="lp">Laptop and Phone</option>
                      </select>

                      <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Laptop Asset Code</label>
                      <input type="text" class="form-control" id="validationCustom05" name="laptopcode" value="{{$datas->laptop_asset_code}}" style="box-shadow:1px 1px 1px #333;">
              
                      <label for="validationCustom06" class="form-label card-title" style="font-size: 15px;">Laptop Asset Name</label>
                      <textarea class="form-control" id="validationCustom06" style="height: 100px;box-shadow:1px 1px 1px #333;" value="{{$datas->laptop_asset_name}}" name="laptopname">{{$datas->laptop_asset_name}}</textarea>

                 
                      <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Handset Asset Code</label>
                      <input type="text" class="form-control" id="validationCustom05"  value="{{$datas->handset_asset_code}}" style="box-shadow:1px 1px 1px #333;" name="handsetcode">
                
                      <label for="validationCustom06" class="form-label card-title" style="font-size: 15px;">Handset Asset Name</label>
                      <textarea class="form-control" id="validationCustom06" value="{{$datas->handset_asset_name}}" style="height: 100px;box-shadow:1px 1px 1px #333;" name="handsetname">{{$datas->handset_asset_name}}</textarea>
                     
               
                      <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Operator</label>
                      <input type="text" class="form-control" id="validationCustom05"  style="box-shadow:1px 1px 1px #333;" name="simname" value="{{$datas->sim_name}}">
                  
                      <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Phone Number</label>
                      <input type="text" class="form-control" id="validationCustom05" value="{{$datas->sim_phone}}" style="box-shadow:1px 1px 1px #333;" name="simnumber">
                    </div>

                      <div class="col-md-4 col-lg-4">
                      <h5 class="card-title" style="font-size: 15px; color:blue;">Asset Infomation</h5>
                      <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Receipt Date</label>
                      <input type="date" class="form-control" id="validationCustom05" value="{{$datas->receipt_date}}" name="receiptdate" style="box-shadow:1px 1px 1px #333;" required>
                      <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        Please select your purchase date.
                      </div>


                  
                        <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Receipt Type</label>
                            <select class="form-select" aria-label="Default select example" name='receipttype' style="box-shadow:1px 1px 1px #333;"  required>
                            <option value="{{$datas->receipt_type}}" selected>{{$datas->receipt_type}}</option>
                            <option value="New">New</option>
                            <option value="Exchange">Exchange</option>
                            <option value="Transfer">Transfer</option>
                            <option value="Log">Log</option>
                            </select>
                   
                      <label for="validationCustom06" class="form-label card-title" style="font-size: 15px;">Remark</label>
                      <textarea class="form-control" value="{{$datas->remark}}" id="validationCustom06" style="height: 100px;box-shadow:1px 1px 1px #333;" name="remark" required>{{$datas->remark}}</textarea>
                      <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        Please enter your remark.
                      </div>
                      <br>
                         <input type="hidden"  value="{{$datas->file}}" name="curr_file" />
                    </div>
                  </div>


                  <hr>
                  <div class="col-12">
                    <button class="btn btn-primary" type="submit"> <font class="card-title" style="color:#fff;font-size: 15px;">Save</font></button>
                    <button class="btn btn-warning" type="reset"> <font class="card-title" style="color:#fff;font-size: 15px;">Back</font></button>
                  </div>
              </form><!-- End Custom Styled Validation -->
              </div>
        </div>
     </div>
     <div class="col-lg-4"></div> 
     </div>
          </div>

        </div>
      </div>


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
            }, 4000); // Hide the toast after 3 seconds
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
    placeholder : 'Choose Your Sale branch',
    width: '100%'
});

$('#branchescode').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your Sale branch code',
    width: '100%'
});

$('#department').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your Sale branch code',
    width: '100%'
});

});


// Get the radio buttons and the text input field
const radioButtons = document.querySelectorAll('input[type="radio"]');
const textInput = document.getElementById('textInput');

// Add event listeners to the radio buttons
radioButtons.forEach(radioButton => {
    radioButton.addEventListener('change', function() {
        // Update the value of the text input based on the selected radio button
        if (this.checked) {
            textInput.value = this.value;
        }
    });
});

$(document).ready(function (){
  $('#branchescode').on('change',function (){
    var branchName=this.value;
    console.log(branchName);
    $.ajax({
      url: "/branch_name/all_branchcode/"+branchName,
                type: "GET",
                success: function (result) {
                    // console.log(result);

                    $('#branches').html('');

                    $.each(result, function (key, value) {
                      // console.log(value);
                         option = `<option value="`+value+`" >`+value+`</option>`
                        $('#branches').append(option);

                    });
                }
    });
  });
});

$(document).ready(function (){
  $('#empID').on('change',function (){
    var empid=this.value;
    console.log(empid);
    $.ajax({
      url: "/employee_asset/search_emp_id/"+empid,
                type: "GET",
                data: { 'employeecode': empid },
                success: function(response) {
                    console.log(response.data);
                    if (response.status === 'success') {
                        $('#employee_name').val(response.data[0].employeename);
                    }
                    if(response.status === 'fail'){
                        Swal.fire({
                        icon: 'error',
                        title: 'Employee ID Not Found',
                        text: 'The requested Employee ID could not be found.'
                    });
                    $('#employee_name').val('');
                    $('#empID').val('');
                    }


                }
    });
  });
});
</script>
@endsection
