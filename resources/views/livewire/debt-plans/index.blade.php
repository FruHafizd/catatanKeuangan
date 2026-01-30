<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rencana Cicilan
        </h2>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header dengan tombol tambah -->
            <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Daftar Rencana Cicilan </h3>
                </div>
                <button
                    x-data
                    {{-- modal create --}}
                    x-on:click.prevent="$dispatch('open-modal', 'modal-create')"
                    class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Rencana Cicilan
                </button>
            </div>

        </div>
    </div>
    <livewire:debt-plans.modal.create />

    {{-- @if (session()->has('message'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-md" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1">
                    <p class="font-semibold text-green-900">{{ session('message') }}</p>

                    @if(session()->has('calculation'))
                        @php $calc = session('calculation'); @endphp
                        <div class="mt-3 space-y-2">
                            <div class="bg-white rounded-lg p-3 border border-green-200">
                                <p class="text-sm font-medium text-gray-900 mb-2">📊 Ringkasan Rencana Cicilan:</p>
                                <div class="grid grid-cols-2 gap-2 text-xs">
                                    <div>
                                        <span class="text-gray-600">Sisihkan per hari:</span>
                                        <p class="font-bold text-green-700">Rp {{ number_format($calc['daily_saving'], 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Rasio cicilan:</span>
                                        <p class="font-bold {{ $calc['ratio_percentage'] > 35 ? 'text-red-600' : 'text-green-700' }}">
                                            {{ $calc['ratio_percentage'] }}%
                                        </p>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Total hari:</span>
                                        <p class="font-bold text-gray-900">{{ number_format($calc['total_days']) }} hari</p>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Status:</span>
                                        <p class="font-bold {{ $calc['is_feasible'] ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $calc['is_feasible'] ? '✅ Layak' : '⚠️ Berisiko' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <button @click="show = false" class="text-green-600 hover:text-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if (session()->has('warning'))
        <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg shadow-md" x-data="{ show: true }" x-show="show">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div class="flex-1">
                    <p class="font-semibold text-yellow-900">Peringatan!</p>
                    <p class="text-sm text-yellow-800 mt-1">{{ session('warning') }}</p>
                </div>
                <button @click="show = false" class="text-yellow-600 hover:text-yellow-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif --}}
</div>
