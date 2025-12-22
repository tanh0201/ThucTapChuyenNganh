@component('mail::message')
# {{ $title ?? 'Test Email' }}

{{ $message ?? 'This is a test email from PetSam' }}

@component('mail::button', ['url' => config('app.url')])
Truy cập PetSam
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
