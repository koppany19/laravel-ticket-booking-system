<x-layout>


    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if($errors->has('err'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm font-bold">
                {{ $errors->first('err') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">

            <h1 class="text-3xl font-bold text-gray-900"><span class="text-orange-600">PAM</span>ADMIN</h1>
            <a href="{{ route('events.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-blue-950">
                + Új esemény
            </a>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

            <div class="bg-white rounded-lg shadow-md p-6 border border-gray-100">

                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Összes esemény</h3>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $numberOfEvents }}</p>
                <span class="text-xs text-gray-400">db aktív esemény</span>

            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border border-gray-100">

                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Eladott jegyek</h3>
                <p class="text-3xl font-bold text-gray-900 mt-2"> {{ $numberOfSoldTickets }} </p>
                <span class="text-xs text-gray-400">darab</span>

            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border border-gray-100">

                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Összbevétel</h3>
                <p class="text-3xl font-bold text-green-600 mt-2">{{ number_format($numberOfIncome, 0, ',', ' ') }} Ft</p>
                <span class="text-xs text-gray-400">teljes bevétel</span>

            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border border-gray-100">

                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Top 3 Ülőhely</h3>

                @forelse($topSeats as $index => $topSeat)
                    <li class="flex justify-between text-gray-800">
                        <span class="font-semibold">{{ $index + 1 }}. {{ $topSeat->seat_number }}</span>
                        <span class="text-gray-600 font-bold">{{ $topSeat->total }} db</span>
                    </li>
                @empty
                    <li class="text-gray-500">Nincs eladott jegy.</li>
                @endforelse

            </div>

        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100">

            <h3 class="text-xl font-bold text-gray-900 p-6 border-b border-gray-200">Események kezelése</h3>

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Esemény</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Szabad helyek</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bevétel</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Műveletek</th>

                    </tr>

                </thead>

                <tbody class="bg-white divide-y divide-gray-200">

                @foreach($events as $event)
                    <tr>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $event->title }}</div>
                            <div class="text-sm text-gray-500">{{ $event->event_date_at->format('Y. m. d.') }}</div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">

                            @php
                                $soldCount = $event->tickets->count();
                                $freeSeats = $totalSeats - $soldCount;
                            @endphp

                            <span class="font-semibold {{ $freeSeats > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $freeSeats }}
                            </span> / {{ $totalSeats }}

                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">

                            <div class="font-medium text-gray-900">

                                @php
                                    $revenue = $event->tickets->sum('price');
                                @endphp

                                {{ number_format($revenue, 0, ',', ' ') }} Ft
                            </div>

                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end gap-4">

                            @can('update', $event)
                                <a href="{{ route('events.edit', $event) }}" class="text-indigo-600 px-1 py-1 rounded-lg border-2 border-indigo-600 hover:text-indigo-900 hover:border-indigo-900">Szerkesztés</a>
                            @endcan

                            @can('delete', $event)
                                <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Biztosan törölni szeretnéd?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 px-1 py-1 rounded-lg border-2 border-red-600 hover:text-red-900 hover:border-red-900 ">Törlés</button>
                                </form>
                            @else
                                <span class="text-gray-400 cursor-not-allowed" title="Nem törölhető, mert van eladott jegy">Törlés</span>
                            @endcan

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

            <div class="m-8">
                {{ $events->links() }}
            </div>

        </div>

    </div>

</x-layout>
