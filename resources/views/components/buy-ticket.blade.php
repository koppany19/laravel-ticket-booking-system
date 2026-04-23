<x-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">

        <a href="{{ route('events.show', $event) }}" class="text-gray-500 hover:text-gray-900 hover:underline mb-6 inline-flex items-center transition">
            &larr; Vissza az eseményhez
        </a>

        <div class="flex flex-col md:flex-row gap-8">

            <div class="flex-1">

                <h1 class="text-3xl font-bold mb-2">Jegyvásárlás</h1>
                <p class="text-gray-600 mb-6">Válassz ülőhelyet a térképen!</p>

                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8 rounded-r shadow-sm">
                    <div class="flex">
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Ebből az eseményből még <span class="font-bold">4 db</span> jegyet vásárolhatsz.
                            </p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('buy-tickets.store', $event) }}" method="POST">
                    @csrf
                    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200">

                        <div class="w-full flex flex-col items-center mb-12">
                            <div class="w-3/4 h-16 bg-gray-800 rounded-b-[4rem] shadow-xl flex items-end justify-center pb-2 relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-b from-gray-700 to-gray-900 opacity-50"></div>
                                <span class="text-gray-400 text-sm font-bold tracking-[0.5em] uppercase relative z-10">Színpad</span>
                            </div>
                            <div class="w-3/4 h-4 bg-gray-200 rounded-b-full mt-1 opacity-50 blur-sm"></div>
                        </div>

                        <div class="grid grid-cols-3 sm:grid-cols-5 md:grid-cols-6 lg:grid-cols-8 gap-4 justify-items-center">

                            @foreach($seats as $seat)
                                @php
                                    // 1. Megnézzük, foglalt-e (a Controllerből kapott tömb alapján)
                                    $isTaken = in_array($seat->id, $takenSeat);

                                    // 2. Kiszámoljuk a dinamikus árat (a szorzó is a Controllerből jön)
                                    // Ha nincs $multiplier (pl. fix ár), akkor 1-nek vesszük
                                    $szorzo = $prod ?? 1.0;
                                    $currentPrice = round($seat->base_price * $szorzo);
                                @endphp

                                @if($isTaken)
                                    <div class="h-16 w-full bg-gray-100 border border-gray-200 rounded-t-xl rounded-b-md flex flex-col items-center justify-center opacity-60 cursor-not-allowed" title="Ez a hely már foglalt">
                                        <span class="font-bold text-gray-400 text-lg line-through">{{ $seat->seat_number }}</span>
                                        <span class="text-xs text-red-400 font-bold">Foglalt</span>
                                    </div>
                                @else
                                    <label class="cursor-pointer group relative w-full">
                                        <input type="checkbox" name="seats[]" value="{{ $seat->id }}" class="peer sr-only"
                                               @if($limit == 0) disabled @endif>

                                        <div class="h-16 w-full bg-white border-2 border-green-500 rounded-t-xl rounded-b-md flex flex-col items-center justify-center transition-all duration-200 hover:shadow-md hover:-translate-y-1 peer-checked:bg-green-600 peer-checked:border-green-600 peer-checked:text-white group-hover:bg-green-50 peer-disabled:opacity-50 peer-disabled:cursor-not-allowed">
                                            <span class="font-bold text-lg">{{ $seat->seat_number }}</span>

                                            <span class="text-xs text-green-600 peer-checked:text-green-100 font-medium">
                                                {{ number_format($currentPrice, 0, ',', ' ') }} Ft
                                            </span>
                                        </div>
                                    </label>
                                @endif
                            @endforeach


                        </div>

                        <div class="mt-12 pt-6 border-t border-gray-100 flex flex-wrap gap-6 justify-center text-sm text-gray-600">

                            <div class="flex items-center">
                                <div class="w-5 h-5 border-2 border-green-500 rounded mr-2"></div> Szabad
                            </div>

                            <div class="flex items-center">
                                <div class="w-5 h-5 bg-green-600 rounded mr-2"></div> Kiválasztva
                            </div>

                            <div class="flex items-center">
                                <div class="w-5 h-5 bg-gray-200 border border-gray-300 rounded mr-2"></div> Foglalt
                            </div>

                        </div>

                    </div>

                    <div class="mt-8 flex justify-end">

                        <button class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-8 rounded-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 flex items-center justify-center text-lg"
                            @if($limit == 0)
                                disabled
                            @endif>
                            <span>Jegyek megvásárlása</span>
                        </button>

                    </div>

                </form>

            </div>

            <div class="md:w-80">

                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 sticky top-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Esemény info</h2>

                    <div class="space-y-4">

                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold">Esemény</p>
                            <p class="font-semibold text-gray-800">{{ $event->title }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold">Időpont</p>
                            <p class="font-semibold text-gray-800">{{ $event->event_date_at->format('Y. m. d. H:i') }}</p>
                        </div>

                        <div>

                            <p class="text-xs text-gray-500 uppercase font-bold">Árazás</p>

                            @if($event->is_dynamic_price)
                                <p class="text-purple-600 font-bold text-sm">⚡ Dinamikus</p>
                                <p class="text-xs text-gray-400 mt-1">Az árak a kereslet függvényében változhatnak.</p>
                            @else
                                <p class="text-gray-800 font-bold text-sm">Fix ár</p>
                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</x-layout>
