<x-layout>
    <div class="max-w-2xl mx-auto px-4 py-10">

        <div class="flex justify-between items-center mb-8">

            <h1 class="text-3xl font-bold text-gray-900">Ülőhely szerkesztése</h1>
            <a href="{{ route('seat.index') }}" class="text-gray-500 hover:text-gray-900 hover:underline font-medium">
                &larr; Vissza
            </a>

        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">

            <form action="{{ route('seat.update', $seat) }}" method="POST">

                @csrf
                @method('PUT')


                <div class="mb-6">

                    <label class="block text-sm font-bold text-gray-700 mb-2">Székszám</label>
                    <input type="text" name="seat_number" value="{{ old('seat_number', $seat->seat_number) }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gray-900 focus:ring-blue-950 transition"
                    >

                    @error('seat_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                </div>


                <div class="mb-8">

                    <label class="block text-sm font-bold text-gray-700 mb-2">Alapár (Ft)</label>
                    <input type="number" name="base_price" value="{{ old('base_price', $seat->base_price) }}" min="0"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gray-900 focus:ring-blue-950 transition"
                    >
                    @error('base_price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                     @enderror

                </div>

                <div class="flex justify-end gap-4">

                    <button type="submit" class="px-6 py-2 bg-orange-600 text-white font-bold rounded-lg shadow hover:bg-orange-950 transition">
                        Mentés
                    </button>


                </div>


            </form>

        </div>

    </div>


</x-layout>
