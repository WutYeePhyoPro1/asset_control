@extends('laptop_asset_code.layouts.master')
@section('content')
    <div class="pagetitle">
      <h1>Asset Control System</h1><br>
      {{-- <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}" style="color:#000;">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{route('laptop_asset_code.index')}}" style="color:#000;">Back</a></li>
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

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show outline-animation" role="alert" style="width: 600px; float: right; z-index: 1000; position: absolute; top: 15%; right: 2%;" id="toast">
      <h4 class="alert-heading" style="font-size: 18px; font-weight: 500; color: #012970; font-family: Poppins, sans-serif;">Error Message</h4><hr>
          <p class="mb-0" style="font-size: 18px; font-weight: 500; color: #012970; font-family: Poppins, sans-serif;">
          @foreach ($errors->all() as $error)
                   {{ $error }}<br>
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

            <h5 class="card-title">Non Asset Code Operator</h5>

        <div class="tab-content pt-2" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <!-- Custom Styled Validation -->
              <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                        <div class="card remark_card"  style="margin-bottom: 5px;border:1px solid lightgray;padding:10px;border-radius:30px;">
                            <div class="card-body" style="padding:20px;">

                                <form action="{{ route('non_asset_codeop_form') }}" method="POST">
                                    @csrf
                                    <input type="hidden" class="form-control" name="date" value="{{ today()->format('Y-m-d') }}">

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <h5 class="card-title">Branch</h5>
                                            <select class="form-select" id="branch" name="branch" style="box-shadow:1px 1px 1px #333;" required>
                                                <option value="">Select Your Branch</option>
                                                @foreach($branches as $branch)
                                                <option value="{{$branch->branch_name}} ({{$branch->branch_code}})">{{$branch->branch_name}} ({{$branch->branch_code}})</option>
                                                @endforeach
                                        </select>
                                        </div>

                                        <div class="col-lg-6">
                                            <h5 class="card-title">Department</h5>
                                            <select class="form-select" aria-label="Default select example" id="department" name="department" style="box-shadow:1px 1px 1px #333;" required>
                                                <option value="">Select Your Department</option>
                                                    @foreach($departments as $department)
                                                    <option value="{{$department->name}}">{{$department->name}}</option>
                                                    @endforeach
                                            </select>
                                        </div>

                                        <div class="col-lg-12">
                                                <h5 class="card-title">Rank</h5>
                                                            <select class="form-select" aria-label="Default select example" name="rank" style="box-shadow:1px 1px 1px #333;" required>
                                                            <option value="" selected>Select Your Rank</option>
                                                            <option value="R1">R1</option>
                                                            <option value="R2">R2</option>
                                                            <option value="R3">R3</option>
                                                            <option value="R4">R4</option>
                                                            <option value="R5">R5</option>
                                                            <option value="R6">R6</option>
                                                            <option value="R7">R7</option>
                                                            <option value="R8">R8</option>
                                                            <option value="R9">R9</option>
                                                </select>
                                        </div>


                                        <div class="col-lg-6">
                                            <h5 class="card-title">Employee ID</h5>
                                            <input type="text" class="form-control" name="emp_id" id="empID" style="box-shadow:1px 1px 1px #333;" required>
                                        </div>


                                        <div class="col-lg-6">
                                            <h5 class="card-title">Name</h5>
                                            <input type="text" class="form-control" name="name" id="employee_name" maxlength="11" style="box-shadow:1px 1px 1px #333;" required>
                                        </div>

                                        <div class="col-lg-6">
                                        <h5 class="card-title">Operator</h5>
                                        <select class="form-select" aria-label="Default select example" name="operator[]" style="box-shadow:1px 1px 1px #333;" required>
                                        <option value="" selected>Select your Operator</option>
                                        <option value="ATOM">ATOM</option>
                                        <option value="Ooredoo">Ooredoo</option>
                                        <option value="MPT">MPT</option>
                                        <option value="Mytel">Mytel</option>
                                        </select>
                                        </div>
                                    <div class="col-lg-6">
                                    <h5 class="card-title">Ph No:</h5>
                                    <input type="text" class="form-control" name="phone[]" maxlength="11" style="box-shadow:1px 1px 1px #333;" required>
                                    </div>
                                    </div>
                                    <br>
                                    <i class="bi bi-plus-square-fill" style="color:#1c88fc;font-size:33px;" id="addbtn"></i></a>

                                    <div class="row" id="showope">

                                    </div>

                                    <h5 class="card-title">Contract</h5>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="contract" id="gridRadios1" value="Yes" required>
                                        <label class="form-check-label" for="contract">
                                        Yes
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="contract" id="gridRadios2" value="No" required>
                                        <label class="form-check-label" for="contract">
                                        No
                                        </label>
                                    </div>

                                    <h5 class="card-title">Remark</h5>
                                    <textarea class="form-control" style="height: 100px" name="remark"></textarea><br>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>

                            </div>
                        </div>

                    </div>
                    <div class="col-lg-3"></div>

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
function deleteRemark(id) {
    Swal.fire({
        title: 'Are you sure?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/remark/delete_remark/" + id,
                type: 'get',
                data: {
                    "id": id,
                },
                success: function () {
                    Swal.fire(
                        'Deleted!',
                        'The operator and phone and contract has been deleted.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                },
                error: function () {
                    Swal.fire(
                        'Error!',
                        'There was an error deleting the operator and phone and contract.',
                        'error'
                    );
                }
            });
        }
    });
        }
