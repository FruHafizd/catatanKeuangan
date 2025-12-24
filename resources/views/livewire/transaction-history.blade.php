<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Transaksi
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Filter Section -->
            <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Filter & Pencarian</h3>
                    <button type="button" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Reset Filter
                    </button>
                </div>

                <form class="space-y-4">
                    <!-- Baris 1: Pencarian dan Bulan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Pencarian Kata Kunci -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                                Cari Keterangan
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="search" 
                                    name="search"
                                    placeholder="Cari dalam keterangan..." 
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                >
                                <svg class="absolute left-3 top-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Filter Bulan -->
                        <div>
                            <label for="month" class="block text-sm font-medium text-gray-700 mb-2">
                                Bulan
                            </label>
                            <select 
                                id="month" 
                                name="month"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            >
                                <option value="">Semua Bulan</option>
                                <option value="2025-01">Januari 2025</option>
                                <option value="2025-02">Februari 2025</option>
                                <option value="2025-03">Maret 2025</option>
                                <option value="2025-04">April 2025</option>
                                <option value="2025-05">Mei 2025</option>
                                <option value="2025-06">Juni 2025</option>
                                <option value="2025-07">Juli 2025</option>
                                <option value="2025-08">Agustus 2025</option>
                                <option value="2025-09">September 2025</option>
                                <option value="2025-10">Oktober 2025</option>
                                <option value="2025-11">November 2025</option>
                                <option value="2025-12" selected>Desember 2025</option>
                            </select>
                        </div>
                    </div>

                    <!-- Baris 2: Kategori dan Metode Pembayaran -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Filter Kategori -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori
                            </label>
                            <select 
                                id="category" 
                                name="category"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            >
                                <option value="">Semua Kategori</option>
                                <option value="income">Income (Pemasukan)</option>
                                <option value="expenditure">Expenditure (Pengeluaran)</option>
                            </select>
                        </div>

                        <!-- Filter Metode Pembayaran -->
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                                Metode Pembayaran
                            </label>
                            <select 
                                id="payment_method" 
                                name="payment_method"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            >
                                <option value="">Semua Metode</option>
                                <option value="cash">Cash (Tunai)</option>
                                <option value="e-wallet">E-wallet</option>
                                <option value="bank_transfer">Transfer Bank</option>
                                <option value="credit_card">Kartu Kredit</option>
                                <option value="debit_card">Kartu Debit</option>
                            </select>
                        </div>
                    </div>

                    <!-- Baris 3: Rentang Tanggal Custom -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Mulai
                            </label>
                            <input 
                                type="date" 
                                id="date_from" 
                                name="date_from"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            >
                        </div>

                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Akhir
                            </label>
                            <input 
                                type="date" 
                                id="date_to" 
                                name="date_to"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            >
                        </div>
                    </div>

                    <!-- Tombol Filter -->
                    <div class="flex justify-end gap-3 pt-2">
                        <button 
                            type="button"
                            class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium"
                        >
                            Bersihkan
                        </button>
                        <button 
                            type="submit"
                            class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium shadow-sm"
                        >
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
                <!-- Table Header dengan Info -->
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Daftar Transaksi</h3>
                        <p class="text-sm text-gray-500 mt-1">Menampilkan 2 transaksi</p>
                    </div>
                    <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium shadow-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Transaksi
                    </button>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Tanggal</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Kategori</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Metode</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Keterangan</th>
                                <th class="px-6 py-3 text-right font-semibold text-gray-700">Jumlah</th>
                                <th class="px-6 py-3 text-center font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <!-- Baris 1 -->
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                            <span class="text-xs font-bold text-red-700">24</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">24 Des 2025</p>
                                            <p class="text-xs text-gray-500">Selasa</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"></path>
                                        </svg>
                                        Pengeluaran
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center text-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Cash
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-gray-900">Beli makan siang</p>
                                </td>

                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <p class="font-bold text-red-600 text-base">- Rp 25.000</p>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="#" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Baris 2 -->
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                            <span class="text-xs font-bold text-green-700">23</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">23 Des 2025</p>
                                            <p class="text-xs text-gray-500">Senin</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        Pemasukan
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center text-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        E-wallet
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-gray-900">Gaji freelance</p>
                                </td>

                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <p class="font-bold text-green-600 text-base">+ Rp 500.000</p>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="#" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                    <p class="text-sm text-gray-600">
                        Menampilkan <span class="font-semibold">1-2</span> dari <span class="font-semibold">2</span> transaksi
                    </p>
                    <div class="flex gap-2">
                        <button class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            Sebelumnya
                        </button>
                        <button class="px-3 py-2 bg-blue-600 text-white rounded-lg font-medium">
                            1
                        </button>
                        <button class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            Selanjutnya
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>