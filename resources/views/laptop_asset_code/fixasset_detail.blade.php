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

            <h5 class="card-title">Fix Asset Detail</h5>

        <div class="tab-content pt-2" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <!-- Custom Styled Validation -->
              <div class="row">
                <div class="col-lg-5">
                    @if(!$remark)
                        <div class="card remark_card"  style="margin-bottom: 5px;border:1px solid lightgray;padding:10px;border-radius:30px;">
                            <div class="card-body" style="padding:20px;">
                                @foreach($query as $item)

                                <form action="{{ route('remark-form') }}" method="POST">
                                    @csrf
                                    <p class="card-title">{{ $item->asset_code }} <br> {{ $item->asset_name }}</p>
                                    <hr>

                                    <input type="hidden" class="form-control asset_code" name="asset_code" value="{{ $item->asset_code }}">
                                    <input type="hidden" class="form-control asset_code" name="department" value="{{ $item->department }}">
                                    <input type="hidden" class="form-control asset_code" name="branch" value="{{ $item->branch_name }}({{ $item->branch_code }})">
                                    <input type="hidden" class="form-control asset_code" name="asset_type" value="{{ $item->asset_type_name }}">
                                    <input type="hidden" class="form-control asset_code" name="asset_name" value="{{ $item->asset_name }}">
                                    <div class="row">
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
                                @endforeach
                            </div>
                        </div>

                    @else
                    <div class="col-lg-5">
                        <div class="card remark_card"  style="margin-bottom: 5px;border:1px solid lightgray;width:400px;">
                            <div class="card-body">
                        @foreach($query as $item)

                        <p class="card-title" style="font-size: 15px;line-height:2;">
                        <font style="color:blue;">Branch</font><br>
                        {{ $item->branch_name }} ({{ $item->branch_code }})<hr>
                        </p>

                        <p class="card-title" style="font-size: 15px;line-height:2;">
                        <font style="color:blue;">Department</font><br>
                        {{ $item->department }}<hr>
                        </p>

                        <p class="card-title" style="font-size: 15px;line-height:2;">
                        <font style="color:blue;">Asset Type Name</font><br>
                        {{ $item->asset_type_name }}<hr>
                        </p>

                        <p class="card-title" style="font-size: 15px;line-height:2;">
                        <font style="color:blue;">Asset Code</font><br>
                        {{ $item->asset_code }}<hr>
                        </p>

                        <p class="card-title" style="font-size: 15px;line-height:2;">
                        <font style="color:blue;">Asset Name</font><br>
                        {{ $item->asset_name }}
                        </p>

                        @endforeach
                    </div>
                    </div>
                </div>
                    @endif
    </div>
     <div class="col-lg-7">

        @if($remark!=null && $remark->asset_code)
        <font style="float:right;"><i class="bi bi-plus-square-fill" style="color:#1c88fc;font-size:33px;" data-bs-toggle="modal" data-bs-target="#addoperator"></i></font>
        @endif

          <div class="modal fade" id="addoperator" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Add New Operator</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('operator-form') }}" method="POST">
                        @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            @if($remark!=null && $remark->asset_code)
                        <input type="hidden" class="form-control asset_code" name="asset_code" value="{{ $remark->asset_code }}">
                        <input type="hidden" class="form-control asset_code" name="department" value="{{ $item->department }}">
                        <input type="hidden" class="form-control asset_code" name="asset_type" value="{{ $item->asset_type_name }}">
                        <input type="hidden" class="form-control asset_code" name="asset_name" value="{{ $item->asset_name }}">

                        <input type="hidden" class="form-control asset_code" name="branch" value="{{ $item->branch_name }}({{ $item->branch_code }})">
                        @endif
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
                    <i class="bi bi-plus-square-fill" style="color:#1c88fc;font-size:33px;" id="addbtn1"></i></a>

                    <div class="row" id="showope1">

                    </div>

                </div>
                <div class="modal-footer">

                  <button type="submit" class="btn btn-primary">Save</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
              </div>
            </div>
          </div><!-- End Vertically centered Modal-->
        <br>


            @foreach ($operators as $operator)
            <p class="card-title" style="color: #fff;">
            <span class="badge rounded-pill bg-primary" style="font-size: 15px;color:#fff;">{{ $operator->operator }}</span><br>
            <span class="badge rounded-pill bg-primary" style="font-size: 15px;color:#fff;">{{ $operator->phone }}</span>
            <br>
            @if(Auth::user()->type=='superadmin')
            <i class="bi bi-x-circle"
            onclick='deleteOperator("{{ $operator->id }}")' style="font-size:14px;color:red;width:80px;float:right;cursor: pointer;">
            Delete</i>
            @endif
            <i data-bs-toggle="modal" data-bs-target="#editoperator{{ $operator->id }}" class="bi bi-pencil-square" style="font-size:14px;color:rgb(19, 60, 240);width:80px;float:right;cursor: pointer;">
            Edit</i>
            </p>
            <hr>

            <div class="modal fade" id="editoperator{{ $operator->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Edit Operator</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('update_operator',$operator->id) }}" method="POST">
                            @csrf
                            @method("PUT")

                        <div class="row">
                            <div class="col-lg-6">
                            <h5 class="card-title">Operator</h5>
                            <select class="form-select" aria-label="Default select example" name="operator" style="box-shadow:1px 1px 1px #333;" required>
                            <option value="{{ $operator->operator }}" selected>{{ $operator->operator }}</option>
                            <option value="ATOM">ATOM</option>
                            <option value="Ooredoo">Ooredoo</option>
                            <option value="MPT">MPT</option>
                            <option value="Mytel">Mytel</option>
                            </select>
                            </div>
                        <div class="col-lg-6">
                        <h5 class="card-title">Ph No:</h5>
                        <input type="text" class="form-control" name="phone" maxlength="11" value="{{ $operator->phone }}" style="box-shadow:1px 1px 1px #333;" required>
                        </div>
                        </div>

                    </div>
                    <div class="modal-footer">

                      <button type="submit" class="btn btn-primary">Save</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
                  </div>
                </div>
              </div><!-- End Vertically centered Modal-->
            @endforeach
        @if($remark!=null && $remark->asset_code)
        <p style="font-size: 15px;color:#000;">Contract</p>
        <span class="badge rounded-pill bg-primary" style="font-size: 15px;">{{ $remark->contract }}</span><br><br>

        <textarea class="form-control" style="height: 100px" name="remark"
        id="remark{{ $remark->id }}" onblur="remarkUpdate({{ $remark->id }})">{{ $remark->remark }}</textarea><br>


    @if($operators->count() <= 0 )

    @if(Auth::user()->type=='superadmin')
        <i class="bi bi-x-circle btn btn-danger"
        onclick='deleteRemark("{{ $remark->id }}")'style="font-size:10px;color:fff;width:80px;float:right;margin:5px;">
        Delete</i>
        @endif
    @endif
        <i data-bs-toggle="modal" data-bs-target="#editremark{{ $remark->id }}" class="bi bi-pencil-square btn btn-primary" style="font-size:10px;color:rgb(243, 244, 248);width:80px;float:right;cursor: pointer;margin:5px;">
            Edit</i>
        <hr>

        <div class="modal fade" id="editremark{{ $remark->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Operator</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update_contract',$remark->id) }}" method="POST">
                        @csrf
                        @method("PUT")

                    <div class="row">

                    <div class="col-lg-6">
                        <h5 class="card-title">Contract</h5>
                        <span class="badge rounded-pill bg-primary" style="font-size: 15px;">{{ $remark->contract }}</span><br><br>

                        <input type="hidden" name="contract_edit" value="{{ $remark->contract }}">
                        @if($remark->contract=='Yes')
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="contract" id="gridRadios1" value="No">
                            <label class="form-check-label" for="contract">
                             No
                            </label>
                          </div>

                          @else
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="contract" id="gridRadios2" value="Yes">
                            <label class="form-check-label" for="contract">
                             Yes
                            </label>
                          </div>
                        @endif
                    </div>

                    <div class="col-lg-6">
                        <h5 class="card-title">Remark</h5>
                        <textarea class="form-control" style="height: 100px" name="remark" >{{ $remark->remark }}</textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">

                  <button type="submit" class="btn btn-primary">Save</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
              </div>
            </div>
        </div><!-- End Vertically centered Modal-->

    @endif

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
@endsection
