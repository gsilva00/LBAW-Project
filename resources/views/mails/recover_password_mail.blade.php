@component('mail::message')

<h1>NewFlow Password Recovery</h1>
<h2>Hello {{ $username }}!</h2>
<p>We received a password recovery request for your NewFlow account. If this request was not made by you, consider changing your password.</p>

<div style="border: 2px solid #393939; padding: 10px; border-radius: 5px; text-align: center;">
    <h4 style="margin: 0;">Your verification code:</h4>
    <h4 style="margin: 0;">{{ $code }}</h4>
</div>

<br>
<p style="margin: 0;">Regards,</p>
<h4 style="margin: 0;">Overflow Inc.</h4>

@endcomponent
