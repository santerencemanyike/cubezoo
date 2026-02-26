@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.view') }} {{ trans('cruds.site.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <label for="name">{{ trans('cruds.site.fields.name') }}</label>
            <p>{{ $site->name }}</p>
        </div>

        <div class="form-group">
            <label for="address">{{ trans('cruds.site.fields.address') }}</label>
            <p>{{ $site->address ?? '-' }}</p>
        </div>

        <div class="form-group">
            @can('site_edit')
                <a class="btn btn-warning" href="{{ route('admin.sites.edit', $site) }}">
                    {{ trans('global.edit') }}
                </a>
            @endcan
            @can('site_delete')
                <form action="{{ route('admin.sites.destroy', $site) }}" method="POST" style="display:inline;">
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
