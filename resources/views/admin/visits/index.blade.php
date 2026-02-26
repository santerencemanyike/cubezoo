@extends('layouts.admin')
@section('content')
@can('visit_access')

    @can('visit_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.visits.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.visit.title_singular') }}
                </a>
            </div>
        </div>
    @endcan

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.visit.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-Visit">
                    <thead>
                        <tr>
                            <th width="10"></th>
                            <th>{{ trans('cruds.visit.fields.id') }}</th>
                            <th>{{ trans('cruds.visit.fields.user') }}</th>
                            <th>{{ trans('cruds.visit.fields.visited_at') }}</th>
                            <th>{{ trans('cruds.visit.fields.status') }}</th>
                            <th>{{ trans('cruds.visit.fields.notes') }}</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($visits as $visit)
                            <tr data-entry-id="{{ $visit->id }}">
                                <td></td>
                                <td>{{ $visit->id ?? '' }}</td>
                                <td>{{ $visit->user->name ?? '' }}</td>
                                <td>{{ $visit->visited_at ?? '' }}</td>
                                <td>{{ $visit->status ?? '' }}</td>
                                <td>{{ $visit->notes ?? '' }}</td>
                                <td>
                                    @if($visit->status === 'draft' && auth()->id() === $visit->user_id)
                                        @can('visit_edit')
                                            <form action="{{ route('admin.visits.submit', $visit->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <input type="submit" class="btn btn-xs btn-warning" value="{{ trans('global.submit') }}">
                                            </form>
                                        @endcan
                                    @endif

                                    @can('visit_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.visits.edit', $visit->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $visits->links() }}
            </div>
        </div>
    </div>

@endcan
@endsection

@section('scripts')
@parent
<script>
$(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);

    $.extend(true, $.fn.dataTable.defaults, {
        orderCellsTop: true,
        order: [[1, 'desc']],
        pageLength: 25,
    });

    let table = $('.datatable-Visit:not(.ajaxTable)').DataTable({ buttons: dtButtons });
    $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });
});
</script>
@endsection