<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Transaksi
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- BALANCE SUMMARY --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Total Income -->
                <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 mb-1">Total Pemasukan</p>
                            <p class="text-2xl font-bold text-green-600">
                                Rp {{ number_format($this->totalIncome, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full flex-shrink-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Expenditure -->
                <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 mb-1">Total Pengeluaran</p>
                            <p class="text-2xl font-bold text-red-600">
                                Rp {{ number_format($this->totalExpenditure, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="bg-red-100 p-3 rounded-full flex-shrink-0">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Balance Difference -->
                <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 mb-1">Selisih Saldo</p>
                            <p class="text-2xl font-bold {{ $this->balance >= 0 ? 'text-blue-600' : 'text-orange-600' }}">
                                Rp {{ number_format(abs($this->balance), 0, ',', '.') }}
                            </p>
                            <p class="text-xs {{ $this->balance >= 0 ? 'text-green-600' : 'text-orange-600' }} font-medium mt-1">
                                {{ $this->balance >= 0 ? '✓ Surplus' : '⚠ Defisit' }}
                            </p>
                        </div>
                        <div class="{{ $this->balance >= 0 ? 'bg-blue-100' : 'bg-orange-100' }} p-3 rounded-full flex-shrink-0">
                            <svg class="w-6 h-6 {{ $this->balance >= 0 ? 'text-blue-600' : 'text-orange-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FILTER SECTION --}}
            <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Filter & Pencarian</h3>

                </div>

                <div class="space-y-4">
                    <!-- Year and Month -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Filter Year -->
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Tahun
                            </label>
                            <select
                                id="year"
                                wire:model.live="year"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none text-sm bg-white"
                            >
                                <option value="">Semua Tahun</option>
                                @foreach ($this->years as $y)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Month -->
                        <div>
                            <label for="month" class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Bulan
                            </label>
                            <select 
                                id="month" 
                                wire:model.live="month"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none text-sm bg-white"
                            >
                                <option value="">Semua Bulan</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                    </div>

                    <!-- Payment Categories and Methods -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Category Filter -->
                        <div>
                            <label for="type_transaction" class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Kategori
                            </label>
                            <select 
                                id="type_transaction" 
                                wire:model.live="type_transaction"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none text-sm bg-white"
                            >
                                <option value="">Semua Kategori</option>
                                <option value="Income">Income (Pemasukan)</option>
                                <option value="Expenditure">Expenditure (Pengeluaran)</option>
                            </select>
                        </div>

                        <!-- Payment Method Filter -->
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                Metode Pembayaran
                            </label>
                            <select 
                                id="payment_method" 
                                wire:model.live="payment_method"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none text-sm bg-white"
                            >
                                <option value="">Semua Metode</option>
                                <option value="Cash">Cash (Tunai)</option>
                                <option value="E-wallet">E-wallet</option>
                                <option value="Debit">Kartu Debit</option>
                            </select>
                        </div>
                    </div>

                    <!-- Clear Filter Button -->
                    @if($year || $month || $type_transaction || $payment_method)
                        <div class="flex justify-end pt-2">
                            <button 
                                type="button"
                                wire:click="clearFilter"
                                class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium text-sm inline-flex items-center gap-2"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Bersihkan Filter
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            {{-- TABLE --}}
            <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
                <!-- Table Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Daftar Transaksi</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Menampilkan <span class="font-semibold text-gray-700">{{ $this->transaction->total() }}</span> transaksi
                            </p>
                        </div>
                        
                        <!-- Loading Indicator -->
                        <div wire:loading class="flex items-center gap-2 text-blue-600">
                            <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-sm font-medium">Memuat...</span>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700 whitespace-nowrap">Tanggal</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700 whitespace-nowrap">Kategori</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700 whitespace-nowrap">Metode</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700 whitespace-nowrap">Keterangan</th>
                                <th class="px-6 py-3 text-right font-semibold text-gray-700 whitespace-nowrap">Jumlah</th>
                                <th class="px-6 py-3 text-center font-semibold text-gray-700 whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($this->transaction as $item)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <!-- Date -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <p class="font-medium text-gray-900">
                                                {{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($item->date)->translatedFormat('l') }}
                                            </p>
                                        </div>
                                    </td>

                                    <!-- Categories -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                            {{ $item->type_transaction === 'Expenditure' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                            <span class="mr-1">{{ $item->type_transaction === 'Expenditure' ? '↓' : '↑' }}</span>
                                            {{ $item->type_transaction === 'Expenditure' ? 'Pengeluaran' : 'Pemasukan' }}
                                        </span>
                                    </td>

                                    <!-- Method -->
                                    <td class="px-6 py-4 text-gray-700 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                            {{ $item->payment_method }}
                                        </div>
                                    </td>

                                    <!-- Information -->
                                    <td class="px-6 py-4 text-gray-900 max-w-xs truncate" title="{{ $item->information }}">
                                        {{ $item->information }}
                                    </td>

                                    <!-- Amount -->
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <span class="font-bold text-base
                                            {{ $item->type_transaction === 'Expenditure' ? 'text-red-600' : 'text-green-600' }}">
                                            {{ $item->type_transaction === 'Expenditure' ? '- ' : '+ ' }}
                                            Rp {{ number_format($item->amount_money, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <!-- Action -->
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <div class="flex justify-center gap-1">
                                            <button
                                                x-data
                                                x-on:click.prevent="
                                                    $dispatch('edit-transaction', { id: {{ $item->id }} });
                                                    $dispatch('open-modal', 'modal-edit');
                                                "
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition text-xs font-medium"
                                                title="Edit transaksi"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </button>

                                            <button
                                                x-data
                                                x-on:click.prevent="
                                                    $dispatch('confirm-delete', { id: {{ $item->id }} });
                                                    $dispatch('open-modal', 'modal-delete');
                                                "
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-red-600 hover:bg-red-50 rounded-lg transition text-xs font-medium"
                                                title="Hapus transaksi"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="text-lg font-medium text-gray-500">Tidak ada transaksi</p>
                                            <p class="text-sm text-gray-400 mt-1">Belum ada data transaksi yang tersedia</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($this->transaction->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <p class="text-sm text-gray-600">
                                Menampilkan
                                <span class="font-semibold text-gray-900">{{ $this->transaction->firstItem() ?? 0 }}</span>
                                -
                                <span class="font-semibold text-gray-900">{{ $this->transaction->lastItem() ?? 0 }}</span>
                                dari
                                <span class="font-semibold text-gray-900">{{ $this->transaction->total() }}</span>
                                transaksi
                            </p>
                            <div class="flex gap-2">
                                <!-- Previous -->
                                <button
                                    wire:click="previousPage"
                                    wire:loading.attr="disabled"
                                    @if ($this->transaction->onFirstPage()) disabled @endif
                                    class="inline-flex items-center gap-2 px-4 py-2 border rounded-lg text-sm font-medium transition
                                    {{ $this->transaction->onFirstPage() 
                                        ? 'opacity-50 cursor-not-allowed bg-gray-100 text-gray-400' 
                                        : 'bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-400' }}"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    Sebelumnya
                                </button>

                                <!-- Page Number -->
                                <div class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold">
                                    {{ $this->transaction->currentPage() }}
                                </div>

                                <!-- Next -->
                                <button
                                    wire:click="nextPage"
                                    wire:loading.attr="disabled"
                                    @if (!$this->transaction->hasMorePages()) disabled @endif
                                    class="inline-flex items-center gap-2 px-4 py-2 border rounded-lg text-sm font-medium transition
                                    {{ !$this->transaction->hasMorePages() 
                                        ? 'opacity-50 cursor-not-allowed bg-gray-100 text-gray-400' 
                                        : 'bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-400' }}"
                                >
                                    Selanjutnya
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>

        {{-- MODALS --}}
        <livewire:transaksi.modal-edit />
        <livewire:transaksi.modal-delete />
    </div>
</div>