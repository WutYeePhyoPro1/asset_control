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

            <div class="table-responsive" style="margin: 10px;">
              <table class="table table-sm card-title table-hover table-bordered table-fix" style="font-size: 15px;" id="fixasset">
                <thead>
                    <form id="clear">
                    <tr  style="text-wrap: nowrap">
                        <th scope="col" colspan="2">
                            <div class="col-md-3" id="filter_col1" data-column="1">
                            <input type="text" class="form-control column_filter" placeholder="Enter Branch Name" id="col1_filter" style="border:1px solid #2809f5;width:250px;">
                            </div>
                        </th>
                        <th scope="col">
                            <div class="col-md-3" id="filter_col2" data-column="2">
                                <input type="text" class="form-control column_filter" placeholder="Enter Department" id="col2_filter" style="border:1px solid #2809f5;width:250px;">
                            </div>
                        </th>
                        <th scope="col">
                            <div class="col-md-3" id="filter_col3" data-column="3">
                                <input type="text" class="form-control column_filter" placeholder="Enter Laptop/Handset" id="col3_filter" style="border:1px solid #2809f5;width:250px;">
                            </div>
                        </th>
                        <th scope="col">
                            <div class="col-md-3" id="filter_col4" data-column="4">
                                <input type="text" class="form-control column_filter" placeholder="Enter Asset Code" id="col4_filter" style="border:1px solid #2809f5;width:250px;">
                            </div>
                        </th>
                        <th scope="col">
                            <div class="col-md-3" id="filter_col5" data-column="5">
                                <input type="text" class="form-control column_filter" placeholder="Enter Asset Name" id="col5_filter" style="border:1px solid #2809f5;width:250px;">
                            </div>
                        </th>

                    </tr>
                </form>
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

                    <td>{{ $data->branch_name }} ({{ $data->branch_code }})</td>
                    <td>{{ $data->department }}</td>
                    <td>{{ $data->asset_type_name }}</td>
                    <td><a data-bs-toggle="modal" data-bs-target="#fixasset{{ $data->asset_code }}" style="color:#000;">{{ $data->asset_code }}</a></td>
                    <td>{{ $data->asset_name }}</td>
                  </tr>
                @php($no++)

                <div class="modal fade" id="fixasset{{ $data->asset_code }}" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">{{ $data->asset_code }}</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="{{ route('remark-form') }}" method="POST">
                                        @csrf
                                        <h5 class="card-title">Name</h5>
                                        <input type="hidden" class="form-control" name="asset_code" value="{{  $data->asset_code }}">
                                        <input type="text" class="form-control" name="name">
                                        <h5 class="card-title">Remark</h5>
                                        <textarea class="form-control" style="height: 100px" name="remark"></textarea><br>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </form>

                                </div>
                                <div class="col-md-6">
                                    @foreach ( getRemark($data->asset_code) as $remark)
                                    <span class="badge rounded-pill bg-primary" style="font-size: 12px;">{{ $remark->name }}</span><br><br>
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
                  </div>
                @endforeach
                </tbody>
              </table>
              <!-- End small tables -->

           <p class="card-title">
           {{-- {{$fix_assets->links('pagination::bootstrap-5')}} --}}
           </p>

              </div>
            </div>
          </div>
        </div>


        </div>
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
        "lengthChange": true,
        "searching": true,
        "searchHighlight": true,

        buttons: [
            {
                extend: 'copy',
                text: 'Copy to Clipboard'
            },
            {
                extend: 'excel',
                text: 'Export to Excel',

            },

            {
                extend: 'csv',
                text: 'Export to CSV'
            },
            {
                extend: 'pdf',
                text: 'Export to PDF'
            },
            {
                extend: 'print',
                text: 'Print'
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
