<!-- resources/views/users/show.blade.php -->
<h1>User Details</h1>
<p><strong>Username:</strong> {{ $user->username }}</p>
<p><strong>Email:</strong> {{ $user->email }}</p>
<p><strong>Full Name:</strong> {{ $user->full_name }}</p>

<h2>Address</h2>
@if ($address)
    <p><strong>City:</strong> {{ $address->city->name }}</p>
    <p><strong>District:</strong> {{ $address->district }}</p>
    <p><strong>Street:</strong> {{ $address->street }}</p>
    <p><strong>Phone:</strong> {{ $address->phone }}</p>
@else
    <p>No address available.</p>
@endif
