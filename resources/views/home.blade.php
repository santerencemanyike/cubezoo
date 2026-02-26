@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Async Batch Processor
    </div>

    <div class="card-body">

        <div class="form-group">
            <button id="runJobs" class="btn  btn-stm-re">
                Run Background Tasks
            </button>
        </div>

        <div class="form-group mt-4">
            <div class="progress" style="height: 30px;">
                <div id="progressBar"
                     class="progress-bar progress-bar-striped progress-bar-animated"
                     role="progressbar"
                     style="width: 0%">
                    0%
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
@parent
<script>
$(document).ready(function(){

    $('#runJobs').click(function(){

        let button = $(this);
        button.prop('disabled', true);

        $.post('{{ route("admin.batch.run") }}', {
            _token: '{{ csrf_token() }}'
        }, function(data){

            Swal.fire({
                icon: 'success',
                title: 'Mail sent with other!',
                timer: 1500,
                showConfirmButton: false
            });

            let batchId = data.batch_id;

            // Generate correct admin-prefixed progress URL
            let progressUrlTemplate = '{{ route("admin.batch.progress", ":id") }}';
            let progressUrl = progressUrlTemplate.replace(':id', batchId);

            let interval = setInterval(function(){

                $.get(progressUrl, function(progress){

                    let percent = progress.progress;

                    $('#progressBar')
                        .css('width', percent + '%')
                        .text(percent + '%');

                    if (progress.failed > 0) {
                        $('#progressBar')
                            .removeClass('bg-success')
                            .addClass('bg-danger');
                    }

                    if (percent >= 100) {
                        clearInterval(interval);
                        $('#progressBar')
                            .removeClass('progress-bar-animated')
                            .addClass('bg-success');
                        button.prop('disabled', false);
                    }

                });

            }, 1000);

        });

    });

});
</script>
@endsection