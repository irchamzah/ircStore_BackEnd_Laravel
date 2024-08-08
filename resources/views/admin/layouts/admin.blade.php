<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')

    <title>@yield('title', 'Admin Dashboard') - My Application</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @yield('head')
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white">
            <div class="p-6">
                <h2 class="text-2xl font-semibold">Admin Panel</h2>
                <nav class="mt-8">
                    <ul>
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                                class="block py-2 px-4 hover:bg-gray-700">Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.products.index') }}"
                                class="block py-2 px-4 hover:bg-gray-700">Products</a>
                        </li>
                        <li>
                            {{-- {{ route('admin.categories.index') }} --}}
                            <a href="#" class="block py-2 px-4 hover:bg-gray-700">Categories</a>
                        </li>
                        <li>
                            {{-- {{ route('admin.orders.index') }} --}}
                            <a href="#" class="block py-2 px-4 hover:bg-gray-700">Orders</a>
                        </li>
                        <li>
                            {{-- {{ route('admin.users.index') }} --}}
                            <a href="#" class="block py-2 px-4 hover:bg-gray-700">Users</a>
                        </li>
                        <!-- Tambahkan menu lainnya sesuai kebutuhan -->
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <header class="mb-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold">@yield('title')</h1>
                    <a href="{{ route('logout') }}" class="text-blue-500 hover:text-blue-700">Logout</a>
                </div>
            </header>

            <section>
                @yield('content')
            </section>
        </main>
    </div>
</body>

</html>