<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>@yield('title', 'Laravel App')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Navbar -->
    <nav class="bg-gray-800 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div>
                <a href="{{ url('/') }}" class="text-white text-lg font-semibold">
                    Laravel App
                </a>
            </div>
            <div class="flex items-center">
                @auth
                <!-- Display user name and logout button if authenticated -->
                <span class="text-white mr-4"> {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-gray-300 hover:text-white">
                        Logout
                    </button>
                </form>
                @else
                <!-- Display login link if not authenticated -->
                <a href="{{ route('login') }}" class="text-gray-300 hover:text-white">
                    Login
                </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mx-auto mt-8">
        @yield('content')
    </div>

</body>

</html>