{{--<!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}
{{--    <title>Request for New Quantity</title>--}}
{{--</head>--}}
{{--<body>--}}
{{--<p>Dear {{ $vendor->name }},</p>--}}
{{--<p>We are requesting a new quantity for our product.</p>--}}
{{--<p>Thank you.</p>--}}
{{--</body>--}}
{{--</html>--}}

{{--@component('mail::message')--}}
    # Request for New Quantity @if($item) for Item: {{ $item->name }} @endif

    Hello {{ $vendor->first_name }},

    We hope this email finds you well. We are writing to request a new quantity @if($item) for the item {{ $item->name }} @endif.

    Please let us know if you have any questions or require further information.

    Thank you for your attention to this matter.

    Sincerely,
    Your Company
{{--@endcomponent--}}
