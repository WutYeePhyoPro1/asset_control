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

          <form id="clear" style="margin-top: 20px;">
            <div class="row"  style="text-wrap: nowrap">

                    <div class="col-md-3" id="filter_col1" data-column="1">

                    <label for="validationCustom03" class="form-label card-title" style="font-size: 15px;">Branch</label>
                    <select class="form-select column_filter" id="col1_filter" name="branchcode">
                            <option value="">Select Your Branch</option>
                            @foreach($branches as $branch)
                            <option value="{{$branch->branch_name}} ({{$branch->branch_code}})">{{$branch->branch_name}} ({{$branch->branch_code}})</option>
                            @endforeach
                    </select>

                    </div>

                    <div class="col-md-3" id="filter_col2" data-column="2">
                        <label for="validationCustom03" class="form-label card-title" style="font-size: 15px;">Department</label>
                        <select class="form-select column_filter" aria-label="Default select example" id="col2_filter" name="department">
                            <option value="">Select Your Department</option>

                                @foreach($departments as $department)
                                <option value="{{$department->name}}">{{$department->name}}</option>
                                @endforeach

                        </select>
                    </div>

                    <div class="col-md-3" id="filter_col3" data-column="3">
                        <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Select Asset Type</label>
                        <select class="form-select column_filter" aria-label="Default select example" id="col3_filter" name="department">
                            <option value="">Select Your Asset Type</option>

                                <option value="Laptop">Laptop</option>
                                <option value="Handset">Handset</option>

                        </select>
                    </div>

<br><br>
            <div class="row"  style="text-wrap: nowrap">

                <div class="col-md-3" id="filter_col4" data-column="4">
                    <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Asset Code </label>
                    <input type="text" class="form-control column_filter" placeholder="Enter Asset Code" id="col4_filter" style="border:1px solid #2809f5;">
                </div>

                <div class="col-md-3" id="filter_col5" data-column="5">
                    <label class="form-label card-title" style="font-size: 15px;">Asset Name</label>
                    <input type="text" class="form-control column_filter" placeholder="Enter Asset Name" id="col5_filter" style="border:1px solid #2809f5;">
                </div>
            </div>
        </form>

<div class="tab-content pt-2" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="card">
            <div class="card-body">
            <div class="table-responsive" style="height: 550px;">
              <table class="table table-sm card-title table-hover table-bordered table-fix" style="font-size: 15px;" id="fixasset">
                <thead>

                  <tr class="table-primary" style="text-wrap: nowrap">
                    <th scope="col">No</th>
                    <th scope="col">Branch Name</th>
                    <th scope="col">Department</th>
                    <th scope="col">Asset Type Name</th>
                    <th scope="col">Asset Code</th>
                    <th scope="col">Asset Name</th>
                  </tr>
                </thead>
                <tbody>
                  @php($no=1)
                  @foreach($fix_assets as $data)
                  {{-- class="clickable-row" data-url="{{ $data->id }}" --}}
                  <tr style="text-wrap: nowrap;cursor: pointer;">
                    <td scope="row">{{$no}}.</td>
                    <td>
                        <a href="{{ route('detail_fixasset',$data->asset_code) }}">
                        {{ $data->branch_name }} ({{ $data->branch_code }})</a>
                    </td>
                    <td>{{ $data->department }}</td>
                    <td>{{ $data->asset_type_name }}</td>
                    <td>
                        <a href="{{ route('detail_fixasset',$data->asset_code) }}">{{ $data->asset_code }}</a>
                        {{-- <button type="button" class="btn btn-transparent"  data-toggle="modal" id="asset_code" value="{{ $data->asset_code }}">{{ $data->asset_code }}</button> --}}
                    </td>
                    <td>{{ $data->asset_name }}</td>
                  </tr>
                @php($no++)

                {{-- <div class="modal fade" id="fixasset{{ $data->asset_code }}" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">{{ $data->asset_code }}&nbsp;&nbsp;/&nbsp;&nbsp;
                            {{ $data->asset_name }}
                          </h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <form action="{{ route('remark-form') }}" method="POST">
                                        @csrf
                                        <h5 class="card-title">Operator</h5>
                                        <input type="hidden" class="form-control" name="asset_code" value="{{  $data->asset_code }}">
                                        <select class="form-select" aria-label="Default select example" name="operator" style="box-shadow:1px 1px 1px #333;" required>
                                            <option value="" selected>Select your Operator</option>
                                            <option value="ATOM">ATOM</option>
                                            <option value="Ooredoo">Ooredoo</option>
                                            <option value="MPT">MPT</option>
                                            <option value="Mytel">Mytel</option>
                                            </select>

                                        <h5 class="card-title">Ph No:</h5>
                                        <input type="text" class="form-control" name="phone" style="box-shadow:1px 1px 1px #333;" required>

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
                                <div class="col-md-8">
                                    @foreach ( getRemark($data->asset_code) as $remark)
                                    Operator<br>
                                    <span class="badge rounded-pill bg-primary" style="font-size: 12px;">{{ $remark->operator }}</span><br><br>
                                    Phone No<br>
                                    <span class="badge rounded-pill bg-primary" style="font-size: 12px;">{{ $remark->phone }}</span><br><br>
                                    Contract<br>
                                    <span class="badge rounded-pill bg-primary" style="font-size: 12px;">{{ $remark->contract }}</span><br><br>

                                    <textarea class="form-control" style="height: 100px" name="remark"
                                    id="remark{{ $remark->id }}" onblur="remarkUpdate({{ $remark->id }})">{{ $remark->remark }}</textarea><br>

                                    <i class="bi bi-x-circle btn btn-danger"
                                    onclick='deleteRemark("{{ $remark->id }}")'style="font-size:10px;color:fff;width:80px;float:right;">
                                    Delete</i>
                                    <hr>
                                    @endforeach
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div> --}}
                @endforeach
                </tbody>
              </table>
              <!-- End small tables -->

            </div>
          </div>
        </div>


        </div>
     </div>
   </div>
 </div>
