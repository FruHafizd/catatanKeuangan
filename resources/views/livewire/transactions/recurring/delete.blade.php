<x-modal name="modal-delete" focusable>
    <div class="p-4 sm:p-6">

        <!-- HEADER -->
        <div class="flex items-start gap-3 sm:gap-4 mb-4 sm:mb-6">
            <div class="flex-shrink-0 bg-red-100 text-red-600 p-2.5 sm:p-3 rounded-full">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h2 class="text-base sm:text-lg font-semibold text-gray-900">
                    Hapus Transaksi Berulang
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Apakah Anda yakin ingin melanjutkan?
                </p>
            </div>
        </div>

        <!-- CONTENT WARNING -->
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-4 sm:mb-6">
            <div class="flex gap-3">
                <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-sm font-semibold text-amber-900 mb-1">
                        Transaksi berulang akan dihapus secara permanen
                    </p>
                    <p class="text-xs text-amber-800 leading-relaxed">
                        Jika sudah ada transaksi yang dihasilkan, maka akan transaksinya tidak akan hilang, yang hilang cuman. Pengaturan Trasaksi Berulang.
                    </p>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="flex flex-col-reverse sm:flex-row justify-end gap-2 sm:gap-3">
            <button
                x-on:click="
                $dispatch('close-modal', 'modal-delete');
                $dispatch('close-delete-modal');
                "
                type="button"
                class="w-full sm:w-auto border-2 border-gray-300 px-4 py-2.5 sm:py-2 rounded-lg hover:bg-gray-50 active:bg-gray-100 transition-colors duration-200 font-medium text-sm text-gray-700">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Batal
                </span>
            </button>

            <button
                wire:click="delete"
                wire:loading.attr="disabled"
                type="button"
                class="w-full sm:w-auto bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2.5 sm:py-2 rounded-lg hover:from-red-700 hover:to-red-800 active:from-red-800 active:to-red-900 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 font-medium text-sm shadow-lg hover:shadow-xl">
                <span wire:loading.remove wire:target="delete" class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Ya, Lanjutkan
                </span>
                <span wire:loading wire:target="delete" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses...
                </span>
            </button>
        </div>

    </div>
</x-modal>