<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'Manager Users' }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div id="app" class="container mt-4">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('login') }}">
                {{ config('app.name', 'Laravel') }}
            </a>


            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    @guest
                        @if (Route::has('login'))
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Users
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('users.index') }}">
                                    {{ __('All Users') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('users.create') }}">
                                    {{ __('Add Users') }}
                                </a>
                            </div>
                        </li>
                    @endguest

                    @guest
                        @if (Route::has('login'))
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Vendors
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('vendors.index') }}">
                                    {{ __('All Vendors') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('vendors.create') }}">
                                    {{ __('Add Vendors') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('vendor_items.index') }}">
                                    {{ __('Vendor_Items') }}
                                </a>
                            </div>
                        </li>
                    @endguest

                    @guest
                        @if (Route::has('login'))
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Brand
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('brands.index') }}">
                                    {{ __('All Brands') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('brands.create') }}">
                                    {{ __('Add Brand') }}
                                </a>
                            </div>
                        </li>
                    @endguest

                    @guest
                        @if (Route::has('login'))
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Items
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('items.index') }}">
                                    {{ __('All Items') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('items.create') }}">
                                    {{ __('Add Item') }}
                                </a>
                            </div>
                        </li>
                    @endguest


                    @guest
                        @if (Route::has('login'))
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Inventory
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('inventories.index') }}">
                                    {{ __('All Inventory') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('inventories.create') }}">
                                    {{ __('Add Inventory') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('inventory_items.index') }}">
                                    {{ __('Inventory_Items') }}
                                </a>
                            </div>
                        </li>
                    @endguest


                    @guest
                        @if (Route::has('login'))
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Country
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('countries.index') }}">
                                    {{ __('All Countries') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('countries.create') }}">
                                    {{ __('Add Country') }}
                                </a>
                            </div>
                        </li>
                    @endguest

                    @guest
                        @if (Route::has('login'))
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                City
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('cities.index') }}">
                                    {{ __('All Cities') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('cities.create') }}">
                                    {{ __('Add City') }}
                                </a>
                            </div>
                        </li>
                    @endguest

                    @guest
                        @if (Route::has('login'))
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Cart
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('cart.show') }}">
                                    {{ __('Cart') }}
                                </a>
                            </div>
                        </li>
                    @endguest


                </ul>


                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->username }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('login') }}"
                                   onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>

            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
<script>
    document.getElementById('run-seeder-btn').addEventListener('click', function () {
        fetch('{{ route('run.seeder') }}', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            }
        })
            .then(response => response.json())
            .then(data => {
                document.getElementById('response-message').innerText = data.message;
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });


</script>

</html>
