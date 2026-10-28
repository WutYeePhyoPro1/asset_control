@extends('laptop_asset_code.layouts.master')

@section('content')
    <div class="pagetitle">
        <h1>Master Sim List</h1>
    </div>

    @if (session('import_summary'))
        @php($summary = session('import_summary'))
        <div class="alert alert-success" role="status">
            <strong>Import complete.</strong>
            {{ $summary['total'] }} rows processed:
            {{ $summary['unchanged'] }} identical skipped,
            {{ $summary['added'] }} added,
            {{ $summary['updated'] }} updated.
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="section">
        <div class="card">
            <div class="card-body pt-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                    <h5 class="card-title mb-0">Master Sim List</h5>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('master_sim.sample') }}" class="btn btn-outline-success">
                            <i class="bi bi-download"></i> Download Sample
                        </a>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#masterSimImportModal">
                            <i class="bi bi-file-earmark-excel"></i> Excel Import
                        </button>
                    </div>
                </div>

                <form method="GET" action="{{ route('master_sim.index') }}"
                    class="row g-3 align-items-end mb-4 master-sim-filters">
                    <div class="col-md-4">
                        <label for="simTypeFilter" class="form-label">Type</label>
                        <select name="type" id="simTypeFilter" class="form-select">
                            <option value="">All Types</option>
                            <option value="reserve" @selected(request('type') === 'reserve')>Reserve</option>
                            <option value="available" @selected(request('type') === 'available')>Available</option>
                            <option value="used" @selected(request('type') === 'used')>Used</option>
                        </select>
                    </div>

                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('master_sim.index') }}" class="btn btn-outline-secondary">Clear</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle" id="masterSimTable">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Simcard</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sims as $sim)
                                <tr>
                                    <td>{{ $sims->firstItem() + $loop->index }}</td>
                                    <td>{{ $sim->simcard }}</td>
                                    <td>{{ $sim->type }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No SIM cards found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $sims->links() }}
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="masterSimImportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Master Sim List</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('master_sim.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <p class="mb-3">
                            First download the sample file, fill in the same columns, then upload it here.
                        </p>
                        <a href="{{ route('master_sim.sample') }}" class="btn btn-outline-success mb-3">
                            <i class="bi bi-download"></i> Download Sample Excel
                        </a>

                        <label for="masterSimFile" class="form-label d-block" style="font-weight: 600">Excel File</label>
                        <input type="file" name="file" id="masterSimFile" class="form-control"
                            accept=".xlsx,.xls,.csv" required>
                        <small class="text-muted">
                            Required columns: Simcard, Type.
                        </small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Import Excel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeFilter = document.getElementById('simTypeFilter');
            const filterForm = typeFilter.closest('form');

            typeFilter.addEventListener('change', function() {
                filterForm.submit();
            });
        });
    </script>
@endsection
