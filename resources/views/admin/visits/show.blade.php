@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.view') }} {{ trans('cruds.visit.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <label for="site_id">{{ trans('cruds.visit.fields.site') }}</label>
            <p>{{ $visit->site->name ?? '-' }}</p>
        </div>

        <div class="form-group">
            <label for="user_id">{{ trans('cruds.visit.fields.user') }}</label>
            <p>{{ $visit->user->name ?? '-' }}</p>
        </div>

        <div class="form-group">
            <label for="visited_at">{{ trans('cruds.visit.fields.visited_at') }}</label>
            <p>{{ $visit->visited_at ?? '-' }}</p>
        </div>

        <div class="form-group">
            <label for="status">{{ trans('cruds.visit.fields.status') }}</label>
            <p>
                @if($visit->status === 'draft')
                    <span class="badge bg-secondary">Draft</span>
                @elseif($visit->status === 'submitted')
                    <span class="badge bg-info">Submitted</span>
                @else
                    {{ $visit->status }}
                @endif
            </p>
        </div>

        <div class="form-group">
            <label for="notes">{{ trans('cruds.visit.fields.notes') }}</label>
            <p>{{ $visit->notes ?? '-' }}</p>
        </div>

        <div class="form-group">
            @if($visit->status === 'draft')
                @can('visit_edit')
                    <a class="btn btn-warning" href="{{ route('admin.visits.edit', $visit) }}">
                        {{ trans('global.edit') }}
                    </a>
                @endcan
                @can('visit_edit')
                    <form action="{{ route('admin.visits.submit', $visit) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            {{ trans('global.submit') }}
                        </button>
                    </form>
                @endcan
            @endif
            @can('visit_delete')
                <form action="{{ route('admin.visits.destroy', $visit) }}" method="POST" style="display:inline;">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('{{ trans('global.areYouSure') }}')">
                        {{ trans('global.delete') }}
                    </button>
                </form>
            @endcan
        </div>
    </div>
</div>

@endsection
