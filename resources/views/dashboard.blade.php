@extends('laptop_asset_code.layouts.master')
@section('content')
    <style>.chart-shell{border:0;border-radius:18px;padding:8px;background:#fff;box-shadow:none!important;transition:none;}.chart-shell:hover{box-shadow:none!important;transform:none;}</style>

    <script src="{{ asset('assets/js/highcharts.js') }}"></script>

    <script src="{{ asset('assets/js/exporting.js') }}"></script>

    <script src="{{ asset('assets/js/export-data.js') }}"></script>

    <script src="{{ asset('assets/js/accessibility.js') }}"></script>

    <div class="pagetitle">
        <h1>Asset Control System</h1><br>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color:blue;">Dashboard</a></li>
                {{-- <li class="breadcrumb-item"><a href="{{route('laptop_asset_code.index')}}" style="color:#000;">Asset</a></li>
          <li class="breadcrumb-item"><a href="{{route('laptop_asset_code.create')}}" style="color:#000;">Add New</a></li> --}}
            </ol>
        </nav>
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


    <div class="row mb-3 g-3">
        <div class="col-lg-4">
            <form method="GET" id="branchFilterForm">
                <label class="form-label">Branch အလိုက် ရှာရန်</label>
                <select name="branch" id="branchFilter" class="form-control" style="width:100%"
                    {{ Auth::user()->type != 'Manager' ? 'disabled' : '' }}>
                    <option value="">-- All Branches --</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->branch_code }}"
                            {{ Auth::user()->type != 'Manager' && Auth::user()->branch_id == $branch->id ? 'selected' : '' }}
                            {{ request('branch') == $branch->branch_code ? 'selected' : '' }}>
                            {{ $branch->branch_name }} ({{ $branch->branch_code }})
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="col-lg-3">
            <label class="form-label" for="monthFilter">Date အလိုက် ရှာရန်</label>
            <input type="month" name="month" id="monthFilter" class="form-control"
                value="{{ request('month') }}" min="2000-01" max="{{ now()->format('Y-m') }}"
                form="branchFilterForm"
                onchange="document.getElementById('branchFilterForm').submit()">
        </div>
        <div class="col-lg-2 d-flex align-items-end">
            @if (request('month'))
                <a href="{{ route('home') }}" class="btn btn-outline-secondary ms-2">Clear</a>
            @endif
        </div>
    </div>


    <section class="section">
        <div class="row">

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">Laptop</h5>
                        <div class="col-md-12 chart-shell">

                            <div id="container-pi"></div>
                            <p id="totalAssetCount"></p>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">Handset</h5>
                        <div class="col-md-12 chart-shell">

                            <div id="container-pi-h"></div>
                            <p id="totalAssetCounth"></p>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">Handset and Asset Code Operator</h5>
                        <div class="col-md-12 chart-shell">

                            <div id="container-pi-h-o" style="height:600px;"></div>
                            <p id="totalHandsetAsset"></p>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">Non Asset Code Operator</h5>
                        <div class="col-md-12 chart-shell">

                            <div id="container-pi-non"></div>
                            <p id="totalNonAssetCount" style="margin: 10px 0px 10px 100px;">Total
                                Operators:{{ $totalPhoneCount }}</p>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row chart-shell">
                            <h5 class="card-title">Laptop, Handset, Operator </h5>
                            <div class="col-md-12">

                                <div id="container-fix-lh" style="height: 600px;"></div>

                            </div>

                        </div>


                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Employee ID / Name မပြည့်သေးသော Asset များ</h5>
                        <div class="col-md-12 chart-shell">
                            <div id="container-pending-employee" style="height: 500px;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- {{-- <div class="row">
            <script src="https://code.highcharts.com/highcharts.js"></script>
             <script src="https://code.highcharts.com/modules/exporting.js"></script>
             <script src="https://code.highcharts.com/modules/export-data.js"></script>
             <script src="https://code.highcharts.com/modules/accessibility.js"></script>
                 <div class="col-lg-6">
                     <div class="card">
                     <div class="card-body">

                     <h5 class="card-title">By Department</h5>
                     <div class="col-md-12 chart-shell">
                     <div id="container-bar-department"></div>
                     </div>

                     </div>
                     </div>
                 </div>

                 <div class="col-lg-6">
                     <div class="card">
                     <div class="card-body">

                     <h5 class="card-title">By Branch</h5>
                     <div class="col-md-12 chart-shell">


                     <div id="container-bar-branch"></div>
                     </div>

                     </div>
                     </div>
                 </div>
         </div> --}} -->

    </section>


