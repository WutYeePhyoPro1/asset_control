@extends('laptop_asset_code.layouts.master')
@section('content')
    <div class="pagetitle">
      <h1>Employee Asset Control System</h1><br>
      <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}" style="color:#000;">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{route('laptop_asset_code.index')}}" style="color:#000;">Back</a></li>
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

        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              
            <h5 class="card-title">Laptop Asset Code</h5>

          <!-- Default Tabs -->
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"> 
                <font class="card-title" style="font-size: 15px;">Laptop Asset</font></button>
            </li>
            <!-- <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
              <font class="card-title" style="font-size: 15px;"><i class="bi bi-plus-square-fill" style="font-size: 20px;"></i>&nbsp; Add New</font></button>
            </li> -->

          </ul>
          <br>

        <div class="tab-content pt-2" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <!-- Custom Styled Validation -->
              <div class="row">
        <div class="col-lg-12">
          <div class="card"  style="margin-bottom: 5px;border:1px solid lightgray;padding:10px;border-radius:30px;">
            <div class="card-body" style="padding:20px;">
                <form action="{{route('laptop_asset_code.store')}}" class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                <div class="row">
                  <div class="row">
                    <div class="form-check col-md-2 col-lg-2">
                      <input class="form-check-input" type="radio" name="type" id="gridRadios1" value="Emp" required>
                      <label class="form-check-label" for="gridRadios1" style="font-size: 15px;font-weight: 500;color: #012970;font-family: Poppins, sans-serif;">
                       By Employee
                      </label>
                      <p class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        Please choose your employee or department.
                        </p>
                    </div>
                    <div class="form-check col-md-2 col-lg-2">
                      <input class="form-check-input" type="radio" name="type" id="gridRadios2" value="Dept" required>
                      <label class="form-check-label" for="gridRadios2" style="font-size: 15px;font-weight: 500;color: #012970;font-family: Poppins, sans-serif;">
                        By Department
                      </label>
                    </div>
                  
                  </div><br><br><hr>

                    <div class="col-md-4 col-lg-4">
                    <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;color:blue;">Employee Information</label>
                    <input type="hidden" class="form-control"  name="userid" value="{{Auth::user()->id}}">
                    <input type="hidden" class="form-control" name="date" style="border:1px solid #2809f5;"   value="<?php echo date('Y-m-d'); ?>">

                    <div id="employeeFields">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                        <label for="empID" class="form-label card-title" style="font-size: 15px;">Employee ID</label>
                        <input type="text" class="form-control" id="empID" name="empcode" style="box-shadow:1px 1px 1px #333;" required>
                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                            Please enter your employee ID.
                        </div>
                        </div>
                      </div>
                     <div class="row mb-2">
                        <div class="col-sm-12">
                        <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">Employee name</label>
                        <input type="text" class="form-control" id="employee_name" name="empname"  style="box-shadow:1px 1px 1px #333;" required>
                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                            Please enter your employee name.
                        </div>
                        </div>
                      </div>
                    </div>
             
                      <div class="row mb-2">
                        <div class="col-sm-12">
                        <label for="validationCustom03" class="form-label card-title" style="font-size: 15px;">Department</label>
                        <select class="form-select" aria-label="Default select example" id="department" name="department" required>
                            <option value="">Select Your Department</option>
                                @foreach($departments as $department)
                                <option value="{{$department->name}}">{{$department->name}}</option>
                                @endforeach
                        </select>
                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                            Please enter your Department.
                        </div>
                        </div>
                      </div>
            
                      <div class="row mb-2">
                            <div class="col-sm-12">
                            <label for="validationCustom03" class="form-label card-title" style="font-size: 15px;">Branch Code</label>
                            <select class="form-select" id="branchescode" name="branchcode" required>
                                <option value="">Select Your Branch Code</option>
                                    @foreach($branches as $branch)
                                    <option value="{{$branch->branch_code}}">{{$branch->branch_code}}</option>
                                    @endforeach
                            </select>
                            <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                                Please enter your branch code.
                            </div>
                            </div>
                      </div>

                      
                      <div class="row mb-2">
                        <div class="col-sm-12">
                            <label for="validationCustom04" class="form-label card-title" style="font-size: 15px;">Branch Name</label>
                            <select class="form-select" id="branches" name="branchname" required>
                            <option value="">Select Your Branch</option>
                        
                            </select>
                            <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                                Please enter your branch name.
                            </div>
                        </div>
                      </div>

                    
                    <div class="row g-3">
                    <div class="col-md-6 col-lg-6">
                    <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;"><i class="ri-information-fill" style="font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="We can accept file types as jpg, png, gif,webp or jpeg."></i> Employee Profile</label>
                    <label for="my_file">
                    <i class="bi bi-upload btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Employee profile click the button."></i>
                    </label>
                    <input type="file" id="my_file" style="display: none;" name="file" />
                    <!-- <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        Please upload your employee profile.
                    </div> -->
             
                    </div>
                    <div class="col-md-6 col-lg-6">
                    <div id="image_preview" style="width: 100px;"></div>
                    <!-- <div id="file_name" style="font-size: 15px;font-weight: 500;color: #012970;font-family:Poppins, sans-serif;color:red;"></div> -->
                    </div>
               
                    </div>
                    </div>
                  
        
                    <div class="col-md-4 col-lg-4">
                      <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;color:blue;">Asset Information</label>

                      <div class="row mb-2">
                        <div class="col-sm-12">
                        <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Asset Type</label>
                            <select class="form-select" aria-label="Default select example" id="elementSelector" name="assettype" style="box-shadow:1px 1px 1px #333;" required>
                            <option value="" selected>Select your asset type</option>
                            <option value="laptop">Laptop</option>
                            <option value="phone">Phone</option>
                            <option value="lp">Laptop and Phone</option>
                            </select>
                            <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                            Please select your asset type.
                            </div>
                        </div>
                    </div>

                    <div id="laptop" class="selected-content">
                      <div class="row mb-2">
                        <div class="col-sm-12">
                        <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Laptop Asset Code</label>
                        <input type="text" class="form-control" id="validationCustom05" name="laptopcode" style="box-shadow:1px 1px 1px #333;" required>
                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                            Please enter your laptop asset code.
                        </div>
                        </div>
                      </div>

                      <div class="row mb-2">
                            <div class="col-sm-12">
                            <label for="validationCustom06" class="form-label card-title" style="font-size: 15px;">Laptop Asset Name</label>
                            <textarea class="form-control" id="validationCustom06" style="height: 100px;box-shadow:1px 1px 1px #333;" name="laptopname" required></textarea>
                            <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                                Please enter your laptop asset name.
                            </div>
                            </div>
                      </div>
                    </div>
        
                    <div id="phone" class="hidden">
                      <div class="row mb-2">
                        <div class="col-sm-12">
                        <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Handset Asset Code</label>
                        <input type="text" class="form-control" id="validationCustom05"  style="box-shadow:1px 1px 1px #333;" name="handsetcode" required>
                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                            Please enter your handset asset code.
                        </div>
                        </div>
                      </div>

                      <div class="row mb-2">
                            <div class="col-sm-12">
                            <label for="validationCustom06" class="form-label card-title" style="font-size: 15px;">Handset Asset Name</label>
                            <textarea class="form-control" id="validationCustom06" style="height: 100px;box-shadow:1px 1px 1px #333;" name="handsetname" required></textarea>
                            <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                                Please enter your handset asset name.
                            </div>
                            </div>
                      </div>
            

                        <div class="row mb-2">
                            <div class="col-sm-12">
                            <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Operator</label>
                            <input type="text" class="form-control" id="validationCustom05"  style="box-shadow:1px 1px 1px #333;" name="simname" required>
                            <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                                Please enter your operator.
                            </div>
                            </div>
                        </div>
            

                      <div class="row mb-2">
                            <div class="col-sm-12">
                            <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Phone Number</label>
                            <input type="text" class="form-control" id="validationCustom05"  style="box-shadow:1px 1px 1px #333;" name="simnumber" required>
                            <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                                Please enter your sim card number.
                            </div>
                            </div>
                      </div>
                    </div>
            

                    </div>
           
                    
                    <div class="col-md-4 col-lg-4">
                      <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;color:blue;">Receipt Information</label>
                      <div class="row mb-2">
                            <div class="col-sm-12">
                            <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Receipt Date</label>
                            <input type="date" class="form-control" id="validationCustom05" name="receiptdate" style="box-shadow:1px 1px 1px #333;" required>
                            <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                                Please select your receipt date.
                            </div>
                            </div>
                      </div>
                      

                      <div class="row mb-2">
                        <div class="col-sm-12">
                        <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Receipt Type</label>
                            <select class="form-select" aria-label="Default select example" name='receipttype' style="box-shadow:1px 1px 1px #333;"  required>
                            <option value="" selected>Select your receipt type</option>
                            <option value="New">New</option>
                            <option value="Exchange">Exchange</option>
                            <option value="Transfer">Transfer</option>
                            <option value="Log">Log</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-2">
                    <div class="col-sm-12">
                      <label for="validationCustom06" class="form-label card-title" style="font-size: 15px;">Remark</label>
                      <textarea class="form-control" id="validationCustom06" style="height: 100px;box-shadow:1px 1px 1px #333;" name="remark" required></textarea>
                      <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        Please enter your remark.
                      </div>
                    </div>
                    </div>
                
                    </div>
                  </div>


                  <hr>
                  <div class="col-12">
                    <button class="btn btn-primary" type="submit"> <font class="card-title" style="color:#fff;font-size: 15px;">Save</font></button>
                    <button class="btn btn-warning" type="reset"> <font class="card-title" style="color:#fff;font-size: 15px;">Cancel</font></button>
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
   </div>
 </div>
