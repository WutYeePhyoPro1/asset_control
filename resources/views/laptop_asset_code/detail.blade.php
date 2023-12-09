@extends('laptop_asset_code.layouts.master')
@section('content')
    <div class="pagetitle">
      <h1>Employee Asset Control System</h1><br>
      {{-- <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('home')}}" style="color:#000;">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{route('laptop_asset_code.index')}}" style="color:#000;">Back</a></li>
          <!-- <li class="breadcrumb-item">New</li>
          <li class="breadcrumb-item active">Back</li> -->
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
    <section class="section profile">
      <div class="row">


        <div class="col-xl-12">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview" style="font-size: 18px;font-weight: 500;color: #012970;font-family:Poppins, sans-serif;">Overview</button>
                </li>

                @if(Auth::user()->type=='superadmin')
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit" style="font-size: 18px;font-weight: 500;color: #012970;font-family:Poppins, sans-serif;">Edit </button>
                </li>
                @endif

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview"  style="font-size: 15px;font-weight: 500;color: #012970;font-family:Poppins, sans-serif;">

                  <div class="card" style="background-image: url('https://png.pngtree.com/thumb_back/fh260/background/20230114/pngtree-blue-background-light-mobile-wallpaper-stock-photo-free-image_1539073.jpg')">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                      @if($datas->file==null)
                      <img src="{{asset('assets/img/acc.png')}}" alt="Profile" class="rounded-circle">
                      @else
                      <img src="{{asset('storage/emp_profile/'.$datas->file)}}" alt="Profile" class="rounded-circle">
                      @endif
                      <h2 style="color:#fff;text-shadow:1px 2px 3px #000;">{{$datas->emp_name}}</h2>
                      <h3 style="color:#fff;text-shadow:1px 2px 3px #000;">{{$datas->department}}</h3>

                    </div>
                  </div>

                  <h5 class="card-title">Employee Details</h5>
                  <div class="row">

                    <div class="col-lg-3 col-md-4">Document No</div>
                    <div class="col-lg-9 col-md-8">{{$datas->doc_no}}</div>
                  </div>

                  <div class="row">
                  <div class="col-lg-3 col-md-4">
                  @if($datas->type=='Dept')
                      By Department
                      @else
                      By Employee
                  @endif
                  </div>
                    <div class="col-lg-9 col-md-8">
                    </div>
                  </div>

                  <h5 class="card-title" style="font-size: 15px; color:blue;">Employee Infomation</h5>
                  @if($datas->type=='Emp')

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Employee Name</div>
                    <div class="col-lg-9 col-md-8">{{$datas->emp_name}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Employee ID</div>
                    <div class="col-lg-9 col-md-8">{{$datas->emp_code}}</div>
                  </div>
                  @endif

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Department</div>
                    <div class="col-lg-9 col-md-8">{{$datas->department}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Branch Code</div>
                    <div class="col-lg-9 col-md-8">{{$datas->branch_code}}</div>
                  </div>


                  <h5 class="card-title" style="font-size: 15px; color:blue;">Asset Infomation</h5>

                  @foreach ($addassets as $addasset)
                  <div class="row">
                    <div class="col-lg-3 col-md-4">Asset Type</div>
                    <div class="col-lg-9 col-md-8">{{$addasset->assettype}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Asset Code</div>
                    <div class="col-lg-9 col-md-8">{{$addasset->assetcode}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Asset Name</div>
                    <div class="col-lg-9 col-md-8">{{$addasset->assetname}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Operator</div>
                    <div class="col-lg-9 col-md-8">{{$addasset->operator}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Phone No:</div>
                    <div class="col-lg-9 col-md-8">{{$addasset->ph}}</div>
                  </div>
                  <hr>
                  @endforeach

                    <hr>
                  <div class="row small fst-italic">
                    @foreach ($files as $file)
                    <div class="col-lg-3 col-md-3">

                        <a href="" data-bs-toggle="modal" data-bs-target="#viewUpload{{ $file->id }}">
                        <img src="{{asset('storage/asset_upload/'.$file->file)}}" alt="asset images" class="img-fluid" style="width: 200px;"></a>
                        <div class="modal fade" id="viewUpload{{ $file->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-body">
                                    <img src="{{asset('storage/asset_upload/'.$file->file)}}" alt="asset images" class="img-fluid" style="width: 600px;">
                                </div>
                                <div class="modal-footer">
                                    {{-- <a href="{{asset('storage/asset_upload/'.$file->file)}}" target="_blank"  class="btn btn-primary">Download</a> --}}
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                      <!-- Custom Styled Validation -->
      <div class="row">
        <div class="col-lg-12">
          <div class="card"  style="margin-bottom: 5px;border:1px solid lightgray;padding:10px;border-radius:30px;">
            <div class="card-body" style="padding:20px;">
                  <form action="{{route('laptop_asset_code.update',$datas->id)}}" class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
                  @METHOD('PUT')
                  @csrf
                  <div class="row g-3">
                    <div class="card" style="background-image: url('https://png.pngtree.com/thumb_back/fh260/background/20230114/pngtree-blue-background-light-mobile-wallpaper-stock-photo-free-image_1539073.jpg');">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                          @if($datas->file==null)
                          <img src="{{asset('assets/img/acc.png')}}" alt="Profile" class="rounded-circle">
                          @else
                          <img src="{{asset('storage/emp_profile/'.$datas->file)}}" alt="Profile" class="rounded-circle">
                          @endif
                          <h2 style="color:#fff;text-shadow:1px 2px 3px #000;">{{$datas->emp_name}}</h2>
                          <h3 style="color:#fff;text-shadow:1px 2px 3px #000;">{{$datas->department}}</h3>

                        </div>
                      </div>

                    <div class="col-md-4 col-lg-4">
                      <input type="hidden" class="form-control"  name="userid" value="1">
                      <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;color:blue;">Employee Information</label><br>

                      <div class="row">
                      <div class="col-md-6">
                      <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">Document No</label>
                      <input type="text" class="form-control" id="validationCustom01" name="doc_no"  value="{{$datas->doc_no}}" style="box-shadow:1px 1px 1px #333;" readonly>
                      </div>
                      <div class="col-md-6">
                      <label for="validationCustom03" class="form-label card-title" style="font-size: 15px;">De/Emp</label>
                      <select class="form-control" name="type" style="box-shadow:1px 1px 1px #333;" readonly>
                          <option value="{{$datas->type}}" selected>
                            @if($datas->type=='Emp')
                            By Employee
                            @else
                            By Department
                            @endif
                          </option>
                          <option value="Emp">By Employee</option>
                          <option value="Dept">By Department</option>
                      </select>
                      </div>
                      </div>


                      <label for="validationCustom02" class="form-label card-title" style="font-size: 15px;">Employee ID</label>
                      <input type="text" class="form-control" id="empID" name="empcode" value="{{$datas->emp_code}}" style="box-shadow:1px 1px 1px #333;" readonly>

                      <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">Employee name</label>
                      <input type="text" class="form-control" id="employee_name" name="empname"  value="{{$datas->emp_name}}" style="box-shadow:1px 1px 1px #333;" readonly>

                      <label for="validationCustom03" class="form-label card-title" style="font-size: 15px;">Branch Code</label>
                      <select class="form-control" id="branchescode" name="branchcode" readonly>
                          <option value="{{$datas->branch_code}}">{{$datas->branch_code}}</option>
                            @foreach($branches as $branch)
                            <option value="{{$branch->branch_code}}">{{$branch->branch_code}}</option>
                            @endforeach
                      </select>
                      <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        Please enter your branch code.
                      </div><br>

                      <label for="validationCustom03" class="form-label card-title" style="font-size: 15px;">Department</label>
                      <select class="form-control" id="department" name="department" readonly>
                          <option value="{{$datas->department}}">{{$datas->department}}</option>
                            @foreach($departments as $department)
                            <option value="{{$department->name}}">{{$department->name}}</option>
                            @endforeach
                      </select>

                      <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        Please enter your Department.
                      </div>

                      <br>

                    </div>


                      <div class="col-md-4 col-lg-4">
                      <h5 class="card-title" style="font-size: 15px; color:blue;">Asset Infomation</h5>
                      <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Receipt Date</label>
                      <input type="date" class="form-control" id="validationCustom05" value="{{$datas->receipt_date}}" name="receiptdate" style="box-shadow:1px 1px 1px #333;" readonly>
                      <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        Please select your purchase date.
                      </div>


                        <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Receipt Type</label>
                            <select class="form-select" aria-label="Default select example" name='receipttype' style="box-shadow:1px 1px 1px #333;"  readonly>
                            <option value="{{$datas->receipt_type}}" selected>{{$datas->receipt_type}}</option>
                            <option value="New">New</option>
                            <option value="Exchange">Exchange</option>
                            <option value="Transfer">Transfer</option>
                            <option value="Log">Log</option>
                            </select>

                      <label for="validationCustom06" class="form-label card-title" style="font-size: 15px;">Remark</label>
                      <textarea class="form-control" value="{{$datas->remark}}" id="validationCustom06" style="height: 100px;box-shadow:1px 1px 1px #333;" name="remark" readonly>{{$datas->remark}}</textarea>
                      <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        Please enter your remark.
                      </div>
                      <br>


                    </div>

                  <div class="col-12">
                    {{-- <button class="btn btn-primary" type="submit"> <font class="card-title" style="color:#fff;font-size: 15px;">Save</font></button> --}}
                    {{-- <button class="btn btn-warning" type="reset"> <font class="card-title" style="color:#fff;font-size: 15px;">Back</font></button> --}}
                    <hr>
                  </div>
                    <div class="col-md-12" style="font-size: 15px;font-weight: 500;color: #012970;font-family:Poppins, sans-serif;line-height:3;">


                  <h5 class="card-title" style="font-size: 15px; color:blue;">Asset Infomation</h5>

                  @foreach ($addassets as $addasset)

                  <div class="row">

                    <div class="col-lg-12 col-md-12" style="text-align:right;">
                      <a href="" data-bs-toggle="modal" data-bs-target="#delasset{{ $addasset->id }}">
                        <i class="ri-delete-bin-6-fill" style="color:red;font-size:30px;"></i></a><br>

                        <div class="modal fade" id="delasset{{ $addasset->id }}" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                  <div class="modal-body">
                                      <div class="row">
                                          <div class="col-md-12 col-12">
                                              <center>
                                                  <img
                                                      src="https://img.icons8.com/external-kmg-design-outline-color-kmg-design/52/000000/external-warning-maps-navigation-kmg-design-outline-color-kmg-design.png" />
                                                  <p style="color:#000;">Do you want to
                                                      delete?</p>
                                                  <i class="bi bi-x-circle btn btn-danger"
                                                      onclick='deleteRecordasset("{{ $addasset->id }}")'
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
                    </div>
                  </div>


                  <div class="row">
                    <div class="col-lg-3 col-md-4">Asset Type</div>
                    <div class="col-lg-9 col-md-8">{{$addasset->assettype}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Asset Code</div>
                    <div class="col-lg-9 col-md-8">{{$addasset->assetcode}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Asset Name</div>
                    <div class="col-lg-9 col-md-8">{{$addasset->assetname}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Operator</div>
                    <div class="col-lg-9 col-md-8">{{$addasset->operator}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4">Phone No:</div>
                    <div class="col-lg-9 col-md-8">{{$addasset->ph}}</div>
                  </div>
                  <hr>
                  @endforeach
                    </div>

                  </div>


              </form><!-- End Custom Styled Validation -->

              <form action="{{route('asset_updatestore')}}" class="needs-validation" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" value="{{ $datas->id }}" name="getID">
                <input type="hidden" value="{{ $datas->department }}" name="department">
                <input type="hidden" value="{{ $datas->branch_code }}" name="branch_code">
              <div class="col-md-12 col-lg-12">

                <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;color:blue;">Add New Asset Information</label>

                <table class="table table-borderless">
                    <thead>

                    <tr>
                        <td><label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Action</label></td>
                        <td><label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Asset Type</label></td>
                        <td><label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Asset Code</label></td>
                        <td><label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Asset Name</label></td>
                        <td id="operatorFieldf" style="display: none;"><label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Operator</label></td>
                        <td id="operatorFields" style="display: none;"><label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Phone No:</label></td>
                        <td><label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Upload</label></td>
                    </tr>


                    </thead>
                    <tbody id="rowsasset">
                        <tr>
                            <td><i class="bi bi-plus-square-fill" style="color:#1c88fc;font-size:23px;" id="addbtn"></i></td>
                            <td>
                                <select class="form-select" aria-label="Default select example" id="elementSelector" name="assettype[]" style="box-shadow:1px 1px 1px #333;">
                                    <option value="" selected>Select your asset type</option>
                                    <option value="laptop">Laptop</option>
                                    <option value="phone">Phone</option>
                                    <option value="Properties">Properties</option>
                                    <option value="Other">Other</option>
                                    </select>
                            </td>


                            <td>
                                <input type="text" class="form-control" id="assetCode" name="assetcode[]" style="box-shadow:1px 1px 1px #333;" >
                                <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                                    Please enter your asset code.
                                </div>
                            </td>

                            <td>
                                <textarea class="form-control" id="assetName" style="height: 100px;box-shadow:1px 1px 1px #333;" name="assetname[]" ></textarea>
                                <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                                        Please enter your handset asset name.
                                </div>
                            </td>

                            <td id="operatorFieldt" style="display: none;">
                                <select class="form-select" aria-label="Default select example" name="simname[]" style="box-shadow:1px 1px 1px #333;" >
                                    <option value="" selected>Select your Operator</option>
                                    <option value="ATOM">ATOM</option>
                                    <option value="Ooredoo">Ooredoo</option>
                                    <option value="MPT">MPT</option>
                                    <option value="Mytel">Mytel</option>
                                    </select>
                                <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                                    Please enter your operator.
                                </div>
                            </td>

                            <td id="operatorFieldft" style="display: none;">
                                <input type="tel" class="form-control" id="ph" placeholder="09******" style="box-shadow:1px 1px 1px #333;" name="simnumber[]" >
                                {{-- pattern="09[0-9]{9}" --}}
                            </td>

                            <td>
                                <a href="" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#uploadasset">
                                    <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;cursor: pointer;"><i class="ri-information-fill" style="font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="We can accept file types as jpg, png, gif,webp or jpeg."></i>Asset image</label>
                                    <i class="bi bi-upload" style="color:#2809f5;font-size:20px;"></i>
                                    </a>
                                    <div class="modal fade" id="uploadasset" tabindex="-1">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title">Upload Asset Images</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="drop-zone" id="dropZone">
                                                    <span class="drop-text">Drag & Drop Images Here</span>
                                                    <input type="file" id="fileInput" style="display:none;" name="file[]" multiple>
                                                </div>
                                                <div id="preview" class="image-preview"></div>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Confirm</button>
                                            </div>
                                        </div>
                                        </div>
                                    </div><!-- End Vertically centered Modal-->
                            </td>


                        </tr>
                    </tbody>
                </table>
               </div>
               <div class="col-12">
                <button class="btn btn-primary" type="submit"> <font class="card-title" style="color:#fff;font-size: 15px;">Save</font></button>
                {{-- <button class="btn btn-warning" type="reset"> <font class="card-title" style="color:#fff;font-size: 15px;">Back</font></button> --}}
                <hr>
              </div>
               </form>

              <div class="row small fst-italic">
                @foreach ($files as $file)
                <div class="col-lg-3 col-md-3">
                    <a href="" data-bs-toggle="modal" data-bs-target="#delupload{{ $file->id }}">
                        <i class="ri-delete-bin-6-fill" style="color:red;font-size:20px;"></i></a><br>

                    <a href="" data-bs-toggle="modal" data-bs-target="#viewUpload1{{ $file->id }}">

                    <img src="{{asset('storage/asset_upload/'.$file->file)}}" alt="asset images" class="img-fluid"></a>
                    <div class="modal fade" id="viewUpload1{{ $file->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-body">
                               <center><img src="{{asset('storage/asset_upload/'.$file->file)}}" alt="asset images" class="img-fluid" style="width: 600px;"></center>
                            </div>
                            <div class="modal-footer">
                                {{-- <a href="{{asset('storage/asset_upload/'.$file->file)}}" target="_blank"  class="btn btn-primary">Download</a> --}}
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>

                <div class="modal fade" id="delupload{{ $file->id }}" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <center>
                                            <img
                                                src="https://img.icons8.com/external-kmg-design-outline-color-kmg-design/52/000000/external-warning-maps-navigation-kmg-design-outline-color-kmg-design.png" />
                                            <p style="color:#000;">Do you want to
                                                delete?</p>
                                            <i class="bi bi-x-circle btn btn-danger"
                                                onclick='deleteRecordUpload("{{ $file->id }}")'
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

            </div>
              </div>
        </div>
     </div>
     <div class="col-lg-4"></div>
     </div>
          </div>

        </div>
      </div>


@endsection
@section('js')
<script>

    $(document).ready(function () {
$('#elementSelector').change(function () {
    var selectedType = $(this).val();
    if (selectedType === 'phone') {
        $('#operatorFieldf').show();
        $('#operatorFields').show();
        $('#operatorFieldt').show();
        $('#operatorFieldft').show();
    } else {
        $('#operatorFieldf').hide();
        $('#operatorFields').hide();
        $('#operatorFieldt').hide();
        $('#operatorFieldft').hide();
    }

});
});


</script>
<script>
    $(document).on('click','#removebtn',function (e){
        $(this).parent('td').parent('tr').remove();

    });

    $(document).ready(function (){

        var max_filed=10;
        var x=0;
        // if(x < max_filed){
            $('#addbtn').on('click', function() {

                    x++;
                    console.log(x);
                var wrapperasset =`
                <tr>
                    <td><i class="bi bi-dash-square-fill" style="color:red;font-size:23px;" id="removebtn"></i></td>
                    <td>
                        <select class="form-select" id="elementSelectorw${x}" aria-label="Default select example" name="assettype[]" style="box-shadow:1px 1px 1px #333;">
                            <option value="" selected>Select your asset type</option>
                            <option value="laptop">Laptop</option>
                            <option value="phone">Phone</option>
                            <option value="Properties">Properties</option>
                            <option value="Other">Other</option>
                            </select>
                    </td>

                    <td>
                        <input type="text" class="form-control" id="assetCode${x}" name="assetcode[]" style="box-shadow:1px 1px 1px #333;">
                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                            Please enter your asset code.
                        </div>
                    </td>

                    <td>
                        <textarea class="form-control" id="assetName${x}" style="height: 100px;box-shadow:1px 1px 1px #333;" name="assetname[]"></textarea>
                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                                Please enter your handset asset name.
                        </div>
                    </td>


                    <td id="operatorFieldw${x}" style="display: none;">
                                    <select class="form-select" aria-label="Default select example" name="simname[]" style="box-shadow:1px 1px 1px #333;">
                                        <option value="" selected>Select your Operator</option>
                                        <option value="ATOM">ATOM</option>
                                        <option value="Ooredoo">Ooredoo</option>
                                        <option value="MPT">MPT</option>
                                        <option value="Mytel">Mytel</option>
                                        </select>
                                    <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                                        Please enter your operator.
                                    </div>
                                </td>


                    <td id="operatorFieldp${x}" style="display: none;">
                                    <input type="tel" class="form-control" id="ph" placeholder="09*******" style="box-shadow:1px 1px 1px #333;" name="simnumber[]">

                    </td>


                    <td>
                        <a href="" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#uploadasset${x}">
                        <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;cursor: pointer;"><i class="ri-information-fill" style="font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="We can accept file types as jpg, png, gif,webp or jpeg."></i> Asset images</label>
                        <i class="bi bi-upload" style="color:#2809f5;font-size:20px;"></i>
                        </a>

                        <div class="modal fade" id="uploadasset${x}" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title">Upload Asset Images</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="drop-zone" id="dropZone${x}">
                                    <span class="drop-text">Drag & Drop Images Here</span>
                                    <input type="file" id="fileInput${x}" style="display:none;" name="file[]" multiple>
                                </div>
                                <div id="preview${x}" class="image-preview"></div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Confirm</button>
                            </div>
                        </div>
                        </div>
                    </div><!-- End Vertically centered Modal-->
                    </td>

                </tr>
                `;

                $('#rowsasset').append(wrapperasset);
                $(document).on('change','#elementSelectorw'+x,function(){

                    var selectedType = $(this).val();

                    if (selectedType === 'phone') {
                        $('#operatorFieldw'+x).show();
                    } else {
                        $('#operatorFieldw'+x).hide();
                    }

                        if (selectedType === 'phone') {
                            $('#operatorFieldp'+x).show();
                        } else {
                            $('#operatorFieldp'+x).hide();
                        }
                    })

//   $('#elementSelectorw'+x).change(function () {

//     var selectedType = $(this).val();



// });


  const dropZone = document.getElementById('dropZone'+x);
  const fileInput = document.getElementById('fileInput'+x);
  const preview = document.getElementById('preview'+x);


  dropZone.addEventListener('click', () => {
    fileInput.click();
  });

  dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('dragover');
  });

  dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('dragover');
  });

  dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('dragover');
    const files = e.dataTransfer.files;
    handleFiles(files);
  });

  fileInput.addEventListener('change', () => {
    const files = fileInput.files;
    handleFiles(files);
  });

  function removePreview(element) {
    element.remove();
  }

  function handleFiles(files) {
    for (const file of files) {
      const reader = new FileReader();
      const fileType = file.type;

      const removeButton = document.createElement('button');
      removeButton.innerText = 'Remove';
      removeButton.classList.add('remove-button');

      const container = document.createElement('div');
      container.classList.add('file-container');


      reader.onload = (e) => {
        if (fileType.startsWith('image/')) {
          const image = new Image();
          image.src = e.target.result;

          removeButton.addEventListener('click', () => {
            removePreview(container);
          });

          container.appendChild(removeButton);
          container.appendChild(image);
        } else if (fileType === 'application/pdf') {
          const pdfEmbed = document.createElement('embed');
          pdfEmbed.setAttribute('src', e.target.result);
          pdfEmbed.setAttribute('type', 'application/pdf');
          pdfEmbed.setAttribute('width', '400px');
          pdfEmbed.setAttribute('height', '200px');

          removeButton.addEventListener('click', () => {
            removePreview(container);
          });

          container.appendChild(removeButton);
          container.appendChild(pdfEmbed);
        }
        preview.appendChild(container);
      };

      reader.readAsDataURL(file);
    }
  }


  $('#assetCode'+x).on('change', function () {
    var assetCode = this.value;
    console.log(assetCode);
    $.ajax({
        url: "/employee_asset/search_asset_code/" + assetCode,
        type: "GET",
        data: { 'assetCode': assetCode },
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                $('#assetName'+x).val(response.data[0].fxassetdetailname);
            }
            if (response.status === 'fail') {
                Swal.fire({
                    icon: 'error',
                    title: 'Laptop asset code not found.',
                    text: 'The requested Laptop asset code could not be found.'
                });
                $('#assetCode'+x).val('');
                $('#assetName'+x).val('');

            }
        }
    });
    });


            });


        // }


    });


</script>
<script>

function deleteRecordasset(id) {
            console.log(id);
              $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/employee_asset/delete_asset_record/" + id,
                type: 'DELETE',
                data: {

                    "id": id,
                }
            });

            setTimeout(function() {
                window.location.reload(); // Reload the page on success
            }, 1000);
        }



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

    function deleteRecordUpload(id) {
            console.log(id);
              $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/employee_asset/delete_upload_record/" + id,
                type: 'DELETE',
                data: {

                    "id": id,
                }
            });

            setTimeout(function() {
                window.location.reload(); // Reload the page on success
            }, 1000);
        }

