@component('mail::message')
# Hello {{$bid->project->user->name}},

A bid of {{$bid->amount}} has been placed on your project.

@component('mail::button', ['url' => ''])
Review Bid
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
