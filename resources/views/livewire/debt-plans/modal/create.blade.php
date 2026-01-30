<x-modal name="modal-create" focusable>
    <div class="p-4 sm:p-6 max-h-[90vh] overflow-y-auto">

        <!-- HEADER -->
        <div class="flex justify-between items-start mb-4 sm:mb-6 top-0 bg-white pb-4 border-b z-10">
            <div>
                <h2 class="text-lg sm:text-xl font-semibold text-gray-900">
                    Rencana Cicilan Cerdas
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Rencanakan cicilan dengan bijak - lindungi masa depan finansial Anda
                </p>
            </div>

            <button x-on:click="$dispatch('close-modal', 'modal-create')" type="button"
                class="flex-shrink-0 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-1.5 transition-colors duration-200 ml-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- FORM -->
        <form wire:submit.prevent="interimCalculation" class="space-y-4">
            @if (!$show_result)
                <!-- Nama Rencana & Total Pinjaman -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nama Rencana -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            Nama Rencana
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model.blur="debt_name"
                            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            placeholder="Contoh: Kredit Motor Honda Beat">
                        @error('debt_name')
                            <span class="text-xs text-red-600 flex items-center gap-1 mt-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Total Pinjaman -->
                    <div x-data="{
                        get wireValue() { return $wire.total_loan || ''; },
                        display: '',
                        init() {
                            if (this.wireValue && !isNaN(this.wireValue)) {
                                this.display = new Intl.NumberFormat('id-ID').format(this.wireValue);
                            }
                            this.$watch('wireValue', (newValue) => {
                                if (newValue && !isNaN(newValue)) {
                                    this.display = new Intl.NumberFormat('id-ID').format(newValue);
                                } else if (!newValue) {
                                    this.display = '';
                                }
                            });
                        },
                        format() {
                            const raw = this.display.replace(/\D/g, '');
                            if (raw) {
                                $wire.total_loan = raw;
                                this.display = new Intl.NumberFormat('id-ID').format(raw);
                            } else {
                                $wire.total_loan = '';
                                this.display = '';
                            }
                        }
                    }" class="space-y-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Total Pinjaman + Bunga
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">Rp</span>
                            <input type="text" x-model="display" @input="format()"
                                class="w-full border border-gray-300 rounded-lg p-2.5 pl-10 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="20.000.000">
                        </div>
                        <p class="text-xs text-amber-600 flex items-start gap-1">
                            <svg class="w-3 h-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Masukkan total yang harus dibayar (termasuk bunga). Cek di perjanjian kredit Anda.</span>
                        </p>
                        @error('total_loan')
                            <span class="text-xs text-red-600 flex items-center gap-1 mt-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Tenor (Jangka Waktu Cicilan)
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <input type="number" wire:model.blur="tenor_value"
                            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            placeholder="36" min="1">
                        <select
                            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white"
                            wire:model.blur="tenor_unit">
                            <option value="month">Bulan</option>
                            <option value="year">Tahun</option>
                        </select>
                    </div>
                    @error('tenor_value')
                        <span class="text-xs text-red-600 flex items-center gap-1 mt-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
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
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-sm font-semibold text-gray-900">Pendapatan Anda</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Pola Pemasukan -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 flex items-center gap-1">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Pola Pemasukan
                                <span class="text-red-500">*</span>
                            </label>
                            <select
                                class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white"
                                wire:model.blur="income_type">
                                <option value="">-- Pilih Pola --</option>
                                <option value="daily">Harian (Pekerja Lepas)</option>
                                <option value="weekly">Mingguan</option>
                                <option value="monthly">Bulanan (Karyawan)</option>
                            </select>
                            @error('income_type')
                                <span class="text-xs text-red-600 flex items-center gap-1 mt-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Jumlah Pemasukan -->
                        <div x-data="{
                            get wireValue() { return $wire.income_value || ''; },
                            displayIncome: '',
                            init() {
                                if (this.wireValue && !isNaN(this.wireValue)) {
                                    this.displayIncome = new Intl.NumberFormat('id-ID').format(this.wireValue);
                                }
                                this.$watch('wireValue', (newValue) => {
                                    if (newValue && !isNaN(newValue)) {
                                        this.displayIncome = new Intl.NumberFormat('id-ID').format(newValue);
                                    } else if (!newValue) {
                                        this.displayIncome = '';
                                    }
                                });
                            },
                            formatIncome() {
                                const raw = this.displayIncome.replace(/\D/g, '');
                                if (raw) {
                                    $wire.income_value = raw;
                                    this.displayIncome = new Intl.NumberFormat('id-ID').format(raw);
                                } else {
                                    $wire.income_value = '';
                                    this.displayIncome = '';
                                }
                            }
                        }" class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 flex items-center gap-1">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Jumlah Pemasukan (Bersih)
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">Rp</span>
                                <input type="text" x-model="displayIncome" @input="formatIncome()"
                                    class="w-full border border-gray-300 rounded-lg p-2.5 pl-10 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="5.000.000">
                            </div>
                            <p class="text-xs text-blue-600 flex items-start gap-1">
                                <svg class="w-3 h-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Gunakan <strong>pendapatan bersih</strong> (setelah dipotong pajak/iuran)</span>
                            </p>
                            @error('income_value')
                                <span class="text-xs text-red-600 flex items-center gap-1 mt-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Pengeluaran Wajib Bulanan -->
                    <div x-data="{
                        get wireValue() { return $wire.monthly_expense || ''; },
                        displayExpense: '',
                        init() {
                            if (this.wireValue && !isNaN(this.wireValue)) {
                                this.displayExpense = new Intl.NumberFormat('id-ID').format(this.wireValue);
                            }
                            this.$watch('wireValue', (newValue) => {
                                if (newValue && !isNaN(newValue)) {
                                    this.displayExpense = new Intl.NumberFormat('id-ID').format(newValue);
                                } else if (!newValue) {
                                    this.displayExpense = '';
                                }
                            });
                        },
                        formatExpense() {
                            const raw = this.displayExpense.replace(/\D/g, '');
                            if (raw) {
                                $wire.monthly_expense = raw;
                                this.displayExpense = new Intl.NumberFormat('id-ID').format(raw);
                            } else {
                                $wire.monthly_expense = '';
                                this.displayExpense = '';
                            }
                        }
                    }" class="space-y-2">
                        <label class="text-sm font-medium text-gray-700 flex items-start gap-1.5">
                            <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            <div class="flex-1">
                                <span class="block">
                                    Pengeluaran Wajib Bulanan
                                    <span class="text-red-500">*</span>
                                </span>
                                <span class="block text-xs font-normal text-gray-500 mt-0.5">
                                    Total kebutuhan pokok per bulan (makan, sewa, listrik, air, transport, kesehatan,
                                    pendidikan)
                                </span>
                            </div>
                        </label>

                        <div class="relative">
                            <span
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">Rp</span>
                            <input type="text" x-model="displayExpense" @input="formatExpense()"
                                class="w-full border border-gray-300 rounded-lg p-2.5 pl-10 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="2.500.000">
                        </div>

                        <!-- Warning jika pengeluaran terlalu tinggi -->
                        @if ($monthly_expense && $income_value)
                            @php
                                $monthlyIncome = match ($income_type) {
                                    'daily' => $income_value * 30.44,
                                    'weekly' => $income_value * 4.33,
                                    'monthly' => $income_value,
                                    default => 0,
                                };
                                $expenseRatio = $monthlyIncome > 0 ? ($monthly_expense / $monthlyIncome) * 100 : 0;
                            @endphp

                            @if ($expenseRatio >= 70 && $expenseRatio < 80)
                                <div class="bg-amber-50 border border-amber-300 rounded-lg p-3 text-xs">
                                    <div class="flex gap-2">
                                        <svg class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div class="text-amber-800">
                                            <p class="font-semibold mb-1">Pengeluaran Tinggi
                                                ({{ number_format($expenseRatio, 1) }}% dari pendapatan)</p>
                                            <p>Pengeluaran Anda sudah mencapai {{ number_format($expenseRatio, 1) }}%
                                                dari pendapatan. Ruang untuk cicilan sangat terbatas.</p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($expenseRatio >= 80)
                                <div class="bg-red-50 border border-red-300 rounded-lg p-3 text-xs">
                                    <div class="flex gap-2">
                                        <svg class="w-4 h-4 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div class="text-red-800">
                                            <p class="font-semibold mb-1">Pengeluaran Berlebihan
                                                ({{ number_format($expenseRatio, 1) }}%!)</p>
                                            <p>Pengeluaran ≥80% pendapatan sangat berisiko. Hampir tidak ada ruang untuk
                                                cicilan atau dana darurat!</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif

                        @error('monthly_expense')
                            <span class="text-xs text-red-600 flex items-center gap-1 mt-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Info Box Edukasi -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm text-blue-900">
                            <p class="font-semibold mb-1.5">Prinsip Manajemen Keuangan yang Sehat</p>
                            <ul class="list-disc list-inside space-y-1 text-xs">
                                <li><strong>Rasio 30%:</strong> Cicilan maksimal 30% dari pendapatan (zona aman)</li>
                                <li><strong>Rasio 35%:</strong> Hati-hati - zona kuning, keuangan akan ketat</li>
                                <li><strong>Rasio >40%:</strong> Sangat berisiko - bisa terlilit hutang</li>
                                <li><strong>Dana Darurat:</strong> Minimal sisakan Rp 500rb/bulan untuk kejadian tak
                                    terduga</li>
                                <li><strong>Perhitungan Tepat:</strong> Sistem akan menghitung tabungan harian yang
                                    harus disisihkan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- HASIL PERHITUNGAN --}}
            @if ($show_result && $calculation_result)
                @php
                    $status = $calculation_result['status'] ?? null;
                    $isFeasible = $calculation_result['is_feasible'] ?? false;
                    $ratio = $calculation_result['ratio_percentage'] ?? 0;
                    $remaining = $calculation_result['remaining_money'] ?? 0;
                @endphp

                <div class="space-y-4">
                    {{-- Ringkasan Data Input --}}
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <h3 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Data Rencana Cicilan Anda
                        </h3>
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div>
                                <p class="text-gray-600">Nama Rencana</p>
                                <p class="font-semibold text-gray-900">{{ $debt_name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Total Pinjaman</p>
                                <p class="font-semibold text-gray-900">Rp {{ number_format($total_loan, 0, ',', '.') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-600">Tenor</p>
                                <p class="font-semibold text-gray-900">{{ $tenor_value }}
                                    {{ $tenor_unit == 'month' ? 'Bulan' : 'Tahun' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Pendapatan</p>
                                <p class="font-semibold text-gray-900">
                                    Rp {{ number_format($income_value, 0, ',', '.') }}
                                    @if ($income_type == 'daily')
                                        /Hari
                                    @elseif($income_type == 'weekly')
                                        /Minggu
                                    @else
                                        /Bulan
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Header Hasil --}}
                    <div class="flex items-center gap-2 mb-4">
                        <h3 class="text-base font-bold text-gray-900">Hasil Analisis Keuangan</h3>
                    </div>

                    {{-- TARGET TABUNGAN HARIAN (PRIMARY INFO) --}}
                    <div
                        class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-xl p-5 shadow-lg">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <p class="text-sm opacity-90 mb-1">Target Tabungan Per Hari</p>
                                <p class="text-3xl font-bold">
                                    Rp {{ number_format($calculation_result['daily_saving'], 0, ',', '.') }}
                                </p>
                            </div>
                            <div
                                class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-3 text-center border border-white/30">
                                <p class="text-xs opacity-90 mb-1">Total Hari</p>
                                <p class="text-xl font-bold">{{ number_format($calculation_result['total_days']) }}</p>
                                <p class="text-xs opacity-75">hari</p>
                            </div>
                        </div>
                        <p class="text-xs bg-white/10 rounded-lg p-2 backdrop-blur-sm">
                            <strong>Artinya:</strong> Sisihkan uang sejumlah ini setiap hari. Jangan dipakai untuk
                            hal lain sampai cicilan lunas!
                        </p>
                    </div>

                    {{-- DETAIL FINANSIAL --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        {{-- Cicilan Bulanan --}}
                        <div class="bg-white border-2 border-blue-200 rounded-lg p-3">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <p class="text-xs text-gray-600 font-medium">Cicilan/Bulan</p>
                            </div>
                            <p class="text-lg font-bold text-gray-900">
                                Rp {{ number_format($calculation_result['monthly_installment'], 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- Rasio Cicilan --}}
                        <div
                            class="bg-white border-2 rounded-lg p-3 {{ $ratio > 35 ? 'border-red-300' : ($ratio >= 30 ? 'border-yellow-300' : 'border-green-300') }}">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 {{ $ratio > 35 ? 'text-red-600' : ($ratio >= 30 ? 'text-yellow-600' : 'text-green-600') }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <p class="text-xs text-gray-600 font-medium">Rasio Beban</p>
                            </div>
                            <p
                                class="text-lg font-bold {{ $ratio > 35 ? 'text-red-600' : ($ratio >= 30 ? 'text-yellow-600' : 'text-green-600') }}">
                                {{ number_format($ratio, 1) }}%
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                @if ($ratio < 30)
                                    Zona Aman
                                @elseif($ratio < 35)
                                    Zona Hati-hati
                                @else
                                    Zona Bahaya
                                @endif
                            </p>
                        </div>

                        {{-- Sisa Uang --}}
                        <div
                            class="bg-white border-2 rounded-lg p-3 {{ $remaining < 500000 ? 'border-red-300' : ($remaining < 1000000 ? 'border-yellow-300' : 'border-green-300') }}">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 {{ $remaining < 500000 ? 'text-red-600' : ($remaining < 1000000 ? 'text-yellow-600' : 'text-green-600') }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <p class="text-xs text-gray-600 font-medium">Sisa/Bulan</p>
                            </div>
                            <p
                                class="text-lg font-bold {{ $remaining < 500000 ? 'text-red-600' : ($remaining < 1000000 ? 'text-yellow-600' : 'text-green-600') }}">
                                Rp {{ number_format($remaining, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                @if ($remaining >= 1000000)
                                    ✅ Cukup Aman
                                @elseif($remaining >= 500000)
                                    ⚠️ Minimal
                                @else
                                    🚨 Terlalu Sedikit
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- STATUS KELAYAKAN & ANALISIS RISIKO --}}
                    @if ($status === 'feasible')
                        <div class="bg-green-50 border-2 border-green-300 rounded-xl p-4">
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-green-900 mb-2">✅ Rencana Cicilan LAYAK &
                                        AMAN!</p>
                                    <p class="text-xs text-green-800 mb-3">{{ $calculation_result['message'] }}</p>

                                    <div class="bg-white/60 rounded-lg p-3 space-y-2">
                                        <p class="text-xs font-semibold text-green-900">📊 Analisis Risiko:</p>
                                        <ul class="text-xs text-green-800 space-y-1.5">
                                            <li class="flex items-start gap-2">
                                                <span class="text-green-600 flex-shrink-0">✓</span>
                                                <span>Cicilan hanya {{ number_format($ratio, 1) }}% dari pendapatan
                                                    (di bawah batas aman 30%)</span>
                                            </li>
                                            <li class="flex items-start gap-2">
                                                <span class="text-green-600 flex-shrink-0">✓</span>
                                                <span>Sisa uang
                                                    Rp {{ number_format($remaining, 0, ',', '.') }}/bulan cukup untuk
                                                    dana darurat</span>
                                            </li>
                                            <li class="flex items-start gap-2">
                                                <span class="text-green-600 flex-shrink-0">✓</span>
                                                <span>Masih ada ruang untuk tabungan atau investasi</span>
                                            </li>
                                            <li class="flex items-start gap-2">
                                                <span class="text-green-600 flex-shrink-0">✓</span>
                                                <span>Keuangan tetap stabil meskipun ada pengeluaran tak terduga
                                                    kecil</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="mt-3 bg-green-100 border border-green-300 rounded-lg p-2.5">
                                        <p class="text-xs font-semibold text-green-900 mb-1">💡 Tips Sukses:</p>
                                        <ul class="text-xs text-green-800 space-y-1 list-disc list-inside">
                                            <li>Sisihkan Rp {{ number_format($calculation_result['daily_saving'], 0, ',', '.') }}
                                                setiap hari tanpa kompromi</li>
                                            <li>Buat rekening terpisah khusus untuk tabungan cicilan</li>
                                            <li>Set reminder harian untuk menabung</li>
                                            <li>Hindari pinjaman baru selama masa cicilan</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($status === 'warning')
                        <div class="bg-yellow-50 border-2 border-yellow-400 rounded-xl p-4">
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-yellow-900 mb-2">PERINGATAN: Rencana Berisiko
                                        Tinggi!</p>
                                    <p class="text-xs text-yellow-800 mb-3">{{ $calculation_result['message'] }}</p>

                                    <div class="bg-white/60 rounded-lg p-3 space-y-2">
                                        <p class="text-xs font-semibold text-yellow-900">🚨 Potensi Risiko:</p>
                                        <ul class="text-xs text-yellow-900 space-y-1.5">
                                            <li class="flex items-start gap-2">
                                                <span class="text-yellow-600 flex-shrink-0">⚠</span>
                                                <span><strong>Rasio {{ number_format($ratio, 1) }}%</strong> -
                                                    Mendekati batas maksimal! Keuangan akan sangat ketat</span>
                                            </li>
                                            <li class="flex items-start gap-2">
                                                <span class="text-yellow-600 flex-shrink-0">⚠</span>
                                                <span>Sisa uang hanya
                                                    Rp {{ number_format($remaining, 0, ',', '.') }} - Hampir tidak ada
                                                    ruang untuk kejutan</span>
                                            </li>
                                            <li class="flex items-start gap-2">
                                                <span class="text-yellow-600 flex-shrink-0">⚠</span>
                                                <span>Jika ada pengeluaran mendadak (sakit, AC rusak, dll), bisa
                                                    gagal bayar</span>
                                            </li>
                                            <li class="flex items-start gap-2">
                                                <span class="text-yellow-600 flex-shrink-0">⚠</span>
                                                <span>Tidak ada ruang untuk menabung atau investasi</span>
                                            </li>
                                            <li class="flex items-start gap-2">
                                                <span class="text-yellow-600 flex-shrink-0">⚠</span>
                                                <span>Stres finansial tinggi selama {{ $calculation_result['total_days'] }}
                                                    hari</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="mt-3 bg-yellow-100 border border-yellow-400 rounded-lg p-2.5">
                                        <p class="text-xs font-semibold text-yellow-900 mb-1">Syarat Melanjutkan:</p>
                                        <ul class="text-xs text-yellow-900 space-y-1 list-disc list-inside">
                                            <li><strong>Wajib punya dana darurat</strong> minimal 3 bulan pengeluaran
                                                (Rp {{ number_format($monthly_expense * 3, 0, ',', '.') }})</li>
                                            <li>Yakin tidak ada pinjaman/cicilan lain yang berjalan</li>
                                            <li>Pendapatan stabil dan tidak akan turun</li>
                                            <li>Sanggup hidup sangat hemat selama masa cicilan</li>
                                            <li>Punya rencana cadangan jika pendapatan terganggu</li>
                                        </ul>
                                    </div>

                                    <div class="mt-3 bg-red-50 border border-red-300 rounded-lg p-2.5">
                                        <label class="flex items-start gap-2 cursor-pointer">
                                            <input type="checkbox" wire:model="confirm_warning"
                                                class="mt-0.5 rounded border-red-300 text-red-600 focus:ring-red-500">
                                            <span class="text-xs text-red-900">
                                                <strong>Saya memahami semua risiko di atas</strong> dan tetap ingin
                                                melanjutkan rencana ini. Saya sadar keuangan saya akan sangat ketat dan
                                                berisiko gagal bayar.
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- NOT FEASIBLE --}}
                        <div class="bg-red-50 border-2 border-red-400 rounded-xl p-4">
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-red-900 mb-2">Rencana TIDAK LAYAK - DITOLAK!
                                    </p>
                                    <p class="text-xs text-red-800 mb-3">{{ $calculation_result['message'] }}</p>

                                    <div class="bg-white/60 rounded-lg p-3 space-y-2">
                                        <p class="text-xs font-semibold text-red-900">Mengapa Ditolak:</p>
                                        <ul class="text-xs text-red-900 space-y-1.5">
                                            <li class="flex items-start gap-2">
                                                <span class="text-red-600 flex-shrink-0">✗</span>
                                                <span>
                                                    @if ($ratio > 40)
                                                        <strong>Rasio {{ number_format($ratio, 1) }}%</strong> -
                                                        Melebihi batas maksimal 40%! Beban hutang sangat berbahaya
                                                    @elseif($remaining <= 0)
                                                        Cicilan melebihi sisa uang yang tersedia - Secara matematis
                                                        tidak mungkin!
                                                    @else
                                                        Sisa uang hanya
                                                        Rp {{ number_format($remaining, 0, ',', '.') }} - Tidak cukup
                                                        untuk hidup
                                                    @endif
                                                </span>
                                            </li>
                                            <li class="flex items-start gap-2">
                                                <span class="text-red-600 flex-shrink-0">✗</span>
                                                <span>Risiko gagal bayar dan kredit macet sangat tinggi (>80%)</span>
                                            </li>
                                            <li class="flex items-start gap-2">
                                                <span class="text-red-600 flex-shrink-0">✗</span>
                                                <span>Akan terlilit hutang dan sulit keluar</span>
                                            </li>
                                            <li class="flex items-start gap-2">
                                                <span class="text-red-600 flex-shrink-0">✗</span>
                                                <span>Tidak ada dana darurat sama sekali</span>
                                            </li>
                                            <li class="flex items-start gap-2">
                                                <span class="text-red-600 flex-shrink-0">✗</span>
                                                <span>Bisa merusak kesehatan finansial jangka panjang</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="mt-3 bg-red-100 border border-red-400 rounded-lg p-2.5">
                                        <p class="text-xs font-semibold text-red-900 mb-1.5">Dampak Jika Dipaksakan:
                                        </p>
                                        <ul class="text-xs text-red-900 space-y-1 list-disc list-inside">
                                            <li>Tidak bisa makan dengan layak atau bayar listrik</li>
                                            <li>Terpaksa pinjam lagi (debt trap/jerat hutang)</li>
                                            <li>Nama masuk blacklist BI Checking</li>
                                            <li>Aset bisa disita</li>
                                            <li>Stres berat dan masalah kesehatan mental</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- SARAN ALTERNATIF (Hanya jika tidak layak atau warning) --}}
                    @if (!empty($calculation_result['suggestions']))
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 border-2 border-indigo-300 rounded-xl p-4">
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                                <p class="text-sm font-bold text-indigo-900">💡 Solusi Alternatif yang Disarankan</p>
                            </div>

                            <div class="space-y-3">
                                @foreach ($calculation_result['suggestions'] as $index => $suggestion)
                                    <div class="bg-white border-2 border-indigo-200 rounded-lg p-3">
                                        <div class="flex items-start gap-3">
                                            <div
                                                class="flex-shrink-0 w-8 h-8 bg-indigo-500 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                                {{ $index + 1 }}
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-indigo-900 mb-1">
                                                    {{ $suggestion['title'] }}</p>
                                                <p class="text-xs text-gray-700 mb-2">
                                                    {{ $suggestion['description'] }}</p>

                                                <div class="bg-indigo-50 rounded-lg p-2 mb-2">
                                                    <p class="text-xs font-semibold text-indigo-900">
                                                        Rekomendasi: <span
                                                            class="text-indigo-700">{{ $suggestion['value'] }}</span>
                                                    </p>
                                                </div>

                                                @if (isset($suggestion['warning']))
                                                    <p class="text-xs text-amber-700 bg-amber-50 rounded p-2 border border-amber-200">
                                                        {{ $suggestion['warning'] }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-3 bg-blue-50 border border-blue-200 rounded-lg p-3">
                                <p class="text-xs text-blue-900">
                                    <strong>💬 Rekomendasi Kami:</strong> Pertimbangkan salah satu solusi di atas
                                    untuk membuat rencana cicilan yang lebih aman dan realistis. Jangan paksa diri
                                    dengan rencana yang tidak sehat!
                                </p>
                            </div>
                        </div>
                    @endif

                </div>
            @endif

            <!-- FOOTER BUTTONS -->
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-2 sm:gap-3 pt-4 border-t mt-6">

                {{-- Tombol Batal --}}
                <button x-on:click="$dispatch('close-modal', 'modal-create')" type="button"
                    class="w-full sm:w-auto border-2 border-gray-300 px-4 py-2.5 sm:py-2 rounded-lg hover:bg-gray-50 active:bg-gray-100 transition-colors duration-200 font-medium text-sm text-gray-700">
                    Batal
                </button>

                {{-- Tombol Kembali & Edit (Muncul saat show_result = true) --}}
                @if ($show_result)
                    <button type="button" wire:click="backToForm"
                        class="w-full sm:w-auto border-2 border-blue-600 text-blue-600 px-4 py-2.5 sm:py-2 rounded-lg hover:bg-blue-50 active:bg-blue-100 transition-all duration-200 font-medium text-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                        </svg>
                        Kembali & Edit
                    </button>
                @endif

                {{-- Tombol Submit --}}
                @if ($show_result && $calculation_result)
                    @if ($calculation_result['is_feasible'])
                        {{-- Tombol Simpan (FEASIBLE atau WARNING dengan konfirmasi) --}}
                        @if ($status === 'warning' && !$confirm_warning)
                            <button type="button" disabled
                                class="w-full sm:w-auto bg-gray-300 text-gray-600 px-4 py-2.5 sm:py-2 rounded-lg font-medium text-sm cursor-not-allowed flex items-center justify-center gap-2">
                                Centang Konfirmasi Dulu
                            </button>
                        @else
                            <button type="button" wire:click="save" wire:loading.attr="disabled"
                                class="w-full sm:w-auto bg-gradient-to-r from-green-600 to-green-700 text-white px-4 py-2.5 sm:py-2 rounded-lg hover:from-green-700 hover:to-green-800 active:from-green-800 active:to-green-900 transition-all duration-200 font-medium text-sm shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="save">
                                    Simpan Rencana Cicilan
                                </span>
                                <span wire:loading wire:target="save" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Menyimpan...
                                </span>
                            </button>
                        @endif
                    @else
                        {{-- Tombol Disabled (NOT FEASIBLE) --}}
                        <button type="button" disabled
                            class="w-full sm:w-auto bg-gray-300 text-gray-600 px-4 py-2.5 sm:py-2 rounded-lg font-medium text-sm cursor-not-allowed flex items-center justify-center gap-2">
                            Rencana Tidak Layak Disimpan
                        </button>
                    @endif
                @else
                    {{-- Tombol Hitung (Default) --}}
                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-2.5 sm:py-2 rounded-lg hover:from-blue-700 hover:to-blue-800 active:from-blue-800 active:to-blue-900 transition-all duration-200 font-medium text-sm shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                        <span wire:loading.remove wire:target="interimCalculation">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            Hitung & Analisis Rencana
                        </span>
                        <span wire:loading wire:target="interimCalculation" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Menganalisis...
                        </span>
                    </button>
                @endif

            </div>

        </form>

    </div>
</x-modal>
