@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Sites</h2>
        @can('site_create')
            <a href="{{ route('admin.sites.create') }}" class="btn btn-primary">+ New Site</a>
        @endcan
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Created</th>
                    <th style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sites as $site)
                    <tr>
                        <td><strong>{{ $site->name }}</strong></td>
                        <td>{{ $site->address ?? '-' }}</td>
                        <td>{{ $site->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.sites.show', $site) }}" class="btn btn-sm btn-info">View</a>
                            @can('site_edit')
                                <a href="{{ route('admin.sites.edit', $site) }}" class="btn btn-sm btn-warning">Edit</a>
                            @endcan
                            @can('site_delete')
                                <form action="{{ route('admin.sites.destroy', $site) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">No sites found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
