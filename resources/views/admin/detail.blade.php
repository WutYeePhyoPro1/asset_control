@extends('laptop_asset_code.layouts.master')
@section('content')
    <div class="pagetitle">
      <h1>Employee Asset Control System</h1><br>
      <nav>
        <ol class="breadcrumb">

        <li class="breadcrumb-item"><a href="{{route('home')}}" style="color:#000;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('laptop_asset_code.index')}}" style="color:#000;">Asset</a></li>
        <li class="breadcrumb-item"><a href="  {{route('all_user.index')}}" style="color:#000;">Back</a></li>
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

              <img src="{{asset('storage/profile/'.$user->profile)}}" alt="Profile" class="rounded-circle">
              <h2>{{$user->name}}</h2>
              <h3>{{$user->department}}</h3>
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

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit" style="font-size: 18px;font-weight: 500;color: #012970;font-family:Poppins, sans-serif;">Edit Employee </button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#password-edit" style="font-size: 18px;font-weight: 500;color: #012970;font-family:Poppins, sans-serif;">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview"  style="font-size: 15px;font-weight: 500;color: #012970;font-family:Poppins, sans-serif;">


                  <h5 class="card-title">User Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">User Name</div>
                    <div class="col-lg-9 col-md-8">{{$user->name}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Employee ID</div>
                    <div class="col-lg-9 col-md-8">{{$user->emp_code}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Department</div>
                    <div class="col-lg-9 col-md-8">{{$user->department}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Branch</div>
                    <div class="col-lg-9 col-md-8">{{$user->branches->branch_name}}</div>
                  </div>


                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">User Type</div>
                    <div class="col-lg-9 col-md-8">{{$user->type}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Status Date</div>
                    <div class="col-lg-9 col-md-8">
                        {{$user->status==1? 'Active':'Inactive'}}
                    </div>
                  </div>

                </div>

          <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
          <form action="{{route('all_user.update',$user->id)}}" class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
                  @METHOD('PUT')
                  @csrf
                <div class="row">
                    <div class="col-md-3 col-lg-3"></div>
                    <div class="col-md-6 col-lg-6">
                    <div class="card">

                    <div class="card-body"><br>
                        <div class="row g-3">
                        <div class="col-md-12 col-lg-12">
                        <div class="row g-3">
                        <div class="col-md-4 col-lg-4">
                        <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;"><i class="ri-information-fill" style="font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="We can accept file types as jpg, png, gif,webp or jpeg."></i> User Profile</label>
                        <label for="my_file">
                        <i class="bi bi-upload btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="user account profile click the button."></i>
                        </label>
                        <input type="file" id="my_file" style="display: none;" name="profile" />
                        <input type="hidden" name="curr_file" value="{{$user->profile}}"/>
                        </div>
                        <div class="col-md-4 col-lg-4">
                        <div id="image_preview" style="width: 100px;"></div>
                        <!-- <div id="file_name" style="font-size: 15px;font-weight: 500;color: #012970;font-family:Poppins, sans-serif;color:red;"></div> -->
                        </div>

                        </div>

                        </div>
                        </div>

                        <div class="row g-3">

                        <div class="col-md-6 col-lg-6">
                        <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">User name</label>
                        <input type="text" class="form-control" id="validationCustom01" name="name" value="{{$user->name}}" style="box-shadow:1px 1px 1px #333;"  required>

                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                            Please enter your user name.
                        </div>

                        </div>

                        <div class="col-md-6 col-lg-6">
                        <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">Employee ID</label>
                        <input type="text" class="form-control @error('emp_code') is-invalid @enderror" id="validationCustom01" name="emp_code"  value="{{ old('emp_code',$user->emp_code) }}" style="box-shadow:1px 1px 1px #333;" required>

                        <!-- <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                            Please enter your employee ID.
                        </div> -->

                        @error('emp_code')
                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        <strong>Employee ID has already been taken.</strong>
                        </div>
                        @enderror

                        </div>

                        <div class="col-md-6 col-lg-6">
                        <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">Department</label>

                        <select class="form-select mb-3" aria-label=".form-select-lg example" name="department" style="box-shadow:1px 1px 1px #333;" required>
                        <option value="System Development" {{$user->department=='System Development'?'selected':''}}>System Development</option>
                        <option value="HR" {{$user->department=='HR'?'selected':''}}>HR</option>
                        </select>

                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        Please enter your department.
                        </div>

                        </div>

                        <div class="col-md-6 col-lg-6">
                            <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">Branch</label>

                            <select class="form-select mb-3" aria-label=".form-select-lg example" name="branch_id" style="box-shadow:1px 1px 1px #333;" required>
                            @foreach ($branches as $branch)
                            <option value="{{$branch->id}}" {{$user->branch_id==$branch->id?'selected':''}}>{{$branch->branch_name}}</option>
                            @endforeach
                            </select>

                            <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                            Please Select your branch.
                            </div>
                            </div>

                        <div class="col-md-6 col-lg-6">
                        <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">Status</label>

                        @if(Auth::user()->type=='superadmin' || Auth::user()->type=='Admin' )
                        <input type="hidden" name="status" value="{{ $user->status }}" class="form-control" style="box-shadow:1px 1px 1px #333;">
                        <input type="text" value="{{ $user->status=='1'?'Active':'Inactive' }}" class="form-control" style="box-shadow:1px 1px 1px #333;" readonly>
                        @else
                        <select class="form-select mb-3" aria-label=".form-select-lg example" name="status" style="box-shadow:1px 1px 1px #333;" required>
                        <option value="1" {{$user->status=='1'? 'selected':''}}>Active</option>
                        <option value="0" {{$user->status=='0'? 'selected':''}}>Inactive</option>
                        </select>

                        @endif
                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                         Please select user status.
                        </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                        <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">User Type</label>

                        @if(Auth::user()->type=='superadmin' || Auth::user()->type=='Admin' )
                        <input type="text" value="{{ $user->type}}" name="type" class="form-control" style="box-shadow:1px 1px 1px #333;" readonly>
                        @else
                        <select class="form-select mb-3" aria-label=".form-select-lg example" name="type" style="box-shadow:1px 1px 1px #333;" required>
                        <option value="admin" {{$user->type=='admin'?'selected':''}}>Admin</option>
                        <option value="superadmin" {{$user->type=='superadmin'?'selected':''}}>Superadmin</option>
                        @if(Auth::user()->type=='Manager')
                        <option value="Manager" {{$user->type=='Manager'?'selected':''}}>Manager</option>
                        @endif
                        </select>
                        @endif


                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                            Please select your user type.
                        </div>
                        </div>



                        <div class="col-md-6 col-lg-6" style="padding-top: 65px;">

                        <button class="btn btn-primary" type="submit"> <font class="card-title" style="color:#fff;font-size: 15px;">Save</font></button>

                        </div>

                        </div>

                    </div>

                    </div>
                    </div>
                    <div class="col-md-3 col-lg-3"></div>
                </div>
           </form>
          </div>

          <div class="tab-pane fade password-edit pt-3" id="password-edit">
          <form action="{{route('change_password',$user->id)}}" class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
                    @METHOD('POST')
                    @csrf
                <div class="row">
                    <div class="col-md-3 col-lg-3"></div>
                    <div class="col-md-6 col-lg-6">
                    <div class="card">

                    <div class="card-body"><br>

                        <div class="row g-3">

                        <div class="col-md-6 col-lg-6">
                        <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="validationCustom01" name="password"  style="box-shadow:1px 1px 1px #333;" autocomplete="new-password" required>
                        <!-- <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                         Please enter your password.
                        </div> -->
                        @error('password')
                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                        </div>

                        <div class="col-md-6 col-lg-6">
                        <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">Confirm Password</label>
                        <input type="password" class="form-control" id="validationCustom01" name="password_confirmation"  style="box-shadow:1px 1px 1px #333;" required>
                        @error('password')
                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                        <!-- <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                         Please enter your confirm password.
                        </div> -->
                        </div>

                        <div class="col-md-6 col-lg-6" style="padding-top: 65px;">

                        <button class="btn btn-primary" type="submit"> <font class="card-title" style="color:#fff;font-size: 15px;">Change</font></button>

                        </div>

                        </div>

                    </div>

                    </div>
                    </div>
                    <div class="col-md-3 col-lg-3"></div>
                </div>
           </form>
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
});

$('#branchescode').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your Sale branch code',
});

$('#department').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your Sale branch code',
});

});
</script>
@endsection
