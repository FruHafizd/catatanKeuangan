<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beranda') }}
        </h2>
    </x-slot>
    
        <livewire:layout.home.static-cards />

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

        <div class="grid grid-cols-1 sm:grid-cols-2P lg:grid-cols-3 gap-6">

            @foreach ($transactions as $item)
                    <div
                        class="bg-white shadow-md rounded-xl p-5 border-l-4
                        {{ $item['type_transaction'] === 'Income'
                            ? 'border-green-500'
                            : 'border-red-500' }}">

                        <!-- HEADER -->
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($item['date'])->format('d M Y') }}
                                </p>
                                <p class="font-semibold text-gray-800">
                                    {{ $item['information'] }}
                                </p>
                            </div>

                            <span
                                class="text-xs px-2 py-1 rounded
                                {{ $item['type_transaction'] === 'Income'
                                    ? 'bg-green-100 text-green-600'
                                    : 'bg-red-100 text-red-600' }}">
                                {{ $item['type_transaction'] === 'Income'
                                    ? 'Pemasukan'
                                    : 'Pengeluaran' }}
                            </span>
                        </div>

                        <!-- AMOUNT -->
                        <p
                            class="text-xl font-bold mt-4
                            {{ $item['type_transaction'] === 'Income'
                                ? 'text-green-600'
                                : 'text-red-600' }}">
                            {{ $item['type_transaction'] === 'Income' ? '+' : '-' }}
                            Rp {{ number_format($item['amount_money'], 0, ',', '.') }}
                        </p>

                        <!-- FOOTER INFO -->
                        <p class="text-sm text-gray-500 mt-2">
                            {{ $item['payment_method'] }} • {{ $item['information'] }}
                        </p>

                        <!-- ACTION -->
                        <div class="mt-4 flex justify-end gap-3">
                            <button
                                x-data
                                x-on:click.prevent="
                                    $dispatch('edit-transaction', { id: {{ $item->id }} });
                                    $dispatch('open-modal', 'modal-edit');
                                "
                                class="text-sm text-blue-600 hover:underline">
                                Edit
                            </button>

                            <button
                                x-data
                                x-on:click="$dispatch('open-modal', 'modal-delete')"
                                class="text-sm text-red-600 hover:underline">
                                Delete
                            </button>
                        </div>
                    </div>
                @endforeach


        </div>
        
        <livewire:transaksi.modal-tambah />
        <livewire:transaksi.modal-edit />
        <livewire:transaksi.modal-delete />
    </div>



</div>
