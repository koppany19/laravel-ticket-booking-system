<x-layout>
    <div class="bg-gray-100 text-gray-800">

        <div class="max-w-4xl mx-auto">
            <a href="/" class="text-gray-500 hover:underline mb-4 inline-block">&larr; Vissza a főoldalra</a>

            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <div class="h-80 w-full bg-gray-300">
                    @php
                        $img = $event->image;
                    @endphp

                    @if(str_starts_with($img, 'http'))
                        <img src="{{ $img }}" class="w-full h-full object-cover">
                    @else($img && asset('storage/' . $event->image))
                        <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                    @endif
                </div>

                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-4xl font-bold">{{ $event->title }}</h1>

                        @auth
                            <a href="{{ route('buy-tickets', $event) }}" class="bg-gray-800 text-white text-lg px-8 py-3 rounded-lg shadow hover:bg-white hover:font-bold hover:text-gray-800 hover:border-2  hover:border-gray-800 transition">
                                Jegyvásárlás
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-gray-800 text-white px-6 py-3 rounded hover:bg-gray-900">
                                Jelentkezz be a vásárláshoz!
                            </a>
                        @endauth
                    </div>

                    <div class="border-b">

                    </div>

                    <div class="prose max-w-none text-gray-700 leading-relaxed mt-5">
                        <h2 class="text-2xl pb-8 font-bold">Reszletek</h2>
                        <p>{{ $event->description }}</p>
                    </div>

                    <div class="flex justify-around bg-gray-50 p-4 rounded-lg border border-gray-200 mb-8 text-sm mt-5">

                        <div>
                            <span class="block font-extrabold text-gray-700 uppercase text-xs">Jegyértékesítés</span>
                            <div class="text-gray-600 font-light">
                                {{ $event->sale_start_at->format('Y.m.d.') }} - {{ $event->sale_end_at->format('Y.m.d.') }}
                            </div>
                        </div>

                        <div>
                            <span class="block font-extrabold text-gray-700 uppercase text-xs">Árazás</span>
                            @if($event->is_dynamic_price)
                                <span class="text-purple-700 font-bold text-xs">Dinamikus ár</span>
                            @else
                                <span class="text-gray-600 font-light">Fix ár</span>
                            @endif
                        </div>

                        <div>
                            <span class="block font-extrabold text-gray-700 uppercase text-xs">Szabályok</span>
                            <span class="text-gray-600 font-light">Max {{ $event->max_number_allowed }} jegy / fő</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-layout>
