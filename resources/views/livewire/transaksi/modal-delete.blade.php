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
                    Hapus Catatan Keuangan
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Data akan dihapus permanen
                </p>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="bg-red-50 border border-red-100 rounded-lg p-3 sm:p-4 mb-4 sm:mb-6">
            <p class="text-xs sm:text-sm text-gray-700 leading-relaxed">
                Apakah kamu yakin ingin menghapus catatan ini?
                <span class="block mt-2 font-semibold text-red-600">
                    ⚠️ Tindakan ini tidak bisa dibatalkan
                </span>
            </p>
        </div>

        <!-- FOOTER -->
        <div class="flex flex-col-reverse sm:flex-row justify-end gap-2 sm:gap-3">
            <button
                x-on:click="$dispatch('close-modal', 'modal-delete')"
                type="button"
                class="w-full sm:w-auto border-2 border-gray-300 px-4 py-2.5 sm:py-2 rounded-lg hover:bg-gray-50 active:bg-gray-100 transition-colors duration-200 font-medium text-sm text-gray-700">
                Batal
            </button>

            <button
                wire:click="destroy"
                wire:loading.attr="disabled"
                type="button"
                class="w-full sm:w-auto bg-red-600 text-white px-4 py-2.5 sm:py-2 rounded-lg hover:bg-red-700 active:bg-red-800 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 font-medium text-sm shadow-sm hover:shadow-md">
                <span wire:loading.remove wire:target="destroy">Hapus Catatan</span>
                <span wire:loading wire:target="destroy" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Menghapus...
                </span>
            </button>
        </div>

    </div>
</x-modal>