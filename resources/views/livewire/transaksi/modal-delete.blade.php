<x-modal name="modal-delete" focusable>
    <div class="p-6">

        <!-- HEADER -->
        <div class="flex items-center gap-3 mb-4">
            <div class="bg-red-100 text-red-600 p-2 rounded-full">
                ⚠️
            </div>
            <h2 class="text-lg font-semibold">
                Hapus Catatan Keuangan
            </h2>
        </div>

        <!-- CONTENT -->
        <p class="text-sm text-gray-600">
            Apakah kamu yakin ingin menghapus catatan ini?
            Tindakan ini <span class="font-semibold text-red-600">tidak bisa dibatalkan</span>.
        </p>

        <!-- FOOTER -->
        <div class="flex justify-end gap-3 mt-6">
            <button
                x-on:click="$dispatch('close-modal', 'modal-delete')"
                class="border px-4 py-2 rounded-lg">
                Batal
            </button>

            <button
                wire:click="destroy"
                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                Hapus
            </button>

        </div>

    </div>
</x-modal>