</div>
<div class="modal" tabindex="-1" id="assetCodeModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><span id="code"></span> &nbsp;&nbsp;/&nbsp;&nbsp;
                <span id="asname"></span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-4">
                      <form action="{{ route('remark-form') }}" method="POST">
                          @csrf
                          <h5 class="card-title">Operator</h5>
                          <input type="hidden" class="form-control asset_code" name="asset_code" value="">
                          <select class="form-select" aria-label="Default select example" name="operator" style="box-shadow:1px 1px 1px #333;" required>
                              <option value="" selected>Select your Operator</option>
                              <option value="ATOM">ATOM</option>
                              <option value="Ooredoo">Ooredoo</option>
                              <option value="MPT">MPT</option>
                              <option value="Mytel">Mytel</option>
                              </select>

                          <h5 class="card-title">Ph No:</h5>
                          <input type="text" class="form-control" name="phone" style="box-shadow:1px 1px 1px #333;" required>

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
                  <div class="col-md-8">

                      <div class="remarks-container">
                      </div>
                  </div>

              </div>

          </div>
          <div class="modal-footer">
            <button type="button" id="closeModalBtn" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>

          </div>
        </div>
      </div>
  </div>
</section>
<style>

.dataTables_wrapper .highlight {
    background-color: yellow;
    color: red;
}
  </style>
@endsection
@section('js')
<script>
        $(document).ready(function() {

        $('#closeModalBtn').on('click', function() {
            $('#assetCodeModal').removeClass('d-block'); // Assuming 'd-block' class is used to display modal

        });
    });
</script>
<script>
    $(document).on('click','#asset_code',function () {
        $id = $(this).val();
        $.ajax({
            type: "GET",
            url: "/search_asset_code",
            data: {asset_code:$id},
            dataType: "JSOn",
            success: function (response) {
               var info = response.info;
               var remarks = response.remarks;
               console.log(remarks);

                $('#code').append(`<span>`+info.asset_code+`</span>`);
                $('#asname').append(`<span>`+info.asset_name+`</span>`);
                $('.asset_code').val(info.asset_code);

                $('.remarks-container').empty();

            // Append each remark to the container
            remarks.forEach(function(remark) {
                var remarkHTML = `<div class="remark-item">
                    <div>Operator</div>
                    <span class="badge rounded-pill bg-primary" style="font-size: 12px;">${remark.operator}</span><br><br>
                      Phone No<br>
                      <span class="badge rounded-pill bg-primary" style="font-size: 12px;">${ remark.phone }</span><br><br>
                      Contract<br>
                      <span class="badge rounded-pill bg-primary" style="font-size: 12px;">${ remark.contract }</span><br><br>

                      <textarea class="form-control" style="height: 100px" name="remark"
                      id="remark${ remark.id }" onblur="remarkUpdate(${ remark.id })">${ remark.remark }</textarea><br>

                      <i class="bi bi-x-circle btn btn-danger"
                      onclick='deleteRemark("${remark.id}")'style="font-size:10px;color:fff;width:80px;float:right;">
                      Delete</i>
                      <hr>
                    </div>`;
                $('.remarks-container').append(remarkHTML);
            });
                $('#assetCodeModal').addClass('d-block');
            }
        });
    });

function remarkUpdate(id) {
    var remark = $('#remark' + id).val();
    console.log(remark);
    var url = '/remark_update/' + id;

    // Get the CSRF token from the meta tag
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: "POST",
        url: url,
        data: {'remark': remark},
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Your remark has been updated',
                    // You can add more customization options here
                });
            } else {
                // Handle the case where the response is not successful
                console.error('Update failed');
            }
        },
        error: function (error) {
            // Handle the case where the AJAX request encounters an error
            console.error('AJAX request failed:', error);
        }
    });
}



        function deleteRemark(id) {
            console.log(id);
              $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/remark/delete_remark/" + id,
                type: 'DELETE',
                data: {

                    "id": id,
                }
            });

            setTimeout(function() {
                window.location.reload(); // Reload the page on success
            }, 1000);
        }


    $(document).ready(function() {
    var table = $('#fixasset').DataTable({
        "lengthMenu": [10, 20, 50, 100, 200],
        "pageLength": 20,
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

<script>
    $(document).ready(function(){
        $('#col1_filter').select2({
            theme       : 'bootstrap-5',
            placeholder : 'Choose Your  branch',
            width: '100%'
        });

        $('#col2_filter').select2({
            theme       : 'bootstrap-5',
            placeholder : 'Choose Department  branch',
            width: '100%'
        });

        $('#col3_filter').select2({
            theme       : 'bootstrap-5',
            placeholder : 'Choose Asset Type',
            width: '100%'
        });



    });
</script>
@endsection
