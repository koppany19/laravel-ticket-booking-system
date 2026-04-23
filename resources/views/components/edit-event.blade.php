
<x-layout>
    <div class="max-w-5xl mx-auto px-4 py-10">

        <div class="flex justify-between items-center mb-8">

            <h1 class="text-3xl font-bold text-gray-900">Esemény szerkesztése</h1>
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-900 hover:underline font-medium transition">
                &larr; Mégse
            </a>

        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">

            <form action="{{ route('events.update', ['event' => $event]) }}" method="POST" enctype="multipart/form-data" class="p-8">

                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="space-y-6">

                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Alapadatok</h2>

                        <div>

                            <label class="block text-sm font-bold text-gray-700 mb-2">

                                Esemény megnevezése

                                @error('title')
                                    <span class="text-red-500 text-xs font-normal ml-2">{{ $message }}</span>
                                @enderror

                            </label>

                            <input type="text" name="title" value="{{ old('title', $event->title) }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gray-600 focus:ring-gray-600 transition @error('title') border-red-500 @enderror"
                            >

                        </div>


                        <div>

                            <label class="block text-sm font-bold text-gray-700 mb-2">

                                Részletes leírás

                                @error('description')
                                    <span class="text-red-500 text-xs font-normal ml-2">{{ $message }}</span>
                                @enderror

                            </label>

                            <textarea name="description" rows="6"
                                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gray-600 focus:ring-gray-600 transition @error('description') border-red-500 @enderror">{{ old('description', $event->description) }}
                            </textarea>
                        </div>
                    </div>


                    <div class="space-y-6">

                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Időpontok és Beállítások</h2>

                        <div>

                            <label class="block text-sm font-bold text-gray-700 mb-2">

                                Esemény időpontja

                                @error('event_date_at')
                                    <span class="text-red-500 text-xs font-normal ml-2">{{ $message }}</span>
                                @enderror

                            </label>

                            <input type="datetime-local" name="event_date_at"
                                   value="{{ old('event_date_at', $event->event_date_at->format('Y-m-d\TH:i')) }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gray-600 focus:ring-gray-600 @error('event_date_at') border-red-500 @enderror"
                            >

                        </div>

                        <div class="grid grid-cols-2 gap-4">

                            <div>

                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">
                                    Jegyértékesítés indul
                                </label>

                                <input type="datetime-local" name="sale_start_at"
                                       value="{{ old('sale_start_at', $event->sale_start_at->format('Y-m-d\TH:i')) }}"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gray-600 focus:ring-gray-600 text-sm @error('sale_start_at') border-red-500 @enderror"
                                >

                                @error('sale_start_at')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror

                            </div>


                            <div>

                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">
                                    Jegyértékesítés zárul
                                </label>

                                <input type="datetime-local" name="sale_end_at"
                                       value="{{ old('sale_end_at', $event->sale_end_at->format('Y-m-d\TH:i')) }}"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gray-600 focus:ring-gray-600 text-sm @error('sale_end_at') border-red-500 @enderror"
                                >

                                @error('sale_end_at')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror

                            </div>

                        </div>


                        <div>

                            <label class="block text-sm font-bold text-gray-700 mb-2">

                                Maximum vásárolható jegy / fő

                                @error('max_number_allowed')
                                    <span class="text-red-500 text-xs font-normal ml-2">{{ $message }}</span>
                                @enderror

                            </label>

                            <input type="number" name="max_number_allowed"
                                   value="{{ old('max_number_allowed', $event->max_number_allowed) }}" min="1"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gray-600 focus:ring-gray-600 @error('max_number_allowed') border-red-500 @enderror"
                            >

                        </div>


                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex items-center">

                            <input type="checkbox" name="is_dynamic_price" id="is_dynamic_price"
                                   class="h-5 w-5 text-red-600 focus:ring-red-500 border-gray-300 rounded"
                                {{ old('is_dynamic_price', $event->is_dynamic_price ? "on" : "off") == "on" ? "checked" : "" }}
                            >

                            <div class="ml-3">

                                <label for="is_dynamic_price" class="font-bold text-gray-700 cursor-pointer">Dinamikus árazás</label>

                            </div>

                        </div>

                    </div>

                </div>



                <div class="mt-8 pt-8 border-t border-gray-100">

                    <label class="block text-sm font-bold text-gray-700 mb-2">

                        Borítókép módosítása (Opcionális)

                        @error('image')
                            <span class="text-red-500 text-xs font-normal ml-2">{{ $message }}</span>
                        @enderror

                    </label>

                    <div class="flex items-center gap-6">

                        @if($event->image)

                            <div class="w-32 h-20 rounded overflow-hidden border border-gray-300 shadow-sm">

                                @php
                                    $img = $event->image;
                                @endphp

                                @if(str_starts_with($img, 'http'))
                                    <img src="{{ $img }}" class="w-full h-full object-cover">
                                @else($img && asset('storage/' . $event->image))
                                    <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                                @endif

                            </div>

                            <span class="text-sm text-gray-500">Jelenlegi kép</span>

                        @endif

                        <
                        <input type="file"
                               name="image"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer @error('image') border-red-500 bg-red-50 @enderror"
                        >

                    </div>

                </div>

                <div class="mt-10 flex justify-end gap-4">

                    <a href="{{ route('dashboard') }}"
                       class="px-6 py-3 bg-white border-2 border-gray-900 text-gray-700 font-semibold rounded-lg hover:border-red-500 hover:border-2 transition">
                        Mégse
                    </a>

                    <button type="submit" class="px-8 py-3 bg-orange-600 text-white font-bold rounded-lg shadow hover:bg-gray-900 transition transform hover:-translate-y-0.5">
                        Módosítások mentése
                    </button>

                </div>

            </form>


        </div>

    </div>


</x-layout>
