@component('mail::message')
# Hello {{$bid->project->user->name}},

You accepted the bid of {{$bid->amount}} that was placed by {{$bid->user->name}}
on your project {{$bid->project->id}}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
