@component('mail::message')
# Introduction

The body of your message. Link expired in one hour

@component('mail::button', ['url' => config('app.url') . $url ])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
