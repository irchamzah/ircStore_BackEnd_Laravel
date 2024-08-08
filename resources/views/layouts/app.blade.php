<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>@yield('title', 'Laravel App')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Navbar -->
    <nav class="bg-gray-800 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <!-- Logo / Home -->
                <a href="{{ url('/') }}" class="text-white text-lg font-semibold">
                    ircStore
                </a>

                <!-- Categories -->
                <a href="{{ route('categories.index') }}" class="text-gray-300 hover:text-white">
                    Categories
                </a>

                <!-- All Products -->
                <a href="{{ route('search') }}" class="text-gray-300 hover:text-white">
                    All Products
                </a>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Search Bar -->
                <form action="{{ route('search') }}" method="GET" class="hidden md:flex">
                    <input type="text" name="query" placeholder="Search products..."
                        class="px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </form>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Shopping Cart -->



                @auth
                <a href="{{ route('cart.index') }}" class="text-gray-300 hover:text-white">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="ml-1">
                        {{ $cartCount }}
                    </span>
                </a>
                <!-- User Account and Logout -->
                <div class="relative">
                    <span class="text-white cursor-pointer" id="userMenuButton">{{ Auth::user()->name }}</span>
                    <div id="userMenu"
                        class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                        {{-- {{ route('profile.index') }} --}}
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                        {{-- {{ route('orders.index') }} --}}
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Orders</a>
                        {{-- {{ route('wishlist.index') }} --}}
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Wishlist</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full text-left block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
                @else
                <!-- Login Link -->
                <a href="{{ route('login') }}" class="text-gray-300 hover:text-white">
                    Login
                </a>
                @endauth
            </div>
        </div>
    </nav>

    <script>
        document.getElementById('userMenuButton').addEventListener('click', function() {
            var menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        });
    </script>


    <!-- Content -->
    <div class="container mx-auto mt-8">
        @yield('content')
    </div>

</body>

</html>