@component('mail::message')

<div> {{ trans('emails.welcome').' '. $data['name'] }}, </div>
@component('mail::button', ['url' => url('/')])
    {{ trans('emails.visit_site') }}
@endcomponent
@endcomponent
