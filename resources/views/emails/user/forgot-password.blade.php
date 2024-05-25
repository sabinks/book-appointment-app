<x-mail::message>
Dear User,

I hope this email finds you well. It has come to our attention that you are experiencing difficulty accessing your email account due to a forgotten password. 
Please rest assured, we are here to assist you in resolving this matter swiftly.

To reset your password, click on the button below.

<x-mail::button :url="$url">
    Reset Password
</x-mail::button>

Or copy and paste the URL into your browser:
{{ $url }}

Best regards,<br>
{{ config('app.name') }}
</x-mail::message>