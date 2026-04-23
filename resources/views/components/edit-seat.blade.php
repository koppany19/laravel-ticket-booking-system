<x-layout>
    <div class="max-w-7xl mx-auto px-4 py-10">

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Ülőhelyek kezelése</h1>
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-900 hover:underline transition">
                &larr; Vissza
            </a>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">

                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Szék</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Alapár</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Művelet</th>

                            </tr>

                        </thead>



                        <tbody class="bg-white divide-y divide-gray-200">

                        @forelse($seats as $seat)

                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-lg font-bold text-gray-900">{{ $seat->seat_number }}</span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($seat->base_price, 0, ',', ' ') }} Ft
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                                    <a href="{{ route('seat.edit', $seat) }}" class="text-indigo-600 px-1 py-1 rounded-lg border-2 border-indigo-600 hover:text-indigo-900 hover:border-indigo-900 transition">
                                        Szerkesztés
                                    </a>

                                    @if($seat->tickets_count == 0)
                                        <form action="{{ route('seat.destroy', $seat) }}" method="POST" onsubmit="return confirm('Biztosan törölni szeretnéd ezt az ülőhelyet?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ml-3 text-red-600 px-1 py-1 rounded-lg border-2 border-red-600 hover:text-red-900 hover:border-red-900">
                                                Törlés
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 cursor-not-allowed" title="Nem törölhető, mert van hozzá eladott jegy">Törlés</span>
                                    @endif

                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">
                                    Még nincsenek ülőhelyek létrehozva.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 h-fit sticky top-6">

                <h2 class="text-xl font-bold text-gray-900 mb-6 border-b pb-2">Új ülőhely hozzáadása</h2>

                <form action="{{ route('seat.store') }}" method="POST">
                    @csrf


                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Székszám (pl. A005)</label>
                        <input type="text" name="seat_number" value="{{ old('seat_number') }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
                               placeholder="A005">
                        <p class="text-xs text-gray-500 mt-1">Formátum: 1 nagybetű + 3 számjegy</p>

                        @error('seat_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                    </div>


                    <div class="mb-6">

                        <label class="block text-sm font-bold text-gray-700 mb-2">Alapár (Ft)</label>
                        <input type="number" name="base_price" value="{{ old('base_price', 5000) }}" min="0"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition">

                        @error('base_price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg shadow hover:bg-blue-700 transition transform hover:-translate-y-0.5">
                        Hozzáadás
                    </button>

                </form>


            </div>

        </div>

    </div>



</x-layout>
