@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.visit.title_singular') }} - {{ $site->name }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.visits.store') }}">
            @csrf
            <input type="hidden" name="site_id" value="{{ $site->id }}">
            <div class="form-group">
                <label class="required" for="visited_at">{{ trans('cruds.visit.fields.visited_at') }}</label>
                <input class="form-control {{ $errors->has('visited_at') ? 'is-invalid' : '' }}" type="datetime-local" name="visited_at" id="visited_at" value="{{ old('visited_at') }}" required>
                @if($errors->has('visited_at'))
                    <div class="invalid-feedback">
                        {{ $errors->first('visited_at') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.visit.fields.visited_at_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="notes">{{ trans('cruds.visit.fields.notes') }}</label>
                <textarea class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" id="notes">{{ old('notes') }}</textarea>
                @if($errors->has('notes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('notes') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.visit.fields.notes_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection