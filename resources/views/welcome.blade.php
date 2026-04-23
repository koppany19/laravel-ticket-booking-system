<x-layout>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">


        <div class="flex justify-between">

            <h1 class="text-3xl font-bold mb-6">Koncertek Listaja</h1>

            <div>
                @auth
                    @if(auth()->user()->admin)

                        <div class="hidden md:flex items-center gap-1 bg-gray-50 rounded-lg p-1 border border-gray-200 mr-2">

                            <a href="{{ route('dashboard') }}"
                               class="px-3 py-1.5 rounded-md text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-white text-red-600 shadow-sm' : 'text-gray-600 hover:bg-gray-200' }}">
                                Irányítópult
                            </a>

                            <a href="{{ route('seat.index') }}"
                               class="px-3 py-1.5 rounded-md text-sm font-semibold {{ request()->routeIs('seats.*') ? 'bg-white text-red-600 shadow-sm' : 'text-gray-600 hover:bg-gray-200' }}">
                                Ülőhelyek
                            </a>

                            <a href="{{ route('scanner') }}"
                               class="px-3 py-1.5 rounded-md text-sm font-semibold {{ request()->routeIs('admin.scanner') ? 'bg-white text-red-600 shadow-sm' : 'text-gray-600 hover:bg-gray-200' }}">
                                Jegykezelés
                            </a>

                        </div>

                    @endif
                @endauth
            </div>

            @auth
                @if(auth()->user())
                    <a href="{{ route('my-tickets') }}" class="text-xl font-bold border-2 mb-6 border-orange-600 rounded-lg px-4 py-2 hover:border-black hover:bg-gray-950 hover:text-white transition">
                        Jegyeim
                    </a>
                @endif
            @else
            @endauth


        </div>

        <div class="space-y-6">
            @foreach($events as $event)
                <x-concert-card :event="$event" />
            @endforeach
        </div>

        <div class="mt-8">
            {{ $events->links() }}
        </div>

    </main>
</x-layout>