@endsection
@section('js')
    <script>
        var mergedData = @json($mergedData);

        var categories = mergedData.map(function(item) {
            return item.branch;
        });

        var laptopCounts = mergedData.map(function(item) {
            return (item.asset_type_count || {}).Laptop || 0;
        });

        var handsetCounts = mergedData.map(function(item) {
            return (item.asset_type_count || {}).Handset || 0;
        });

        var operatorCounts = mergedData.map(function(item) {
            return item.operator_count || 0;
        });

        // var nonoperatorCounts = mergedData.map(function(item) {
        //     return item.non_operator_count || 0;
        // });

        // Summing up counts for Laptop, Handset, and Operator
        Highcharts.chart('container-fix-lh', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Laptop, Handset, Operator By Branch'
            },
            xAxis: {
                categories: categories,
                crosshair: true,
                labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '12px',
                        fontFamily: 'Arial, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Counts'
                }
            },
            series: [{
                name: 'Laptop',
                data: laptopCounts,
                dataLabels: {
                    enabled: true,
                    formatter: function() {
                        return this.y !== 0 ? this.y : null;
                    }
                }
            }, {
                name: 'Handset',
                data: handsetCounts,
                dataLabels: {
                    enabled: true,
                    formatter: function() {
                        return this.y !== 0 ? this.y : null;
                    }
                }
            }, {
                name: 'Operator Sim(ph)',
                data: operatorCounts,
                dataLabels: {
                    enabled: true,
                    formatter: function() {
                        return this.y !== 0 ? this.y : null;
                    }
                }
            }]
        });
    </script>
    {{--
<script>

    var opers = @json($opers);


    var branches = [];
    var phoneCounts = [];
    opers.forEach(function(item) {
        branches.push(item.branch);
        phoneCounts.push(item.phone_count);
    });

    Highcharts.chart('container-fix-operator', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Phone Count By Branch'
        },
        xAxis: {
            categories: branches,
            title: {
                text: 'Branch'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Phone Count'
            }
        },
        series: [{
            name: 'Phone Count',
            data: phoneCounts
        }]
    });
