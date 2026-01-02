<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beranda') }}
        </h2>
    </x-slot>
    
    <livewire:transactions.static-cards />

    <div class="max-w-6xl mx-auto">
        <div class="max-w-6xl mx-auto flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Catatan Keuangan Terakhir</h2>

            <button
                x-data
                x-on:click.prevent="$dispatch('open-modal', 'modal-create')"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                + Tambah Catatan
            </button>
        </div>

        <livewire:transactions.index />
        <livewire:transactions.create />
        <livewire:transactions.edit />
        <livewire:transactions.delete />
    </div>



</div>
