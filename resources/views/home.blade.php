<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>
    
    

    <div class="py-12 flex justify-center">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl w-full px-4">

            <!-- TOTAL UANG -->
            <div class="bg-white shadow-md rounded-xl p-6 flex items-center gap-4">
                <div class="bg-green-100 text-green-600 p-4 rounded-full">
                    <!-- Icon Wallet -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2m4-3h-6a2 2 0 000 4h6v-4z" />
                    </svg>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Total Uang</p>
                    <p class="text-2xl font-bold text-gray-800">
                        Rp {{ number_format($totalUang ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- UANG MASUK -->
            <div class="bg-white shadow-md rounded-xl p-6 flex items-center gap-4">
                <div class="bg-blue-100 text-blue-600 p-4 rounded-full">
                    <!-- Icon Arrow Down -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v16m0 0l-6-6m6 6l6-6" />
                    </svg>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Uang Masuk</p>
                    <p class="text-2xl font-bold text-gray-800">
                        Rp {{ number_format($uangMasuk ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- UANG KELUAR -->
            <div class="bg-white shadow-md rounded-xl p-6 flex items-center gap-4">
                <div class="bg-red-100 text-red-600 p-4 rounded-full">
                    <!-- Icon Arrow Up -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 20V4m0 0l6 6m-6-6l-6 6" />
                    </svg>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Uang Keluar</p>
                    <p class="text-2xl font-bold text-gray-800">
                        Rp {{ number_format($uangKeluar ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto">
        <div class="max-w-6xl mx-auto flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Catatan Keuangan Terakhir</h2>

            <button
                x-data
                x-on:click.prevent="$dispatch('open-modal', 'modal-tambah')"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                + Tambah Catatan
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- CARD PENGELUARAN -->
            <div class="bg-white shadow-md rounded-xl p-5 border-l-4 border-red-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">15 Jan 2025</p>
                        <p class="font-semibold text-gray-800">Makan</p>
                    </div>

                    <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded">
                        Pengeluaran
                    </span>
                </div>

                <p class="text-xl font-bold text-red-600 mt-4">
                    - Rp 25.000
                </p>

                <p class="text-sm text-gray-500 mt-2">
                    Tunai • Makan siang
                </p>

                <div class="mt-4 flex justify-end gap-3">
                    <!-- EDIT -->
                    <button
                        x-data
                        x-on:click.prevent="$dispatch('open-modal', 'modal-edit')"
                        class="text-sm text-blue-600 hover:underline">
                        Edit
                    </button>

                    <!-- DELETE -->
                    <button
                        x-data
                        x-on:click.prevent="$dispatch('open-modal', 'modal-delete')"
                        class="text-sm text-red-600 hover:underline">
                        Delete
                    </button>
                </div>
            </div>

            <!-- CARD PEMASUKAN -->
            <div class="bg-white shadow-md rounded-xl p-5 border-l-4 border-green-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">14 Jan 2025</p>
                        <p class="font-semibold text-gray-800">Gaji</p>
                    </div>

                    <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded">
                        Pemasukan
                    </span>
                </div>

                <p class="text-xl font-bold text-green-600 mt-4">
                    + Rp 3.000.000
                </p>

                <p class="text-sm text-gray-500 mt-2">
                    Transfer • Gaji Bulanan
                </p>

                <div class="mt-4 flex justify-end gap-3">
                    <!-- EDIT -->
                    <button
                        x-data
                        x-on:click.prevent="$dispatch('open-modal', 'modal-edit')"
                        class="text-sm text-blue-600 hover:underline">
                        Edit
                    </button>

                    <!-- DELETE -->
                    <button
                        x-data
                        x-on:click.prevent="$dispatch('open-modal', 'modal-delete')"
                        class="text-sm text-red-600 hover:underline">
                        Delete
                    </button>
                </div>
            </div>

            <!-- COPY CARD SAMPAI 10 ITEM -->

        </div>
        <livewire:transaksi.modal-tambah />
        <livewire:transaksi.modal-edit />
        <livewire:transaksi.modal-delete />
    </div>



</x-app-layout>
