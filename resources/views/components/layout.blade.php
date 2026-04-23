<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PAMKUTYA</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
        <body class="bg-gray-100 text-gray-800 antialiased">

        <nav class="bg-white shadow mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
                <a href="/" class="text-2xl font-extrabold text-black"><span class="text-orange-600">PAM</span>KUTYA</a>
                <div class="flex gap-5">
                    @auth

                        <p> Szia, <span class="text-black bold font-medium"> {{ auth()->user()->name }}</span>! </p>

                        <form method="POST" action="{{ route('logout') }}" class="inline">

                            @csrf
                            <button type="submit" class="text-orange-700 hover:text-red-900 hover:border-red-950 font-bold ml-2 transition border-2 border-orange-600 rounded-lg py-0.2 px-2">
                                Kilepes
                            </button>

                        </form>

                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Belépés</a>
                        <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900">Regisztráció</a>
                    @endauth
                </div>
            </div>
        </nav>

        <main>
            {{ $slot }}
        </main>

    </body>
</html>
