@component('mail::message')
# Welcome to remjob.io


Dear {{ $user->name }}, thanks for registering with us! 

The jobs you post at remjob.io will receive big exposition and will be shared on 
social networks to help you find the best fits for your organization.


@component('mail::button', ['url' => 'https://remjob.io'])
remjo.io
@endcomponent

Best regards,<br>
{{ config('app.name') }}
@endcomponent
