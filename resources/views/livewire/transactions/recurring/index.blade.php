<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaksi Berulang
        </h2>
    </x-slot>
    
    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header dengan tombol tambah -->
            <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Daftar Transaksi Berulang</h3>
                    <p class="mt-1 text-sm text-gray-600">Kelola transaksi yang berulang secara otomatis</p>
                </div>
                <button 
                    x-data
                    x-on:click.prevent="$dispatch('open-modal', 'modal-create')"
                    class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Transaksi
                </button>
            </div>

            @if($recurringTransactions->isEmpty())
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-16 text-center">
                        <div class="mx-auto w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Transaksi Berulang</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">
                            Mulai otomatisasi keuangan Anda dengan membuat transaksi berulang pertama. 
                            Sempurna untuk gaji bulanan, tagihan rutin, atau pengeluaran berkala.
                        </p>
                        <button 
                            x-data
                            x-on:click.prevent="$dispatch('open-modal', 'modal-create')"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Buat Transaksi Berulang
                        </button>
                    </div>
                </div>
            @else
                <!-- Desktop View - Tabel -->
                <div class="hidden lg:block bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Transaksi</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tipe</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Frekuensi</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Periode</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($recurringTransactions as $item)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4">
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $item->name }}</div>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    Terakhir: {{ $item->last_generated_at ? $item->last_generated_at->format('d M Y') : 'Belum ada' }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $item->type === 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $item->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-900">
                                                Rp {{ number_format($item->amount, 0, ',', '.') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                {{ ['daily' => 'Harian', 'weekly' => 'Mingguan', 'monthly' => 'Bulanan', 'yearly' => 'Tahunan'][$item->frequency] ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $item->start_date->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-500 mt-1">s/d {{ $item->end_date->format('d M Y') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $item->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                                <span class="w-1.5 h-1.5 mr-1.5 rounded-full {{ $item->is_active ? 'bg-green-500' : 'bg-gray-500' }}"></span>
                                                {{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button 
                                                    x-data
                                                    x-on:click.prevent="$dispatch('edit-recurring-transaction', { id: {{ $item->id }} })"
                                                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-md transition-colors duration-150">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Edit
                                                </button>
                                                <button 
                                                    x-data
                                                    x-on:click.prevent="$dispatch('delete-recurring-transaction', { id: {{ $item->id }} })"
                                                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded-md transition-colors duration-150">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Mobile & Tablet View - Cards -->
                <div class="lg:hidden space-y-4">
                    @foreach ($recurringTransactions as $item)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-4">
                                <!-- Header Card -->
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base font-semibold text-gray-900 truncate">{{ $item->name }}</h3>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Terakhir: {{ $item->last_generated_at ? $item->last_generated_at->format('d M Y') : 'Belum ada' }}
                                        </p>
                                    </div>
                                    <span class="ml-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $item->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }} whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 mr-1 rounded-full {{ $item->is_active ? 'bg-green-500' : 'bg-gray-500' }}"></span>
                                        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>
                                
                                <!-- Info Grid -->
                                <div class="grid grid-cols-2 gap-3 mb-3">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Tipe</p>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $item->type === 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $item->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Jumlah</p>
                                        <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($item->amount, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Frekuensi</p>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                            {{ ['daily' => 'Harian', 'weekly' => 'Mingguan', 'monthly' => 'Bulanan', 'yearly' => 'Tahunan'][$item->frequency] ?? '-' }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Periode</p>
                                        <p class="text-xs text-gray-900">{{ $item->start_date->format('d M Y') }}</p>
                                        <p class="text-xs text-gray-500">s/d {{ $item->end_date->format('d M Y') }}</p>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2 pt-3 border-t border-gray-100">
                                    <button 
                                        x-data
                                        x-on:click.prevent="$dispatch('edit-recurring-transaction', { id: {{ $item->id }} })"
                                        class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-blue-600 hover:bg-blue-50 rounded-md transition-colors duration-150">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </button>
                                    <button 
                                        x-data
                                        x-on:click.prevent="$dispatch('delete-recurring-transaction', { id: {{ $item->id }} })"
                                        class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-md transition-colors duration-150">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($recurringTransactions->hasPages())
                <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200 px-4 py-3">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <!-- Showing Info -->
                        <div class="text-sm text-gray-700 text-center sm:text-left">
                            Menampilkan 
                            <span class="font-medium">{{ $recurringTransactions->firstItem() }}</span> - 
                            <span class="font-medium">{{ $recurringTransactions->lastItem() }}</span> dari 
                            <span class="font-medium">{{ $recurringTransactions->total() }}</span> transaksi
                        </div>

                        <!-- Pagination Buttons -->
                        <nav class="inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <!-- Previous Button -->
                            <button 
                                wire:click='previousPage'
                                wire:loading.attr='disabled'
                                @if ($recurringTransactions->onFirstPage()) disabled @endif
                                class="relative inline-flex items-center px-3 py-2 rounded-l-md border border-gray-300 text-sm font-medium {{ $recurringTransactions->onFirstPage() ? 'bg-gray-50 text-gray-400 cursor-not-allowed' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </button>

                            <!-- Page Numbers - Desktop -->
                            <div class="hidden sm:flex">
                                @foreach ($recurringTransactions->getUrlRange(1, $recurringTransactions->lastPage()) as $page => $url)
                                    <button 
                                        wire:click='gotoPage({{ $page }})'
                                        class="relative inline-flex items-center px-4 py-2 border text-sm font-medium {{ $page === $recurringTransactions->currentPage() ? 'bg-blue-50 border-blue-500 text-blue-600 z-10' : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                                        {{ $page }}
                                    </button>
                                @endforeach
                            </div>

                            <!-- Current Page - Mobile -->
                            <div class="sm:hidden relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                {{ $recurringTransactions->currentPage() }} / {{ $recurringTransactions->lastPage() }}
                            </div>
                        
                            <!-- Next Button -->
                            <button 
                                wire:click='nextPage'
                                wire:loading.attr='disabled'
                                @if (!$recurringTransactions->hasMorePages()) disabled @endif
                                class="relative inline-flex items-center px-3 py-2 rounded-r-md border border-gray-300 text-sm font-medium {{ !$recurringTransactions->hasMorePages() ? 'bg-gray-50 text-gray-400 cursor-not-allowed' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </nav>
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>
    
    <livewire:transactions.recurring.create />
    <livewire:transactions.recurring.edit />
    <livewire:transactions.recurring.delete />
</div>