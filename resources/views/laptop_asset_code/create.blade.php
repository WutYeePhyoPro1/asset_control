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

            <h5 class="card-title">Create New Asset</h5>


        <div class="tab-content pt-2" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <!-- Custom Styled Validation -->
              <div class="row">
        <div class="col-lg-12">
          <div class="card"  style="margin-bottom: 5px;border:1px solid lightgray;padding:10px;border-radius:30px;">
            <div class="card-body" style="padding:20px;">
                <form action="{{route('laptop_asset_code.store')}}" class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                <div class="row">
                  <div class="row">

                    <div class="form-check col-md-2 col-lg-2">
                        <font style="font-size: 15px;font-weight: 500;color: #f10b0b;font-family: Poppins, sans-serif;"> *</font>
                      <input class="form-check-input" type="radio" name="type" id="gridRadios1" value="Emp" required>
                      <label class="form-check-label" for="gridRadios1" style="font-size: 15px;font-weight: 500;color: #012970;font-family: Poppins, sans-serif;">
                       By Employee
                      </label>
                      <p class="invalid-feedback card-title" style="color:red;font-size:12px;">
                        Please choose your employee or department.
                        </p>
                    </div>
                    <div class="form-check col-md-2 col-lg-2">
                      <font style="font-size: 15px;font-weight: 500;color: #f10b0b;font-family: Poppins, sans-serif;"> *</font>
                      <input class="form-check-input" type="radio" name="type" id="gridRadios2" value="Dept" required>
                      <label class="form-check-label" for="gridRadios2" style="font-size: 15px;font-weight: 500;color: #012970;font-family: Poppins, sans-serif;">
                        By Department
                      </label>
                    </div>

                  </div><br><br><hr>

                    <div class="col-md-4 col-lg-4">
                    <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;color:blue;">Employee Information</label>
                    <input type="hidden" class="form-control"  name="userid" value="{{Auth::user()->id}}">
                    <input type="hidden" class="form-control" name="date" style="border:1px solid #2809f5;"   value="<?php echo date('Y-m-d'); ?>">

                    <div id="employeeFields">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                        <label for="empID" class="form-label card-title" style="font-size: 15px;">Employee ID <font style="font-size: 15px;font-weight: 500;color: #f10b0b;font-family: Poppins, sans-serif;"> *</font></label>
                        <input type="text" class="form-control" id="empID" name="empcode" style="box-shadow:1px 1px 1px #333;" required>
                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                            Please enter your employee ID.
                        </div>
                        </div>
                      </div>
                     <div class="row mb-2">
                        <div class="col-sm-12">
                        <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;">Employee name <font style="font-size: 15px;font-weight: 500;color: #f10b0b;font-family: Poppins, sans-serif;"> *</font></label>
                        <input type="text" class="form-control" id="employee_name" name="empname"  style="box-shadow:1px 1px 1px #333;" required>
                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                            Please enter your employee name.
                        </div>
                        </div>
                      </div>
                    </div>

                      <div class="row mb-2">
                            <div class="col-sm-12">
                            <label for="validationCustom03" class="form-label card-title" style="font-size: 15px;">Branch <font style="font-size: 15px;font-weight: 500;color: #f10b0b;font-family: Poppins, sans-serif;"> *</font></label>
                            <select class="form-select" id="branchescode" name="branchcode" required>
                                    <option value="">Select Your Branch</option>
                                    @foreach($branches as $branch)
                                    <option value="{{$branch->branch_code}}({{$branch->branch_name}})">{{$branch->branch_code}} ({{$branch->branch_name}})</option>
                                    @endforeach
                            </select>
                            <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                                Please enter your branch code.
                            </div>
                            </div>
                      </div>

                      <input type="hidden" class="form-control" id="branches" name="branchname"  style="box-shadow:1px 1px 1px #333;">

                      <div class="row mb-2">
                        <div class="col-sm-12">
                        <label for="validationCustom03" class="form-label card-title" style="font-size: 15px;">Department <font style="font-size: 15px;font-weight: 500;color: #f10b0b;font-family: Poppins, sans-serif;"> *</font></label>
                        <select class="form-select" aria-label="Default select example" id="department" name="department" required>
                            <option value="">Select Your Department</option>

                                @foreach($departments as $department)
                                <option value="{{$department->name}}">{{$department->name}}</option>
                                @endforeach
                        </select>
                        <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                            Please enter your Department.
                        </div>
                        </div>
                      </div>

                      <div class="row g-3">
                        <div class="col-md-12 col-lg-">

                        </div>
                     </div>

                    </div>


                   <div class="col-md-8 col-lg-8">

                    <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;color:blue;">Receipt Information</label>
                    <div class="row mb-2">
                          <div class="col-sm-6">
                          <label for="validationCustom05" class="form-label card-title" style="font-size: 15px;">Receipt Date <font style="font-size: 15px;font-weight: 500;color: #f10b0b;font-family: Poppins, sans-serif;"> *</font></label>
                          <input type="date" class="form-control" id="validationCustom05" name="receiptdate" style="box-shadow:1px 1px 1px #333;" required>
                          <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                              Please select your receipt date.
                          </div>
                          </div>
                    </div>

                  <input type="hidden"  name="receipttype" value="-">

                  <div class="row mb-2">
                  <div class="col-sm-6">
                    <label for="validationCustom06" class="form-label card-title" style="font-size: 15px;">Remark <font style="font-size: 15px;font-weight: 500;color: #f10b0b;font-family: Poppins, sans-serif;"> *</font></label>
                    <textarea class="form-control" id="validationCustom06" style="height: 100px;box-shadow:1px 1px 1px #333;" name="remark" required></textarea>
                    <div class="invalid-feedback card-title" style="color:red;font-size:12px;">
                      Please enter your remark.
                    </div>
                  </div>
                  </div>
                   </div>


                   <div class="col-md-12 col-lg-12">

                    <label for="validationCustom01" class="form-label card-title" style="font-size: 15px;color:blue;">Asset Information</label>

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
                    <hr>

                   </div>


                  </div>

                  <div class="col-12">
                    <button class="btn btn-primary" type="submit"> <font class="card-title" style="color:#fff;font-size: 15px;">Save</font></button>
                    <button class="btn btn-warning" type="reset"> <font class="card-title" style="color:#fff;font-size: 15px;">Cancel</font></button>
                  </div>

              </div>


            </form>
        </div>
     </div>
     <div class="col-lg-4"></div>
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

    // if (selectedType === 'phone') {
    //     $('#operatorField1').show();
    // } else {
    //     $('#operatorField1').hide();
    // }

    // if (selectedType === 'phone') {
    //     $('#operatorField2').show();
    // } else {
    //     $('#operatorField2').hide();
    // }

    // if (selectedType === 'phone') {
    //     $('#operatorField3').show();
    // } else {
    //     $('#operatorField3').hide();
    // }


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

