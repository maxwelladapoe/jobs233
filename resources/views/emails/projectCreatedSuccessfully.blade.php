@component('mail::message')
# Hello {{$project->user->first_name}},

Your Project was created successfully.

Title: {{$project->title}}

Id: {{$project->id}}


@component('mail::button', ['url' => env('app_url').'/projects/'.$project->id])
View Project
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
