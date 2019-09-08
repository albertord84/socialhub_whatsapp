@component('mail::message')
    <div>  {{trans('emails.dear').$data['name']}} <br>
        {{trans('emails.reset_password_text')}}
        @component('mail::button', ['url' => url('/#reset_password/'.$data['token'])])
            {{ trans('emails.this_form') }}
        @endcomponent
    </div>
@endcomponent