// const dropZone = document.getElementById('dropZone');
// const fileInput = document.getElementById('fileInput');
// const preview = document.getElementById('preview');

// // Trigger the file input when clicking the drop-zone
// dropZone.addEventListener('click', () => {
//     fileInput.click();
// });

// dropZone.addEventListener('dragover', (e) => {
//     e.preventDefault();
//     dropZone.classList.add('dragover');
// });

// dropZone.addEventListener('dragleave', () => {
//     dropZone.classList.remove('dragover');
// });

// dropZone.addEventListener('drop', (e) => {
//     e.preventDefault();
//     dropZone.classList.remove('dragover');
//     const files = e.dataTransfer.files;
//     handleFiles(files);
// });

// fileInput.addEventListener('change', () => {
//     const files = fileInput.files;
//     handleFiles(files);
// });

// function handleFiles(files) {
//     for (const file of files) {
//         if (file.type.startsWith('image/')) {
//             const reader = new FileReader();

//             reader.onload = (e) => {
//                 const imageContainer = document.createElement('div');
//                 imageContainer.classList.add('image-container');

//                 const image = new Image();
//                 image.src = e.target.result;

//                 const removeButton = document.createElement('button');
//                 removeButton.innerText = 'Remove';
//                 removeButton.classList.add('remove-button');
//                 removeButton.addEventListener('click', () => {
//                     imageContainer.remove();
//                 });