</div>
</section>

@endsection
@section('js')
<script>
    // JavaScript to handle the display and hiding of the toast
    // document.addEventListener('DOMContentLoaded', function() {
    //     const toast = document.getElementById('toast');
    //     if (toast.innerText) {
    //         toast.style.display = 'block';
    //         setTimeout(() => {
    //             toast.style.display = 'none';
    //         }, 5000); // Hide the toast after 3 seconds
    //     }
    // });

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
    width: '100%'
});

$('#branches1').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your  branch',
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

document.addEventListener("DOMContentLoaded", function() {
    const elementSelector = document.getElementById('elementSelector');
    const laptopContent = document.getElementById('laptop');
    const phoneContent = document.getElementById('phone');
    const laptopphone = document.getElementById('laptopphone');
    // Set initial state: Hide phone content and disable required
    phoneContent.style.display = 'none';
    phoneContent.querySelectorAll('input, textarea').forEach((el) => {
        el.required = false;
    });

    // Add a change event listener to the "select" element
    elementSelector.addEventListener('change', function () {
        // Get the selected value
        const selectedValue = elementSelector.value;

        // Show/hide content based on the selection
        if (selectedValue === 'laptop') {
            laptopContent.style.display = 'block';
            phoneContent.style.display = 'none';
            laptopContent.querySelectorAll('input, textarea').forEach((el) => {
                el.required = true;
            });
            phoneContent.querySelectorAll('input, textarea').forEach((el) => {
                el.required = false;
            });
        } else if (selectedValue === 'phone') {
            laptopContent.style.display = 'none';
            phoneContent.style.display = 'block';
            laptopContent.querySelectorAll('input, textarea').forEach((el) => {
                el.required = false;
            });
            phoneContent.querySelectorAll('input, textarea').forEach((el) => {
                el.required = true;
            });
        }else if (selectedValue === 'lp') {
            laptopContent.style.display = 'block';
            phoneContent.style.display = 'block';
            laptopContent.querySelectorAll('input, textarea').forEach((el) => {
                el.required = true;
            });
            phoneContent.querySelectorAll('input, textarea').forEach((el) => {
                el.required = true;
            });
        }
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const gridRadios1 = document.getElementById('gridRadios1');
    const gridRadios2 = document.getElementById('gridRadios2');
    const employeeFields = document.getElementById('employeeFields');
    // const departmentFields = document.getElementById('departmentFields');
    const employeeId = document.getElementById('employeeid');
    const empployeeId = document.getElementById('departmentName');

    // Function to enable required attribute
    function enableRequiredFields() {
        employeeFields.style.display = 'block';
        // departmentFields.style.display = 'none';
        // employeeFields.required = true;
        employeeFields.querySelectorAll('input, textarea').forEach((el) => {
        el.required = true;
    });
        // departmentName.required = false;
    }

    // Function to disable required attribute
    function disableRequiredFields() {
        employeeFields.style.display = 'none';
        // departmentFields.style.display = 'block';
        employeeFields.querySelectorAll('input, textarea').forEach((el) => {
        el.required = false;
    });
    }

    // Initialize the form based on the default radio button
   

    // if (gridRadios1.checked) {
    //   alert('hi');
    //     // enableRequiredFields();
    // } else if (gridRadios2.checked) {
    //     disableRequiredFields();
    // }

    // Add event listeners to the radio buttons
    gridRadios1.addEventListener('change', function () {
        enableRequiredFields();
    });

    gridRadios2.addEventListener('change', function () {
        disableRequiredFields();
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
