@extends('laptop_asset_code.layouts.master')
@section('content')
    <style>
        #fixasset th.gbh-column {
            background-color: #fff3cd !important;
        }

        #fixasset th.pro1-column {
            color: white !important;
            background-color: #2F70B4 !important;
        }

        .fix-asset-page form[id="clear"] {
            font-family: "Nunito", sans-serif;
        }

        .fix-asset-page form[id="clear"] .form-label {
            display: block;
            margin-bottom: 9px;
            color: #0f2b78;
            font-family: "Nunito", sans-serif;
            font-size: 15px !important;
            font-weight: 800;
        }

        .fix-asset-page form[id="clear"] .form-control,
        .fix-asset-page form[id="clear"] .form-select {
            min-height: 48px;
            padding: 10px 14px;
            color: #243b64;
            font-family: "Nunito", sans-serif;
            font-size: 15px;
            font-weight: 600;
            border: 1px solid #cbd5e1 !important;
            border-radius: 9px;
            box-shadow: none !important;
            transition: border-color .18s ease, box-shadow .18s ease;
        }

        .fix-asset-page form[id="clear"] .form-control::placeholder {
            color: #94a3b8;
            font-style: italic;
            font-weight: 600;
        }

        .fix-asset-page form[id="clear"] .form-control:focus,
        .fix-asset-page form[id="clear"] .form-select:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 .22rem rgba(59, 130, 246, .13) !important;
        }

        .fix-asset-page .select2-container--bootstrap-5 .select2-selection {
            min-height: 48px;
            padding: 0 42px 0 14px;
            color: #243b64;
            font-family: "Nunito", sans-serif;
            font-size: 15px;
            font-weight: 600;
            border: 1px solid #cbd5e1 !important;
            border-radius: 9px;
            box-shadow: none !important;
        }

        .fix-asset-page .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            display: flex;
            align-items: center;
            height: 46px;
            padding: 0;
            color: #243b64;
        }

        .fix-asset-page .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
            top: 12px;
            right: 12px;
        }

        .fix-asset-page .select2-container--bootstrap-5.select2-container--focus .select2-selection {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 .22rem rgba(59, 130, 246, .13) !important;
        }

        .fix-asset-page form[id="clear"] .btn {
            min-height: 48px;
            padding: 10px 19px;
            font-family: "Nunito", sans-serif;
            font-size: 15px;
            font-weight: 800 !important;
            border-radius: 9px;
        }
    </style>
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

    @if (Session::has('failures'))
        <div class="alert alert-danger alert-dismissible fade show outline-animation" role="alert"
            style="width: 1000px; z-index: 1000; position: absolute; top: 15%; right: 2%;" id="toast">
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
        <div class="alert alert-danger alert-dismissible fade show outline-animation" role="alert"
            style="width: 300px; float: right; z-index: 1000; position: absolute; top: 15%; right: 2%;" id="toast">
            <h4 class="alert-heading"
                style="font-size: 18px; font-weight: 500; color: #012970; font-family: Poppins, sans-serif;">Error Message
            </h4>
            <hr>
            <p class="mb-0" style="font-size: 18px; font-weight: 500; color: #012970; font-family: Poppins, sans-serif;">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <section class="section fix-asset-page">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {{-- Fix Asset Page --}}
                        <form id="clear" style="margin-top: 20px;">
                            <div class="row g-3" style="text-wrap: nowrap">
                                <div class="col-md-3" id="filter_col2" data-column="2">
                                    <label for="validationCustom03" class="form-label"
                                        style="font-size: 15px;">Branch</label>
                                    <select class="form-select column_filter" id="col2_filter" name="branchcode">
                                        <option value="">Select Your Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ trim($branch->branch_name) }}">
                                                {{ $branch->branch_name }} ({{ $branch->branch_code }})</option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="col-md-3" id="filter_col5" data-column="5">
                                    <label for="validationCustom04" class="form-label" style="font-size: 15px;">Select
                                        Asset Type</label>
                                    <select class="form-select column_filter" aria-label="Default select example"
                                        id="asset_type_filter" name="asset_type">
                                        <option value="">Select Asset Type</option>
                                        <option value="Laptop">Laptop</option>
                                        <option value="Handset">Handset</option>
                                        <option value="Handset+Simcard">Handset+Simcard</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>

                                <div class="col-md-3" id="filter_col3" data-column="3">
                                    <label for="validationCustom03" class="form-label"
                                        style="font-size: 15px;">Department</label>
                                    <select class="form-select column_filter" aria-label="Default select example"
                                        id="col3_filter" name="department">
                                        <option value="">Select Your Department</option>

                                        @foreach ($departments as $department)
                                            <option value="{{ $department->name }}">{{ $department->name }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-md-3" id="filter_col6" data-column="6">
                                    <label for="validationCustom04" class="form-label" style="font-size: 15px;">Asset
                                        Code </label>
                                    <input type="text" class="form-control column_filter"
                                        placeholder="Enter asset code" id="col6_filter"
                                        style="border:1px solid #0d0d0e;">
                                </div>


                                <div class="w-100"></div>

                                <div class="col-md-3" id="filter_col7" data-column="7">
                                    <label class="form-label" style="font-size: 15px;">Asset Name</label>
                                    <input type="text" class="form-control column_filter"
                                        placeholder="Enter Asset Name" id="col7_filter"
                                        style="border:1px solid #1c1c1d;">
                                </div>

                                <div class="col-md-3" id="filter_col10" data-column="10">
                                    <label for="validationCustom06" class="form-label" style="font-size: 15px;">Select
                                        Status</label>
                                    <select class="form-select column_filter" aria-label="Default select example"
                                        id="status_filter" name="status">
                                        <option value="">Status</option>
                                        <option value="Using">Using</option>
                                        <option value="Transfered">Transfered</option>
                                        <option value="Sold">Sold</option>
                                        <option value="Cancel">Cancel</option>
                                    </select>
                                </div>

                                <div class="col-md-3" id="filter_col11" data-column="11">
                                    <label for="validationCustom07" class="form-label" style="font-size: 15px;">Operator
                                        or Phone No:</label>
                                    <input type="text" class="form-control column_filter" placeholder="Enter Phone"
                                        id="col11_filter" style="border:1px solid #1c1c1d;">
                                </div>

                                <div class="col-md-3" id="filter_col13" data-column="13">
                                    <label for="validationCustom05" class="form-label" style="font-size: 15px;">Select
                                        Contract</label>
                                    <select class="form-select column_filter" aria-label="Default select example"
                                        id="col13_filter" name="contract">
                                        <option value="">Select Your Contract</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>

                                <div class="col-md-12 d-flex justify-content-between" id="filter_clear">

                                    <a id="clear-fix-asset-filters" class="nav-link collapsed"
                                        href="{{ route('laptop_asset_code.fix_asset') }}">
                                        <button class="btn btn-primary"
                                            style="font-weight: 500; color: #fff; font-family: Poppins, sans-serif;">All</button>
                                    </a>

                                    <div class="me-5 my-3">
                                        <button type="submit" form="refresh-fix-assets" class="btn btn-link p-0"
                                            title="Refresh ERP data">
                                            <i class="bi bi-arrow-clockwise fs-3"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <form id="refresh-fix-assets" method="POST"
                            action="{{ route('laptop_asset_code.fix_asset.refresh') }}">
                            @csrf
                        </form>

                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="">
                                    <div class="card-body">
                                        <div class="table-responsive" style="height: 550px;">
                                            <table class="table table-sm card-title table-hover table-bordered table-fix"
                                                style="font-size: 15px;" id="fixasset">
                                                <thead>

                                                    <tr class="table-primary" style="text-wrap: nowrap">
                                                        <th scope="col">No</th>
                                                        <th scope="col">Action</th>
                                                        <th scope="col" class="pro1-column">Branch Name (PRO1)</th>
                                                        <th scope="col" class="pro1-column">Department (PRO1)</th>
                                                        <th scope="col" class="pro1-column">Sub-Department (PRO1)</th>
                                                        <th scope="col" class="pro1-column">Asset Type Name (PRO1)</th>
                                                        <th scope="col" class="gbh-column">Asset Code (GBH)</th>
                                                        <th scope="col" class="gbh-column">Asset Name (GBH)</th>
                                                        <th scope="col" class="pro1-column">Employee Id (PRO1)</th>
                                                        <th scope="col" class="pro1-column">Employee Name (PRO1)</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Operator</th>
                                                        <th scope="col">Phone</th>
                                                        <th scope="col">Contract</th>
                                                        <th scope="col">Remark</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @php($no = 1)

                                                    @foreach ($fix_assets as $data)
                                                        <tr style="text-wrap: nowrap;cursor: pointer;">
                                                            <td scope="row">{{ $no }}.</td>
                                                            <td scope="row">
                                                                <center>
                                                                    <a
                                                                        href="{{ route('detail_fixasset', $data['asset_code']) }}"><i
                                                                            class="bi bi-eye-fill pointer"></i></a>
                                                                </center>
                                                            </td>
                                                            <td>
                                                                <a
                                                                    href="{{ route('detail_fixasset', $data['asset_code']) }}">
                                                                    {{ $data['branch_name'] }}

                                                                </a>
                                                            </td>
                                                            <td>{{ $data['department'] }}</td>
                                                            <td>{{ $data['sub_department'] }}</td>
                                                            <td>{{ $data['asset_type_name'] }}</td>
                                                            <td>
                                                                <a
                                                                    href="{{ route('detail_fixasset', $data['asset_code']) }}">{{ $data['asset_code'] }}</a>
                                                            </td>
                                                            <td>{{ $data['asset_name'] }}</td>
                                                            <td>{{ $data['employee_id'] ?? '--' }}</td>
                                                            <td>{{ $data['employee_name'] ?? '--' }}</td>
                                                            <td>{{ $data['status'] == 'Ongoing' ? 'Using' : $data['status'] }}
                                                            </td>

                                                            @php($assetOperators = $operatorsByAsset->get($data['asset_code'], collect()))
                                                            <td>
                                                                {{ $assetOperators->pluck('operator')->filter()->implode(', ') ?: '--' }}
                                                            </td>

                                                            <td>
                                                                {{ $assetOperators->pluck('phone')->filter()->implode(', ') ?: '--' }}
                                                            </td>
                                                            <td>
                                                                {{ $data['contract'] ?? '--' }}
                                                            </td>
                                                            <td>
                                                                {{ $data['remark'] ?? '--' }}
                                                            </td>
                                                        </tr>
                                                        @php($no++)
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <!-- End small tables -->

                                        </div>
                                    </div>
                                    @if ($assetPaginator && $assetPaginator->hasPages())
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <span>Page {{ $assetPaginator->currentPage() }} /
                                                {{ $assetPaginator->lastPage() }}</span>
                                            <div>
                                                @if ($assetPaginator->previousPageUrl())
                                                    <a class="btn btn-sm btn-outline-primary"
                                                        href="{{ $assetPaginator->previousPageUrl() }}">Previous</a>
                                                @endif
                                                @if ($assetPaginator->nextPageUrl())
                                                    <a class="btn btn-sm btn-outline-primary"
                                                        href="{{ $assetPaginator->nextPageUrl() }}">Next</a>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <form action="{{ route('remark-form') }}" method="POST">
                                        @csrf
                                        <h5 class="card-title">Operator</h5>
                                        <input type="hidden" class="form-control asset_code" name="asset_code"
                                            value="">
                                        <select class="form-select" aria-label="Default select example" name="operator"
                                            style="box-shadow:1px 1px 1px #333;">
                                            <option value="" selected>Select your Operator</option>
                                            <option value="ATOM">ATOM</option>
                                            <option value="Ooredoo">Ooredoo</option>
                                            <option value="MPT">MPT</option>
                                            <option value="Mytel">Mytel</option>
                                        </select>

                                        <h5 class="card-title">Ph No:</h5>
                                        <input type="text" class="form-control" name="phone"
                                            style="box-shadow:1px 1px 1px #333;">

                                        <h5 class="card-title">Contract</h5>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="contract"
                                                id="gridRadios1" value="Yes">
                                            <label class="form-check-label" for="contract">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="contract"
                                                id="gridRadios2" value="No">
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
                            <button type="button" id="closeModalBtn" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
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
                $('#assetCodeModal').removeClass(
                    'd-block'); // Assuming 'd-block' class is used to display modal

            });
        });
    </script>
    <script>
        $(document).on('click', '#asset_code', function() {
            $id = $(this).val();
            $.ajax({
                type: "GET",
                url: "/search_asset_code",
                data: {
                    asset_code: $id
                },
                dataType: "JSOn",
                success: function(response) {
                    var info = response.info;
                    var remarks = response.remarks;
                    console.log(remarks);

                    $('#code').append(`<span>` + info.asset_code + `</span>`);
                    $('#asname').append(`<span>` + info.asset_name + `</span>`);
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
                data: {
                    'remark': remark
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
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
                error: function(error) {
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
                // Filter values are persisted separately in localStorage below.
                // Disable DataTables' old column-index state so stale filters do not
                // get applied to the wrong columns after the table layout changes.
                "stateSave": false,
                "stateDuration": -1,

                buttons: [

                    {
                        extend: 'excel',
                        text: 'Export to Excel',

                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
                        },

                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];

                            $('col', sheet).eq(0).attr('width', 20);
                        }
                    },

                    {
                        extend: 'csv',
                        text: 'Export to CSV'
                    },

                    'colvis'
                ],


            });


            table.buttons().container().appendTo('#fixasset_wrapper .col-md-6:eq(0)');

            // Keep filter selectors, table indexes and URL keys in one place.
            const selectFilters = {
                '#col2_filter': {
                    column: 2,
                    queryKey: 'branch'
                },
                '#asset_type_filter': {
                    column: 5,
                    queryKey: 'asset_type'
                },
                '#status_filter': {
                    column: 10,
                    queryKey: 'status'
                },
                '#col3_filter': {
                    column: 3,
                    queryKey: 'department'
                },
                '#col13_filter': {
                    column: 13,
                    queryKey: 'contract'
                }
            };

            const savedPage = table.page();
            const savedFilters = JSON.parse(localStorage.getItem('fixAssetFilters') || '{}');
            const urlFilters = new URLSearchParams(window.location.search);
            let operatorFilterValue = '';

            // Operator and phone are two independent cells. Use one OR filter
            // for the shared input instead of DataTables' default AND behavior.
            $.fn.dataTable.ext.search.push(function(settings, data) {
                if (settings.nTable.id !== 'fixasset' || !operatorFilterValue) {
                    return true;
                }

                const needle = operatorFilterValue.toLowerCase();
                return [data[11], data[12]].some(function(value) {
                    return String(value || '').toLowerCase().includes(needle);
                });
            });

            function escapeRegex(value) {
                return String(value).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            }

            function normalizeStatusFilter(value) {
                return String(value || '').trim() === 'Ongoing' ? 'Using' : String(value || '').trim();
            }

            function filterColumn(column, selector, exactMatch = false) {
                const value = String($(selector).val() || '').trim();
                const searchValue = exactMatch && value ?
                    '^\\s*' + escapeRegex(value) + '\\s*$' :
                    value;

                table.column(column).search(searchValue, exactMatch, false).draw();
            }

            function filterGlobal() {
                table.search($(this).val() || '').draw();
            }

            function applySelectFilters() {
                Object.keys(selectFilters).forEach(function(selector) {
                    const filter = selectFilters[selector];
                    filterColumn(filter.column, selector, true);
                });
            }

            function persistSelectFilters() {
                const filters = {};
                const currentUrl = new URL(window.location.href);

                Object.keys(selectFilters).forEach(function(selector) {
                    const filter = selectFilters[selector];
                    const value = $(selector).val() || '';
                    filters[selector] = value;
                    currentUrl.searchParams.set(filter.queryKey, value);
                });

                localStorage.setItem('fixAssetFilters', JSON.stringify(filters));
                window.history.replaceState({}, '', currentUrl.toString());
            }

            // Restore saved filters after the table layout/column indexes changed.
            Object.keys(selectFilters).forEach(function(selector) {
                const filter = selectFilters[selector];
                const savedValue = urlFilters.has(filter.queryKey) ?
                    urlFilters.get(filter.queryKey) :
                    savedFilters[selector];

                if (savedValue !== undefined && savedValue !== null) {
                    const normalizedValue = filter.queryKey === 'status' ?
                        normalizeStatusFilter(savedValue) : savedValue;

                    $(selector).val(normalizedValue);
                }
            });

            applySelectFilters();
            table.page(savedPage).draw('page');

            $('input.global_filter').on('keyup click', filterGlobal);

            $('input.column_filter').on('keyup click', function() {
                const column = $(this).closest('[data-column]').data('column');
                const selector = '#' + this.id;

                // Operator and phone are separate table columns but intentionally
                // share one search box: match either value.
                if (selector === '#col11_filter') {
                    operatorFilterValue = String($(this).val() || '').trim();
                    table.column(11).search('');
                    table.column(12).search('').draw();
                    return;
                }

                filterColumn(column, selector);
            });

            $('select.column_filter').on('change', function() {
                const selector = '#' + this.id;
                const filter = selectFilters[selector];

                if (filter) {
                    filterColumn(filter.column, selector, true);
                    persistSelectFilters();
                }
            });

            $('#clear-fix-asset-filters').on('click', function(event) {
                event.preventDefault();
                localStorage.removeItem('fixAssetFilters');
                sessionStorage.removeItem('fixAssetFilters');
                table.state.clear();

                table.search('');
                table.columns().search('');
                operatorFilterValue = '';
                $('#clear').find('input.column_filter').val('');
                $('#clear').find('select.column_filter').val('');

                // Navigate to the clean route, never to the current URL with
                // branchcode=&asset_type=&... appended to it.
                window.location.replace(this.href.split('?')[0]);
            });

        });
    </script>
@endsection
