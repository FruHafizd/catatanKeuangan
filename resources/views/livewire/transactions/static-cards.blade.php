<div class="py-8 flex justify-center">
       <div class="max-w-6xl w-full px-4">

        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">
                Catatan Keuangan
            </h1>
            <p class="text-sm text-gray-500">
                {{ Carbon\Carbon::now()->translatedFormat('F Y') }}
            </p>
        </div>

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