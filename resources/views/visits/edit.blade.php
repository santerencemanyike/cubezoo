@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <h2>Edit Visit</h2>

            <div class="card mt-3">
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Status:</strong>
                        @if ($visit->status === 'draft')
                            <span class="badge bg-secondary">Draft</span>
                        @elseif ($visit->status === 'submitted')
                            <span class="badge bg-info">Submitted</span>
                        @elseif ($visit->status === 'processed')
                            <span class="badge bg-success">Processed</span>
                        @endif
                    </div>

                    <form action="{{ route('admin.visits.update', $visit) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="site_id" class="form-label">Site *</label>
                            <select class="form-select @error('site_id') is-invalid @enderror" 
                                    id="site_id" name="site_id" required>
                                <option value="">Select Site</option>
                                @foreach ($sites as $site)
                                    <option value="{{ $site->id }}" {{ old('site_id', $visit->site_id) == $site->id ? 'selected' : '' }}>{{ $site->name }}</option>
                                @endforeach
                            </select>
                            @error('site_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="visited_at" class="form-label">Visit Date *</label>
                            <input type="date" class="form-control @error('visited_at') is-invalid @enderror" 
                                   id="visited_at" name="visited_at" value="{{ old('visited_at', $visit->visited_at?->format('Y-m-d') ?? '') }}" required>
                            @error('visited_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3">{{ old('notes', $visit->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.visits.show', $visit) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

