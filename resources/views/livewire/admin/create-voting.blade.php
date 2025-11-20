<div class="max-w-2xl mx-auto bg-white rounded-lg border border-gray-200 p-8">
    <form wire:submit.prevent="createVoting" class="space-y-8">
        <!-- Title -->
        <div>
            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Voting <span class="text-red-600">*</span></label>
            <input 
                type="text" 
                id="title" 
                wire:model="title" 
                placeholder="Contoh: Pemilihan Ketua OSIS 2025"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
            >
            @error('title')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
            <textarea 
                id="description" 
                wire:model="description"
                rows="4"
                placeholder="Jelaskan tentang voting ini..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
            ></textarea>
            @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Top Results -->
        <div>
            <label for="top_results" class="block text-sm font-semibold text-gray-700 mb-2">Tampilkan Top (kandidat) <span class="text-red-600">*</span></label>
            <input 
                type="number" 
                id="top_results" 
                wire:model="top_results" 
                min="1"
                max="100"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
            >
            <p class="text-gray-600 text-xs mt-2">Berapa banyak hasil teratas yang ingin ditampilkan?</p>
        </div>

        <!-- Candidates -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <label class="text-sm font-semibold text-gray-700">Kandidat <span class="text-red-600">*</span></label>
                <button 
                    type="button"
                    wire:click="addCandidate"
                    class="text-sm text-primary-600 hover:text-primary-800 font-medium"
                >
                    + Tambah Kandidat
                </button>
            </div>

            <div class="space-y-3">
                @foreach ($candidates as $index => $candidate)
                    <div class="flex gap-3 items-end">
                        <div class="flex-1">
                            <input 
                                type="text" 
                                wire:model="candidates.{{ $index }}.name"
                                placeholder="Nama kandidat"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            >
                            @error("candidates.{$index}.name")
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        @if (count($candidates) > 2)
                            <button 
                                type="button"
                                wire:click="removeCandidate({{ $index }})"
                                class="px-4 py-2 text-red-600 hover:text-red-800 font-medium"
                            >
                                Hapus
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>

            @error('candidates')
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit -->
        <div class="flex gap-4 pt-4">
            <button 
                type="submit"
                class="flex-1 bg-primary-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-primary-700 transition"
            >
                Buat Voting
            </button>
            <a 
                href="{{ route('admin.dashboard') }}"
                class="flex-1 bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-medium hover:bg-gray-300 transition text-center"
            >
                Batal
            </a>
        </div>
    </form>
</div>
