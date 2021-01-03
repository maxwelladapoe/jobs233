@component('mail::message')
# Hello {{$projectPayment->user->name}},

Your {{$projectPayment->description}} was successful.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
