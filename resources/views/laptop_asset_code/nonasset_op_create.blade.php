@extends('laptop_asset_code.layouts.master')
@section('content')
    <style>
        .nonasset-create {
            --form-primary: #1d4ed8;
            --form-ink: #172554;
            --form-border: #d8e1ed;
        }

        .nonasset-create .create-shell {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 12px 32px rgba(15, 23, 42, .08);
        }

        .nonasset-create .create-shell>.card-body {
            padding: 26px 30px 32px;
        }

        .nonasset-create .page-heading {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 0 24px;
            color: var(--form-ink);
            font-size: 20px;
            font-weight: 700;
        }

        .nonasset-create .page-heading i {
            padding: 9px;
            color: var(--form-primary);
            font-size: 18px;
            background: #eff6ff;
            border-radius: 10px;
        }

        .nonasset-create .create-panel {
            margin: 0;
            padding: 10px;
            border: 1px solid var(--form-border);
            border-radius: 16px;
            box-shadow: none;
        }

        .nonasset-create .create-panel>.card-body {
            padding: 22px;
        }

        .nonasset-create .field-label {
            display: block;
            margin: 0 0 8px;
            color: var(--form-ink);
            font-size: 14px;
            font-weight: 700;
        }

        .nonasset-create .nonasset-create-form .form-control,
        .nonasset-create .nonasset-create-form .form-select {
            min-height: 52px;
            padding: 11px 14px;
            color: #334155;
            font-size: 14px;
            font-weight: 500;
            border: 1px solid var(--form-border);
            border-radius: 9px;
            box-shadow: none !important;
            transition: border-color .18s ease, box-shadow .18s ease;
        }

        .nonasset-create .nonasset-create-form textarea.form-control {
            min-height: 118px;
            resize: vertical;
        }

        .nonasset-create .nonasset-create-form .form-control:focus,
        .nonasset-create .nonasset-create-form .form-select:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 .22rem rgba(59, 130, 246, .13) !important;
        }

        .nonasset-create .select2-container--bootstrap-5 .select2-selection {
            min-height: 52px;
            padding: 0 42px 0 14px;
            color: #334155;
            font-size: 14px;
            font-weight: 500;
            border: 1px solid var(--form-border) !important;
            border-radius: 9px;
            box-shadow: none !important;
        }

        .nonasset-create .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            display: flex;
            align-items: center;
            height: 50px;
            padding: 0;
            color: #334155;
        }

        .nonasset-create .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
            top: 14px;
            right: 13px;
        }

        .nonasset-create .select2-container--bootstrap-5.select2-container--focus .select2-selection {
            border-color: #60a5fa !important;
            box-shadow: 0 0 0 .22rem rgba(59, 130, 246, .13) !important;
        }

        .nonasset-create .nonasset-create-form .form-control::placeholder {
            color: #94a3b8;
            font-style: normal;
        }

        .nonasset-create .operator-add {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            margin: 2px 0 4px;
            color: #fff;
            font-size: 18px;
            background: var(--form-primary);
            border-radius: 9px;
            cursor: pointer;
            box-shadow: 0 5px 12px rgba(29, 78, 216, .2);
        }

        .nonasset-create .operator-add:hover {
            background: #1e40af;
        }

        .nonasset-create #showope .row {
            padding-top: 14px;
        }

        .nonasset-create #showope .card-title {
            display: block;
            margin: 0 0 8px;
            padding: 0;
            color: var(--form-ink);
            font-size: 14px;
            font-weight: 700;
        }

        .nonasset-create #showope .removebtn {
            display: inline-flex;
            margin-top: 32px;
            cursor: pointer;
        }

        .nonasset-create .contract-options {
            display: flex;
            gap: 12px;
        }

        .nonasset-create .contract-options .form-check {
            min-width: 94px;
            margin: 0;
            padding: 9px 12px 9px 34px;
            border: 1px solid var(--form-border);
            border-radius: 9px;
        }

        .nonasset-create .contract-options .form-check-input {
            margin-top: .28rem;
        }

        .nonasset-create .save-btn {
            min-width: 108px;
            padding: 10px 18px;
            border-radius: 9px;
            font-weight: 600;
        }

        @media (max-width: 575.98px) {
            .nonasset-create .create-shell>.card-body {
                padding: 20px 16px;
            }

            .nonasset-create .create-panel>.card-body {
                padding: 18px;
            }
        }
    </style>
    <div class="pagetitle">
        <h1>Asset Control System</h1><br>
        {{-- <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}" style="color:#000;">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{route('laptop_asset_code.index')}}" style="color:#000;">Back</a></li>
        </ol>
      </nav> --}}
    </div><!-- End Page Title -->

    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show outline-animation" role="alert"
            style="width: 300px; float: right; z-index: 1000; position: absolute; top: 15%; right: 2%;" id="toast">
            <h4 class="alert-heading"
                style="font-size: 18px; font-weight: 500; color: #012970; font-family: Poppins, sans-serif;">Success</h4>
            <hr>
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
        <div class="alert alert-danger alert-dismissible fade show outline-animation" role="alert"
            style="width: 600px; float: right; z-index: 1000; position: absolute; top: 15%; right: 2%;" id="toast">
            <h4 class="alert-heading"
                style="font-size: 18px; font-weight: 500; color: #012970; font-family: Poppins, sans-serif;">Error Message
            </h4>
            <hr>
            <p class="mb-0" style="font-size: 18px; font-weight: 500; color: #012970; font-family: Poppins, sans-serif;">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <section class="section nonasset-create">
        <div class="row">

            <div class="col-lg-12">
                <div class="card create-shell">
                    <div class="card-body">

                        <h5 class="page-heading"><i class="bi bi-person-plus"></i> Non Asset Code Operator</h5>

                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <!-- Custom Styled Validation -->
                                <div class="row">
                                    <div class="col-xl-2"></div>
                                    <div class="col-xl-8">
                                        <div class="card create-panel">
                                            <div class="card-body">

                                                <form action="{{ route('non_asset_codeop_form') }}" method="POST"
                                                    class="nonasset-create-form">
                                                    @csrf
                                                    <input type="hidden" class="form-control" name="date"
                                                        value="{{ today()->format('Y-m-d') }}">

                                                    <div class="row g-4">

                                                        <div class="col-lg-6">
                                                            <label class="field-label" for="branch">Branch</label>
                                                            <select class="form-select" id="branch" name="branch"
                                                                style="box-shadow:1px 1px 1px #333;" required>
                                                                <option value="">Select Your Branch</option>
                                                                @foreach ($branches as $branch)
                                                                    <option
                                                                        value="{{ $branch->branch_name }}({{ $branch->branch_code }})">
                                                                        {{ $branch->branch_name }}
                                                                        ({{ $branch->branch_code }})</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <label class="field-label" for="department">Department</label>
                                                            <select class="form-select" aria-label="Default select example"
                                                                id="department" name="department"
                                                                style="box-shadow:1px 1px 1px #333;" required>
                                                                <option value="">Select Your Department</option>
                                                                @foreach ($departments as $department)
                                                                    <option value="{{ $department->name }}">
                                                                        {{ $department->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <label class="field-label">Rank</label>
                                                            <select class="form-select" aria-label="Default select example"
                                                                name="rank" style="box-shadow:1px 1px 1px #333;"
                                                                required>
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
                                                            <label class="field-label" for="empID">Employee ID</label>
                                                            <input type="text" class="form-control" name="emp_id"
                                                                id="empID" placeholder="Enter employee ID" required>
                                                        </div>


                                                        <div class="col-lg-6">
                                                            <label class="field-label" for="employee_name">Name</label>
                                                            <input type="text" class="form-control" name="name"
                                                                id="employee_name" placeholder="Enter employee name"
                                                                required>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <label class="field-label">Operator</label>
                                                            <select class="form-select"
                                                                aria-label="Default select example" name="operator[]"
                                                                style="box-shadow:1px 1px 1px #333;" required>
                                                                <option value="" selected>Select your Operator
                                                                </option>
                                                                <option value="ATOM">ATOM</option>
                                                                <option value="Ooredoo">Ooredoo</option>
                                                                <option value="MPT">MPT</option>
                                                                <option value="Mytel">Mytel</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label class="field-label">Phone No.</label>
                                                            <input type="text" class="form-control" name="phone[]"
                                                                maxlength="11" placeholder="Enter phone number" required>
                                                        </div>
                                                    </div>
                                                    <i class="bi bi-plus-lg operator-add mt-2" id="addbtn"
                                                        title="Add another operator"></i>

                                                    <div class="row" id="showope">

                                                    </div>

                                                    <label class="field-label mt-3">Contract</label>
                                                    <div class="contract-options">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="contract" id="gridRadios1" value="Yes" required>
                                                            <label class="form-check-label" for="contract">
                                                                Yes
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="contract" id="gridRadios2" value="No" required>
                                                            <label class="form-check-label" for="contract">
                                                                No
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <label class="field-label mt-4" for="remark">Remark</label>
                                                    <textarea class="form-control" name="remark" id="remark" placeholder="Add a remark (optional)"></textarea>
                                                    <div class="text-end mt-4"><button type="submit"
                                                            class="btn btn-primary save-btn"><i
                                                                class="bi bi-check2-circle me-1"></i>Save</button></div>
                                                </form>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-xl-2"></div>

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
                        success: function() {
                            Swal.fire(
                                'Deleted!',
                                'The operator and phone and contract has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function() {
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
                        success: function() {
                            Swal.fire(
                                'Deleted!',
                                'The operator has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function() {
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
        $(document).ready(function() {
            var max_fields = 3;
            var x = 0;

            $('#addbtn').on('click', function() {
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

            $('#showope').on('click', '.removebtn', function() {
                $(this).closest('.row').remove();
                x--;
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var max_fields = 3;
            var x = 0;

            $('#addbtn1').on('click', function() {
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

            $('#showope1').on('click', '.removebtn1', function() {
                $(this).closest('.row').remove();
                x--;
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $('#branch').select2({
                theme: 'bootstrap-5',
                placeholder: 'Choose Your  branch',
                width: '100%'
            });



            $('#department').select2({
                theme: 'bootstrap-5',
                placeholder: 'Choose Your department',
                width: '100%'

            });


        });
    </script>


    <script>
        $(document).ready(function() {
            $('#empID').on('change', function() {

                var empid = this.value;
                console.log(empid);
                $.ajax({
                    url: "/employee_asset/search_emp_id/" + empid,
                    type: "GET",
                    data: {
                        'employeecode': empid
                    },
                    success: function(response) {
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
