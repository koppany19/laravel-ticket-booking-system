@props(['event'])

<div class="bg-white rounded-lg flex flex-col md:flex-row hover:border-2 hover:border-gray-700">

    <div class="md:w-1/3 h-48 md:h-auto bg-gray-200 relative">
        @php
            $img = $event->image;
        @endphp

        @if(str_starts_with($img, 'http'))
            <img src="{{ $img }}" class="w-full h-full object-cover">
        @else($img && asset('storage/' . $event->image))
            <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
        @endif
    </div>

    <div class="p-6 flex flex-col justify-between w-full">

        <div>
            <div class="flex justify-between items-start">

                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $event->title }}</h2>
                <span class="bg-gray-200 text-black text-xs font-semibold px-2.5 py-0.5 rounded">
                    {{ $event->event_date_at->format('Y-m-d') }}
                </span>

            </div>

            <p class="text-gray-600 mb-4 line-clamp-2">{{ $event->description }}</p>

            @php
                $totalSeats = \App\Models\Seat::count();
                $sold = $event->tickets->count();
                $free = max($totalSeats - $sold, 0);
            @endphp

            <p>Szabad helyek szama: <span class="text-sm {{ $free > 0 ? 'text-green-700' : 'text-red-500' }} font-semibold"> {{ $free }} </span> </p>


        </div>

        <div class="mt-4 text-right">

            <a href="{{ route('events.show', $event) }}" class="inline-block bg-gray-800 text-white px-6 py-2 rounded hover:bg-white hover:text-black hover:border-black hover:border-2 transition">
                Részletek
            </a>

        </div>

    </div>

</div>
