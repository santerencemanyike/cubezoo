@extends('layouts.admin')
@section('content')
@can('site_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.sites.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.site.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.site.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Site">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.site.fields.id') }}</th>
                        <th>{{ trans('cruds.site.fields.name') }}</th>
                        <th>{{ trans('cruds.site.fields.address') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sites as $site)
                        <tr data-entry-id="{{ $site->id }}">
                            <td></td>
                            <td>{{ $site->id ?? '' }}</td>
                            <td>{{ $site->name ?? '' }}</td>
                            <td>{{ $site->address ?? '' }}</td>
                            <td>
                                @can('site_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.sites.show', $site->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('site_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.sites.edit', $site->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('site_delete')
                                    <form action="{{ route('admin.sites.destroy', $site->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        @method('DELETE')
                                        @csrf
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

