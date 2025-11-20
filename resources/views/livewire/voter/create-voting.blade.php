<div class="max-w-2xl mx-auto bg-white rounded-lg border border-gray-200 p-8">
    <form wire:submit.prevent="createVoting" class="space-y-8">
        <!-- Title -->
        <div>
            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Vote Title <span class="text-red-600">*</span></label>
            <input 
                type="text" 
                id="title" 
                wire:model="title" 
                placeholder="Example: 2025 Student President Election"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
            >
            @error('title')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
            <textarea 
                id="description" 
                wire:model="description"
                rows="4"
                placeholder="Describe what this voting is about..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
            ></textarea>
            @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Top Results -->
        <div>
            <label for="top_results" class="block text-sm font-semibold text-gray-700 mb-2">Show Top Results (candidates) <span class="text-red-600">*</span></label>
            <input 
                type="number" 
                id="top_results" 
                wire:model="top_results" 
                min="1"
                max="100"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
            >
            <p class="text-gray-600 text-xs mt-2">How many top results would you like to display?</p>
        </div>

        <!-- Schedule -->
        <div class="border-t border-gray-200 pt-8">
            <div class="flex items-center gap-3 mb-6">
                <input 
                    type="checkbox" 
                    id="enableSchedule" 
                    wire:model.live="enableSchedule"
                    class="w-4 h-4 text-primary-600 rounded focus:ring-2 focus:ring-primary-500"
                >
                <label for="enableSchedule" class="text-sm font-semibold text-gray-700">
                    Set specific start and end time
                </label>
            </div>

            @if ($enableSchedule)
                <div class="space-y-4">
                    <div>
                        <label for="starts_at" class="block text-sm font-semibold text-gray-700 mb-2">Start Time <span class="text-red-600">*</span></label>
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

                    <div>
                        <label for="ends_at" class="block text-sm font-semibold text-gray-700 mb-2">End Time (optional)</label>
                        <input 
                            type="datetime-local" 
                            id="ends_at" 
                            wire:model="ends_at"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        >
                        @error('ends_at')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-600 text-xs mt-2">Leave empty if you want to manually end the vote</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Candidates -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <label class="text-sm font-semibold text-gray-700">Candidates <span class="text-red-600">*</span></label>
                <button 
                    type="button"
                    wire:click="addCandidate"
                    class="text-sm text-primary-600 hover:text-primary-800 font-medium"
                >
                    + Add Candidate
                </button>
            </div>

            <div class="space-y-3">
                @foreach ($candidates as $index => $candidate)
                    <div class="flex gap-3 items-end">
                        <div class="flex-1">
                            <input 
                                type="text" 
                                wire:model="candidates.{{ $index }}.name"
                                placeholder="Candidate name"
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
                                Remove
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
                Create Vote
            </button>
            <a 
                href="{{ route('voter.dashboard') }}"
                class="flex-1 bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-medium hover:bg-gray-300 transition text-center"
            >
                Cancel
            </a>
        </div>
    </form>
</div>
