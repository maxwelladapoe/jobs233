@component('mail::message')
# Hello {{$projectPayment->user->first_name}},

Your {{$projectPayment->description}} was successful.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
