<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pro 1 Global Home Center</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
  <style>
    body{
        /* background:url('assets/img/bglogin.png'); */
        background:url('assets/img/bglogin.png');
        background-position: fix;
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: fixed;

    }
</style>

</head>

<body>

  <main>
    <div class="container">
        @if(session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">

              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                  <center>
                <img src="{{asset('assets/img/logo.png')}}" alt="Pro 1 Global Home Center" class="img-fluid" style="width:100px;margin:10px;"></center>
                    <h5 class="card-title text-center pb-0 fs-4" style="font-size: 18px; font-weight: 500; color: #012970; font-family: Poppins, sans-serif;">Asset Control System</h5>
                    <p class="text-center small" style="font-size: 13px; font-weight: 500; color: #012970; font-family: Poppins, sans-serif;">Login to Your Account</p>
                  </div>

                  <form action="{{ route('login') }}" method="post" class="row g-3 needs-validation" novalidate id="loginForm">
                  @csrf
                    <div class="col-12">
                      <label for="yourUsername" class="form-label" style="font-size: 15px; font-weight: 500; color: #012970; font-family: Poppins, sans-serif;">Employee Number</label>
                      <div class="input-group has-validation">
                        <input type="text" name="emp_code" class="form-control @error('emp_code') is-invalid @enderror" value="{{ $employee_id }}" id="yourempID" autocomplete="emp_code" autofocus required>
                        @error('emp_code')
                        <div class="invalid-feedback">Please check your employee ID.</div>
                        @enderror
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label" style="font-size: 15px; font-weight: 500; color: #012970; font-family: Poppins, sans-serif;">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" value="{{ $password }}" required>
                      @error('password')
                        <div class="invalid-feedback">Please check your password.</div>
                        @enderror
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe" style="font-size: 15px; font-weight: 500; color: #012970; font-family: Poppins, sans-serif;">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" style="font-size: 15px; font-weight: 500; color: #fff; font-family: Poppins, sans-serif;">Login</button>
                    </div>

                  </form>

                </div>
              </div>

              <div class="credits">

              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('assets/vendor/quill/quill.min.js')}}"></script>
  <script src="{{asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('assets/js/main.js')}}"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function () {
        $('#loginForm').submit();
    });
</script>

</body>

</html>
