@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <h2>{{ $site->name }}</h2>

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card mt-3">
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Name:</strong> {{ $site->name }}
                    </div>
                    <div class="mb-3">
                        <strong>Address:</strong> {{ $site->address ?? 'N/A' }}
                    </div>
                    <div class="mb-3">
                        <strong>Created:</strong> {{ $site->created_at->format('M d, Y') }}
                    </div>
                </div>
            </div>

            <div class="mt-3">
                @can('site_edit')
                    <a href="{{ route('admin.sites.edit', $site) }}" class="btn btn-warning">Edit</a>
                @endcan
                @can('site_delete')
                    <form action="{{ route('admin.sites.destroy', $site) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                @endcan
                <a href="{{ route('admin.sites.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection

