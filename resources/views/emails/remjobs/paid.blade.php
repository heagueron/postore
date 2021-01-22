@component('mail::message')
# Thanks for your payment!

Dear {{ $remjob->company->user->name }},<br>

Congratulations on your new remote job posting!<br>

You can find it <a href="{{ url( '/remote_job/' .$remjob->slug ) }}">here</a> <br><br>


Ref: {{ $remjob->id }}.

@component('mail::button', ['url' => 'https://remjob.io'])
www.remjob.io
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
