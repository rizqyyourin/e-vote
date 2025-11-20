<div class="space-y-8">
    <!-- Header -->
    <div class="bg-white rounded-lg border border-gray-200 p-8">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $voting->title }}</h1>
                <p class="text-gray-600 mt-2">{{ $voting->description }}</p>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                {{ $voting->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                {{ $voting->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                {{ $voting->status === 'finished' ? 'bg-blue-100 text-blue-800' : '' }}
            ">
                {{ ucfirst($voting->status) }}
            </span>
        </div>

        <!-- Vote Count -->
        <div class="grid grid-cols-3 gap-4 pt-6 border-t border-gray-200">
            <div>
                <p class="text-gray-600 text-sm">Total Pemilih</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $voting->votes()->count() }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Kandidat</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $voting->candidates()->count() }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Polling Link</p>
                <a href="{{ route('voting.show', $voting) }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium block mt-1">
                    Buka →
                </a>
            </div>
        </div>
    </div>

    <!-- Share Voting Link -->
    <div class="bg-white rounded-lg border border-gray-200 p-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Bagikan Voting</h2>
        
        <p class="text-gray-600 text-sm mb-4">Bagikan link berikut kepada para pemilih:</p>
        
        <div class="flex gap-2 items-center">
            <input 
                type="text" 
                value="{{ route('voting.show', $voting) }}"
                readonly
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
            >
            <button 
                onclick="navigator.clipboard.writeText('{{ route('voting.show', $voting) }}'); alert('Link disalin!')"
                class="bg-primary-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-700 transition flex items-center gap-2"
            >
                <svg class="w-[18px] h-[18px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" d="M18 3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1V9a4 4 0 0 0-4-4h-3a1.99 1.99 0 0 0-1 .267V5a2 2 0 0 1 2-2h7Z" clip-rule="evenodd"/>
                  <path fill-rule="evenodd" d="M8 7.054V11H4.2a2 2 0 0 1 .281-.432l2.46-2.87A2 2 0 0 1 8 7.054ZM10 7v4a2 2 0 0 1-2 2H4v6a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3Z" clip-rule="evenodd"/>
                </svg>
                Copy
            </button>
        </div>
    </div>

    <!-- Start Voting -->
    @if ($voting->status === 'draft')
        <div class="bg-white rounded-lg border border-gray-200 p-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Mulai Voting</h2>
            
            <form wire:submit.prevent="startVoting" class="space-y-4">
                <div>
                    <label for="starts_at" class="block text-sm font-medium text-gray-700 mb-2">Waktu Mulai <span class="text-red-600">*</span></label>
                    <input 
                        type="datetime-local" 
                        id="starts_at" 
                        wire:model="starts_at"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    >
                    @error('starts_at')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-green-700 transition">
                    Mulai Voting Sekarang
                </button>
            </form>
        </div>
    @elseif ($voting->status === 'active')
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-8">
            <h2 class="text-lg font-semibold text-blue-800 mb-4">Voting Sedang Berlangsung</h2>
            <p class="text-blue-700 mb-4">Voting dimulai pada {{ $voting->starts_at->format('d M Y H:i') }}</p>
            <button 
                wire:click="finishVoting"
                wire:confirm="Yakin ingin mengakhiri voting?"
                class="bg-red-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-red-700 transition"
            >
                Akhiri Voting
            </button>
        </div>
    @endif

    <!-- Top Results Setting -->
    <div class="bg-white rounded-lg border border-gray-200 p-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Pengaturan Hasil</h2>
        
        <form wire:submit.prevent="updateTopResults" class="space-y-4">
            <div>
                <label for="top_results" class="block text-sm font-medium text-gray-700 mb-2">Tampilkan Top (kandidat)</label>
                <input 
                    type="number" 
                    id="top_results" 
                    wire:model="top_results"
                    min="1"
                    max="100"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                >
            </div>

            <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-700 transition">
                Simpan Pengaturan
            </button>
        </form>
    </div>

    <!-- Candidates -->
    <div class="bg-white rounded-lg border border-gray-200 p-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Kandidat</h2>
        
        <div class="space-y-3">
            @foreach ($voting->candidates()->orderBy('name')->get() as $candidate)
                <div class="p-4 border border-gray-200 rounded-lg flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-800">{{ $candidate->name }}</p>
                        @if ($candidate->description)
                            <p class="text-gray-600 text-sm mt-1">{{ $candidate->description }}</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-primary-600">{{ $candidate->votes()->count() }}</p>
                        <p class="text-gray-600 text-sm">suara</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Voters Audit Log -->
    @if ($voting->status !== 'draft')
        <div class="bg-white rounded-lg border border-gray-200 p-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-6">Data Pemilih (Audit)</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama Pemilih</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Kandidat</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($voting->votes()->with(['voter', 'candidate'])->latest()->get() as $vote)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 text-sm text-gray-800">{{ $vote->voter->name }}</td>
                                <td class="px-6 py-3 text-sm text-gray-800">{{ $vote->candidate->name }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ \App\Helpers\DateHelper::formatInUserTimezone($vote->created_at) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada suara yang masuk
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Back Button -->
    <a href="{{ route('admin.dashboard') }}" class="text-primary-600 hover:text-primary-800 font-medium">
        ← Kembali ke Dashboard
    </a>

    @if ($voting->status === 'finished')
        <div class="mt-4">
            <a href="{{ route('admin.voting.pdf', $voting) }}" class="inline-flex bg-primary-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-700 transition items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                Download PDF
            </a>
        </div>
    @endif
</div>
