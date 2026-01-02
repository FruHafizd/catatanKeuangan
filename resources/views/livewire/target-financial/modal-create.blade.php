<x-modal name="modal-create-target" focusable>
    <div class="p-4 sm:p-6 max-h-[90vh] overflow-y-auto">

        <!-- HEADER -->
        <div class="flex justify-between items-start mb-4 sm:mb-6 sticky top-0 bg-white pb-4 border-b">
            <div>
                <h2 class="text-lg sm:text-xl font-semibold text-gray-900">
                    Tambah Target Tabungan
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Buat target tabungan baru untuk mencapai tujuan finansialmu
                </p>
            </div>

            <button
                x-on:click="$dispatch('close-modal', 'modal-create-target')"
                type="button"
                class="flex-shrink-0 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-1.5 transition-colors duration-200 ml-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- FORM -->
        <form wire:submit.prevent="createTarget" class="space-y-4">

            <!-- Nama Target -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Target <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="name"
                    wire:model="name"
                    placeholder="Contoh: Liburan ke Bali, Beli Laptop Baru"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image -->
            <div
                x-data="{
                    imagePreview: null
                }"
                class="space-y-2"
            >
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Gambar Target
                </label>

                <div class="flex items-center gap-4">

                    <!-- Preview -->
                    <div class="w-24 h-24 rounded-lg border border-dashed border-gray-300 flex items-center justify-center overflow-hidden bg-gray-50">
                        <template x-if="imagePreview">
                            <img :src="imagePreview" class="w-full h-full object-cover">
                        </template>

                        <template x-if="!imagePreview">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5h18M3 19h18M5 7v10M19 7v10" />
                            </svg>
                        </template>
                    </div>

                    <!-- Input FILE -->
                    <input
                        type="file"
                        accept="image/*"
                        wire:model="image"
                        @change="imagePreview = URL.createObjectURL($event.target.files[0])"
                        class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-medium
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100"
                    >
                </div>

                @error('image')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>


            <!-- Jumlah Target -->
            <div 
                x-data="{
                    display: '',
                    raw: ''
                }"
                class="space-y-2"
            >
                <label class="text-sm font-medium text-gray-700 flex items-center gap-1">
                    Jumlah Target
                    <span class="text-red-500">*</span>
                </label>

                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">
                        Rp
                    </span>

                    <input
                        type="text"
                        x-model="display"
                        @input="
                            raw = display.replace(/\D/g, '');
                            display = raw.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                            $wire.target_amount = raw;
                        "
                        placeholder="0"
                        class="w-full border border-gray-300 rounded-lg p-2.5 pl-10 text-sm
                            focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                            transition-all duration-200"
                        required
                    >
                </div>

                @error('target_amount')
                    <span class="text-xs text-red-600 flex items-center gap-1 mt-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </span>
                @enderror
            </div>


            <!-- Tanggal -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Mulai <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="start_date"
                        wire:model="start_date"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        required>
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Target Selesai <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="end_date"
                        wire:model="end_date"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        required>
                    @error('end_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col-reverse sm:flex-row gap-3 pt-4 border-t">
                <button
                    type="button"
                    x-on:click="$dispatch('close-modal', 'modal-create-target')"
                    class="w-full sm:w-auto px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </button>
                <button
                    type="submit"
                    class="w-full sm:flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Buat Target Tabungan
                </button>
            </div>

        </form>

    </div>
</x-modal>