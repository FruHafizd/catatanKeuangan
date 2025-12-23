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
        <form wire:submit.prevent="update" class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="text-sm">Tanggal</label>
                <input type="date" wire:model="date" class="w-full border rounded-lg p-2">
                @error('date')
                        <span class="invalid-feedback">
                                {{ $message }}
                         </span>
                @enderror
            </div>

            <div
                x-data="{
                    raw: @entangle('amount_money'),
                    get display() {
                        if (!this.raw) return '';
                        return this.raw.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                    },
                    set display(value) {
                        this.raw = value.replace(/\D/g, '');
                    }
                }"
            >
                <label class="text-sm">Jumlah Uang</label>

                <input
                    type="text"
                    x-model="display"
                    class="w-full border rounded-lg p-2"
                    placeholder="Contoh: 1000"
                >

                @error('amount_money')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>



            <div>
                <label class="text-sm">Jenis Transaksi</label>
                <select class="w-full border rounded-lg p-2" wire:model="type_transaction">
                    <option value="">-- Pilih Metode --</option>
                    <option value="Income">Pemasukan</option>
                    <option value="Expenditure">Pengeluaran</option>
                </select>
                @error('type_transaction')
                        <span class="invalid-feedback">
                                {{ $message }}
                         </span>
                @enderror
            </div>

            <div>
                <label class="text-sm">Metode Pembayaran</label>
                <select class="w-full border rounded-lg p-2" wire:model="payment_method">
                    <option value="">-- Pilih Metode --</option>
                    <option value="Cash">Tunai</option>
                    <option value="Debit">Debit</option>
                    <option value="E-wallet">E-Wallet</option>
                </select>
                @error('payment_method')
                        <span class="invalid-feedback">
                                {{ $message }}
                         </span>
                @enderror
            </div>

            {{-- <div>
                <label class="text-sm">Kategori</label>
                <input type="text" class="w-full border rounded-lg p-2">
            </div> --}}

            <div>
                <label class="text-sm">Keterangan</label>
                <input type="text" class="w-full border rounded-lg p-2" wire:model="information">
                @error('information')
                        <span class="invalid-feedback">
                                {{ $message }}
                         </span>
                @enderror
            </div>


            <!-- FOOTER -->
            <div class="flex justify-end gap-3 mt-6">
                <button
                    x-on:click="$dispatch('close-modal', 'modal-tambah')"
                    class="border px-4 py-2 rounded-lg">
                    Batal
                </button>

                <button
                    wire:click="update"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</x-modal>
