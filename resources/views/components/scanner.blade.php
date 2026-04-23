<x-layout>
    <div class="max-w-2xl mx-auto px-4 py-16">

        <div class="flex justify-between items-center mb-8">

            <h1 class="text-3xl font-bold text-gray-900">Jegy ellenőrzése</h1>
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-900 hover:underline font-medium">
                &larr; Vissza
            </a>

        </div>

        <div class="bg-white rounded-xl shadow-xl border border-gray-100 p-8 text-center">

            <div class="mb-8">
                <p class="text-gray-600 text-lg">Olvassa be a jegy vonalkódját, vagy írja be kézzel!</p>

            </div>

            @if(session('success'))

                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-6 mb-8 rounded shadow-md">

                    <div class="flex justify-center items-center">
                        <span class="text-xl font-bold">{{ session('success') }}</span>
                    </div>

                </div>
            @endif

            @if($errors->any())

                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-6 mb-8 rounded shadow-md">

                    <div class="flex justify-center items-center">

                        <div class="text-left">

                            @foreach ($errors->all() as $error)
                                <p class="font-bold text-lg">{{ $error }}</p>
                            @endforeach

                        </div>

                    </div>

                </div>
            @endif

            <br>

            <form action="{{ route('scanner') }}" method="POST" class="mt-6">
                @csrf
                <div class="relative">
                    <input type="text" name="barcode"
                           class="w-full text-center text-3xl font-mono tracking-widest border-2 border-gray-300 rounded-lg p-4 focus:border-blue-500 focus:ring-blue-500 shadow-sm"
                           placeholder="- - - - - - - - -">
                </div>

                <button type="submit" class="w-full mt-6 bg-gray-900 text-white font-bold py-4 rounded-lg shadow-lg hover:bg-blue-950 transition text-xl">
                    ELLENŐRZÉS
                </button>
            </form>

        </div>
    </div>
</x-layout>
