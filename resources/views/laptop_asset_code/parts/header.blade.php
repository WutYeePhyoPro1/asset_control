  <style>
    .asset-global-search {
      flex: 1;
      max-width: 460px;
      margin: 0 24px;
    }

    .asset-global-search-form {
      display: flex;
      align-items: center;
      gap: 9px;
      height: 40px;
      padding: 0 6px 0 14px;
      background: #f7f9fc;
      border: 1px solid #d8e1ed;
      border-radius: 10px;
      transition: border-color .18s ease, box-shadow .18s ease;
    }

    .asset-global-search-form:focus-within {
      border-color: #a78bfa;
      box-shadow: 0 0 0 3px rgba(109, 40, 217, .12);
    }

    .asset-global-search-form > i {
      color: #64748b;
      font-size: 16px;
    }

    .asset-global-search-form input {
      min-width: 0;
      flex: 1;
      padding: 0;
      color: #172554;
      font-size: 13px;
      font-weight: 700;
      background: transparent;
      border: 0;
      outline: 0;
    }

    .asset-global-search-form input::placeholder {
      color: #94a3b8;
      font-weight: 600;
    }

    .asset-global-search-form button {
      height: 30px;
      padding: 0 13px;
      color: #fff;
      font-size: 12px;
      font-weight: 800;
      background: #6d28d9;
      border: 0;
      border-radius: 7px;
    }

    .asset-global-search-form button:hover {
      background: #5b21b6;
    }

    @media (max-width: 767.98px) {
      .asset-global-search {
        max-width: none;
        margin: 0 10px;
      }

      .asset-global-search-form button {
        width: 30px;
        padding: 0;
        overflow: hidden;
        font-size: 0;
      }

      .asset-global-search-form button::after {
        content: "\f52a";
        font-family: "bootstrap-icons";
        font-size: 14px;
      }
    }

    .asset-global-alert {
      position: fixed;
      top: 76px;
      right: 24px;
      z-index: 1100;
      max-width: min(420px, calc(100vw - 32px));
      box-shadow: 0 10px 24px rgba(15, 23, 42, .14);
    }

    .asset-notification-link {
      position: relative;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      color: #172554;
      font-size: 21px;
      border-radius: 50%;
    }

    .asset-notification-link:hover,
    .asset-notification-link:focus {
      color: #6d28d9;
      background: #f3e8ff;
    }

    .asset-notification-badge {
      position: absolute;
      top: 1px;
      right: 0;
      min-width: 18px;
      height: 18px;
      padding: 1px 5px;
      color: #fff;
      font-size: 10px;
      line-height: 16px;
      text-align: center;
      background: #dc2626;
      border: 2px solid #fff;
      border-radius: 999px;
    }

    .asset-notification-menu {
      width: 360px;
      max-width: calc(100vw - 24px);
      max-height: min(70vh, 560px);
      padding: 0;
      overflow-x: hidden;
      overflow-y: auto;
      scrollbar-width: thin;
      scrollbar-color: #c4b5fd transparent;
    }

    .asset-notification-menu::-webkit-scrollbar {
      width: 6px;
    }

    .asset-notification-menu::-webkit-scrollbar-thumb {
      background: #c4b5fd;
      border-radius: 999px;
    }

    .asset-notification-menu .notification-heading {
      padding: 14px 16px;
      color: #172554;
      font-weight: 800;
      border-bottom: 1px solid #e2e8f0;
    }

    .asset-notification-menu .notification-item {
      display: block;
      padding: 12px 16px;
      color: #334155;
      white-space: normal;
      border-bottom: 1px solid #f1f5f9;
    }

    .asset-notification-menu .notification-item:hover {
      background: #f8fafc;
    }

    .asset-notification-menu .notification-item strong {
      color: #6d28d9;
    }
  </style>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between pb-6">
      <a href="{{route('home')}}" class="logo d-flex align-items-center">
        <img src="{{asset('assets/img/logo.png')}}" alt="" class="img-fluid">
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
      {{-- <p style="padding-left:100px;">Asset Control System</p> --}}
    </div><!-- End Logo -->

    <div class="asset-global-search">
      <form class="asset-global-search-form" method="GET" action="{{ route('asset.global-search') }}">
        <i class="bi bi-search"></i>
        <input type="search" name="asset_code" value="{{ request('asset_code') }}"
          placeholder="Search asset code..." autocomplete="off" aria-label="Search asset code">
        <button type="submit">Search</button>
      </form>
    </div>
    <!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        @php
          $notificationAssetsQuery = \App\Models\FixAsset::query()
              ->whereRaw('LOWER(status) = ?', ['sold']);

          if (Auth::user()->type !== 'Manager') {
              $notificationAssetsQuery->where('branch_code', Auth::user()->getBranch?->branch_code);
          }

          $notificationAssets = $notificationAssetsQuery
              ->orderByDesc('updated_at')
              ->get();

          $notificationPhones = \App\Models\Operator::query()
              ->whereIn('asset_code', $notificationAssets->pluck('asset_code'))
              ->whereNotNull('phone')
              ->whereRaw("TRIM(phone) <> ''")
              ->whereRaw('TRIM(phone) NOT IN (?, ?, ?, ?, ?)', ['-', '--', 'N/A', 'n/a', "'"])
              ->orderByDesc('id')
              ->get()
              ->groupBy('asset_code');

          $assetNotifications = $notificationAssets
              ->filter(fn ($asset) => $notificationPhones->has($asset->asset_code))
              ->values();
        @endphp

        <li class="nav-item dropdown me-3">
          <a class="asset-notification-link" href="#" data-bs-toggle="dropdown" aria-expanded="false"
             aria-label="Asset notifications">
            <i class="bi bi-bell"></i>
            @if ($assetNotifications->count())
              <span class="asset-notification-badge">{{ $assetNotifications->count() > 99 ? '99+' : $assetNotifications->count() }}</span>
            @endif
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow asset-notification-menu">
            <li class="notification-heading">
              Sold assets with phone numbers
              <span class="badge bg-danger float-end">{{ $assetNotifications->count() }}</span>
            </li>
            @forelse ($assetNotifications as $notification)
              @php
                $notificationPhone = $notificationPhones->get($notification->asset_code)->first()->phone;
              @endphp
              <li>
                <a class="notification-item" href="{{ route('detail_fixasset', $notification->asset_code) }}">
                  <strong>{{ $notification->asset_code }}</strong><br>
                  <small>{{ $notification->asset_name }}</small><br>
                  <small><i class="bi bi-telephone me-1"></i>{{ $notificationPhone }}</small>
                </a>
              </li>
            @empty
              <li class="p-3 text-muted">No sold asset notifications.</li>
            @endforelse
          </ul>
        </li>

        <li class="nav-item dropdown pe-5 me-5">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            @php
              $profilePath = Auth::user()->profile ? 'profile/' . Auth::user()->profile : null;
              $hasProfile = $profilePath && \Illuminate\Support\Facades\Storage::disk('public')->exists($profilePath);
            @endphp
            <img src="{{ $hasProfile ? asset('storage/' . $profilePath) : asset('assets/img/default-profile.svg') }}" alt="Profile" class="rounded-circle">
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

  @if (session('error'))
    <div class="alert alert-warning alert-dismissible fade show asset-global-alert" role="alert">
      <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

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

      @if(Auth::user()->type=='Manager')
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
