  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="{{asset('assets/img/logo.png')}}" alt="" class="img-fluid">

      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
      {{-- <p style="padding-left:100px;">Asset Control System</p> --}}
    </div><!-- End Logo -->

    <!-- <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div> -->
    <!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            @if(Auth::user()->profile!=null)
            <img src="{{asset('storage/profile/'.Auth::user()->profile)}}" alt="Profile" class="rounded-circle">
            @else
            @endif
            <span class="d-none d-md-block dropdown-toggle ps-2">
              {{Auth::user()->name}}
            </span>

          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{Auth::user()->name}}</h6>

              {{Auth::user()->emp_code}}
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="">
                <i class="bi bi-person"></i>
                <span>{{Auth::user()->department}}</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{route('all_user.show',Auth::user()->id)}}">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="">
                <i class="bi bi-question-circle"></i>
                <span>{{Auth::user()->type}}</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>


            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('home')}}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        {{-- <a class="nav-link collapsed" href="{{route('laptop_asset_code.index')}}">
          <i class="bi bi-menu-button-wide"></i><span>Asset Control</span>
        </a> --}}

        <a class="nav-link collapsed" href="{{route('laptop_asset_code.fix_asset')}}">
            <i class="bi bi-menu-button-wide"></i><span>Fix Asset</span>
        </a>
        {{-- <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('laptop_asset_code.index')}}">
              <i class="bi bi-circle"></i><span>Laptop Asset Code</span>
            </a>
          </li>
          <li>
            <a href="{{route('laptop_asset_code.create')}}">
              <i class="bi bi-circle"></i><span>Add New</span>
            </a>
          </li>

        </ul> --}}
        <a class="nav-link collapsed" href="{{route('laptop_asset_code.nonasset_operator')}}">
            <i class="bi bi-menu-button-wide"></i><span>Non Asset Code Operator</span>
        </a>
      </li><!-- End Components Nav -->

      @if(Auth::user()->type=='superadmin')
      <li class="nav-heading"><hr></li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('all_user.index')}}">
          <i class="bi bi-card-list"></i>
          <span>Register</span>
        </a>
      </li><!-- End Register Page Nav -->
      @else

    @endif
    </ul>

  </aside><!-- End Sidebar-->
