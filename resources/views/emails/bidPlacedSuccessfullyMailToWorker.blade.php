@component('mail::message')
# Hello {{$bid->user->name}},

Your bid of {{$bid->amount}} has been placed successfully.

@component('mail::button', ['url' => env('app_url').'/projects/'.$bid->project->id])
View Project
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
