@component('mail::message')
# Hello {{$bid->project->user->first_name}},

A bid of {{$bid->amount}} has been placed on your project.

@component('mail::button', ['url' => env('app_url').'/projects/'.$bid->project->id])
Review Bid
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
