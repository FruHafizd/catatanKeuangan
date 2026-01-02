<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Target Tabungan') }}
            </h2>
            <button 
            x-data
            x-on:click.prevent="$dispatch('open-modal', 'modal-create-target')"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200 flex items-center gap-2 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Target Baru
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
               @forelse($targets as $target)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">

                    {{-- IMAGE --}}
                    <div class="h-48 bg-gray-100 overflow-hidden">
                        @if($target->image)
                            <img 
                                src="{{ \Illuminate\Support\Facades\Storage::url($target->image) }}"
                                alt="{{ $target->name }}"
                                class="w-full h-full object-cover"
                            >
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-blue-400 to-blue-600">
                                <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 1.343-3 3m6 0a3 3 0 00-3-3m0 6a3 3 0 01-3-3m6 0a3 3 0 01-3 3" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- CONTENT --}}
                    <div class="p-6">

                        {{-- TITLE --}}
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-lg font-bold text-gray-800">
                                {{ $target->name }}
                            </h3>

                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                {{ $target->status === 'active' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $target->status === 'completed' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $target->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ ucfirst($target->status) }}
                            </span>
                        </div>

                        {{-- DATE --}}
                        <div class="text-sm text-gray-500 mb-4">
                            <p>Mulai: {{ \Carbon\Carbon::parse($target->start_date)->format('d M Y') }}</p>
                            <p>Selesai: {{ \Carbon\Carbon::parse($target->end_date)->format('d M Y') }}</p>
                        </div>

                        {{-- PROGRESS (STATIC) --}}
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Progress</span>
                                <span class="font-semibold text-gray-800">0%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-blue-500 h-3 rounded-full w-0"></div>
                            </div>
                        </div>

                        {{-- AMOUNT --}}
                        <div class="flex justify-between items-center mb-5">
                            <div>
                                <p class="text-xs text-gray-500">Terkumpul</p>
                                <p class="text-lg font-bold text-gray-800">
                                    Rp 0
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-xs text-gray-500">Target</p>
                                <p class="text-lg font-bold text-blue-600">
                                    Rp {{ number_format($target->target_amount, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        {{-- ACTION --}}
                        <div class="flex gap-2">
                            <button
                                disabled
                                class="flex-1 bg-gray-300 text-gray-600 font-semibold py-2 px-4 rounded-lg cursor-not-allowed">
                                Tambah
                            </button>

                            <button
                                disabled
                                class="bg-red-300 text-white font-semibold py-2 px-4 rounded-lg cursor-not-allowed">
                                Hapus
                            </button>
                        </div>

                    </div>
                </div>
                @empty

                <!-- Empty State -->
                <div class="col-span-full flex flex-col items-center justify-center py-12">
                    <svg class="w-24 h-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Target Tabungan</h3>
                    <p class="text-gray-500 mb-4">Mulai buat target tabunganmu sekarang!</p>
                    <button 
                    x-data
                    x-on:click.prevent="$dispatch('open-modal', 'modal-create-target')" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Buat Target Pertama
                    </button>
                </div>
                @endforelse

            </div>
        </div>
    </div>
    <livewire:target-financial.modal-create />
</div>