</script>

<script>
function deleteOperator(id) {
    Swal.fire({
        title: 'Are you sure?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/operator/delete_operator/" + id,
                type: 'get',
                data: {
                    "id": id,
                },
                success: function () {
                    Swal.fire(
                        'Deleted!',
                        'The operator has been deleted.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                },
                error: function () {
                    Swal.fire(
                        'Error!',
                        'There was an error deleting the operator.',
                        'error'
                    );
                }
            });
        }
    });
}

</script>

<script>
$(document).ready(function () {
    var max_fields = 3;
    var x = 0;

    $('#addbtn').on('click', function () {
        if (x < max_fields) {
            x++;
            console.log(x);
            var wrapperope = `
                <div class="row">
                    <div class="col-lg-5">
                        <h5 class="card-title">Operator</h5>
                        <select class="form-select" aria-label="Default select example" name="operator[]" required>
                            <option value="" selected>Select your Operator</option>
                            <option value="ATOM">ATOM</option>
                            <option value="Ooredoo">Ooredoo</option>
                            <option value="MPT">MPT</option>
                            <option value="Mytel">Mytel</option>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="card-title">Ph No:</h5>
                        <input type="text" class="form-control" name="phone[]" maxlength="11" required>
                    </div>
                    <div class="col-lg-1">

                        <i class="bi bi-dash-square-fill removebtn" style="color:red;font-size:23px;"></i>
                    </div>
                </div>
            `;

            $('#showope').append(wrapperope);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Maximum fields limit reached!',
            });
        }
    });

    $('#showope').on('click', '.removebtn', function () {
        $(this).closest('.row').remove();
        x--;
    });
});

</script>

<script>
    $(document).ready(function () {
        var max_fields = 3;
        var x = 0;

        $('#addbtn1').on('click', function () {
            if (x < max_fields) {
                x++;
                console.log(x);
                var wrapperope = `
                    <div class="row">
                        <div class="col-lg-5">
                            <h5 class="card-title">Operator</h5>
                            <select class="form-select" aria-label="Default select example" name="operator[]" required>
                                <option value="" selected>Select your Operator</option>
                                <option value="ATOM">ATOM</option>
                                <option value="Ooredoo">Ooredoo</option>
                                <option value="MPT">MPT</option>
                                <option value="Mytel">Mytel</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="card-title">Ph No:</h5>
                            <input type="text" class="form-control" name="phone[]" maxlength="11" required>
                        </div>
                        <div class="col-lg-1">
                            <br>
                            <i class="bi bi-dash-square-fill removebtn1" style="color:red;font-size:23px;"></i>
                        </div>
                    </div>
                `;

                $('#showope1').append(wrapperope);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Maximum fields limit reached!',
                });
            }
        });

        $('#showope1').on('click', '.removebtn1', function () {
            $(this).closest('.row').remove();
            x--;
        });
    });

    </script>

    <script>
$(document).ready(function () {

$('#branch').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your  branch',
    width: '100%'
});



$('#department').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your department',
    width: '100%'

});


});
    </script>


<script>
$(document).ready(function () {
    $('#empID').on('change', function () {

        var empid = this.value;
        console.log(empid);
        $.ajax({
            url: "/employee_asset/search_emp_id/" + empid,
            type: "GET",
            data: { 'employeecode': empid },
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    $('#employee_name').val(response.data[0].employeename);

                    $('#branchescode').val(response.data[0].branch_code);
                    $('#branches').val(response.data[0].branch_name);
                }
                if (response.status === 'fail') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Employee ID Not Found',
                        text: 'The requested Employee ID could not be found.'
                    });
                    $('#empID').val('');
                    $('#employee_name').val('');
                    $('#branchescode').val('');
                    $('#branches').val('');
                }
            }
        });
    });
});
</script>
@endsection
