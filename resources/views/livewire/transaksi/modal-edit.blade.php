<x-modal name="modal-edit" focusable>

    <div class="p-6">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">
                Edit Catatan Keuangan
            </h2>

            <button
                x-on:click="$dispatch('close-modal', 'modal-edit')"
                class="text-gray-500 hover:text-gray-700">
                ✖
            </button>
        </div>

        <!-- FORM -->
        <form class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="text-sm">Tanggal</label>
                <input type="date" class="w-full border rounded-lg p-2">
            </div>

            <div>
                <label class="text-sm">Jumlah Uang</label>
                <input type="number" class="w-full border rounded-lg p-2">
            </div>

            <div>
                <label class="text-sm">Jenis Transaksi</label>
                <select class="w-full border rounded-lg p-2">
                    <option>Pemasukan</option>
                    <option>Pengeluaran</option>
                </select>
            </div>

            <div>
                <label class="text-sm">Metode Pembayaran</label>
                <select class="w-full border rounded-lg p-2">
                    <option>Tunai</option>
                    <option>Debit Bank A</option>
                    <option>Kredit Bank B</option>
                    <option>Gopay</option>
                    <option>OVO</option>
                    <option>Dana</option>
                </select>
            </div>

            <div>
                <label class="text-sm">Kategori</label>
                <select class="w-full border rounded-lg p-2">
                    <option>Makan</option>
                    <option>Transport</option>
                    <option>Hiburan</option>
                    <option>Tabungan</option>
                </select>
            </div>

            <div>
                <label class="text-sm">Keterangan</label>
                <input type="text" class="w-full border rounded-lg p-2">
            </div>

        </form>

        <!-- FOOTER -->
        <div class="flex justify-end gap-3 mt-6">
            <button
                x-on:click="$dispatch('close-modal', 'modal-edit')"
                class="px-4 py-2 border rounded-lg">
                Batal
            </button>

            <button
                type="button"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Simpan (Dummy)
            </button>
        </div>

    </div>

</x-modal>
