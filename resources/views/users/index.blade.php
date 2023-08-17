    @extends('layouts.app')

    @section('content')
        <h1>Manage Users</h1>

        <button id="run-seeder-btn"
                style="margin: 10px 5px 20px;padding: 10px 20px;background: #3dd5f3;border-radius: 5px;font-weight: bold">
            Run Seeder
        </button>

        <div id="response-message"></div>


        {{--    <form action="{{ route('users.index') }}" method="GET" >--}}
        {{--        <label>Username:</label>--}}
        {{--        <input type="text" name="username" value="{{ request('username') }}">--}}

        {{--        <label>Email:</label>--}}
        {{--        <input type="text" name="email" value="{{ request('email') }}">--}}

        {{--        <label>Name:</label>--}}
        {{--        <input type="text" name="name" value="{{ request('name') }}">--}}

        {{--        <label>Is Active:</label>--}}
        {{--        <select name="is_active">--}}
        {{--            <option value="1" @if(request('is_active') == '1') selected @endif>Active</option>--}}
        {{--            <option value="0" @if(request('is_active') === '0') selected @endif>Inactive</option>--}}
        {{--        </select>--}}

        {{--        <label>Is Admin:</label>--}}
        {{--        <select name="is_admin">--}}
        {{--            <option value="1" @if(request('is_admin') === '1') selected @endif>Admin</option>--}}
        {{--            <option value="0" @if(request('is_admin') === '0') selected @endif>User</option>--}}
        {{--        </select>--}}

        {{--        <button type="submit" style="padding: 10px 20px;margin: 10px;background: #3dd5f3;border-radius: 5px;font-weight: bold">Filter</button>--}}
        {{--    </form>--}}

        {{--    <ul>--}}
        {{--        @foreach($users as $user)--}}
        {{--            <li>{{ $user->username }} - {{ $user->email }} - {{ $user->first_name }} {{ $user->last_name }}</li>--}}
        {{--        @endforeach--}}
        {{--    </ul>--}}



        <form action="{{ route('users.index') }}" method="GET">
            <label>Username:</label>
            <input type="text" name="username" value="{{ request('username') }}">

            <label>Email:</label>
            <input type="text" name="email" value="{{ request('email') }}">

            <label>Name (First or Last):</label>
            <input type="text" name="name" value="{{ request('name') }}">

            <label>Is Active:</label>
            <select name="is_active">
                <option value="1" @if(request('is_active') == '1') selected @endif>Active</option>
                <option value="0" @if(request('is_active') === '0') selected @endif>Inactive</option>
            </select>

            <label>Is Admin:</label>
            <select name="is_admin">
                <option value="1" @if(request('is_admin') == '1') selected @endif>Admin</option>
                <option value="0" @if(request('is_admin') === '0') selected @endif>User</option>
            </select>

            <button type="submit"
                    style="padding: 10px 20px;margin: 10px;background: #3dd5f3;border-radius: 5px;font-weight: bold">Filter
            </button>
        </form>



        <table class="table mt-3">
            <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Admin</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->username}}</td>
                    <td>{{ $user->email}}</td>
                    <td>{{ $user->first_name}}</td>
                    <td>{{ $user->last_name}}</td>
                    <td>{{ $user->is_admin ? 'Yes' : 'No' }}</td>
                    <td>{{ $user->is_active ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Soft Delete</button>
                        </form>
                        <form action="{{ route('users.send_email', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Send Email</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {!! $users->links() !!}

    @endsection


