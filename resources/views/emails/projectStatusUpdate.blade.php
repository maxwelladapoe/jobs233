@component('mail::message')
# Hello {{$project->user->first_name}},

There is an update on your project.
Click the button below to go to your project page

@component('mail::button', ['url' => env('app_url').'/projects/assigned/'.$project->id])
Go to Project
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
