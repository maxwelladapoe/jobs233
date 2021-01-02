@component('mail::message')
# Hello {{$bid->user->name}},

Your bid of {{$bid->amount}} on project {{$bid->project->id}} was accepted.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