</script> --}}

    <script>
        // JavaScript to handle the display and hiding of the toast
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('toast');
            if (toast && toast.innerText) {
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
                    imagePreview.innerHTML = '<img src="' + e.target.result +
                        '" style="max-width: 100%; max-height: 100%;">';
                };

                reader.readAsDataURL(fileInput.files[0]);
                var fileName = fileInput.files[0].name;
                $("#file_name").text(fileName);
            } else {
                imagePreview.innerHTML = ''; // Clear the image preview
                $("#file_name").text(""); // Clear the file name
            }
        });

        $(document).ready(function() {

            $('#branches').select2({
                theme: 'bootstrap-5',
                placeholder: 'Choose Your  branch',
            });

            $('#branches1').select2({
                theme: 'bootstrap-5',
                placeholder: 'Choose Your  branch',
            });

            $('#branchescode').select2({
                theme: 'bootstrap-5',
                placeholder: 'Choose Your branch code',
            });

            $('#department').select2({
                theme: 'bootstrap-5',
                placeholder: 'Choose Your department',
            });

            $('#department1').select2({
                theme: 'bootstrap-5',
                placeholder: 'Choose Your department',
            });

        });
    </script>

    <script>
        var assetCounts = @json($assetCounts);

        var data = [];
        assetCounts.forEach(function(item) {
            data.push({
                name: item.branch + ' - ' + item.asset_type_count,
                y: item.asset_type_count
            });
        });

        Highcharts.chart('container-pi', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Laptop By Branch'
            },
            series: [{
                name: 'Laptop',
                data: data
            }]
        });


        var totalCount = assetCounts.reduce(function(total, item) {
            return total + item.asset_type_count;
        }, 0);

        document.getElementById('totalAssetCount').innerText = 'Total Laptop: ' + totalCount;
    </script>

    <script>
        var assetCounts = @json($assetCounts1);

        var data = [];
        assetCounts.forEach(function(item) {
            data.push({
                name: item.branch + ' - ' + item.asset_type_count,
                y: item.asset_type_count
            });
        });

        Highcharts.chart('container-pi-h', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Handset By Branch'
            },
            series: [{
                name: 'Handset',
                data: data
            }]
        });


        var totalCount = assetCounts.reduce(function(total, item) {
            return total + item.asset_type_count;
        }, 0);

        document.getElementById('totalAssetCounth').innerText = 'Total Handset: ' + totalCount;
    </script>

    {{-- <script>

var assetCounts = @json($assetCountslh);

var data = {};
assetCounts.forEach(function(item) {
    if (!data[item.branch]) {
        data[item.branch] = {};
    }
    // Filter for 'Laptop' and 'Handset' asset types only
    if (item.asset_type_name === 'Laptop' || item.asset_type_name === 'Handset') {
        data[item.branch][item.asset_type_name] = item.asset_type_count;
    }
});

var seriesData = [];
Object.keys(data).forEach(function(branch) {
    var assetTypes = data[branch];
    var series = {
        name: branch,
        data: []
    };

    ['Laptop', 'Handset'].forEach(function(assetType) {
        series.data.push(assetTypes[assetType] || 0);
    });
    seriesData.push(series);
});

Highcharts.chart('container-fix-lh', {
    chart: {
        type: 'column'
    },
    title: {
        text: ' '
    },
    xAxis: {
        categories: Object.keys(data)
    },
    yAxis: {
        title: {
            text: 'Asset Count'
        }
    },
    series: seriesData
});

</script> --}}

    <?php
    
    use Illuminate\Support\Facades\DB;
    
    $departments = App\Models\LaptopAssetCode::whereNotNull('department')->distinct('department')->get();
    
    $departmentLaptopCounts = [];
    $departmentPhoneCounts = [];
    $departmentProperties = [];
    $departmentOther = [];
    $allOperators = [];
    
    foreach ($departments as $department) {
        $laptopCount = App\Models\AssetType::where('department', $department->department)->where('assettype', 'laptop')->count();
    
        $phoneCount = App\Models\AssetType::where('department', $department->department)->where('assettype', 'phone')->count();
    
        $properties = App\Models\AssetType::where('department', $department->department)->where('assettype', 'Properties')->count();
    
        $other = App\Models\AssetType::where('department', $department->department)->where('assettype', 'Other')->count();
        $operators = App\Models\AssetType::where('department', $department->department)->groupBy('operator')->selectRaw('count(*) as count, operator as operator_name')->get();
    
        $operatorCounts = [];
    
        foreach ($operators as $operator) {
            $operatorCounts[$operator->operator_name] = $operator->count;
        }
    
        $allOperators[] = $operatorCounts;
    
        $departmentLaptopCounts[] = $laptopCount;
        $departmentPhoneCounts[] = $phoneCount;
        $departmentProperties[] = $properties;
        $departmentOther[] = $other;
    }
    
    ?>

    <script type="text/javascript">
        const departments = {!! json_encode($departments) !!};
        const departmentLaptopCounts = {!! json_encode($departmentLaptopCounts) !!};
        const departmentPhoneCounts = {!! json_encode($departmentPhoneCounts) !!};
        const departmentProperties = {!! json_encode($departmentProperties) !!};
        const departmentOther = {!! json_encode($departmentOther) !!};
        const allOperators = {!! json_encode($allOperators) !!};

        const departmentChartContainer = document.getElementById('container-bar-department');

        if (departmentChartContainer) {
            Highcharts.chart(departmentChartContainer, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Asset Counts'
                },
                xAxis: {
                    categories: departments.map(department => department.department)
                },
                yAxis: {
                    title: {
                        text: 'Counts'
                    }
                },
                legend: {
                    align: 'center',
                    verticalAlign: 'top',
                    floating: true,
                    backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                tooltip: {
                    shared: true
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    column: {
                        borderRadius: '25%',
                        colors: ['#007bff', '#ff0000', '#00ff00'],
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}',
                            style: {
                                color: 'black'
                            }
                        }
                    }
                },
                series: [{
                        name: 'Laptop Counts',
                        data: departmentLaptopCounts
                    }, {
                        name: 'Handset Counts',
                        data: departmentPhoneCounts
                    }, {
                        name: 'Operator Counts',
                        data: departmentProperties
                    }
                    // , {
                    //     name: 'Other Counts',
                    //     data: departmentOther
                    // }

                    // ,{
                    //     name: 'Sim Operator',
                    //     data: allOperators.map((operatorCounts, index) => ({
                    //     name: departments[index].department,
                    //     y: Object.values(operatorCounts).reduce((acc, val) => acc + val, 0)
                    // }
                    // ))
                    // }

                ]

            });
        }
    </script>

    <?php
    $branches = App\Models\LaptopAssetCode::whereNotNull('branch_code')->distinct('branch_code')->get();
    $branchLaptopCounts = [];
    $branchPhoneCounts = [];
    $branchProperties = [];
    $branchOther = [];
    $allOperators = [];
    
    foreach ($branches as $branch) {
        $laptopCount = App\Models\AssetType::where('branch', $branch->branch_co)->where('assettype', 'laptop')->count();
    
        $phoneCount = App\Models\AssetType::where('branch', $branch->branch_code)->where('assettype', 'phone')->count();
    
        $properties = App\Models\AssetType::where('branch', $branch->branch_code)->where('assettype', 'Properties')->count();
    
        $other = App\Models\AssetType::where('branch', $branch->branch_code)->where('assettype', 'Other')->count();
        $operators = App\Models\AssetType::where('branch', $branch->branch_code)->groupBy('operator')->selectRaw('count(*) as count, operator as operator_name')->get();
    
        $operatorCounts = [];
    
        foreach ($operators as $operator) {
            $operatorCounts[$operator->operator_name] = $operator->count;
        }
    
        $allOperators[] = $operatorCounts;
    
        $branchLaptopCounts[] = $laptopCount;
        $branchPhoneCounts[] = $phoneCount;
        $branchProperties[] = $properties;
        $branchOther[] = $other;
    }
    ?>
    <script>
        const branches = {!! json_encode($branches) !!};
        const branchLaptopCounts = {!! json_encode($branchLaptopCounts) !!};
        const branchPhoneCounts = {!! json_encode($branchPhoneCounts) !!};
        const branchProperties = {!! json_encode($branchProperties) !!};
        const branchOther = {!! json_encode($branchOther) !!};
        const allBranchOperators = {!! json_encode($allOperators) !!};

        const branchChartContainer = document.getElementById('container-bar-branch');

        if (branchChartContainer) {
            Highcharts.chart(branchChartContainer, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Branch-wise Asset Counts'
                },
                xAxis: {
                    categories: branches.map(branch => branch.branch_code)
                },
                yAxis: {
                    title: {
                        text: 'Counts'
                    }
                },
                legend: {
                    align: 'center',
                    verticalAlign: 'top',
                    floating: true,
                    backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                tooltip: {
                    shared: true
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    column: {
                        borderRadius: '25%',
                        colors: ['#007bff', '#ff0000', '#00ff00', '#ffcc00', '#000000'],
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}',
                            style: {
                                color: 'black'
                            }
                        }
                    }
                },
                series: [{
                    name: 'Laptop Counts',
                    data: branchLaptopCounts
                }, {
                    name: 'Phone Counts',
                    data: branchPhoneCounts
                }, {
                    name: 'Properties Counts',
                    data: branchProperties
                }, {
                    name: 'Other Counts',
                    data: branchOther
                }, {
                    name: 'Sim Operator',
                    data: allBranchOperators.map((operatorCounts, index) => ({
                        name: branches[index].branch,
                        y: Object.values(operatorCounts).reduce((acc, val) => acc + val, 0)
                    }))
                }]
            });
        }
    </script>
    <script>
        var categories = mergedData.map(function(item) {
            return item.branch;
        });

        var handsetCounts = mergedData.map(function(item) {
            return (item.asset_type_count || {}).Handset || 0;
        });

        var operatorCounts = mergedData.map(function(item) {
            return item.operator_count || 0;
        });

        var totalHandsets = handsetCounts.reduce(function(acc, count) {
            return acc + count;
        }, 0);

        var totalOperators = operatorCounts.reduce(function(acc, count) {
            return acc + count;
        }, 0);

        Highcharts.chart('container-pi-h-o', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Handset and Operator Counts By Branch'
            },
            subtitle: {
                text: `Total Handsets: ${totalHandsets} | Total Operators: ${totalOperators}`
            },
            xAxis: {
                categories: categories,
                title: {
                    text: 'Branch'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Counts',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '10px',
                            fontWeight: 'bold'
                        }
                    }
                }
            },
            series: [{
                name: 'Handsets',
                data: handsetCounts,
                color: '#1f77b4' // Optional: Color for Handsets
            }, {
                name: 'Operators',
                data: operatorCounts,
                color: '#ff7f0e' // Optional: Color for Operators
            }],
            credits: {
                enabled: false
            },
            legend: {
                reversed: true // Optional: Reverse the legend order
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var phoneData = @json($nonopers);


            var pieData = phoneData.map(function(item) {
                return {
                    name: item.branch,
                    y: parseInt(item.phone_count)
                };
            });

            Highcharts.chart('container-pi-non', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Non Asset Code Operator by Branch'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b> ({point.percentage:.1f}%)'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y}'
                        }
                    }
                },
                series: [{
                    name: 'None Asset Code Operators',
                    colorByPoint: true,
                    data: pieData
                }],
                credits: {
                    enabled: false
                }
            });
        });
    </script>

    <script>
        // Re-render every dashboard chart when a branch is selected.
        document.addEventListener('DOMContentLoaded', function() {
            (function() {
                var branchFilter = document.getElementById('branchFilter');
                var laptopData = @json($assetCounts);
                var handsetData = @json($assetCounts1);
                var branchSummaryData = @json($mergedData);
                var nonAssetOperatorData = @json($nonopers);
                var pendingEmployeeData = @json($pendingEmployeeUpdates);

                function belongsToBranch(branchValue, branchCode) {
                    if (!branchCode) return true;

                    var value = String(branchValue || '').trim();
                    return value === branchCode || value.indexOf('(' + branchCode + ')') !== -1;
                }

                function toPieData(items, branchCode) {
                    return items
                        .filter(function(item) {
                            return belongsToBranch(item.branch, branchCode);
                        })
                        .map(function(item) {
                            return {
                                name: item.branch,
                                y: Number(item.asset_type_count || item.phone_count || 0)
                            };
                        });
                }

                function total(items) {
                    return items.reduce(function(sum, item) {
                        return sum + item.y;
                    }, 0);
                }

                function pieChart(container, title, seriesName, chartData) {
                    Highcharts.chart(container, {
                        chart: {
                            type: 'pie'
                        },
                        title: {
                            text: title
                        },
                        subtitle: {
                            text: chartData.length ? null : 'No data for this branch.'
                        },
                        tooltip: {
                            pointFormat: '<b>{point.y}</b> ({point.percentage:.1f}%)'
                        },
                        plotOptions: {
                            pie: {
                                innerSize: '58%',
                                size: '88%',
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    distance: 22,
                                    format: '<b>{point.name}</b>: {point.y}',
                                    connectorColor: '#999999',
                                    connectorWidth: 1,
                                    softConnector: true,
                                    style: {
                                        fontSize: '11px',
                                        textOutline: 'none'
                                    }
                                }
                            }
                        },
                        series: [{
                            name: seriesName,
                            colorByPoint: true,
                            data: chartData
                        }],
                        credits: {
                            enabled: false
                        }
                    });
                }

                function renderDashboard(branchCode) {
                    var selectedLabel = branchFilter.options[branchFilter.selectedIndex].text;
                    var laptopChartData = toPieData(laptopData, branchCode);
                    var handsetChartData = toPieData(handsetData, branchCode);
                    var nonAssetChartData = toPieData(nonAssetOperatorData, branchCode);
                    var pendingEmployeeChartData = pendingEmployeeData
                        .filter(function(item) {
                            return belongsToBranch(item.branch, branchCode);
                        })
                        .map(function(item) {
                            return {
                                name: item.branch,
                                y: Number(item.pending_count || 0),
                                laptop_count: Number(item.laptop_count || 0),
                                handset_count: Number(item.handset_count || 0)
                            };
                        });
                    var filteredSummary = branchSummaryData.filter(function(item) {
                        return belongsToBranch(item.branch, branchCode);
                    });

                    pieChart('container-pi', 'Laptop by Branch', 'Laptop', laptopChartData);
                    pieChart('container-pi-h', 'Handset by Branch', 'Handset', handsetChartData);
                    pieChart('container-pi-non', 'Non Asset Code Operator by Branch', 'Operators',
                        nonAssetChartData);

                    document.getElementById('totalAssetCount').textContent = 'Total Laptop: ' + total(
                        laptopChartData);
                    document.getElementById('totalAssetCounth').textContent = 'Total Handset: ' + total(
                        handsetChartData);
                    document.getElementById('totalNonAssetCount').textContent = 'Total Operators: ' + total(
                        nonAssetChartData);

                    Highcharts.chart('container-pending-employee', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Employee ID / Name မပြည့်သေးသော Laptop / Handset အရေအတွက်'
                        },
                        subtitle: {
                            text: selectedLabel
                        },
                        xAxis: {
                            categories: pendingEmployeeChartData.map(function(item) {
                                return item.name;
                            }),
                            title: {
                                text: 'Branch'
                            }
                        },
                        yAxis: {
                            min: 0,
                            allowDecimals: false,
                            title: {
                                text: 'Pending asset count'
                            }
                        },
                        tooltip: {
                            shared: true,
                            headerFormat: '<b>{point.key}</b><br/>',
                            pointFormat: '<span style="color:{series.color}">●</span> {series.name}: <b>{point.y}</b><br/>'
                        },
                        plotOptions: {
                            bar: {
                                color: '#dc3545',
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y}'
                                }
                            }
                        },
                        series: [{
                            name: 'Laptop',
                            color: '#dc3545',
                            data: pendingEmployeeChartData.map(function(item) {
                                return item.laptop_count || 0;
                            })
                        }, {
                            name: 'Handset',
                            color: '#0d6efd',
                            data: pendingEmployeeChartData.map(function(item) {
                                return item.handset_count || 0;
                            })
                        }],
                        credits: {
                            enabled: false
                        }
                    });

                    // Use one normalized branch row so hover labels never point to a duplicate branch.
                    filteredSummary = filteredSummary.reduce(function(rows, item) {
                        var key = String(item.branch || '').trim().replace(/\s+/g, ' ')
                            .replace(/\s*\(\s*/g, '(').replace(/\s*\)\s*/g, ')');
                        var existing = rows.find(function(row) { return row._branchKey === key; });
                        if (!existing) {
                            item._branchKey = key;
                            item.branch = key;
                            rows.push(item);
                        } else {
                            existing.asset_type_count = Object.assign({}, existing.asset_type_count || {}, item.asset_type_count || {});
                            existing.handset_count = Math.max(Number(existing.handset_count || 0), Number(item.handset_count || 0));
                            existing.operator_count = Math.max(Number(existing.operator_count || 0), Number(item.operator_count || 0));
                        }
                        return rows;
                    }, []);

                    var categories = filteredSummary.map(function(item) {
                        return item.branch;
                    });
                    var laptops = filteredSummary.map(function(item) {
                        return Number((item.asset_type_count || {}).Laptop || 0);
                    });
                    var handsets = filteredSummary.map(function(item) {
                        return Number(item.handset_count || (item.asset_type_count || {}).Handset || 0);
                    });
                    var operators = filteredSummary.map(function(item) {
                        return Number(item.operator_count || 0);
                    });

                    Highcharts.chart('container-fix-lh', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Laptop, Handset, Operator by Branch'
                        },
                        subtitle: {
                            text: selectedLabel
                        },
                        xAxis: {
                            categories: categories,
                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Counts'
                            }
                        },
                        tooltip: {
                            shared: true,
                            valueSuffix: ' items',
                            headerFormat: '<b>{point.key}</b><br/>'
                        },
                        plotOptions: {
                            column: {
                                dataLabels: {
                                    enabled: true
                                }
                            }
                        },
                        series: [{
                                name: 'Laptop',
                                data: laptops
                            },
                            {
                                name: 'Handset',
                                data: handsets
                            },
                            {
                                name: 'Operator Sim(ph)',
                                data: operators
                            }
                        ],
                        credits: {
                            enabled: false
                        }
                    });

                    Highcharts.chart('container-pi-h-o', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Handset and Operator Counts by Branch'
                        },
                        subtitle: {
                            text: selectedLabel
                        },
                        xAxis: {
                            categories: categories
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Counts'
                            }
                        },
                        tooltip: {
                            shared: true,
                            valueSuffix: ' items',
                            headerFormat: '<b>{point.key}</b><br/>'
                        },
                        plotOptions: {
                            bar: {
                                dataLabels: {
                                    enabled: true
                                }
                            }
                        },
                        series: [{
                                name: 'Handsets',
                                data: handsets,
                                color: '#1f77b4'
                            },
                            {
                                name: 'Operators',
                                data: operators,
                                color: '#ff7f0e'
                            }
                        ],
                        credits: {
                            enabled: false
                        }
                    });
                }

                branchFilter.addEventListener('change', function() {
                    renderDashboard(this.value);
                });

                renderDashboard(branchFilter.value);
            })();
        });
    </script>
@endsection
