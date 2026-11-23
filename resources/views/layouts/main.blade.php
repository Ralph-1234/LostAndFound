<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University of Baguio - Lost & Found</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-gray-600 text-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex flex-wrap justify-between items-center gap-4">
            <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight">
                U<span class="text-red-400">B Lost & Found</span>
            </a>

            <div class="flex flex-wrap items-center gap-5 text-sm font-medium">
                <a href="{{ route('home') }}" class="hover:text-red-300 hover:underline">Home</a>
                <a href="{{ route('items.lost') }}" class="hover:text-red-300 hover:underline">Lost Items</a>
                <a href="{{ route('items.found') }}" class="hover:text-red-300 hover:underline">Found Items</a>

                @auth
                    <!-- <a href="{{ route('items.create') }}" class="bg-green-500 hover:bg-green-600 text-blue-950 font-semibold px-1.5 py-1 rounded">
                        + Report Item
                    </a> -->
                    <a href="{{ route('claims.my') }}" class="hover:text-red-300 hover:underline">My Claims</a>
                    <a href="{{ route('profile.edit') }}" class="hover:text-red-300 hover:underline">Profile</a>

                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded">
                            Admin Panel
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-300 hover:text-white">Logout</button> 
                        <!--Logout ({{ auth()->user()->name }}) -->
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-red-300">Login</a>
                    <a href="{{ route('register') }}" class="bg-white text-blue-900 px-3 py-1.5 rounded font-semibold hover:bg-red-300">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 mt-4 w-full">
        @if(session('success'))
            <div id="flash-success" class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => {
                    const alert = document.getElementById('flash-success');
                    if (alert) {
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 1000);
        </script>
        @endif
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Page Content -->
    <main class="max-w-7xl mx-auto px-4 py-8 grow w-full">
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-gray-400 text-center py-4 text-sm">
        &copy; {{ date('Y') }} University of Baguio Lost & Found Management System
    </footer>
</body>
</html>