// $('#branches').select2({
//     theme       : 'bootstrap-5',
//     placeholder : 'Choose Your  branch',
//     width: '100%'
// });

$('#branches1').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your  branch',
    width: '100%'
});

$('#branchescode').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your branch code',
    width: '100%'
});

$('#department').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your department',
    width: '100%'

});

$('#department1').select2({
    theme       : 'bootstrap-5',
    placeholder : 'Choose Your department',
    width: '100%'
});

});

// document.addEventListener("DOMContentLoaded", function() {
//     const elementSelector = document.getElementById('elementSelector');
//     const laptopContent = document.getElementById('laptop');
//     const phoneContent = document.getElementById('phone');
//     const laptopphone = document.getElementById('laptopphone');
//     const ph = document.getElementById('ph');
//     // Set initial state: Hide phone content and disable required
//     phoneContent.style.display = 'none';
//     phoneContent.querySelectorAll('input, textarea').forEach((el) => {
//         el.required = false;
//     });

//     // Add a change event listener to the "select" element
//     elementSelector.addEventListener('change', function () {
//         // Get the selected value
//         const selectedValue = elementSelector.value;

//         // Show/hide content based on the selection
//         if (selectedValue === 'laptop') {
//             if(ph.hasAttribute('pattern')){
//                 ph.removeAttribute('pattern');
//             }
//             laptopContent.style.display = 'block';
//             phoneContent.style.display = 'none';
//             laptopContent.querySelectorAll('input, textarea').forEach((el) => {
//                 el.required = true;
//             });
//             phoneContent.querySelectorAll('input, textarea,select').forEach((el) => {
//                 el.required = false;
//             });
//         } else if (selectedValue === 'phone') {
//             // if(!ph.hasAttribute('pattern')){
//             //     ph.addAttribute('pattern','09[0-9]{9}');
//             // }
//             laptopContent.style.display = 'none';
//             phoneContent.style.display = 'block';
//             laptopContent.querySelectorAll('input, textarea').forEach((el) => {
//                 el.required = false;
//             });
//             phoneContent.querySelectorAll('input, textarea,select,tel').forEach((el) => {
//                 el.required = true;
//             });
//         }else if (selectedValue === 'lp') {
//             laptopContent.style.display = 'block';
//             phoneContent.style.display = 'block';
//             laptopContent.querySelectorAll('input, textarea,select,tel').forEach((el) => {
//                 el.required = true;
//             });
//             phoneContent.querySelectorAll('input, textarea,select,tel').forEach((el) => {
//                 el.required = true;
//             });
//         }
//     });
// });


document.addEventListener("DOMContentLoaded", function () {
    const gridRadios1 = document.getElementById('gridRadios1');
    const gridRadios2 = document.getElementById('gridRadios2');
    const employeeFields = document.getElementById('employeeFields');
    // const departmentFields = document.getElementById('departmentFields');
    const employeeId = document.getElementById('employeeid');
    const empployeeId = document.getElementById('departmentName');

    // Function to enable required attribute
    function enableRequiredFields() {
        employeeFields.style.display = 'block';
        // departmentFields.style.display = 'none';
        // employeeFields.required = true;
        employeeFields.querySelectorAll('input, textarea').forEach((el) => {
        el.required = true;
    });
        // departmentName.required = false;
    }

    // Function to disable required attribute
    function disableRequiredFields() {
        employeeFields.style.display = 'none';
        // departmentFields.style.display = 'block';
        employeeFields.querySelectorAll('input, textarea').forEach((el) => {
        el.required = false;
    });
    }

    // Initialize the form based on the default radio button


    // if (gridRadios1.checked) {
    //   alert('hi');
    //     // enableRequiredFields();
    // } else if (gridRadios2.checked) {
    //     disableRequiredFields();
    // }

    // Add event listeners to the radio buttons
    gridRadios1.addEventListener('change', function () {
        enableRequiredFields();
    });

    gridRadios2.addEventListener('change', function () {
        disableRequiredFields();
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


$(document).ready(function () {
    $('#assetCode2').on('change', function () {

        var assetCode2 = this.value;
        console.log(assetCode2);
        $.ajax({
            url: "/employee_asset/search_asset_code2/" + assetCode2,
            type: "GET",
            data: { 'assetCode2': assetCode2 },
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    $('#assetName2').val(response.data[0].fxassetdetailname);
                }
                if (response.status === 'fail') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Phone asset code not found.',
                        text: 'The requested Phone asset code could not be found.'
                    });
                    $('#assetCode2').val('');
                    $('#assetName2').val('');

                }
            }
        });
    });
});

</script>
@endsection
