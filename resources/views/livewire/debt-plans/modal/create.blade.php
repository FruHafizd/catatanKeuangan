<x-modal name="modal-create" focusable>
    <div class="p-4 sm:p-6 max-h-[90vh] overflow-y-auto">

        <!-- HEADER -->
        <div class="flex justify-between items-start mb-4 sm:mb-6 sticky top-0 bg-white pb-4 border-b">
            <div>
                <h2 class="text-lg sm:text-xl font-semibold text-gray-900">
                    Rencana Cicilan Cerdas
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Rencanakan cara menyisihkan uang untuk cicilan Anda dengan mudah
                </p>
            </div>

            <button
                x-on:click="$dispatch('close-modal', 'modal-create')"
                type="button"
                class="flex-shrink-0 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-1.5 transition-colors duration-200 ml-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- FORM -->
        <form wire:submit.prevent="save" class="space-y-4">

            <!-- Nama Rencana & Total Pinjaman -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Nama Rencana -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        Nama Rencana
                        <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        wire:model="debt_name"
                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                        placeholder="Contoh: Pinjaman Bank Mandiri, Kredit Motor">
                    @error('debt_name')
                        <span class="text-xs text-red-600 flex items-center gap-1 mt-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Total Pinjaman -->
                <div
                    x-data="{
                        display: '',
                        raw: ''
                    }"
                    class="space-y-2"
                >
                    <label class="text-sm font-medium text-gray-700 flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Total Pinjaman (+ Bunga)
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">Rp</span>
                        <input
                            type="text"
                            x-model="display"
                            @input="
                                raw = display.replace(/\D/g, '');
                                display = raw.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                $wire.total_loan = raw;
                            "
                            class="w-full border border-gray-300 rounded-lg p-2.5 pl-10 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            placeholder="20.000.000"
                        >
                    </div>
                    @error('total_loan')
                        <span class="text-xs text-red-600 flex items-center gap-1 mt-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Tenor Section -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700 flex items-center gap-1">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Tenor (Jangka Waktu)
                    <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <input
                        type="number"
                        wire:model="tenor_value"
                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                        placeholder="36"
                        min="1">
                    <select
                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white"
                        wire:model="tenor_unit">
                        <option value="month">Bulan</option>
                        <option value="year">Tahun</option>
                    </select>
                </div>
                @error('tenor_value')
                    <span class="text-xs text-red-600 flex items-center gap-1 mt-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-200 my-6"></div>

            <!-- Pola Pemasukan Section -->
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-sm font-semibold text-gray-900">Informasi Pemasukan Anda</h3>
                </div>

                <!-- Pola Pemasukan & Jumlah -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Pola Pemasukan -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Pola Pemasukan
                            <span class="text-red-500">*</span>
                        </label>
                        <select
                            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white"
                            wire:model="income_type">
                            <option value="" class="text-gray-400">-- Pilih Pola --</option>
                            <option value="daily">Harian</option>
                            <option value="weekly">Mingguan</option>
                            <option value="monthly">Bulanan</option>
                        </select>
                        @error('income_type')
                            <span class="text-xs text-red-600 flex items-center gap-1 mt-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Jumlah Pemasukan -->
                    <div
                        x-data="{
                            displayIncome: '',
                            rawIncome: ''
                        }"
                        class="space-y-2"
                    >
                        <label class="text-sm font-medium text-gray-700 flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Jumlah Pemasukan
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">Rp</span>
                            <input
                                type="text"
                                x-model="displayIncome"
                                @input="
                                    rawIncome = displayIncome.replace(/\D/g, '');
                                    displayIncome = rawIncome.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                    $wire.income_value = rawIncome;
                                "
                                class="w-full border border-gray-300 rounded-lg p-2.5 pl-10 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="40.000"
                            >
                        </div>
                        @error('income_value')
                            <span class="text-xs text-red-600 flex items-center gap-1 mt-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm text-blue-900">
                        <p class="font-semibold mb-1.5">Cara Kerja Rencana Cicilan Cerdas</p>
                        <ul class="list-disc list-inside space-y-1 text-xs">
                            <li>Sistem akan menghitung berapa uang yang harus Anda sisihkan per hari</li>
                            <li>Anda akan mendapat peringatan jika rencana cicilan tidak realistis</li>
                            <li>Rasio cicilan maksimal yang aman adalah <strong>35% dari pendapatan</strong></li>
                            <li>Jika tidak memungkinkan, sistem akan memberikan saran alternatif</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- HASIL PERHITUNGAN REAL-TIME -->
            @if($calculation_result)
            <div class="space-y-4 mt-6 pt-6 border-t-2 border-gray-200">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-base font-bold text-gray-900">📊 Hasil Perhitungan</h3>
                </div>

                <!-- Info Cicilan Harian -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-blue-700 font-medium mb-1">💰 Sisihkan Per Hari</p>
                            <p class="text-2xl font-bold text-blue-900">
                                Rp {{ number_format($calculation_result['daily_saving'], 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-blue-700 font-medium mb-1">📅 Total Hari</p>
                            <p class="text-xl font-bold text-blue-900">{{ number_format($calculation_result['total_days']) }} hari</p>
                        </div>
                    </div>
                </div>

                <!-- Rasio & Status -->
                <div class="grid grid-cols-2 gap-3">
                    <!-- Rasio Cicilan -->
                    <div class="bg-white border-2 border-gray-200 rounded-lg p-3">
                        <p class="text-xs text-gray-600 mb-1">Rasio Cicilan</p>
                        <p class="text-lg font-bold {{ $calculation_result['ratio_percentage'] > 35 ? 'text-red-600' : 'text-green-600' }}">
                            {{ $calculation_result['ratio_percentage'] }}%
                        </p>
                    </div>

                    <!-- Pendapatan Harian -->
                    <div class="bg-white border-2 border-gray-200 rounded-lg p-3">
                        <p class="text-xs text-gray-600 mb-1">Pendapatan/Hari</p>
                        <p class="text-lg font-bold text-gray-900">
                            Rp {{ number_format($calculation_result['daily_income'], 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <!-- Status Kelayakan -->
                @if($calculation_result['risk_level'] === 'safe')
                    <div class="bg-green-50 border-2 border-green-300 rounded-lg p-4">
                        <div class="flex gap-3">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-green-900 mb-1">Rencana Layak Dilakukan!</p>
                                <p class="text-xs text-green-800">{{ $calculation_result['message'] }}</p>
                            </div>
                        </div>
                    </div>
                @elseif($calculation_result['risk_level'] === 'high')
                    <div class="bg-yellow-50 border-2 border-yellow-300 rounded-lg p-4">
                        <div class="flex gap-3">
                            <svg class="w-6 h-6 text-yellow-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-yellow-900 mb-1">Peringatan: Berisiko Tinggi!</p>
                                <p class="text-xs text-yellow-800">{{ $calculation_result['message'] }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-red-50 border-2 border-red-300 rounded-lg p-4">
                        <div class="flex gap-3">
                            <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-red-900 mb-1">Rencana Tidak Logis!</p>
                                <p class="text-xs text-red-800">{{ $calculation_result['message'] }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Saran Alternatif (jika tidak feasible) -->
                @if(!$calculation_result['is_feasible'] && count($calculation_result['suggestions']) > 0)
                    <div class="bg-indigo-50 border-2 border-indigo-200 rounded-lg p-4">
                        <p class="text-sm font-bold text-indigo-900 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            💡 Saran Alternatif
                        </p>
                        <div class="space-y-2">
                            @foreach($calculation_result['suggestions'] as $suggestion)
                                <div class="bg-white border border-indigo-200 rounded-lg p-3">
                                    <p class="text-xs font-semibold text-indigo-900 mb-1">{{ $suggestion['title'] }}</p>
                                    <p class="text-xs text-gray-700 mb-1">{{ $suggestion['description'] }}</p>
                                    <p class="text-xs font-bold text-indigo-700">Rekomendasi: {{ $suggestion['value'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            @endif

            <!-- FOOTER -->
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-2 sm:gap-3 pt-4 border-t mt-6">
                <button
                    x-on:click="$dispatch('close-modal', 'modal-create')"
                    type="button"
                    class="w-full sm:w-auto border-2 border-gray-300 px-4 py-2.5 sm:py-2 rounded-lg hover:bg-gray-50 active:bg-gray-100 transition-colors duration-200 font-medium text-sm text-gray-700">
                    Batal
                </button>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-2.5 sm:py-2 rounded-lg hover:from-blue-700 hover:to-blue-800 active:from-blue-800 active:to-blue-900 transition-all duration-200 font-medium text-sm shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <span wire:loading.remove wire:target="save">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Hitung Rencana Cicilan
                    </span>
                    <span wire:loading wire:target="save" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menghitung...
                    </span>
                </button>
            </div>

        </form>

    </div>
</x-modal>
