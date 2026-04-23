<x-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Libre+Barcode+39+Text&display=swap');

        .barcode {
            font-family: 'Libre Barcode 39 Text', cursive;
            font-size: 3.5rem;
            line-height: 1.2;
            color: #333;
        }
    </style>

    <div class="max-w-4xl mx-auto px-4 py-8">

        <div class="flex justify-between items-center mb-8">

            <h1 class="text-3xl font-bold mb-8">Megvásárolt jegyeim</h1>
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-900 hover:underline font-medium">
                &larr; Vissza
            </a>

        </div>

        @if(session('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow" role="alert">
                <p>{{ session('message') }}</p>
            </div>
        @endif

        @forelse($groupByTitle as $eventName => $tickets)

            <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-8 overflow-hidden">
                <div class="bg-gray-50 p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $eventName }}</h2>
                    <p class="text-gray-600 font-semibold">{{ $tickets->first()->event->event_date_at->format('Y. m. d. H:i') }}</p>
                </div>

                <div class="divide-y divide-gray-100">
                    @foreach($tickets as $ticket)
                        <div class="p-6 flex flex-col md:flex-row items-center justify-between gap-4">

                            <div class="flex-1">
                                <span class="block text-sm font-bold text-gray-500 uppercase">Ülőhely</span>
                                <span class="text-2xl font-bold text-red-600">{{ $ticket->seat->seat_number }}</span>
                                <span class="block text-sm text-gray-500 mt-1">{{ number_format($ticket->price, 0, ',', ' ') }} Ft</span>
                            </div>

                            <div class="text-center md:text-right">
                                <p class="text-sm font-mono text-gray-600 mb-1 tracking-wider">{{ $ticket->barcode }}</p>
                                <p class="barcode">*{{ $ticket->barcode }}*</p>
                                </div>

                        </div>
                    @endforeach
                </div>
            </div>

        @empty
            <div class="text-center p-12 bg-white rounded-lg shadow">
                <p class="text-xl text-gray-500">Még nincsenek megvásárolt jegyeid.</p>
                <a href="{{ route('home') }}" class="mt-4 inline-block bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition">
                    Vissza a koncertekhez
                </a>
            </div>
        @endforelse
    </div>
</x-layout>
