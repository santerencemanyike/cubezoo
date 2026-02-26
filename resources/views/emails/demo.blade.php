@component('mail::message')
# Introduction

Your queued job completed successfully.

Thanks,<br>

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
