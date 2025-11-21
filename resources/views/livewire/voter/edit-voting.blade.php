<div class="space-y-8">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('voter.dashboard') }}" class="text-primary-600 hover:text-primary-800 font-medium inline-flex items-center gap-1">
            ← Back to Dashboard
        </a>
    </div>

    <!-- Info Alert for Finished Voting -->
    @if ($voting->status === 'finished')
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
            <div>
                <p class="text-blue-900 font-medium">This voting has finished</p>
                <p class="text-blue-800 text-sm mt-1">You can view who has voted below. Editing is disabled for finished votings.</p>
            </div>
        </div>
    @endif

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
                <p class="text-gray-600 text-sm">Total Voters</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $voting->votes()->count() }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Candidates</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $voting->candidates()->count() }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Voting Link</p>
                <a href="{{ route('voting.show', $voting) }}" class="inline-flex items-center gap-1 bg-primary-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-primary-700 transition mt-2">
                    Open
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Share Voting Link -->
    <div class="bg-white rounded-lg border border-gray-200 p-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Share Vote</h2>
        
        <p class="text-gray-600 text-sm mb-4">Share this link with voters to let them participate:</p>
        
        <div class="flex gap-2 items-center">
            <input 
                type="text" 
                value="{{ route('voting.show', $voting) }}"
                readonly
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
            >
            <button 
                type="button"
                onclick="copyToClipboard('{{ route('voting.show', $voting) }}')"
                class="bg-primary-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-700 transition flex items-center gap-2"
            >
                <svg class="w-[18px] h-[18px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" d="M18 3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1V9a4 4 0 0 0-4-4h-3a1.99 1.99 0 0 0-1 .267V5a2 2 0 0 1 2-2h7Z" clip-rule="evenodd"/>
                  <path fill-rule="evenodd" d="M8 7.054V11H4.2a2 2 0 0 1 .281-.432l2.46-2.87A2 2 0 0 1 8 7.054ZM10 7v4a2 2 0 0 1-2 2H4v6a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3Z" clip-rule="evenodd"/>
                </svg>
                Copy
            </button>

            <script>
                function copyToClipboard(text) {
                    const textarea = document.createElement('textarea');
                    textarea.value = text;
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textarea);
                    showToast('Copied to clipboard!', 'success');
                }

                function showToast(message, type = 'success') {
                    const toast = document.createElement('div');
                    toast.textContent = message;
                    toast.style.cssText = `
                        position: fixed;
                        bottom: 20px;
                        right: 20px;
                        background-color: ${type === 'success' ? '#10b981' : '#ef4444'};
                        color: white;
                        padding: 12px 24px;
                        border-radius: 8px;
                        font-weight: 500;
                        font-size: 14px;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                        animation: slideIn 0.3s ease-out;
                        z-index: 9999;
                    `;
                    document.body.appendChild(toast);
                    
                    setTimeout(() => {
                        toast.style.animation = 'slideOut 0.3s ease-out';
                        setTimeout(() => document.body.removeChild(toast), 300);
                    }, 2500);
                }

                const style = document.createElement('style');
                style.textContent = `
                    @keyframes slideIn {
                        from {
                            transform: translateX(400px);
                            opacity: 0;
                        }
                        to {
                            transform: translateX(0);
                            opacity: 1;
                        }
                    }
                    @keyframes slideOut {
                        from {
                            transform: translateX(0);
                            opacity: 1;
                        }
                        to {
                            transform: translateX(400px);
                            opacity: 0;
                        }
                    }
                `;
                document.head.appendChild(style);
            </script>
        </div>
    </div>

    <!-- Start Voting -->
    @if ($voting->status === 'draft')
        <div class="bg-white rounded-lg border border-gray-200 p-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-6">Start Vote</h2>
            
            @if ($hasSchedule)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-blue-700">
                        <strong>Scheduled Start:</strong> {{ $starts_at ? \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $starts_at)->format('d M Y H:i') : 'Not set' }}
                        @if ($ends_at)
                            <br><strong>Scheduled End:</strong> {{ \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $ends_at)->format('d M Y H:i') }}
                        @endif
                    </p>
                </div>
            @endif

            <form wire:submit.prevent="startVoting" class="space-y-4">
                @if ($hasSchedule)
                    <p class="text-gray-600 text-sm mb-4">This vote is scheduled to start at the specified time. You can change the schedule below or start it now.</p>
                    <div class="grid grid-cols-2 gap-4 mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-2">Edit Start Time</label>
                            <input 
                                type="datetime-local" 
                                wire:model="starts_at"
                                class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-2">Edit End Time (optional)</label>
                            <input 
                                type="datetime-local" 
                                wire:model="ends_at"
                                class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            >
                        </div>
                    </div>
                    <button type="button" wire:click="updateSchedule" class="text-sm text-primary-600 hover:text-primary-800 font-medium mb-4">
                        Update Schedule
                    </button>
                @else
                    <p class="text-gray-600 text-sm mb-4">This vote will start immediately when you click the button below.</p>
                @endif

                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-green-700 transition">
                    Start Vote Now
                </button>
            </form>
        </div>
    @elseif ($voting->status === 'active')
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-8">
            <h2 class="text-lg font-semibold text-blue-800 mb-2">Vote is Active</h2>
            <p class="text-blue-700 mb-4">
                Voting started on {{ $voting->starts_at->format('d M Y H:i') }}
                @if ($voting->ends_at)
                    and will end on {{ $voting->ends_at->format('d M Y H:i') }}
                @else
                    with no automatic end time
                @endif
            </p>
            <button 
                wire:click="$set('showEndModal', true)"
                class="bg-red-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-red-700 transition"
            >
                End Vote
            </button>
        </div>
    @endif

    <!-- Top Results Setting -->
    <div class="bg-white rounded-lg border border-gray-200 p-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Results Settings</h2>
        
        <form wire:submit.prevent="updateTopResults" class="space-y-4">
            <div>
                <label for="top_results" class="block text-sm font-medium text-gray-700 mb-2">Show Top (candidates)</label>
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
                Save Settings
            </button>
        </form>

        @script
        <script>
            $wire.on('flash', (data) => {
                if (data[0]) {
                    const message = data[0];
                    const type = message.includes('error') || message.includes('Error') ? 'error' : 'success';
                    showToast(message, type);
                }
            });
        </script>
        @endscript
    </div>

    <!-- Candidates -->
    <div class="bg-white rounded-lg border border-gray-200 p-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Candidates</h2>
        
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
                        <p class="text-gray-600 text-sm">votes</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Voters Audit Log -->
    @if ($voting->status !== 'draft')
        <div class="bg-white rounded-lg border border-gray-200 p-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-6">Voter Records (Audit)</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Voter Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Candidate</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Time</th>
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
                                    No votes yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if ($voting->status === 'finished')
        <div class="mt-4">
            <a href="{{ route('voting.pdf', $voting) }}" class="inline-flex bg-primary-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-700 transition items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                Download PDF
            </a>
        </div>
    @endif

    <!-- End Vote Confirmation Modal (Only show if voting is active) -->
    <div class="fixed inset-0 z-50 flex items-center justify-center" @class(['hidden' => !$showEndModal || $voting->status !== 'active'])>
        <div class="fixed inset-0 bg-black bg-opacity-50" wire:click="$set('showEndModal', false)"></div>
        <div class="relative bg-white rounded-lg p-6 max-w-sm mx-4 shadow-xl">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">End Vote</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to end this vote? Voters will no longer be able to participate.</p>
            <div class="flex gap-3 justify-end">
                <button wire:click="$set('showEndModal', false)" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition">
                    Cancel
                </button>
                <button wire:click="finishVoting" class="px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                    End Vote
                </button>
            </div>
        </div>
    </div>
</div>
