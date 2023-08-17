<!DOCTYPE html>
<html>
<head>
    <title>User Email</title>
</head>
<body>
<h1>Hello {{ $user->first_name }} {{ $user->last_name }},</h1>

<p>This is a sample email content. You can customize this template as needed.</p>

<p>Here are your details:</p>
<ul>
    <li>Username: {{ $user->username }}</li>
    <li>Email: {{ $user->email }}</li>
    <li>Full Name: {{ $user->full_name }}</li>
    <li>Is Admin: {{ $user->is_admin ? 'Yes' : 'No' }}</li>
    <li>Is Active: {{ $user->is_active ? 'Yes' : 'No' }}</li>
</ul>

<p>Thank you for using our application!</p>
</body>
</html>
