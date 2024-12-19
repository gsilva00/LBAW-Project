@component('mail::message')

<h1>NewFlow Password Recovery</h1>
<h2>Hello {{ $username }}!</h2>
<p>We received a password recovery request for your NewFlow account. If this request was not made by you, consider changing your password.</p>

<div style="border: 2px solid #393939; padding: 10px; border-radius: 5px; text-align: center;">
    <p style="margin: 0; text-align: center;"><b>Your verification code:</b></p>
    <p style="margin: 0; text-align: center;"><b>{{ $code }}</b></p>
</div>

<br>
<p style="margin: 0;">Regards,</p>
<p style="margin: 0;"><b>Overflow Inc.</b></p>

@endcomponent
