<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Transaksi
        </h2>
    </x-slot>

    <div class="py-12">
        
        <div class="py-8 flex justify-center">
            <div class="max-w-6xl w-full px-4">
                <!-- GRID CARD -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    <!-- TOTAL PEMASUKAN -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-green-700 font-medium mb-1">Total Pemasukan</p>
                                <p class="text-2xl font-bold text-green-800">
                                    Rp {{ number_format($summary['income'] ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- TOTAL PENGELUARAN -->
                    <div class="bg-gradient-to-br from-red-50 to-red-100 border border-red-200 rounded-xl p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-red-700 font-medium mb-1">Total Pengeluaran</p>
                                <p class="text-2xl font-bold text-red-800">
                                    Rp {{ number_format($summary['expense'] ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-red-200 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- SALDO BERSIH -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-blue-700 font-medium mb-1">Saldo Bersih</p>
                                <p class="text-2xl font-bold text-blue-800">
                                    Rp {{ number_format($summary['difference'] ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
        </div>


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Deskripsi
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jumlah
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($transactions as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        02 Jan 2026
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        Gaji Bulanan
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item['type'] === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'  }}">
                                            {{ $item['type'] === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium    {{ $item['type'] === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $item['type'] === 'income' ? '+' : '-' }}
                                        Rp {{ number_format($item['amount'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center gap-2">
                                            <button 
                                            x-data
                                            x-on:click.prevent="
                                                            $dispatch('edit-transaction', { id: {{ $item->id }} });
                                                            $dispatch('open-modal', 'modal-edit');
                                                        "
                                            class="inline-flex items-center px-3 py-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 text-xs font-medium rounded-md transition-colors duration-150">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </button>
                                            <button 
                                            x-data
                                            x-on:click.prevent="
                                                            $dispatch('confirm-delete', { id: {{ $item->id }} });
                                                            $dispatch('open-modal', 'modal-delete');
                                                        "
                                            class="inline-flex items-center px-3 py-1.5 text-red-600 hover:text-red-800 hover:bg-red-50 text-xs font-medium rounded-md transition-colors duration-150">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <!-- Showing Info -->
                        <div class="text-sm text-gray-700">
                            Menampilkan 
                            <span class="font-medium">{{ $transactions->firstItem() }}</span> sampai 
                            <span class="font-medium">{{ $transactions->lastItem() }}</span> dari 
                            <span class="font-medium">{{ $transactions->total() }}</span> transaksi
                        </div>

                        <!-- Pagination Buttons -->
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <!-- Previous Button -->
                            <button 
                            wire:click='previousPage'
                            wire:loading.attr='disabled'
                            @if ($this->transactions->onFirstPage()) disabled @endif
                            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 
                            {{ $this->transactions->onfirstPage() 
                            ? 'disabled:opacity-50 disabled:cursor-not-allowed'
                            : 'bg-white text-sm font-medium text-gray-500 hover:bg-gray-50'}}">
                                <span class="sr-only">Previous</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </button>

                            <!-- Page Numbers -->
                            @foreach ($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                                <button 
                                wire:click='gotoPage({{ $page }})'
                                class="relative inline-flex items-center px-4 py-2 border text-sm font-medium
                                {{ $page === $transactions->currentPage()
                                ? 'bg-blue-50 text-blue-600'
                                : 'bg-white text-gray-700 hover:bg-gray-50' }}"
                                >
                                    {{ $page }}
                                </button>
                            @endforeach
                        
                            <!-- Next Button -->
                            <button 
                            wire:click='nextPage'
                            wire:loading.attr='disabled'
                            @if (!$this->transactions->hasMorePages()) disabled @endif
                            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 
                            {{!$this->transactions->hasMorePages() 
                            ? 'disabled:opacity-50 disabled:cursor-not-allowed'
                            : 'bg-white text-sm font-medium text-gray-500 hover:bg-gray-50'}}">
                                <span class="sr-only">Next</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <livewire:transactions.edit />
        <livewire:transactions.delete />

    </div>
</div>