//                 imageContainer.appendChild(removeButton);
//                 imageContainer.appendChild(image);

//                 preview.appendChild(imageContainer);
//             };

//             reader.readAsDataURL(file);
//         }
//     }
// }


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
    width: '100%'
});



$('#branchescode').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your Sale branch code',
    width: '100%'
});

$('#department').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your Sale branch code',
    width: '100%'
});

});


// Get the radio buttons and the text input field
const radioButtons = document.querySelectorAll('input[type="radio"]');
const textInput = document.getElementById('textInput');

// Add event listeners to the radio buttons
radioButtons.forEach(radioButton => {
    radioButton.addEventListener('change', function() {
        // Update the value of the text input based on the selected radio button
        if (this.checked) {
            textInput.value = this.value;
        }
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
<script>
    $(document).ready(function () {
    $('#assetCode').on('change', function () {

        var assetCode = this.value;
        console.log(assetCode);
        $.ajax({
            url: "/employee_asset/search_asset_code/" + assetCode,
            type: "GET",
            data: { 'assetCode': assetCode },
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    $('#assetName').val(response.data[0].fxassetdetailname);
                }
                if (response.status === 'fail') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Laptop asset code not found.',
                        text: 'The requested Laptop asset code could not be found.'
                    });
                    $('#assetCode').val('');
                    $('#assetName').val('');

                }
            }
        });
    });
});
</script>
<script>
    const dropZone = document.getElementById('dropZone');
      const fileInput = document.getElementById('fileInput');
      const preview = document.getElementById('preview');

      dropZone.addEventListener('click', () => {
        fileInput.click();
      });

      dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('dragover');
      });

      dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('dragover');
      });

      dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        const files = e.dataTransfer.files;
        handleFiles(files);
      });

      fileInput.addEventListener('change', () => {
        const files = fileInput.files;
        handleFiles(files);
      });

      function removePreview(element) {
        element.remove();
      }

      function handleFiles(files) {
        for (const file of files) {
          const reader = new FileReader();
          const fileType = file.type;

          const removeButton = document.createElement('button');
          removeButton.innerText = 'Remove';
          removeButton.classList.add('remove-button');

          const container = document.createElement('div');
          container.classList.add('file-container');


          reader.onload = (e) => {
            if (fileType.startsWith('image/')) {
              const image = new Image();
              image.src = e.target.result;

              removeButton.addEventListener('click', () => {
                removePreview(container);
              });

              container.appendChild(removeButton);
              container.appendChild(image);
            } else if (fileType === 'application/pdf') {
              const pdfEmbed = document.createElement('embed');
              pdfEmbed.setAttribute('src', e.target.result);
              pdfEmbed.setAttribute('type', 'application/pdf');
              pdfEmbed.setAttribute('width', '400px');
              pdfEmbed.setAttribute('height', '200px');

              removeButton.addEventListener('click', () => {
                removePreview(container);
              });

              container.appendChild(removeButton);
              container.appendChild(pdfEmbed);
            }
            preview.appendChild(container);
          };

          reader.readAsDataURL(file);
        }
      }
    </script>
@endsection
