@extends('laptop_asset_code.layouts.master')
@section('content')
    <style>
        .admin-users-page { --user-primary: #1d4ed8; --user-ink: #172554; --user-border: #d8e1ed; font-family: "Nunito", sans-serif; }
        .admin-users-page .card { border-color: #e4ebf5; box-shadow: 0 10px 28px rgba(15, 23, 42, .05); }
        .admin-users-page .nav-tabs { border-bottom-color: #dfe7f3; }
        .admin-users-page .nav-tabs .nav-link { padding: 12px 18px; color: #526580; font-family: "Nunito", sans-serif; font-weight: 800; }
        .admin-users-page .nav-tabs .nav-link.active { color: var(--user-primary); border-color: #dfe7f3 #dfe7f3 #fff; }
        .admin-users-page form .form-label { margin-bottom: 8px; color: var(--user-ink); font-family: "Nunito", sans-serif; font-size: 14px !important; font-weight: 800; }
        .admin-users-page form .form-control, .admin-users-page form .form-select {
            min-height: 52px; padding: 11px 14px; color: #334155; font-family: "Nunito", sans-serif; font-size: 14px; font-weight: 600;
            border: 1px solid var(--user-border) !important; border-radius: 9px; box-shadow: none !important;
        }
        .admin-users-page form .form-control:focus, .admin-users-page form .form-select:focus { border-color: #60a5fa !important; box-shadow: 0 0 0 .22rem rgba(59,130,246,.13) !important; }
        .admin-users-page .select2-container--bootstrap-5 .select2-selection { min-height: 52px; padding: 0 42px 0 14px; color: #334155; font-family: "Nunito", sans-serif; font-size: 14px; font-weight: 600; border: 1px solid var(--user-border) !important; border-radius: 9px; box-shadow: none !important; }
        .admin-users-page .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered { display: flex; align-items: center; height: 50px; padding: 0; color: #334155; }
        .admin-users-page .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow { top: 14px; right: 13px; }
        .admin-users-page .select2-container--bootstrap-5.select2-container--focus .select2-selection { border-color: #60a5fa !important; box-shadow: 0 0 0 .22rem rgba(59,130,246,.13) !important; }
        .admin-users-page .user-register-card { border: 0; border-radius: 18px; box-shadow: 0 14px 32px rgba(15,23,42,.08); }
        .admin-users-page .user-register-card .card-body { padding: 28px; }
        .admin-users-page .profile-upload { display: flex; align-items: center; gap: 16px; padding: 14px; background: #f8fbff; border: 1px dashed #b9cbea; border-radius: 12px; }
        .admin-users-page .profile-preview { width: 72px; height: 72px; overflow: hidden; border: 3px solid #fff; border-radius: 50%; box-shadow: 0 4px 12px rgba(15,23,42,.12); }
        .admin-users-page .profile-preview img { width: 100%; height: 100%; object-fit: cover; }
        .admin-users-page .form-actions { display: flex; gap: 10px; align-items: end; height: 100%; padding-top: 27px; }
        .admin-users-page .form-actions .btn { min-height: 46px; padding: 10px 18px; border-radius: 9px; font-family: "Nunito", sans-serif; font-weight: 800; }
    </style>
    <div class="pagetitle">
      <h1>Employee Asset Control System</h1><br>
      <nav>

        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}" style="color:#000;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('laptop_asset_code.index')}}" style="color:#000;">Asset</a></li>
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

    <section class="section admin-users-page">
      <div class="row">

        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">

            <h5 class="card-title">User Accounts</h5>


<!-- Default Tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
            <font class="card-title" style="font-size: 15px;">User Accounts</font></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
            <font class="card-title" style="font-size: 15px;"><i class="bi bi-plus-square-fill" style="font-size: 20px;"></i>&nbsp; Register</font></button>
        </li>

        </ul>
<br>


        <div class="tab-content pt-2" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="card">
                <div class="card-body"><br>

<form method="POST" action="{{route('all_user.search')}}" class="user-search-form">
              @csrf
            <div class="row g-3">

                    <div class="col-md-2 col-lg-2">
                      <label for="validationCustom01" class="form-label card-title" style="font-size: 12px;padding:0px;">User Name</label>
                      <input type="text" class="form-control" id="validationCustom01" name="username"  style="box-shadow:1px 1px 1px #333;">
                    </div>

                    <div class="col-md-2 col-lg-2">
                      <label for="validationCustom01" class="form-label card-title" style="font-size: 12px;padding:0px;">Employee ID</label>
                      <input type="text" class="form-control" id="validationCustom01" name="empcode"  style="box-shadow:1px 1px 1px #333;">
                    </div>

                    <div class="col-md-2 col-lg-2">
                      <label for="validationCustom01" class="form-label card-title" style="font-size: 12px;padding:0px;">Department</label>
                      <select class="form-select" id="department" name="department" style="box-shadow:1px 1px 1px #333;">
                        <option value="" selected>Select Your Department</option>
                        <option value="System Development">System Development</option>
                        <option value="HR">HR</option>
                        </select>
                    </div>

                    <div class="col-md-2 col-lg-2">
                        <label for="validationCustom01" class="form-label card-title" style="font-size: 12px;padding:0px;">Branch</label>
                    <select class="form-select column_filter" id="branc_id" name="branch">
                        <option value="">Select Your Branch</option>
                        @foreach($branches as $branch)
                        <option value="{{$branch->id}}">{{$branch->branch_name}} ({{$branch->branch_code}})</option>
                        @endforeach
                    </select>
                </div>

                    <div class="col-md-2 col-lg-2">
                    <label for="validationCustom01" class="form-label card-title" style="font-size: 12px;padding:0px;">User Type</label>
                    <select class="form-select mb-3" id="type" name="type" style="box-shadow:1px 1px 1px #333;">
                        <option value="" selected>Select Your User Type</option>
                        <option value="admin">Admin</option>
                        <option value="superadmin">Superadmin</option>
                        <option value="Manager">Manager</option>
                        </select>
                    </div>

                    <div class="col-md-2 col-lg-2">
                    <label for="validationCustom01" class="form-label card-title" style="font-size: 12px;padding:0px;">Status</label>
                        <select class="form-select mb-3"  name="status" id="status" style="box-shadow:1px 1px 1px #333;">
                        <option value="" selected>Select Your Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                        </select>
                    </div>


                    <div class="col-md-2 col-lg-2">
                    <label for="validationCustom01" class="form-label" style="font-size: 12px;padding:0px;"><br></label><br>
                    <button class="btn btn-primary" type="submit"> <font class="card-title" style="color:#fff;font-size: 13px;">Search</font></button>
                    </div>

            </div>
            </form>
                <div class="table-responsive" style="margin: 10px;">
              <table class="table table-sm card-title table-hover table-bordered table-fix" style="font-size: 15px;" id="myTable">
                <thead>
                  <tr class="table-primary">
                    <th scope="col">#</th>
                    <th scope="col">Action</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Employee ID</th>
                    <th scope="col">Department</th>
                    <th scope="col">Branch</th>
                    <th scope="col">User Type</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Updated at</th>
                  </tr>
                </thead>
                <tbody>
                  @php($no=1)
                  @foreach($users as $data)
                  <tr>
                    <th scope="row">{{$no}}.</th>
                    <td>
                        <center>
                        @if(Auth::user()->type=='Manager')
                        <i class="bi bi-trash-fill pointer" data-bs-toggle="modal" data-bs-target="#del{{ $data->id }}" style="font-size: 15px;"></i> | @endif
                        <a href="{{route('all_user.show',$data->id)}}">
                            <i class="bi bi-eye-fill pointer"></i></a></center>
                    </td>
                    <td><a href="{{route('all_user.show',$data->id)}}" style="text-decoration:none;color:#000">{{$data->name}}</a></td>
                    <td><a href="{{route('all_user.show',$data->id)}}" style="text-decoration:none;color:#000">{{$data->emp_code}}</a></td>
                    <td><a href="{{route('all_user.show',$data->id)}}" style="text-decoration:none;color:#000">{{$data->department}}</a></td>
                    <td><a href="{{route('all_user.show',$data->id)}}" style="text-decoration:none;color:#000">{{$data->branches->branch_name}}</a></td>
                    <td><a href="{{route('all_user.show',$data->id)}}" style="text-decoration:none;color:#000">{{$data->type}}</a></td>
					<td><a href="{{route('all_user.show',$data->id)}}" style="text-decoration:none;color:#000">
                        {{$data->status=='1'? 'Active':'Inactive'}}
                    </a></td>
                    <td>{{$data->created_at}}</td>
                    <td>{{$data->updated_at}}</td>
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
                                                                                        src="{{ asset('img/external-warning.png') }}" />
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
           {{$users->links('pagination::bootstrap-5')}}
           </p>

              </div>
                </div>
                </div>
            </div>

            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <form action="{{route('all_user.store')}}" class="needs-validation user-register-form" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                <div class="row">
                    <div class="col-md-3 col-lg-3"></div>
                    <div class="col-md-6 col-lg-6">
                    <div class="card user-register-card">

                    <div class="card-body"><br>
                        <div class="row g-3">
                        <div class="col-md-12 col-lg-12">
                        <div class="row g-3">
                        <div class="col-md-12 col-lg-12">
                        <div class="profile-upload">
                        <div class="profile-preview" id="image_preview"><img src="{{ asset('assets/img/default-profile.svg') }}" alt="Default profile"></div>
                        <div>
                        <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;"><i class="ri-information-fill" style="font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="We can accept file types as jpg, png, gif,webp or jpeg."></i> User Profile</label>
                        <label for="my_file">
                        <span class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload a user profile image."><i class="bi bi-upload me-1"></i>Upload photo</span>
                        </label>
                        <input type="file" id="my_file" style="display: none;" name="profile" accept="image/jpeg,image/png,image/gif,image/webp" />
                        <div class="small text-muted">Optional — a default profile image will be used when empty.</div>
                        </div>
                        </div>
                        </div>

                        </div>

                        </div>
                        </div>

                        <div class="row g-3">

                        <div class="col-md-6 col-lg-6">
                        <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">User name</label>
                        <input type="text" class="form-control" id="validationCustom01" name="name" style="box-shadow:1px 1px 1px #333;"  required>

                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                            Please enter your user name.
                        </div>

                        </div>

                        <div class="col-md-6 col-lg-6">
                        <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">Employee ID</label>
                        <input type="text" class="form-control @error('emp_code') is-invalid @enderror" id="validationCustom01" name="emp_code"  value="{{ old('emp_code') }}" style="box-shadow:1px 1px 1px #333;" required>

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
                        <option value="" selected>Select Your Department</option>
                        <option value="System Development">System Development</option>
                        <option value="HR">HR</option>
                        </select>

                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        Please Select your department.
                        </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">Branch</label>

                            <select class="form-select mb-3" aria-label=".form-select-lg example" name="branch_id" style="box-shadow:1px 1px 1px #333;" required>
                            <option value="" selected>Select Your Branch</option>
                            @foreach ($branches as $branch)
                            <option value="{{$branch->id}}">{{$branch->branch_name}}</option>
                            @endforeach
                            </select>

                            <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                            Please Select your branch.
                            </div>
                            </div>

                        <div class="col-md-6 col-lg-6">
                        <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">User Type</label>
                        <select class="form-select mb-3" aria-label=".form-select-lg example" name="type" style="box-shadow:1px 1px 1px #333;" required>
                        <option value="" selected>Select Your User Type</option>
                        <option value="admin">Admin</option>
                        <option value="superadmin">Superadmin</option>
                        <option value="Manager">Manager</option>
                        </select>

                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                            Please select your user type.
                        </div>
                        </div>


                        <div class="col-md-6 col-lg-6">
                            <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">Status</label>

                            <select class="form-select mb-3" aria-label=".form-select-lg example" name="status" style="box-shadow:1px 1px 1px #333;" required>
                            <option value="" selected>Select Your Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                            </select>
                            <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                             Please select user status.
                            </div>
                            </div>

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


                        <div class="col-md-6 col-lg-6 form-actions">

                        <button class="btn btn-primary" type="submit"> <font class="card-title" style="color:#fff;font-size: 15px;">Save</font></button>
                        <button class="btn btn-warning" type="reset"> <font class="card-title" style="color:#fff;font-size: 15px;">Cancel</font></button>
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
                url: "/all_user/delete_record/" + id,
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

$('#department').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your department',
});

$('#type').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your user type',
});

$('#status').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your user status',
});

$('#branc_id').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your user Branch',
});

});

</script>
@endsection
