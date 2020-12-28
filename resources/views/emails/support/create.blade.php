@component('mail::message')
# Suppor request


<p><strong>Sender name:</strong> {{$data['name']}}</p>
<p><strong>Sender email:</strong> {{$data['email']}}</p>

<strong>Message:</strong>
<p>
    {{$data['support-request']}}
</p>


@component('mail::button', ['url' => 'https://remjob.io'])
remjob.io
@endcomponent

@endcomponent
