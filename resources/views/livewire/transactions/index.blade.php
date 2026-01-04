<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

    @foreach ($transactions as $item)
        <div
            class="bg-white shadow-md rounded-xl p-5 border-l-4
                        {{ $item->type === 'income' ? 'border-green-500' : 'border-red-500' }}">

            <!-- HEADER -->
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">
                        {{ $item->date->format('d M Y') }}
                    </p>
                    <p class="font-semibold text-gray-800">
                        {{ $item['name'] }}
                    </p>
                </div>

                <span
                    class="text-xs px-2 py-1 rounded
                                {{ $item['type'] === 'income' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                    {{ $item['type'] === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                </span>
            </div>

            <!-- AMOUNT -->
            <p
                class="text-xl font-bold mt-4
                            {{ $item['type'] === 'income' ? 'text-green-600' : 'text-red-600' }}">
                {{ $item['type'] === 'income' ? '+' : '-' }}
                Rp {{ number_format($item['amount'], 0, ',', '.') }}
            </p>


            <!-- ACTION -->
            <div class="mt-4 flex justify-end gap-3">
                <button x-data
                    x-on:click.prevent="
                                    $dispatch('edit-transaction', { id: {{ $item->id }} });
                                    $dispatch('open-modal', 'modal-edit');
                                "
                    class="text-sm text-blue-600 hover:underline">
                    Edit
                </button>

                <button x-data
                    x-on:click.prevent="
                                    $dispatch('confirm-delete', { id: {{ $item->id }} });
                                    $dispatch('open-modal', 'modal-delete');
                                "
                    class="text-sm text-red-600 hover:underline">
                    Delete
                </button>

            </div>
        </div>
    @endforeach


</div>
