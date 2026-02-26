@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Visits</h2>
        @can('visit_create')
            <a href="{{ route('admin.visits.create') }}" class="btn btn-primary">+ New Visit</a>
        @endcan
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.visits.index') }}" class="row g-2">
                <div class="col-md-3">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Submitted</option>
                        <option value="processed" {{ request('status') === 'processed' ? 'selected' : '' }}>Processed</option>
                    </select>
                </div>
                @if (auth()->check() && auth()->user()->is_admin)
                    <div class="col-md-3">
                        <select name="user_id" class="form-select form-select-sm">
                            <option value="">All Users</option>
                            @foreach (\App\Models\User::all() as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="col-md-3">
                    <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}" placeholder="From Date">
                </div>
                <div class="col-md-3">
                    <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}" placeholder="To Date">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                    <a href="{{ route('admin.visits.index') }}" class="btn btn-sm btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Site</th>
                    <th>User</th>
                    <th>Visit Date</th>
                    <th>Notes</th>
                    <th>Status</th>
                    <th style="width: 180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($visits as $visit)
                    <tr>
                        <td><strong>{{ $visit->site?->name ?? 'N/A' }}</strong></td>
                        <td>{{ $visit->user?->name ?? 'N/A' }}</td>
                        <td>{{ $visit->visited_at?->format('M d, Y') ?? 'N/A' }}</td>
                        <td><small>{{ Str::limit($visit->notes, 25) ?? '-' }}</small></td>
                        <td>
                            @if ($visit->status === 'draft')
                                <span class="badge bg-secondary">Draft</span>
                            @elseif ($visit->status === 'submitted')
                                <span class="badge bg-info">Submitted</span>
                            @elseif ($visit->status === 'processed')
                                <span class="badge bg-success">Processed</span>
                            @else
                                <span class="badge bg-warning">{{ ucfirst($visit->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.visits.show', $visit) }}" class="btn btn-sm btn-info">View</a>
                            @if ($visit->status === 'draft')
                                @can('visit_edit')
                                    <a href="{{ route('admin.visits.edit', $visit) }}" class="btn btn-sm btn-warning">Edit</a>
                                @endcan
                                <form action="{{ route('admin.visits.submit', $visit) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Submit?')">Submit</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No visits found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($visits->count() > 0)
        <div class="mt-3">
            {{ $visits->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
