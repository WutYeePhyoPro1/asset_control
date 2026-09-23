@extends('laptop_asset_code.layouts.master')
@section('content')
    <style>
        .fixasset-detail {
            --detail-primary: #1d4ed8;
            --detail-ink: #172554;
            --detail-muted: #64748b;
            font-family: "Nunito", sans-serif;
        }

        .fixasset-detail .detail-shell {
            border: 0;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 12px 32px rgba(15, 23, 42, .08);
        }

        .fixasset-detail .detail-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0;
            color: var(--detail-ink);
            font-size: 20px;
            font-weight: 800;
        }

        .fixasset-detail .detail-heading i {
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

        .fixasset-detail .detail-body {
            padding: 28px;
        }

        .fixasset-detail .asset-summary-card {
            height: 100%;
            margin: 0;
            background: linear-gradient(180deg, #f8fbff 0%, #fff 100%);
            border: 1px solid #dfe7f3;
            border-radius: 14px;
            box-shadow: none;
        }

        .fixasset-detail .asset-summary-card .card-body {
            padding: 6px 22px;
        }

        .fixasset-detail .asset-summary-card p.card-title {
            margin: 0;
            padding: 19px 0;
            color: var(--detail-ink);
            font-family: "Nunito", sans-serif;
            font-size: 15px !important;
            font-weight: 700;
            line-height: 1.6 !important;
            border-bottom: 1px solid #e5eaf2;
        }

        .fixasset-detail .asset-summary-card p.card-title:last-child {
            border-bottom: 0;
        }

        .fixasset-detail .asset-summary-card p.card-title font {
            display: block;
            margin-bottom: 5px;
            color: var(--detail-muted) !important;
            font-family: "Nunito", sans-serif;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .fixasset-detail .asset-summary-card hr {
            display: none;
        }

        .fixasset-detail .asset-detail-panel {
            padding-left: 16px;
        }

        .fixasset-detail .operator-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .fixasset-detail .operator-toolbar h6 {
            margin: 0;
            color: var(--detail-ink);
            font-size: 16px;
            font-weight: 800;
        }

        .fixasset-detail .add-operator-btn {
            border-radius: 10px;
            font-weight: 700;
            box-shadow: 0 5px 12px rgba(29, 78, 216, .2);
        }

        .fixasset-detail .operator-card {
            position: relative;
            margin-bottom: 12px;
            padding: 16px 18px;
            background: #fff;
            border: 1px solid #e1e8f3;
            border-radius: 12px;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .fixasset-detail .operator-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(15, 23, 42, .07);
        }

        .fixasset-detail .operator-name {
            margin: 0 0 5px;
            color: var(--detail-ink);
            font-size: 15px;
            font-weight: 800;
        }

        .fixasset-detail .operator-phone {
            color: var(--detail-muted);
            font-size: 14px;
            font-weight: 600;
        }

        .fixasset-detail .operator-actions {
            position: absolute;
            top: 14px;
            right: 16px;
            display: flex;
            gap: 10px;
        }

        .fixasset-detail .action-link {
            padding: 0;
            color: var(--detail-primary);
            font-size: 13px;
            font-weight: 700;
            background: none;
            border: 0;
            cursor: pointer;
        }

        .fixasset-detail .action-link.delete {
            color: #dc2626;
        }

        .fixasset-detail .detail-form-card {
            margin-top: 20px;
            padding: 22px;
            border-radius: 16px;
        }

        .fixasset-detail .detail-form-card textarea {
            min-height: 112px;
            border-color: #c4b5fd;
            border-radius: 12px;
            box-shadow: none;
        }

        .fixasset-detail .modal .form-control:focus,
        .fixasset-detail .modal .form-select:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 .2rem rgba(59, 130, 246, .12) !important;
        }

        .fixasset-detail .modal .form-control,
        .fixasset-detail .modal .form-select {
            min-height: 44px;
            border-color: #d7e0ec;
            border-radius: 9px;
            box-shadow: none !important;
        }

        .fixasset-detail .asset-summary-card .form-control,
        .fixasset-detail .asset-summary-card .form-select {
            min-height: 44px;
            border-color: #d7e0ec;
            border-radius: 9px;
            box-shadow: none !important;
        }

        .fixasset-detail .employee-search-wrapper {
            position: relative;
        }

        .fixasset-detail .employee-search-component .input-group {
            display: flex;
            align-items: stretch;
            overflow: hidden;
            background: #fff;
            border: 1px solid #cedbee;
            border-radius: 10px;
        }

        .fixasset-detail .employee-search-component .input-group-text,
        .fixasset-detail .employee-search-component .employee-search-input,
        .fixasset-detail .employee-search-component .employee-search-button {
            min-height: 48px;
            border: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
        }

        .fixasset-detail .employee-search-component .input-group-text {
            flex: 0 0 44px;
            justify-content: center;
            padding: 0;
        }

        .fixasset-detail .employee-search-component .employee-search-input {
            flex: 1 1 auto;
            min-width: 0;
        }

        .fixasset-detail .employee-search-component .employee-search-button {
            flex: 0 0 auto;
            padding: 0 22px;
            border-left: 1px solid rgba(255, 255, 255, .25) !important;
        }

        .fixasset-detail .employee-search-component .input-group:focus-within {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 .2rem rgba(139, 92, 246, .12);
        }

        .fixasset-detail .employee-search-results {
            position: absolute;
            top: calc(100% + 6px);
            right: 0;
            left: 0;
            z-index: 20;
            max-height: 240px;
            overflow-y: auto;
            background: #fff;
            border: 1px solid #d7e0ec;
            border-radius: 9px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .12);
        }

        .fixasset-detail .employee-search-results .list-group-item {
            cursor: pointer;
        }

        .fixasset-detail .asset-hero-card,
        .fixasset-detail .assignment-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(15, 23, 42, .05);
        }

        .fixasset-detail .asset-hero-card {
            display: flex;
            align-items: center;
            gap: 20px;
            margin: 20px 0 14px;
            padding: 22px 24px;
            border-top: 4px solid #2563eb;
        }

        .fixasset-detail .asset-icon-box {
            display: inline-flex;
            flex: 0 0 82px;
            align-items: center;
            justify-content: center;
            width: 82px;
            height: 82px;
            color: #2563eb;
            font-size: 36px;
            background: linear-gradient(145deg, #eff6ff, #dbeafe);
            border: 1px solid #bfdbfe;
            border-radius: 16px;
        }

        .fixasset-detail .asset-hero-content {
            min-width: 0;
            flex: 1;
        }

        .fixasset-detail .asset-hero-title {
            margin: 0 0 6px;
            color: #0f172a;
            font-size: 20px;
            font-weight: 800;
        }

        .fixasset-detail .asset-code-line {
            margin-bottom: 10px;
            color: #64748b;
            font-size: 14px;
            font-weight: 600;
        }

        .fixasset-detail .asset-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .fixasset-detail .type-pill {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            color: #1d4ed8;
            font-size: 12px;
            font-weight: 800;
            background: #dbeafe;
            border: 1px solid #93c5fd;
            border-radius: 999px;
        }

        .fixasset-detail .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 10px;
            color: #047857;
            font-size: 12px;
            font-weight: 800;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 999px;
        }

        .fixasset-detail .status-pill::before {
            width: 7px;
            height: 7px;
            content: "";
            background: #10b981;
            border-radius: 50%;
        }

        .fixasset-detail .status-pill.is-closed {
            color: #b45309;
            background: #fffbeb;
            border-color: #fde68a;
        }

        .fixasset-detail .status-pill.is-closed::before {
            background: #f59e0b;
        }

        .fixasset-detail .assignment-detail {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .fixasset-detail .assignment-detail i {
            color: #64748b;
            font-size: 17px;
        }

        .fixasset-detail .assignment-label {
            display: block;
            margin-bottom: 2px;
            color: #94a3b8;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .03em;
            text-transform: uppercase;
        }

        .fixasset-detail .assignment-value {
            display: block;
            overflow: hidden;
            color: #334155;
            font-size: 13px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .fixasset-detail .assignment-card {
            margin-bottom: 18px;
            padding: 18px 20px;
            background: linear-gradient(100deg, #dcfce7 0%, #ecfdf5 48%, #fff 100%);
            border-color: #6ee7b7;
        }

        .fixasset-detail .assignment-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 16px;
            color: #166534;
            font-size: 14px;
            font-weight: 800;
        }

        .fixasset-detail .assignment-heading-title {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .fixasset-detail .search-employee-btn {
            color: #047857;
            font-weight: 800;
            background: #fff;
            border-color: #6ee7b7;
            cursor : pointer
        }

        .fixasset-detail .assignment-grid {
            display: grid;
            grid-template-columns: minmax(180px, 1.3fr) repeat(4, minmax(120px, 1fr));
            gap: 0;
        }

        .fixasset-detail .assignee-profile,
        .fixasset-detail .assignment-detail {
            min-height: 58px;
            padding: 0 18px;
            border-right: 1px solid #dcfce7;
        }

        .fixasset-detail .assignee-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-left: 0;
        }

        .fixasset-detail .assignment-detail:last-child {
            border-right: 0;
        }

        .fixasset-detail .employee-avatar {
            display: inline-flex;
            flex: 0 0 44px;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            color: #166534;
            font-size: 20px;
            background: #dcfce7;
            border-radius: 50%;
        }

        .fixasset-detail .employee-name {
            color: #0f172a;
            font-size: 15px;
            font-weight: 800;
        }

        .fixasset-detail .employee-id {
            color: #64748b;
            font-size: 12px;
            font-weight: 700;
        }

        .fixasset-detail .asset-detail-panel {
            padding-left: 0;
        }

        .fixasset-detail .operator-toolbar,
        .fixasset-detail .operator-card,
        .fixasset-detail .detail-form-card {
            box-shadow: 0 4px 14px rgba(15, 23, 42, .04);
        }

        .fixasset-detail .operator-toolbar {
            padding: 15px 18px;
            background: linear-gradient(120deg, #1d4ed8, #4f46e5);
            border: 0;
            border-radius: 14px;
            box-shadow: 0 10px 22px rgba(37, 99, 235, .2);
        }

        .fixasset-detail .operator-toolbar h6 {
            color: #fff;
        }

        .fixasset-detail .operator-toolbar .add-operator-btn {
            color: #1d4ed8;
            background: #fff;
            border-color: #fff;
            box-shadow: none;
        }

        .fixasset-detail .operator-card {
            padding: 18px 20px;
            background: linear-gradient(110deg, #fff 0%, #eff6ff 100%);
            border-color: #bfdbfe;
            border-left: 4px solid #0ea5e9;
        }

        .fixasset-detail .remark-card {
            background: linear-gradient(125deg, #f5f3ff 0%, #fdf4ff 58%, #fff 100%);
            border: 1px solid #c4b5fd;
            box-shadow: 0 10px 24px rgba(124, 58, 237, .1);
        }

        .fixasset-detail .remark-card-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .fixasset-detail .remark-card-heading h6 {
            margin: 0 0 2px;
            color: #4c1d95;
            font-size: 16px;
            font-weight: 900;
        }

        .fixasset-detail .remark-card-heading small {
            color: #7c3aed;
            font-weight: 700;
        }

        .fixasset-detail .remark-card-icon {
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

        .fixasset-detail .remark-card textarea[readonly] {
            color: #312e81;
            font-weight: 650;
            background: rgba(255, 255, 255, .82);
            cursor: default;
        }

        .fixasset-detail .remark-actions {
            display: flex;
            justify-content: flex-end;
            gap: 9px;
            margin-top: 14px;
        }

        .fixasset-detail .remark-actions .btn-primary {
            background: #6366f1;
            color: #fff;
            border: 0;
        }

        /* Asset detail edit modal */
        .fixasset-detail .asset-edit-modal {
            overflow: hidden;
            border: 0;
            border-radius: 16px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, .18);
        }

        .fixasset-detail .asset-edit-modal .modal-header {
            padding: 18px 24px;
            background: linear-gradient(135deg, #f8fbff, #f5f3ff);
            border-bottom: 1px solid #e2e8f0;
        }

        .fixasset-detail .asset-edit-modal .modal-title {
            color: #172554;
            font-size: 18px;
            font-weight: 800;
        }

        .fixasset-detail .asset-edit-modal .modal-body {
            padding: 24px;
        }

        .fixasset-detail .asset-edit-modal .modal-footer {
            padding: 16px 24px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .fixasset-detail .asset-edit-modal .field-label {
            display: block;
            margin-bottom: 9px;
            color: #172554;
            font-size: 13px;
            font-weight: 800;
        }

        .fixasset-detail .current-contract-card {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
            padding: 11px 12px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 10px;
        }

        .fixasset-detail .current-contract-card i {
            color: #2563eb;
            font-size: 17px;
        }

        .fixasset-detail .current-contract-card small {
            display: block;
            color: #64748b;
            font-size: 11px;
            font-weight: 700;
        }

        .fixasset-detail .current-contract-card strong {
            color: #1e3a8a;
            font-size: 14px;
        }

        .fixasset-detail .contract-choice-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .fixasset-detail .contract-choice {
            position: relative;
            margin: 0;
        }

        .fixasset-detail .contract-choice input {
            position: absolute;
            opacity: 0;
        }

        .fixasset-detail .contract-choice label {
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

        .fixasset-detail .contract-choice input:checked+label {
            color: #fff;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            border-color: #2563eb;
            box-shadow: 0 5px 12px rgba(37, 99, 235, .22);
        }

        .fixasset-detail .contract-choice input:focus+label {
            outline: 3px solid rgba(59, 130, 246, .2);
            outline-offset: 2px;
        }

        /* New assignment form */
        .fixasset-detail .create-assignment-card {
            margin-bottom: 4px;
            padding: 26px 32px 30px;
            background: #fff;
            border: 1px solid #d8e2f1;
            border-radius: 14px;
            box-shadow: none;
        }

        .fixasset-detail .create-asset-summary {
            margin-bottom: 22px;
            padding-bottom: 20px;
            color: #11175b;
            font-size: 15px;
            font-weight: 800;
            line-height: 1.55;
            border-bottom: 1px solid #e3eaf4;
        }

        .fixasset-detail .create-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px 24px;
        }

        .fixasset-detail .create-form-field.full-width,
        .fixasset-detail .operator-list,
        .fixasset-detail .create-form-actions {
            grid-column: 1 / -1;
        }

        .fixasset-detail .create-form-label {
            display: block;
            margin-bottom: 9px;
            color: #11175b;
            font-size: 14px;
            font-weight: 800;
        }

        .fixasset-detail .create-assignment-card .form-control,
        .fixasset-detail .create-assignment-card .form-select,
        .fixasset-detail .create-assignment-card .input-group-text {
            min-height: 52px;
            color: #172554;
            border-color: #cedbee;
            border-radius: 10px;
            box-shadow: none !important;
        }

        .fixasset-detail .create-assignment-card .form-control::placeholder {
            color: #8ca1c2;
        }

        .fixasset-detail .create-assignment-card .input-group-text {
            border-radius: 10px 0 0 10px;
        }

        .fixasset-detail .create-assignment-card .input-group .form-control {
            border-radius: 0;
        }

        .fixasset-detail .create-assignment-card .employee-search-button {
            min-width: 124px;
            color: #fff;
            font-weight: 700;
            background: #1948f5;
            border-color: #1948f5;
            border-radius: 0 10px 10px 0;
        }

        .fixasset-detail .create-assignment-card .form-control:focus,
        .fixasset-detail .create-assignment-card .form-select:focus {
            border-color: #7c8cff;
            box-shadow: 0 0 0 .2rem rgba(79, 70, 229, .1) !important;
        }

        .fixasset-detail .operator-add-row {
            grid-column: 1 / -1;
            margin-top: -10px;
        }

        .fixasset-detail .operator-add-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            padding: 0;
            color: #fff;
            font-size: 20px;
            background: linear-gradient(135deg, #4f20ed, #2500c8);
            border: 0;
            border-radius: 10px;
            box-shadow: 0 7px 14px rgba(67, 24, 221, .25);
        }

        .fixasset-detail .operator-add-button:hover,
        .fixasset-detail .operator-add-button:focus {
            color: #fff;
            background: linear-gradient(135deg, #3d16cf, #1f00a8);
        }

        .fixasset-detail .operator-entry {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1.2fr) 42px;
            gap: 24px;
            align-items: end;
            margin-bottom: 14px;
        }

        .fixasset-detail .operator-remove-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            margin-bottom: 14px;
            padding: 0;
            color: #fff;
            font-size: 17px;
            line-height: 1;
            background: #ef0000;
            border: 0;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Add operator modal rows must keep both fields aligned with the first row. */
        .fixasset-detail #addoperator .operator-form-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) 24px;
            gap: 24px;
            align-items: end;
            margin-bottom: 14px;
        }

        .fixasset-detail #addoperator .operator-form-row .card-title {
            margin-bottom: 8px;
        }

        .fixasset-detail #addoperator .operator-form-row .operator-remove-button {
            margin: 0 0 10px;
        }

        .fixasset-detail #addoperator .operator-add-controls {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 14px;
        }

        .fixasset-detail .create-contract-options {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .fixasset-detail .create-contract-choice {
            position: relative;
        }

        .fixasset-detail .create-contract-choice input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .fixasset-detail .create-contract-choice label {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 94px;
            min-height: 44px;
            margin: 0;
            padding: 0 14px;
            color: #172554;
            font-weight: 700;
            cursor: pointer;
            border: 1px solid #cedbee;
            border-radius: 9px;
        }

        .fixasset-detail .create-contract-choice label::before {
            width: 13px;
            height: 13px;
            content: "";
            background: #fff;
            border: 1px solid #d4dce8;
            border-radius: 50%;
            box-shadow: inset 0 0 0 3px #fff;
        }

        .fixasset-detail .create-contract-choice input:checked+label {
            color: #2f16c7;
            border-color: #6c55ec;
            background: #f7f5ff;
        }

        .fixasset-detail .create-contract-choice input:checked+label::before {
            background: #4f20ed;
            border-color: #4f20ed;
        }

        .fixasset-detail .create-assignment-card textarea.form-control {
            min-height: 118px;
            resize: vertical;
        }

        .fixasset-detail .create-form-actions {
            display: flex;
            justify-content: flex-end;
        }

        .fixasset-detail .create-save-button {
            min-width: 112px;
            min-height: 44px;
            font-weight: 800;
            background: #1948f5;
            border-color: #1948f5;
            border-radius: 9px;
        }

        .asset-toast {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 2000;
            width: min(380px, calc(100vw - 48px));
            overflow: hidden;
            color: #064e3b;
            background: #d1fae5;
            border: 1px solid #6ee7b7;
            border-radius: 7px;
            box-shadow: 0 12px 26px rgba(16, 185, 129, .2), 0 5px 12px rgba(15, 23, 42, .12);
            animation: asset-toast-enter .34s cubic-bezier(.22, 1, .36, 1) both;
        }

        .asset-toast.is-error {
            color: #7f1d1d;
            background: #fee2e2;
            border-color: #fca5a5;
        }

        .asset-toast.is-closing {
            animation: asset-toast-exit .28s ease-in both;
        }

        .asset-toast-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 0 16px;
            padding: 14px 0 10px;
            border-bottom: 1px solid rgba(6, 78, 59, .22);
        }

        .asset-toast-title {
            font-size: 18px;
            font-weight: 600;
        }

        .asset-toast.is-error .asset-toast-header {
            border-bottom-color: rgba(127, 29, 29, .22);
        }

        .asset-toast-close {
            padding: 0;
            color: #047857;
            font-size: 26px;
            line-height: 1;
            background: transparent;
            border: 0;
            cursor: pointer;
        }

        .asset-toast-close:hover {
            color: #065f46;
        }

        .asset-toast.is-error .asset-toast-close {
            color: #b91c1c;
        }

        .asset-toast-message {
            margin: 0;
            padding: 14px 16px 18px;
            color: inherit;
            font-size: 16px;
            font-weight: 500;
            line-height: 1.25;
        }

        .asset-toast-progress {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            height: 2px;
            background: #10b981;
            border-radius: 0 0 6px 6px;
            transform-origin: left;
            animation: asset-toast-progress 5s linear forwards;
        }

        .asset-toast.is-error .asset-toast-progress {
            background: #ef4444;
        }

        @media (max-width: 575.98px) {
            .asset-toast {
                top: 14px;
                right: 14px;
                width: calc(100vw - 28px);
            }
        }

        @keyframes asset-toast-enter {
            from {
                opacity: 0;
                transform: translateY(-18px) translateX(26px) scale(.92);
            }

            to {
                opacity: 1;
                transform: translate(0);
            }
        }

        @keyframes asset-toast-exit {
            to {
                opacity: 0;
                transform: translateY(-8px) translateX(16px);
            }
        }

        @keyframes asset-toast-progress {
            to {
                transform: scaleX(0);
            }
        }

        @media (max-width: 991.98px) {
            .fixasset-detail .asset-detail-panel {
                padding: 24px 0 0;
            }

            .fixasset-detail .detail-body {
                padding: 20px;
            }

            .fixasset-detail .asset-hero-card {
                align-items: flex-start;
                flex-wrap: wrap;
            }

            .fixasset-detail .assignment-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .fixasset-detail .assignee-profile,
            .fixasset-detail .assignment-detail {
                padding: 12px;
                border-right: 0;
                border-bottom: 1px solid #dcfce7;
            }
        }

        @media (max-width: 575.98px) {
            .fixasset-detail .detail-heading {
                padding: 18px;
                font-size: 17px;
            }

            .fixasset-detail .operator-actions {
                position: static;
                margin-top: 12px;
            }

            .fixasset-detail .asset-hero-card {
                padding: 18px;
            }

            .fixasset-detail .asset-icon-box {
                flex-basis: 58px;
                width: 58px;
                height: 58px;
                font-size: 25px;
            }

            .fixasset-detail .asset-hero-title {
                font-size: 17px;
            }

            .fixasset-detail .assignment-grid {
                grid-template-columns: 1fr;
            }

            .fixasset-detail .create-assignment-card {
                padding: 20px 16px;
            }

            .fixasset-detail .create-form-grid,
            .fixasset-detail .operator-entry {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .fixasset-detail .operator-remove-button {
                margin: -4px 0 0;
            }

            .fixasset-detail .create-assignment-card .employee-search-button {
                min-width: auto;
                padding-right: 14px !important;
                padding-left: 14px !important;
            }
        }

        /* Calm, unified palette for the detail page. */
        .fixasset-detail {
            --detail-primary: #6d28d9;
            --detail-ink: #202342;
            --detail-muted: #718096;
            --detail-border: #e3def4;
            --detail-soft: #fbfaff;
            --detail-accent: #8b5cf6;
        }

        .fixasset-detail .detail-heading i,
        .fixasset-detail .current-contract-card {
            color: var(--detail-primary);
            background: #f3efff;
            border-color: #ddd0ff;
        }

        .fixasset-detail .asset-summary-card,
        .fixasset-detail .operator-card,
        .fixasset-detail .detail-form-card {
            border-color: var(--detail-border);
        }

        .fixasset-detail .asset-summary-card,
        .fixasset-detail .detail-form-card,
        .fixasset-detail .asset-edit-modal .modal-footer {
            background: var(--detail-soft);
        }

        .fixasset-detail .asset-hero-card {
            border-top-color: var(--detail-accent);
        }

        .fixasset-detail .asset-icon-box {
            color: var(--detail-primary);
            background: #f3efff;
            border-color: #ddd0ff;
        }

        .fixasset-detail .type-pill {
            color: var(--detail-primary);
            background: #f1edff;
            border-color: #d8caff;
        }

        .fixasset-detail .assignment-card {
            background: #f8f5ff;
            border-color: #ded4f7;
        }

        .fixasset-detail .assignment-heading,
        .fixasset-detail .search-employee-btn,
        .fixasset-detail .employee-avatar {
            color: var(--detail-primary);
        }

        .fixasset-detail .employee-avatar {
            background: #ebe4ff;
        }

        .fixasset-detail .assignee-profile,
        .fixasset-detail .assignment-detail {
            border-color: #e1d8f5;
        }

        .fixasset-detail .operator-toolbar {
            background: #6d28d9;
            box-shadow: 0 8px 18px rgba(109, 40, 217, .16);
        }

        .fixasset-detail .operator-toolbar .add-operator-btn {
            color: var(--detail-primary);
        }

        .fixasset-detail .operator-card {
            background: #fff;
            border-left-color: var(--detail-accent);
        }

        .fixasset-detail .remark-card {
            background: #f7fbfc;
            border-color: #c5dfe6;
            box-shadow: 0 8px 18px rgba(63, 120, 148, .07);
        }

        .fixasset-detail .remark-card-heading h6,
        .fixasset-detail .remark-card-heading small,
        .fixasset-detail .remark-actions .btn-primary {
            color: var(--detail-primary);
        }

        .fixasset-detail .remark-card-icon,
        .fixasset-detail .remark-actions .btn-primary {
            background: var(--detail-primary);
            border-color: var(--detail-primary);
        }

        .fixasset-detail .remark-card textarea[readonly] {
            color: var(--detail-ink);
            border-color: var(--detail-border);
        }

        .fixasset-detail .asset-edit-modal .modal-header {
            background: #eef3f5;
        }

        .fixasset-detail .modal .form-control:focus,
        .fixasset-detail .modal .form-select:focus,
        .fixasset-detail .create-form-grid .form-control:focus,
        .fixasset-detail .create-form-grid .form-select:focus {
            border-color: #8aa9b7;
            box-shadow: 0 0 0 .2rem rgba(95, 129, 145, .14) !important;
        }

        .fixasset-detail .history-card {
            margin: 18px 0 22px;
            padding: 20px 22px 8px;
            background: linear-gradient(135deg, #f8fbfc 0%, #fff 100%);
            border: 1px solid #d9e6ea;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(31, 78, 96, .06);
        }

        .fixasset-detail .history-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .fixasset-detail .history-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
            color: var(--detail-ink);
            font-size: 16px;
            font-weight: 900;
        }

        .fixasset-detail .history-title i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            color: #fff;
            background: linear-gradient(135deg, #6d28d9, #8b5cf6);
            border-radius: 10px;
        }

        .fixasset-detail .history-count {
            padding: 5px 10px;
            color: #25657d;
            font-size: 12px;
            font-weight: 800;
            background: #e8f2f4;
            border-radius: 999px;
        }

        .fixasset-detail .history-timeline {
            position: relative;
            margin-left: 15px;
            padding-left: 31px;
            border-left: 2px solid #cfe0e5;
        }

        .fixasset-detail .history-entry {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 13px;
            margin-bottom: 14px;
            padding: 13px 15px;
            background: #fff;
            border: 1px solid #dce8ec;
            border-radius: 13px;
        }

        .fixasset-detail .history-entry::before {
            position: absolute;
            top: 21px;
            left: -40px;
            width: 16px;
            height: 16px;
            content: "";
            background: #fff;
            border: 4px solid #6b9caf;
            border-radius: 50%;
            box-shadow: 0 0 0 4px #f8fbfc;
        }

        .fixasset-detail .history-entry.is-current {
            background: #f8f5ff;
            border-color: #a9cdd7;
        }

        .fixasset-detail .history-entry.is-current::before {
            border-color: #1f7a5b;
        }

        .fixasset-detail .history-person {
            display: inline-flex;
            flex: 0 0 38px;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            color: #25657d;
            font-size: 18px;
            background: #e8f2f4;
            border-radius: 50%;
        }

        .fixasset-detail .history-entry-body {
            min-width: 0;
            flex: 1;
        }

        .fixasset-detail .history-entry-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 4px;
        }

        .fixasset-detail .history-entry-label {
            color: #78909c;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .fixasset-detail .history-entry-date {
            color: #90a4ae;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .fixasset-detail .history-entry-name {
            margin: 0;
            color: #163b4a;
            font-size: 14px;
            font-weight: 800;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .fixasset-detail .history-current-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            color: #16704e;
            font-size: 10px;
            font-weight: 900;
            background: #dff5e9;
            border-radius: 999px;
        }

        @media (max-width: 575.98px) {
            .fixasset-detail .history-card {
                padding: 16px 14px 4px;
            }

            .fixasset-detail .history-timeline {
                margin-left: 8px;
                padding-left: 23px;
            }

            .fixasset-detail .history-entry::before {
                left: -32px;
            }

            .fixasset-detail .history-entry-top {
                align-items: flex-start;
                flex-direction: column;
                gap: 2px;
            }
        }

        /* Final system theme overrides */
        .fixasset-detail .asset-hero-card {
            border-top-color: #8b5cf6 !important;
        }

        .fixasset-detail .asset-icon-box,
        .fixasset-detail .detail-heading i,
        .fixasset-detail .employee-avatar {
            color: #6d28d9 !important;
            background: #f1edff !important;
            border-color: #d8caff !important;
        }

        .fixasset-detail .assignment-card {
            background: #f8f5ff !important;
            border-color: #ded4f7 !important;
        }

        .fixasset-detail .assignment-heading,
        .fixasset-detail .assignment-detail i,
        .fixasset-detail .assignment-label,
        .fixasset-detail .search-employee-btn {
            color: #6d28d9 !important;
        }

        .fixasset-detail .operator-toolbar {
            background: linear-gradient(135deg, #6d28d9, #8b5cf6) !important;
            box-shadow: 0 10px 22px rgba(109, 40, 217, .18) !important;
        }

        .fixasset-detail .operator-card {
            background: #fff !important;
            border-left-color: #8b5cf6 !important;
        }

        .fixasset-detail .remark-card {
            background: #fbfaff !important;
            border-color: #ded4f7 !important;
        }

        .fixasset-detail .remark-card-heading h6,
        .fixasset-detail .remark-card-heading small {
            color: #6d28d9 !important;
        }

        .fixasset-detail .remark-card-icon {
            background: linear-gradient(135deg, #6d28d9, #8b5cf6) !important;
        }

        .fixasset-detail .add-operator-btn {
            color: #fff !important;
            background: #6d28d9 !important;
            border-color: #6d28d9 !important;
        }

        .fixasset-detail .add-operator-btn:hover,
        .fixasset-detail .add-operator-btn:focus {
            color: #fff !important;
            background: #5b21b6 !important;
            border-color: #5b21b6 !important;
        }
    </style>
    <div class="pagetitle">
        <h1>Asset Control System</h1><br>
    </div>

    @if (Session::has('success'))
        <div class="asset-toast" role="status" data-toast-duration="5000">
            <div class="asset-toast-header">
                <span class="asset-toast-title">Success</span>
                <button class="asset-toast-close" type="button" aria-label="Close alert">×</button>
            </div>
            <p class="asset-toast-message">{{ Session::get('success') }}</p>
            <span class="asset-toast-progress"></span>
        </div>
    @endif

    @if ($errors->any())
        <div class="asset-toast is-error" role="alert" data-toast-duration="5000">
            <div class="asset-toast-header">
                <span class="asset-toast-title">Error</span>
                <button class="asset-toast-close" type="button" aria-label="Close alert">×</button>
            </div>
            <div class="asset-toast-message">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
            <span class="asset-toast-progress"></span>
        </div>
    @endif
    <section class="section fixasset-detail">
        <div class="row">

            <div class="col-lg-12">
                <div class="card detail-shell">
                    <div class="card-body detail-body">

                        @php
                            $item = collect($query)->first();
                            $rawStatus = $item->status ?? null;
                            $statusLabel = match ($rawStatus) {
                                'C' => 'Cancelled',
                                'T' => 'Transferred',
                                'S' => 'Sold',
                                default => 'Ongoing',
                            };
                            $isClosedStatus = in_array($rawStatus, ['C', 'T', 'S'], true);
                        @endphp

                        <h5 class="detail-heading"><i class="bi bi-laptop"></i> Fix Asset Detail</h5>

                        @if ($item)
                            <div class="asset-hero-card">
                                <div class="asset-icon-box">
                                    <i
                                        class="bi {{ str_contains(strtolower($item->asset_type_name ?? ''), 'handset') ? 'bi-phone' : 'bi-laptop' }}"></i>
                                </div>
                                <div class="asset-hero-content">
                                    <h2 class="asset-hero-title">{{ $item->asset_name }}</h2>
                                    <div class="asset-code-line">Asset Code: {{ $item->asset_code }}</div>
                                    <div class="asset-badges">
                                        <span class="status-pill {{ $isClosedStatus ? 'is-closed' : '' }}">
                                            {{ $statusLabel }}
                                        </span>
                                        <span class="type-pill">{{ $item->asset_type_name ?: 'Unknown type' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($remark && $item)
                            @if ($assetHistories->isNotEmpty())
                                <div class="history-card">
                                    <div class="history-heading">
                                        <h6 class="history-title">
                                            <i class="bi bi-clock-history"></i>
                                            Asset Name History
                                        </h6>
                                        <span class="history-count">
                                            {{ $assetHistories->count() }} record{{ $assetHistories->count() > 1 ? 's' : '' }}
                                        </span>
                                    </div>

                                    <div class="history-timeline">
                                        @foreach ($assetHistories as $history)
                                            <div class="history-entry {{ $loop->last ? 'is-current' : '' }}">
                                                <span class="history-person">
                                                    <i class="bi bi-person-fill"></i>
                                                </span>
                                                <div class="history-entry-body">
                                                    <div class="history-entry-top">
                                                        <span class="history-entry-label">
                                                            {{ $loop->first ? 'Original record' : 'Name updated' }}
                                                        </span>
                                                        <span class="history-entry-date">
                                                            {{ $history->created_at->format('d M Y, h:i A') }}
                                                        </span>
                                                    </div>
                                                    <p class="history-entry-name">{{ $history->asset_name }}</p>
                                                    @if ($loop->last)
                                                        <span class="history-current-badge">
                                                            <i class="bi bi-check-circle-fill"></i> Current
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="assignment-card">
                                <div class="assignment-heading">
                                    <span class="assignment-heading-title">
                                        <i class="bi bi-bookmark-check-fill"></i> Currently Assigned To
                                    </span>
                                    @if($statusLabel == 'Ongoing')
                                    <button type="button" class="btn btn-sm search-employee-btn" data-bs-toggle="modal"
                                        data-bs-target="#changeEmployeeModal">
                                        <i class="bi bi-search me-1"></i>Update Employee
                                    </button>
                                    @endif
                                </div>
                                <div class="assignment-grid">
                                    <div class="assignee-profile">
                                        <span class="employee-avatar"><i class="bi bi-person"></i></span>
                                        <div>
                                            <div class="employee-name">{{ $remark->emp_name ?: 'Employee not recorded' }}
                                            </div>
                                            <div class="employee-id">{{ $remark->emp_id ?: '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="assignment-detail">
                                        <i class="bi bi-building"></i>
                                        <div>
                                            <span class="assignment-label">Branch</span>
                                            <span class="assignment-value">{{ $item->branch_name }}</span>
                                        </div>
                                    </div>
                                    <div class="assignment-detail">
                                        <i class="bi bi-briefcase"></i>
                                        <div>
                                            <span class="assignment-label">Department</span>
                                            <span class="assignment-value">{{ $item->department ?: '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="assignment-detail">
                                        <i class="bi bi-award"></i>
                                        <div>
                                            <span class="assignment-label">Position / Rank</span>
                                            <span class="assignment-value">{{ $remark->rank ?: '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="assignment-detail">
                                        <i class="bi bi-file-earmark-check"></i>
                                        <div>
                                            <span class="assignment-label">Contract</span>
                                            <span class="assignment-value">{{ $remark->contract ?: '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="changeEmployeeModal" tabindex="-1"
                                aria-labelledby="changeEmployeeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('remarks.update_employee', $remark->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="changeEmployeeModalLabel">Search Employee</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <label class="form-label fw-bold">Employee ID or Name</label>
                                                <div class="employee-search-wrapper employee-search-component">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white border-end-0">
                                                            <i class="bi bi-search text-muted"></i>
                                                        </span>
                                                        <input type="text"
                                                            class="form-control border-start-0 employee-search-input"
                                                            autocomplete="off" placeholder="Search employee Name Or ID...">
                                                        <button type="button"
                                                            class="btn btn-primary employee-search-button">Search</button>
                                                    </div>
                                                    <input type="hidden" name="emp_id" class="selected-employee-id">
                                                    <input type="hidden" name="emp_name" class="selected-employee-name">
                                                    <div class="employee-search-results list-group d-none"></div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="bi bi-check-lg me-1"></i>Assign Employee
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <!-- Custom Styled Validation -->
                                <div class="row g-4">
                                    @if (!$remark)
                                        <div class="col-12">
                                            @foreach ($query as $item)
                                                <form action="{{ route('remark-form') }}" method="POST"
                                                    class="create-assignment-card">
                                                    @csrf
                                                    <input type="hidden" name="asset_code"
                                                        value="{{ $item->asset_code }}">
                                                    <input type="hidden" name="department"
                                                        value="{{ $item->department }}">
                                                    <input type="hidden" name="branch"
                                                        value="{{ $item->branch_name }}({{ $item->branch_code }})">
                                                    <input type="hidden" name="asset_type"
                                                        value="{{ $item->asset_type_name }}">
                                                    <input type="hidden" name="asset_name"
                                                        value="{{ $item->asset_name }}">

                                                    <div class="create-form-grid">
                                                        <div class="create-form-field full-width">
                                                            <label class="create-form-label">Employee</label>
                                                            <div
                                                                class="employee-search-wrapper employee-search-component">
                                                                <div class="input-group">
                                                                    <span
                                                                        class="input-group-text bg-white border-end-0">
                                                                        <i class="bi bi-search text-muted"></i>
                                                                    </span>
                                                                    <input type="text"
                                                                        class="form-control border-start-0 employee-search-input"
                                                                        name="employee_data" autocomplete="off"
                                                                        placeholder="Search employee Name Or ID...">
                                                                    <input type="hidden" name="emp_id"
                                                                        class="selected-employee-id">
                                                                    <input type="hidden" name="emp_name"
                                                                        class="selected-employee-name">
                                                                    <button type="button"
                                                                        class="btn btn-primary px-4 employee-search-button">
                                                                        <i class="bi bi-search me-1"></i>Search
                                                                    </button>
                                                                </div>
                                                                <div
                                                                    class="employee-search-results list-group d-none">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="create-form-field full-width">
                                                            <label class="create-form-label" for="create-rank">Rank</label>
                                                            <select class="form-select" id="create-rank" name="rank"
                                                                >
                                                                <option value="" selected>Select your rank</option>
                                                                <option value="R1">R1</option>
                                                                <option value="R2">R2</option>
                                                                <option value="R3">R3</option>
                                                                <option value="R4">R4</option>
                                                                <option value="R5">R5</option>
                                                                <option value="R6">R6</option>
                                                                <option value="R7">R7</option>
                                                                <option value="R8">R8</option>
                                                                <option value="R9">R9</option>
                                                            </select>
                                                        </div>

                                                        <div class="create-form-field">
                                                            <label class="create-form-label"
                                                                for="create-operator">Operator</label>
                                                            <select class="form-select" id="create-operator"
                                                                name="operator[]">
                                                                <option value="" selected>Select your Operator</option>
                                                                <option value="ATOM">ATOM</option>
                                                                <option value="Ooredoo">Ooredoo</option>
                                                                <option value="MPT">MPT</option>
                                                                <option value="Mytel">Mytel</option>
                                                            </select>
                                                        </div>

                                                        <div class="create-form-field">
                                                            <label class="create-form-label" for="create-phone">Ph
                                                                No:</label>
                                                            <input type="text" class="form-control" id="create-phone"
                                                                name="phone[]" maxlength="11" placeholder="09" >
                                                        </div>

                                                        <div class="operator-add-row">
                                                            <button type="button" class="operator-add-button"
                                                                id="addbtn" title="Add another operator"
                                                                aria-label="Add another operator">
                                                                <i class="bi bi-plus-lg"></i>
                                                            </button>
                                                        </div>

                                                        <div class="operator-list" id="showope"></div>

                                                        <div class="create-form-field full-width">
                                                            <span class="create-form-label">Contract</span>
                                                            <div class="create-contract-options">
                                                                <div class="create-contract-choice">
                                                                    <input type="radio" name="contract"
                                                                        id="gridRadios1" value="Yes" >
                                                                    <label for="gridRadios1">Yes</label>
                                                                </div>
                                                                <div class="create-contract-choice">
                                                                    <input type="radio" name="contract"
                                                                        id="gridRadios2" value="No" >
                                                                    <label for="gridRadios2">No</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="create-form-field full-width">
                                                            <label class="create-form-label"
                                                                for="create-remark">Remark</label>
                                                            <textarea class="form-control" id="create-remark" name="remark"
                                                                placeholder="Add a remark (optional)"></textarea>
                                                        </div>

                                                        <div class="create-form-actions">
                                                            <button type="submit"
                                                                class="btn btn-primary create-save-button">Save</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="col-12 asset-detail-panel">
                            @if ($remark != null && $remark->asset_code)
                                <div class="operator-toolbar">
                                    <h6>Phone Operators</h6><button type="button"
                                        class="btn btn-primary btn-sm add-operator-btn" data-bs-toggle="modal"
                                        data-bs-target="#addoperator"><i class="bi bi-plus-lg me-1"></i>Add
                                        operator</button>
                                </div>
                            @endif

                            <div class="modal fade" id="addoperator" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add New Operator</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>


                                        <div class="modal-body">

                                            <div class="operator-add-controls">
                                                <button type="button" class="btn btn-outline-primary btn-sm mt-2"
                                                    id="addbtn1">
                                                    <i class="bi bi-plus-lg me-1"></i>Add
                                                </button>
                                            </div>
                                            <form action="{{ route('operator-form') }}" method="POST">
                                                @csrf
                                                <div class="operator-form-row">
                                                    <div>
                                                        @if ($remark != null && $remark->asset_code)
                                                            <input type="hidden" class="form-control asset_code"
                                                                name="asset_code" value="{{ $remark->asset_code }}">
                                                            <input type="hidden" class="form-control asset_code"
                                                                name="department" value="{{ $item->department }}">
                                                            <input type="hidden" class="form-control asset_code"
                                                                name="asset_type" value="{{ $item->asset_type_name }}">
                                                            <input type="hidden" class="form-control asset_code"
                                                                name="asset_name" value="{{ $item->asset_name }}">
                                                            <input type="hidden" class="form-control asset_code"
                                                                name="branch"
                                                                value="{{ $item->branch_name }}({{ $item->branch_code }})">
                                                        @endif
                                                        <h5 class="card-title">Operator</h5>
                                                        <select class="form-select" aria-label="Default select example"
                                                            name="operator[]" style="box-shadow:1px 1px 1px #333;"
                                                            >
                                                            <option value="" selected>Select your
                                                                Operator</option>
                                                            <option value="ATOM">ATOM</option>
                                                            <option value="Ooredoo">Ooredoo</option>
                                                            <option value="MPT">MPT</option>
                                                            <option value="Mytel">Mytel</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <h5 class="card-title">Ph No:</h5>
                                                        <input type="text" class="form-control" name="phone[]"
                                                            maxlength="11" style="box-shadow:1px 1px 1px #333;" >
                                                    </div>
                                                </div>


                                                <div id="showope1">

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
                            <br>

                            @foreach ($operators as $operator)
                                <div class="operator-card">
                                    <p class="operator-name">{{ $operator->operator }}</p>
                                    <div class="operator-phone"><i
                                            class="bi bi-telephone me-1"></i>{{ $operator->phone }}</div>
                                    <div class="operator-actions">

                                        <button type="button" data-bs-toggle="modal"
                                            data-bs-target="#editoperator{{ $operator->id }}" class="action-link"><i
                                                class="bi bi-pencil-square me-1"></i>Edit</button>

                                        @if (Auth::user()->type == 'superadmin' || Auth::user()->type == 'Manager')
                                            <button type="button" class="action-link delete"
                                                onclick='deleteOperator("{{ $operator->id }}")'><i
                                                    class="bi bi-trash3 me-1"></i>Delete</button>
                                        @endif
                                    </div>
                                </div>

                                <div class="modal fade" id="editoperator{{ $operator->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Operator</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('update_operator', $operator->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="row">

                                                        <div class="col-lg-6">
                                                            <h5 class="card-title">Operator</h5>
                                                            <select class="form-select"
                                                                aria-label="Default select example" name="operator"
                                                                style="box-shadow:1px 1px 1px #333;" >
                                                                <option value="{{ $operator->operator }}" selected>
                                                                    {{ $operator->operator }}</option>
                                                                <option value="ATOM">ATOM</option>
                                                                <option value="Ooredoo">Ooredoo</option>
                                                                <option value="MPT">MPT</option>
                                                                <option value="Mytel">Mytel</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <h5 class="card-title">Ph No:</h5>
                                                            <input type="text" class="form-control" name="phone"
                                                                maxlength="11" value="{{ $operator->phone }}"
                                                                style="box-shadow:1px 1px 1px #333;" >
                                                        </div>
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
                            @endforeach
                            @if ($remark != null && $remark->asset_code)
                                <div class="detail-form-card remark-card">
                                    <div class="remark-card-heading">
                                        <span class="remark-card-icon"><i class="bi bi-chat-left-text"></i></span>
                                        <div>
                                            <h6>Remark</h6>
                                            <small>Additional note for this asset</small>
                                        </div>
                                    </div>
                                    <textarea class="form-control" id="remark{{ $remark->id }}" readonly placeholder="No remark added.">{{ $remark->remark }}</textarea>

                                    <div class="remark-actions">
                                        @if ($operators->count() <= 0)
                                            @if (Auth::user()->type == 'superadmin' || Auth::user()->type == 'Manager')
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                    onclick='deleteRemark("{{ $remark->id }}")'><i
                                                        class="bi bi-trash3 me-1"></i>Delete</button>
                                            @endif
                                        @endif
                                        <button type="button" data-bs-toggle="modal"
                                            data-bs-target="#editremark{{ $remark->id }}"
                                            class="btn btn-primary text-white btn-sm rounded py-2 px-3"><i
                                                class="bi bi-pencil-square me-1"></i>Edit Asset Detail</button>
                                    </div>
                                </div>

                                <div class="modal fade" id="editremark{{ $remark->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content asset-edit-modal">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Asset Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('update_contract', $remark->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="row g-4">
                                                        <div class="col-lg-4">
                                                            <label class="field-label"
                                                                for="rank-{{ $remark->id }}">Rank</label>
                                                            <select class="form-select" id="rank-{{ $remark->id }}"
                                                                name="rank" >
                                                                @foreach (['R1', 'R2', 'R3', 'R4', 'R5', 'R6', 'R7', 'R8', 'R9'] as $rank)
                                                                    <option value="{{ $rank }}"
                                                                        {{ $remark->rank == $rank ? 'selected' : '' }}>
                                                                        {{ $rank }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <span class="field-label">Contract</span>
                                                            <div class="current-contract-card">
                                                                <i class="bi bi-bookmark-check-fill"></i>
                                                                <div><small>Currently
                                                                        assigned</small><strong>{{ $remark->contract ?: 'Not set' }}</strong>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="contract_edit"
                                                                value="{{ $remark->contract }}">
                                                            <div class="contract-choice-list" role="radiogroup"
                                                                aria-label="Select contract status">
                                                                <div class="contract-choice">
                                                                    <input type="radio" name="contract"
                                                                        id="contract-yes-{{ $remark->id }}"
                                                                        value="Yes"
                                                                        {{ $remark->contract == 'Yes' ? 'checked' : '' }}
                                                                        >
                                                                    <label for="contract-yes-{{ $remark->id }}"><i
                                                                            class="bi bi-check-circle"></i> Yes</label>
                                                                </div>
                                                                <div class="contract-choice">
                                                                    <input type="radio" name="contract"
                                                                        id="contract-no-{{ $remark->id }}"
                                                                        value="No"
                                                                        {{ $remark->contract == 'No' ? 'checked' : '' }}>
                                                                    <label for="contract-no-{{ $remark->id }}"><i
                                                                            class="bi bi-x-circle"></i> No</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <label class="field-label"
                                                                for="remark-edit-{{ $remark->id }}">Remark</label>
                                                            <textarea class="form-control" id="remark-edit-{{ $remark->id }}" style="height: 112px" name="remark"
                                                                placeholder="Add a note...">{{ $remark->remark }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary"><i
                                                            class="bi bi-check2 me-1"></i>Save changes</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div><!-- End Vertically centered Modal-->

                            @endif

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
        $(document).ready(function() {
            const searchEmployeeUrl = @json(route('search_employee'));

            $('.employee-search-component').each(function() {
                const component = $(this);
                const employeeInput = component.find('.employee-search-input');
                const searchButton = component.find('.employee-search-button');
                const resultList = component.find('.employee-search-results');
                const selectedEmployeeId = component.find('.selected-employee-id');
                const selectedEmployeeName = component.find('.selected-employee-name');

                function showMessage(message, className = 'text-muted') {
                    resultList
                        .empty()
                        .append($('<div>', {
                            class: 'list-group-item ' + className,
                            text: message
                        }))
                        .removeClass('d-none');
                }

                function searchEmployees() {
                    const employeeData = employeeInput.val().trim();

                    if (!employeeData) {
                        showMessage('Please enter an employee ID or name.', 'text-danger');
                        employeeInput.trigger('focus');
                        return;
                    }

                    searchButton.prop('disabled', true);
                    showMessage('Searching...');

                    $.ajax({
                        url: searchEmployeeUrl,
                        method: 'GET',
                        data: {
                            employee_data: employeeData
                        },
                        success: function(response) {
                            resultList.empty();

                            if (!response.data || response.data.length === 0) {
                                showMessage('No employees found.');
                                return;
                            }

                            response.data.forEach(function(employee) {
                                $('<button>', {
                                        type: 'button',
                                        class: 'list-group-item list-group-item-action'
                                    })
                                    .append($('<strong>', {
                                        text: employee.name
                                    }))
                                    .append($('<small>', {
                                        class: 'd-block text-muted',
                                        text: employee.emp_id
                                    }))
                                    .on('click', function() {
                                        employeeInput.val(employee.emp_id + ' - ' +
                                            employee.name);
                                        selectedEmployeeId.val(employee.emp_id);
                                        selectedEmployeeName.val(employee.name);
                                        resultList.addClass('d-none').empty();
                                    })
                                    .appendTo(resultList);
                            });

                            resultList.removeClass('d-none');
                        },
                        error: function(xhr) {
                            const message = xhr.status === 422 ?
                                'Please enter a valid employee ID or name.' :
                                'Employee search failed. Please try again.';

                            showMessage(message, 'text-danger');
                        },
                        complete: function() {
                            searchButton.prop('disabled', false);
                        }
                    });
                }

                searchButton.on('click', searchEmployees);

                employeeInput.on('keydown', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        searchEmployees();
                    }
                });

                employeeInput.on('input', function() {
                    selectedEmployeeId.val('');
                    selectedEmployeeName.val('');
                });
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('.employee-search-wrapper').length) {
                    $('.employee-search-results').addClass('d-none');
                }
            });
        });
    </script>

    <script>
        function deleteRemark(id) {
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
                        url: "/remark/delete_remark/" + id,
                        type: 'get',
                        data: {
                            "id": id,
                        },
                        success: function() {
                            Swal.fire(
                                'Deleted!',
                                'The operator and phone and contract has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'There was an error deleting the operator and phone and contract.',
                                'error'
                            );
                        }
                    });
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
                        url: "/operator/delete_operator/" + id,
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
                    var wrapperope = `
                <div class="operator-entry">
                    <div class="create-form-field">
                        <label class="create-form-label">Operator</label>
                        <select class="form-select" aria-label="Select your Operator" name="operator[]" >
                            <option value="" selected>Select your Operator</option>
                            <option value="ATOM">ATOM</option>
                            <option value="Ooredoo">Ooredoo</option>
                            <option value="MPT">MPT</option>
                            <option value="Mytel">Mytel</option>
                        </select>
                    </div>
                    <div class="create-form-field">
                        <label class="create-form-label">Ph No:</label>
                        <input type="text" class="form-control" name="phone[]" maxlength="11" placeholder="09" >
                    </div>
                    <button type="button" class="operator-remove-button removebtn"
                        title="Remove operator" aria-label="Remove operator">
                        <i class="bi bi-dash-lg"></i>
                    </button>
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
                $(this).closest('.operator-entry').remove();
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
                    <div class="operator-form-row">
                        <div>
                            <h5 class="card-title">Operator</h5>
                            <select class="form-select" aria-label="Default select example" name="operator[]" >
                                <option value="" selected>Select your Operator</option>
                                <option value="ATOM">ATOM</option>
                                <option value="Ooredoo">Ooredoo</option>
                                <option value="MPT">MPT</option>
                                <option value="Mytel">Mytel</option>
                            </select>
                        </div>
                        <div>
                            <h5 class="card-title">Ph No:</h5>
                            <input type="text" class="form-control" name="phone[]" maxlength="11" >
                        </div>
                        <button type="button" class="operator-remove-button removebtn1"
                            title="Remove operator" aria-label="Remove operator">
                            <i class="bi bi-dash-lg"></i>
                        </button>
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
                $(this).closest('.operator-form-row').remove();
                x--;
            });
        });
    </script>

    <script>
        document.querySelectorAll('.asset-toast').forEach(function(toast) {
            var duration = Number(toast.dataset.toastDuration || 5000);
            var dismissed = false;

            function dismissToast() {
                if (dismissed) return;
                dismissed = true;
                toast.classList.add('is-closing');
                window.setTimeout(function() {
                    toast.remove();
                }, 280);
            }

            toast.querySelector('.asset-toast-close').addEventListener('click', dismissToast);
            window.setTimeout(dismissToast, duration);
        });
    </script>
@endsection
