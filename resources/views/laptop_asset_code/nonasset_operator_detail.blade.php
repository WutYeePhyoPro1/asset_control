@extends('laptop_asset_code.layouts.master')
@section('content')
    <style>
        .nonasset-detail {
            --detail-primary: #1d4ed8;
            --detail-ink: #172554;
            --detail-muted: #64748b;
            font-family: "Nunito", sans-serif;
        }

        .nonasset-detail .detail-shell {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 12px 32px rgba(15, 23, 42, .08);
            overflow: hidden;
        }

        .nonasset-detail .detail-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0;
            padding: 24px 28px;
            color: var(--detail-ink);
            font-size: 20px;
            font-weight: 700;
            border-bottom: 1px solid #e9eef7;
        }

        .nonasset-detail .detail-heading i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            color: var(--detail-primary);
            font-size: 18px;
            background: #eff6ff;
            border-radius: 11px;
        }

        .nonasset-detail .detail-body {
            padding: 28px;
        }

        .nonasset-detail .profile-card {
            height: 100%;
            margin: 0;
            background: linear-gradient(180deg, #f8fbff 0%, #fff 100%);
            border: 1px solid #dfe7f3;
            border-radius: 14px;
            box-shadow: none;
        }

        .nonasset-detail .profile-card .card-body {
            padding: 6px 22px;
        }

        .nonasset-detail .profile-item {
            padding: 19px 0;
            border-bottom: 1px solid #e5eaf2;
        }

        .nonasset-detail .profile-item:last-child {
            border-bottom: 0;
        }

        .nonasset-detail .profile-label {
            display: block;
            margin-bottom: 6px;
            color: var(--detail-muted);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .nonasset-detail .profile-value {
            color: var(--detail-ink);
            font-size: 15px;
            font-weight: 600;
            word-break: break-word;
        }

        .nonasset-detail .content-panel {
            height: 100%;
            padding: 0;
        }

        .nonasset-detail .nonasset-hero-card {
            display: flex;
            align-items: center;
            gap: 20px;
            margin: 0 0 14px;
            padding: 22px 24px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-top: 4px solid #2563eb;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(15, 23, 42, .05);
        }

        .nonasset-detail .nonasset-hero-icon {
            display: inline-flex;
            flex: 0 0 82px;
            align-items: center;
            justify-content: center;
            width: 82px;
            height: 82px;
            color: #2563eb;
            font-size: 34px;
            background: linear-gradient(145deg, #eff6ff, #dbeafe);
            border: 1px solid #bfdbfe;
            border-radius: 16px;
        }

        .nonasset-detail .nonasset-hero-content {
            min-width: 0;
            flex: 1;
        }

        .nonasset-detail .nonasset-hero-title {
            margin: 0 0 6px;
            color: #0f172a;
            font-size: 20px;
            font-weight: 800;
        }

        .nonasset-detail .nonasset-hero-subtitle {
            margin: 0;
            color: #64748b;
            font-size: 14px;
            font-weight: 700;
        }

        .nonasset-detail .nonasset-assignment-card {
            margin-bottom: 26px;
            overflow: hidden;
            background: linear-gradient(105deg, #d1fae5 0%, #f0fdf4 100%);
            border: 1px solid #10b981;
            border-radius: 14px;
        }

        .nonasset-detail .assignment-heading {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 16px 22px 10px;
            color: #047857;
            font-size: 14px;
            font-weight: 800;
        }

        .nonasset-detail .nonasset-assignment-grid {
            display: grid;
            grid-template-columns: 1.5fr repeat(4, 1fr);
            padding: 6px 18px 17px;
        }

        .nonasset-detail .assignment-detail {
            display: flex;
            align-items: center;
            gap: 11px;
            min-width: 0;
            padding: 8px 14px;
            border-right: 1px solid #bbf7d0;
        }

        .nonasset-detail .assignment-detail:last-child {
            border-right: 0;
        }

        .nonasset-detail .assignment-detail i {
            color: #047857;
            font-size: 17px;
        }

        .nonasset-detail .assignment-label {
            display: block;
            color: #64748b;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .03em;
            text-transform: uppercase;
        }

        .nonasset-detail .assignment-value {
            display: block;
            overflow: hidden;
            color: #0f172a;
            font-size: 13px;
            font-weight: 800;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .nonasset-detail .assignment-detail small {
            display: block;
            color: #64748b;
            font-size: 11px;
            font-weight: 700;
        }

        .nonasset-detail .panel-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            padding: 15px 18px;
            background: linear-gradient(120deg, #1d4ed8, #6d28d9);
            border-radius: 14px;
            box-shadow: 0 10px 22px rgba(79, 70, 229, .22);
        }

        .nonasset-detail .panel-title {
            margin: 0;
            color: var(--detail-ink);
            font-size: 16px;
            font-weight: 700;
            color: #fff;
        }

        .nonasset-detail .add-operator-btn {
            border-radius: 10px;
            font-weight: 600;
            box-shadow: 0 5px 12px rgba(29, 78, 216, .2);
            color: #1d4ed8;
            background: #fff;
            border-color: #fff;
        }

        .nonasset-detail .operator-card {
            position: relative;
            margin-bottom: 12px;
            padding: 16px 18px;
            background: linear-gradient(110deg, #fff 0%, #eff6ff 100%);
            border: 1px solid #bfdbfe;
            border-left: 4px solid #0ea5e9;
            border-radius: 12px;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .nonasset-detail .operator-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(15, 23, 42, .07);
        }

        .nonasset-detail .operator-name {
            margin: 0 0 5px;
            color: var(--detail-ink);
            font-size: 15px;
            font-weight: 700;
        }

        .nonasset-detail .operator-phone {
            color: var(--detail-muted);
            font-size: 14px;
            font-weight: 500;
        }

        .nonasset-detail .operator-actions {
            position: absolute;
            top: 14px;
            right: 16px;
            display: flex;
            gap: 10px;
        }

        .nonasset-detail .action-link {
            padding: 0;
            color: var(--detail-primary);
            font-size: 13px;
            font-weight: 600;
            background: none;
            border: 0;
            cursor: pointer;
        }

        .nonasset-detail .action-link.delete {
            color: #dc2626;
        }

        .nonasset-detail .detail-form-card {
            margin-top: 20px;
            padding: 21px;
            background: #f8fafc;
            border: 1px solid #e1e8f3;
            border-radius: 14px;
        }

        .nonasset-detail .remark-card {
            background: linear-gradient(125deg, #f5f3ff 0%, #fdf4ff 58%, #fff 100%);
            border: 1px solid #c4b5fd;
            box-shadow: 0 10px 24px rgba(124, 58, 237, .1);
        }

        .nonasset-detail .remark-card-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .nonasset-detail .remark-card-heading h6 {
            margin: 0 0 2px;
            color: #4c1d95;
            font-size: 16px;
            font-weight: 900;
        }

        .nonasset-detail .remark-card-heading small {
            color: #7c3aed;
            font-weight: 700;
        }

        .nonasset-detail .remark-card-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            color: #fff;
            font-size: 18px;
            background: linear-gradient(135deg, #7c3aed, #db2777);
            border-radius: 12px;
            box-shadow: 0 7px 14px rgba(124, 58, 237, .22);
        }

        .nonasset-detail .remark-card textarea {
            color: #312e81;
            font-weight: 650;
            background: rgba(255, 255, 255, .82);
            border-color: #c4b5fd;
        }

        .nonasset-detail .remark-card .btn-warning {
            background: linear-gradient(135deg, #7c3aed, #db2777);
            border: 0;
        }

        .nonasset-detail .asset-edit-modal {
            overflow: hidden;
            border: 0;
            border-radius: 16px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, .18);
        }

        .nonasset-detail .asset-edit-modal .modal-header {
            padding: 18px 24px;
            background: linear-gradient(135deg, #f8fbff, #f5f3ff);
            border-bottom: 1px solid #e2e8f0;
        }

        .nonasset-detail .asset-edit-modal .modal-title {
            color: #172554;
            font-size: 18px;
            font-weight: 800;
        }

        .nonasset-detail .asset-edit-modal .modal-body {
            padding: 24px;
        }

        .nonasset-detail .asset-edit-modal .modal-footer {
            padding: 16px 24px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .nonasset-detail .asset-edit-modal .field-label {
            display: block;
            margin-bottom: 9px;
            color: #172554;
            font-size: 13px;
            font-weight: 800;
        }

        .nonasset-detail .current-contract-card {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
            padding: 11px 12px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 10px;
        }

        .nonasset-detail .current-contract-card i {
            color: #2563eb;
            font-size: 17px;
        }

        .nonasset-detail .current-contract-card small {
            display: block;
            color: #64748b;
            font-size: 11px;
            font-weight: 700;
        }

        .nonasset-detail .current-contract-card strong {
            color: #1e3a8a;
            font-size: 14px;
        }

        .nonasset-detail .contract-choice-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .nonasset-detail .contract-choice {
            position: relative;
            margin: 0;
        }

        .nonasset-detail .contract-choice input {
            position: absolute;
            opacity: 0;
        }

        .nonasset-detail .contract-choice label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 43px;
            margin: 0;
            color: #475569;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            background: #fff;
            border: 1px solid #d7e0ec;
            border-radius: 9px;
            transition: .18s ease;
        }

        .nonasset-detail .contract-choice input:checked+label {
            color: #fff;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            border-color: #2563eb;
            box-shadow: 0 5px 12px rgba(37, 99, 235, .22);
        }

        .nonasset-detail .contract-choice input:focus+label {
            outline: 3px solid rgba(59, 130, 246, .2);
            outline-offset: 2px;
        }

        .nonasset-detail .field-label {
            margin-bottom: 8px;
            color: var(--detail-ink);
            font-size: 13px;
            font-weight: 700;
        }

        .nonasset-detail .detail-form-card textarea {
            min-height: 112px;
            border-color: #d7e0ec;
            box-shadow: none;
        }

        .nonasset-detail .detail-form-card textarea:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 .2rem rgba(59, 130, 246, .12);
        }

        .nonasset-detail .detail-badge {
            padding: 7px 11px;
            font-size: 13px;
            font-weight: 700;
        }

        .nonasset-detail .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 9px;
            margin-top: 18px;
        }

        .nonasset-detail .modal .form-control,
        .nonasset-detail .modal .form-select {
            min-height: 42px;
            border-color: #d7e0ec;
            border-radius: 8px;
            box-shadow: none !important;
        }

        .nonasset-detail .modal .form-control:focus,
        .nonasset-detail .modal .form-select:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 .2rem rgba(59, 130, 246, .12) !important;
        }

        /* Compact toast used only on this detail page. */
        .nonasset-detail-toast-stack {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 11000;
            display: flex;
            width: min(340px, calc(100vw - 40px));
            flex-direction: column;
            gap: 12px;
        }

        .nonasset-detail-toast {
            display: grid;
            grid-template-columns: 20px minmax(0, 1fr) 24px;
            gap: 9px;
            align-items: center;
            padding: 11px 10px;
            color: #17212b;
            font-family: "Poppins", sans-serif;
            background: #86efc0;
            border-radius: 8px;
            box-shadow: 0 8px 22px rgba(15, 23, 42, .13);
            opacity: 0;
            transform: translateX(20px);
            transition: opacity .25s ease, transform .25s ease;
        }

        .nonasset-detail-toast.is-visible { opacity: 1; transform: translateX(0); }
        .nonasset-detail-toast.is-hiding { opacity: 0; transform: translateX(20px); }
        .nonasset-detail-toast.is-error { background: #fda4af; }
        .nonasset-detail-toast-icon { font-size: 17px; line-height: 1; }

        .nonasset-detail-toast-title {
            margin: 0 0 2px;
            color: #111827;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.25;
        }

        .nonasset-detail-toast-message {
            margin: 0;
            color: #24313d;
            font-size: 11px;
            font-weight: 400;
            line-height: 1.35;
        }

        .nonasset-detail-toast-message + .nonasset-detail-toast-message { margin-top: 2px; }

        .nonasset-detail-toast-close {
            width: 24px;
            height: 24px;
            padding: 0;
            color: #42515e;
            font-size: 22px;
            line-height: 20px;
            background: transparent;
            border: 0;
            border-radius: 50%;
            cursor: pointer;
        }

        .nonasset-detail-toast-close:hover {
            color: #111827;
            background: rgba(255, 255, 255, .28);
        }

        /* Calm, unified palette for the detail page. */
        .nonasset-detail {
            --detail-primary: #3f7894;
            --detail-ink: #24445a;
            --detail-muted: #718895;
            --detail-border: #c9dfe6;
            --detail-soft: #f8fbfc;
            --detail-accent: #6b9bad;
        }

        .nonasset-detail .detail-shell,
        .nonasset-detail .profile-card,
        .nonasset-detail .nonasset-hero-card,
        .nonasset-detail .detail-form-card,
        .nonasset-detail .operator-card {
            border-color: var(--detail-border);
        }

        .nonasset-detail .detail-heading i,
        .nonasset-detail .current-contract-card {
            color: var(--detail-primary);
            background: #eef7f9;
            border-color: #c5dfe7;
        }

        .nonasset-detail .profile-card,
        .nonasset-detail .detail-form-card,
        .nonasset-detail .asset-edit-modal .modal-footer {
            background: var(--detail-soft);
        }

        .nonasset-detail .nonasset-hero-card {
            border-top-color: var(--detail-accent);
        }

        .nonasset-detail .nonasset-hero-icon {
            color: var(--detail-primary);
            background: #eef7f9;
            border-color: #c5dfe7;
        }

        .nonasset-detail .nonasset-assignment-card {
            background: #f0f8fa;
            border-color: #b8d6df;
        }

        .nonasset-detail .assignment-heading,
        .nonasset-detail .assignment-detail i {
            color: var(--detail-primary);
        }

        .nonasset-detail .assignment-detail {
            border-color: #c9dce2;
        }

        .nonasset-detail .panel-toolbar,
        .nonasset-detail .remark-card .btn-warning {
            background: #4f8aa3;
            box-shadow: 0 8px 18px rgba(63, 120, 148, .15);
        }

        .nonasset-detail .add-operator-btn,
        .nonasset-detail .operator-card {
            color: var(--detail-primary);
        }

        .nonasset-detail .operator-card {
            background: #fff;
            border-left-color: var(--detail-accent);
        }

        .nonasset-detail .remark-card {
            background: #f7fbfc;
            border-color: #c5dfe6;
            box-shadow: 0 8px 18px rgba(63, 120, 148, .07);
        }

        .nonasset-detail .remark-card-heading h6,
        .nonasset-detail .remark-card-heading small {
            color: var(--detail-primary);
        }

        .nonasset-detail .remark-card-icon,
        .nonasset-detail .contract-choice input:checked + label {
            background: #4f8aa3;
            border-color: var(--detail-primary);
            box-shadow: 0 5px 12px rgba(49, 91, 120, .16);
        }

        .nonasset-detail .remark-card textarea {
            color: var(--detail-ink);
            border-color: var(--detail-border);
        }

        .nonasset-detail .asset-edit-modal .modal-header {
            background: #eef3f5;
        }

        .nonasset-detail .detail-form-card textarea:focus,
        .nonasset-detail .modal .form-control:focus,
        .nonasset-detail .modal .form-select:focus {
            border-color: #8aa9b7;
            box-shadow: 0 0 0 .2rem rgba(95, 129, 145, .14) !important;
        }

        @media (max-width: 991.98px) {
            .nonasset-detail .content-panel {
                padding: 24px 0 0;
            }

            .nonasset-detail .detail-body {
                padding: 20px;
            }

            .nonasset-detail .nonasset-assignment-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .nonasset-detail .assignment-detail {
                border-bottom: 1px solid #bbf7d0;
            }
        }

        @media (max-width: 575.98px) {
            .nonasset-detail .detail-heading {
                padding: 18px;
                font-size: 17px;
            }

            .nonasset-detail .profile-card .card-body {
                padding: 4px 18px;
            }

            .nonasset-detail .operator-actions {
                position: static;
                margin-top: 12px;
            }

            .nonasset-detail .nonasset-hero-card {
                align-items: flex-start;
                flex-wrap: wrap;
                padding: 18px;
            }

            .nonasset-detail .nonasset-hero-icon {
                flex-basis: 58px;
                width: 58px;
                height: 58px;
                font-size: 25px;
            }

            .nonasset-detail .nonasset-hero-title {
                font-size: 17px;
            }

            .nonasset-detail .nonasset-assignment-grid {
                grid-template-columns: 1fr;
            }

            .nonasset-detail .assignment-detail {
                border-right: 0;
            }
        }

        /* Final system theme overrides */
        .nonasset-detail {
            --detail-primary: #6d28d9;
            --detail-ink: #202342;
            --detail-muted: #718096;
            --detail-border: #e3def4;
            --detail-soft: #fbfaff;
            --detail-accent: #8b5cf6;
        }

        .nonasset-detail .nonasset-hero-card {
            border-top-color: #8b5cf6 !important;
        }

        .nonasset-detail .nonasset-hero-icon,
        .nonasset-detail .remark-card-icon {
            color: #6d28d9 !important;
            background: #f1edff !important;
            border-color: #d8caff !important;
        }

        .nonasset-detail .nonasset-assignment-card {
            background: #f8f5ff !important;
            border-color: #ded4f7 !important;
        }

        .nonasset-detail .assignment-heading,
        .nonasset-detail .assignment-detail i,
        .nonasset-detail .assignment-label,
        .nonasset-detail .panel-title {
            color: #6d28d9 !important;
        }

        .nonasset-detail .employee-avatar {
            color: #6d28d9 !important;
            background: #ebe4ff !important;
        }

        .nonasset-detail .panel-toolbar {
            background: linear-gradient(135deg, #6d28d9, #8b5cf6) !important;
            box-shadow: 0 10px 22px rgba(109, 40, 217, .18) !important;
        }

        .nonasset-detail .operator-card {
            border-left-color: #8b5cf6 !important;
            background: #fff !important;
        }

        .nonasset-detail .remark-card {
            background: #fbfaff !important;
            border-color: #ded4f7 !important;
        }

        .nonasset-detail .remark-card-heading h6,
        .nonasset-detail .remark-card-heading small {
            color: #6d28d9 !important;
        }

        .nonasset-detail .add-operator-btn {
            color: #fff !important;
            background: #6d28d9 !important;
            border-color: #6d28d9 !important;
        }

        .nonasset-detail .add-operator-btn:hover,
        .nonasset-detail .add-operator-btn:focus {
            color: #fff !important;
            background: #5b21b6 !important;
            border-color: #5b21b6 !important;
        }
    </style>
    <div class="pagetitle">
        <h1>Asset Control System</h1><br>
        {{-- <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}" style="color:#000;">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{route('laptop_asset_code.index')}}" style="color:#000;">Back</a></li>
        </ol>
      </nav> --}}
    </div><!-- End Page Title -->

    @if (Session::has('success') || $errors->any())
        <div class="nonasset-detail-toast-stack" aria-live="polite" aria-atomic="true">
            @if (Session::has('success'))
                <div class="nonasset-detail-toast" role="status" data-detail-toast>
                    <i class="bi bi-check-circle nonasset-detail-toast-icon" aria-hidden="true"></i>
                    <div>
                        <h4 class="nonasset-detail-toast-title">Success</h4>
                        <p class="nonasset-detail-toast-message">{{ Session::get('success') }}</p>
                    </div>
                    <button type="button" class="nonasset-detail-toast-close" data-detail-toast-close aria-label="Close">&times;</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="nonasset-detail-toast is-error" role="alert" data-detail-toast>
                    <i class="bi bi-x-circle nonasset-detail-toast-icon" aria-hidden="true"></i>
                    <div>
                        <h4 class="nonasset-detail-toast-title">Error</h4>
                        @foreach ($errors->all() as $error)
                            <p class="nonasset-detail-toast-message">{{ $error }}</p>
                        @endforeach
                    </div>
                    <button type="button" class="nonasset-detail-toast-close" data-detail-toast-close aria-label="Close">&times;</button>
                </div>
            @endif
        </div>
    @endif
    <section class="section nonasset-detail">
        <div class="row">

            <div class="col-lg-12">
                <div class="card detail-shell">
                    <h5 class="detail-heading"><i class="bi bi-person-vcard"></i> Non Asset Code Operator Detail</h5>
                    <div class="card-body detail-body">

                        @if ($getnonRemark != null && $getnonRemark->doc_no)
                            <div class="nonasset-hero-card">
                                <span class="nonasset-hero-icon"><i class="bi bi-person-vcard"></i></span>
                                <div class="nonasset-hero-content">
                                    <h2 class="nonasset-hero-title">Non Asset Code Operator</h2>
                                    <p class="nonasset-hero-subtitle">Document No: {{ $getnonRemark->doc_no }}</p>
                                </div>
                            </div>

                            <div class="nonasset-assignment-card">
                                <div class="assignment-heading"><i class="bi bi-bookmark-check-fill"></i> Currently Assigned
                                    To</div>
                                <div class="nonasset-assignment-grid">
                                    <div class="assignment-detail">
                                        <i class="bi bi-person"></i>
                                        <div><span
                                                class="assignment-value">{{ $getnonRemark->name ?: 'Employee not recorded' }}</span><small>{{ $getnonRemark->emp_id ?: '-' }}</small>
                                        </div>
                                    </div>
                                    <div class="assignment-detail">
                                        <i class="bi bi-building"></i>
                                        <div><span class="assignment-label">Branch</span><span
                                                class="assignment-value">{{ $getnonRemark->branch ?: '-' }}</span></div>
                                    </div>
                                    <div class="assignment-detail">
                                        <i class="bi bi-briefcase"></i>
                                        <div><span class="assignment-label">Department</span><span
                                                class="assignment-value">{{ $getnonRemark->department ?: '-' }}</span></div>
                                    </div>
                                    <div class="assignment-detail">
                                        <i class="bi bi-award"></i>
                                        <div><span class="assignment-label">Position / Rank</span><span
                                                class="assignment-value">{{ $getnonRemark->rank ?: '-' }}</span></div>
                                    </div>
                                    <div class="assignment-detail">
                                        <i class="bi bi-file-earmark-check"></i>
                                        <div><span class="assignment-label">Contract</span><span
                                                class="assignment-value">{{ $getnonRemark->contract ?: '-' }}</span></div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <!-- Custom Styled Validation -->
                                <div class="row">


                                    <div class="col-lg-4 d-none">
                                        <div class="card profile-card">
                                            <div class="card-body">

                                                <div class="profile-item"><span class="profile-label">Document No.</span>
                                                    <div class="profile-value">{{ $getnonRemark->doc_no }}</div>
                                                </div>

                                                <div class="profile-item"><span class="profile-label">Branch</span>
                                                    <div class="profile-value">{{ $getnonRemark->branch }}</div>
                                                </div>

                                                <div class="profile-item"><span class="profile-label">Department</span>
                                                    <div class="profile-value">{{ $getnonRemark->department }}</div>
                                                </div>

                                                <div class="profile-item"><span class="profile-label">Rank</span>
                                                    <div class="profile-value">
                                                        @if ($getnonRemark != null && $getnonRemark->doc_no)
                                                            {{ $getnonRemark->rank }}
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="profile-item"><span class="profile-label">Employee ID</span>
                                                    <div class="profile-value">{{ $getnonRemark->emp_id }}</div>
                                                </div>

                                                <div class="profile-item"><span class="profile-label">Name</span>
                                                    <div class="profile-value">{{ $getnonRemark->name }}</div>
                                                </div>

                                                <div class="profile-item"><span class="profile-label">Remark</span>
                                                    <div class="profile-value">{{ $getnonRemark->remark ?: '—' }}</div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="content-panel">

                                            @if ($getnonRemark != null && $getnonRemark->doc_no)
                                                <div class="panel-toolbar">
                                                    <h6 class="panel-title">Phone Operators</h6><button type="button"
                                                        class="btn btn-primary btn-sm add-operator-btn"
                                                        data-bs-toggle="modal" data-bs-target="#addoperator"><i
                                                            class="bi bi-plus-lg me-1"></i>Add operator</button>
                                                </div>
                                            @endif

                                            <div class="modal fade" id="addoperator" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Add New Operator</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="float-end">
                                                                <i class="bi bi-plus-square-fill"
                                                                    style="color:#1c88fc;font-size:33px;"
                                                                    id="addbtn1"></i></a>
                                                            </div>
                                                            <form action="{{ route('operator-form-non') }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        @if ($getnonRemark != null && $getnonRemark->doc_no)
                                                                            <input type="hidden"
                                                                                class="form-control asset_code"
                                                                                name="doc_no"
                                                                                value="{{ $getnonRemark->doc_no }}">
                                                                            <input type="hidden"
                                                                                class="form-control asset_code"
                                                                                name="department"
                                                                                value="{{ $getnonRemark->department }}">
                                                                            <input type="hidden"
                                                                                class="form-control asset_code"
                                                                                name="emp_id"
                                                                                value="{{ $getnonRemark->emp_id }}">
                                                                            <input type="hidden"
                                                                                class="form-control asset_code"
                                                                                name="name"
                                                                                value="{{ $getnonRemark->name }}">

                                                                            <input type="hidden"
                                                                                class="form-control asset_code"
                                                                                name="branch"
                                                                                value="{{ $getnonRemark->branch }}">
                                                                        @endif
                                                                        <h5 class="card-title">Operator</h5>
                                                                        <select class="form-select"
                                                                            aria-label="Default select example"
                                                                            name="operator[]"
                                                                            style="box-shadow:1px 1px 1px #333;" required>
                                                                            <option value="" selected>Select your
                                                                                Operator</option>
                                                                            <option value="ATOM">ATOM</option>
                                                                            <option value="Ooredoo">Ooredoo</option>
                                                                            <option value="MPT">MPT</option>
                                                                            <option value="Mytel">Mytel</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <h5 class="card-title">Ph No:</h5>
                                                                        <input type="text" class="form-control"
                                                                            name="phone[]" maxlength="11"
                                                                            style="box-shadow:1px 1px 1px #333;" required>
                                                                    </div>
                                                                </div>


                                                                <div class="row" id="showope1">

                                                                </div>

                                                        </div>
                                                        <div class="modal-footer">

                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div><!-- End Vertically centered Modal-->
                                            @foreach ($getnonOperator as $operator)
                                                <div class="operator-card">
                                                    <p class="operator-name">{{ $operator->operator }}</p>
                                                    <div class="operator-phone"><i
                                                            class="bi bi-telephone me-1"></i>{{ $operator->phone }}</div>
                                                    <div class="operator-actions">

                                                        <button type="button" data-bs-toggle="modal"
                                                            data-bs-target="#editoperator{{ $operator->id }}"
                                                            class="action-link" ><i
                                                                class="bi bi-pencil-square me-1 fs-5"></i></button>

                                                        @if (Auth::user()->type == 'superadmin' || Auth::user()->type == 'Manager')
                                                            <button type="button" class="action-link delete"
                                                                onclick='deleteOperator("{{ $operator->id }}")'><i
                                                                    class="bi bi-trash3 me-1 fs-5"></i></button>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="editoperator{{ $operator->id }}"
                                                    tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Non Asset Code Operator</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('update_operator_non', $operator->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <h5 class="card-title">Operator</h5>
                                                                            <select class="form-select"
                                                                                aria-label="Default select example"
                                                                                name="operator"
                                                                                style="box-shadow:1px 1px 1px #333;"
                                                                                required>
                                                                                <option value="{{ $operator->operator }}"
                                                                                    selected>{{ $operator->operator }}
                                                                                </option>
                                                                                <option value="ATOM">ATOM</option>
                                                                                <option value="Ooredoo">Ooredoo</option>
                                                                                <option value="MPT">MPT</option>
                                                                                <option value="Mytel">Mytel</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <h5 class="card-title">Ph No:</h5>
                                                                            <input type="text" class="form-control"
                                                                                name="phone" maxlength="11"
                                                                                value="{{ $operator->phone }}"
                                                                                style="box-shadow:1px 1px 1px #333;"
                                                                                required>
                                                                        </div>
                                                                    </div>

                                                            </div>
                                                            <div class="modal-footer">

                                                                <button type="submit"
                                                                    class="btn btn-primary">Save</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div><!-- End Vertically centered Modal-->
                                            @endforeach
                                            @if ($getnonRemark != null && $getnonRemark->doc_no)
                                                <div class="detail-form-card remark-card">
                                                    <div class="remark-card-heading">
                                                        <span class="remark-card-icon"><i
                                                                class="bi bi-chat-left-text"></i></span>
                                                        <div>
                                                            <h6>Remark</h6><small>Additional note for this operator</small>
                                                        </div>
                                                    </div>
                                                    <textarea class="form-control" name="remark" id="remark{{ $getnonRemark->id }}"
                                                        onblur="remarkUpdate({{ $getnonRemark->id }})" placeholder="Add a remark...">{{ $getnonRemark->remark }}</textarea>


                                                    @if ($getnonOperator->count() <= 0)
                                                        @if (Auth::user()->type == 'superadmin' || Auth::user()->type == 'Manager')
                                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delnon{{ $getnonRemark->id }}"><i
                                                                    class="bi bi-trash3 me-1"></i>Delete</button>
                                                        @endif
                                                    @endif
                                                    <div class="form-actions">
                                                        <button type="button" data-bs-toggle="modal"
                                                            data-bs-target="#editremark{{ $getnonRemark->id }}"
                                                            class="btn btn-warning text-white btn-sm p-2" style="border-radius: 8px;">Edit Detail</button>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="editremark{{ $getnonRemark->id }}"
                                                    tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content asset-edit-modal">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Asset Details</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form
                                                                action="{{ route('update_contract_non', $getnonRemark->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="row g-4">
                                                                        <div class="col-lg-4">
                                                                            <label class="field-label"
                                                                                for="rank-{{ $getnonRemark->id }}">Rank</label>
                                                                            <select class="form-select"
                                                                                id="rank-{{ $getnonRemark->id }}"
                                                                                name="rank" required>
                                                                                @foreach (['R1', 'R2', 'R3', 'R4', 'R5', 'R6', 'R7', 'R8', 'R9'] as $rank)
                                                                                    <option value="{{ $rank }}"
                                                                                        {{ $getnonRemark->rank == $rank ? 'selected' : '' }}>
                                                                                        {{ $rank }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <span class="field-label">Contract</span>
                                                                            <div class="current-contract-card">
                                                                                <i class="bi bi-bookmark-check-fill"></i>
                                                                                <div><small>Currently
                                                                                        assigned</small><strong>{{ $getnonRemark->contract ?: 'Not set' }}</strong>
                                                                                </div>
                                                                            </div>
                                                                            <input type="hidden" name="contract_edit"
                                                                                value="{{ $getnonRemark->contract }}">
                                                                            <div class="contract-choice-list"
                                                                                role="radiogroup"
                                                                                aria-label="Select contract status">
                                                                                <div class="contract-choice">
                                                                                    <input type="radio" name="contract"
                                                                                        id="contract-yes-{{ $getnonRemark->id }}"
                                                                                        value="Yes"
                                                                                        {{ $getnonRemark->contract == 'Yes' ? 'checked' : '' }}
                                                                                        required>
                                                                                    <label
                                                                                        for="contract-yes-{{ $getnonRemark->id }}"><i
                                                                                            class="bi bi-check-circle"></i>
                                                                                        Yes</label>
                                                                                </div>
                                                                                <div class="contract-choice">
                                                                                    <input type="radio" name="contract"
                                                                                        id="contract-no-{{ $getnonRemark->id }}"
                                                                                        value="No"
                                                                                        {{ $getnonRemark->contract == 'No' ? 'checked' : '' }}>
                                                                                    <label
                                                                                        for="contract-no-{{ $getnonRemark->id }}"><i
                                                                                            class="bi bi-x-circle"></i>
                                                                                        No</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <label class="field-label"
                                                                                for="remark-edit-{{ $getnonRemark->id }}">Remark</label>
                                                                            <textarea class="form-control" id="remark-edit-{{ $getnonRemark->id }}" style="height: 112px" name="remark"
                                                                                placeholder="Add a note...">{{ $getnonRemark->remark }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary"><i
                                                                            class="bi bi-check2 me-1"></i>Save
                                                                        changes</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div><!-- End Vertically centered Modal-->

                                            @endif

                                        </div>

                                        <div class="modal fade" id="delnon{{ $getnonRemark->id }}"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12 col-12">
                                                                <center>
                                                                    <img
                                                                        src="{{ asset('assets/img/external-warning.png') }}" />
                                                                    <p style="color:#000;">Do you want to
                                                                        delete?</p>
                                                                    <i class="bi bi-x-circle btn btn-danger"
                                                                        onclick='deleteRecordnon("{{ $getnonRemark->id }}")'
                                                                        style="font-size:20px;color:fff;width:200px;">
                                                                        Yes, delete it!</i>
                                                                    <button type="button" class="btn btn-light-secondary"
                                                                        data-bs-dismiss="modal">
                                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                                        <span class="d-none d-sm-block">Cancel</span>
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
                            </div>
                        </div>
                    </div>
                </div>
    </section>



@endsection
@section('js')
    <script>
        document.querySelectorAll('[data-detail-toast]').forEach(function(toast, index) {
            var dismissToast = function() {
                if (toast.classList.contains('is-hiding')) return;
                toast.classList.add('is-hiding');
                window.setTimeout(function() {
                    toast.remove();
                }, 250);
            };

            toast.querySelector('[data-detail-toast-close]').addEventListener('click', dismissToast);
            window.setTimeout(function() {
                toast.classList.add('is-visible');
            }, 30 + (index * 80));
            window.setTimeout(dismissToast, 5000 + (index * 250));
        });
    </script>
    <script>
        function deleteRecordnon(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "/non-remark/delete_remark/" + id,
                type: 'DELETE',
                data: {
                    "id": id,
                },
                success: function(data) {
                    console.log('Success! Data deleted.');
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'The operator and phone and contract has been deleted.',
                        icon: 'success'
                    }).then(() => {
                        // Redirect to the URL provided in the JSON response after a delay
                        setTimeout(function() {
                            window.location.href = data.redirect;
                        }, 1000);
                    });
                },
                error: function() {
                    console.log('Error! Unable to delete data.');
                    Swal.fire(
                        'Error!',
                        'There was an error deleting the operator and phone and contract.',
                        'error'
                    );
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
                        url: "/non-operator/delete_operator/" + id,
                        type: 'get',
                        data: {
                            "id": id,
                        },
                        success: function() {
                            Swal.fire(
                                'Deleted!',
                                'The operator has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function() {
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
        $(document).ready(function() {
            var max_fields = 3;
            var x = 0;

            $('#addbtn').on('click', function() {
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

            $('#showope').on('click', '.removebtn', function() {
                $(this).closest('.row').remove();
                x--;
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var max_fields = 3;
            var x = 0;

            $('#addbtn1').on('click', function() {
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

            $('#showope1').on('click', '.removebtn1', function() {
                $(this).closest('.row').remove();
                x--;
            });
        });
    </script>
@endsection
