<div class="space-y-8">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ auth()->check() && auth()->user()->isVoter() ? route('voter.dashboard') : route('home') }}" class="text-primary-600 hover:text-primary-800 font-medium inline-flex items-center gap-1">
            ← Back
        </a>
    </div>

    <!-- Voting Header -->
    <div class="bg-white rounded-lg border border-gray-200 p-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">{{ $voting->title }}</h1>
            @if ($voting->description)
                <p class="text-gray-600 mt-2">{{ $voting->description }}</p>
            @endif
        </div>

        <!-- Status & Info -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <div>
                <p class="text-gray-600 text-sm">
                    @if ($isActive)
                        <span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        Voting is ongoing
                    @elseif ($voting->status === 'finished')
                        <span class="inline-block w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                        Voting has ended
                    @else
                        <span class="inline-block w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
                        Voting hasn't started yet
                    @endif
                </p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-primary-600">{{ $voting->votes()->count() }}</p>
                <p class="text-gray-600 text-sm">voters have cast their votes</p>
            </div>
        </div>
    </div>

    <!-- Auth Check -->
    @if (!auth()->check())
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-8 text-center">
            <h2 class="text-lg font-semibold text-blue-800 mb-4">Please Sign In First</h2>
            <p class="text-blue-700 mb-6">You must be logged in to cast your vote.</p>
            <div class="flex gap-4 justify-center">
                <a href="{{ route('login') }}" class="bg-primary-600 text-white px-8 py-2 rounded-lg font-medium hover:bg-primary-700 transition">
                    Sign In
                </a>
                <a href="{{ route('register') }}" class="border-2 border-primary-600 text-primary-600 px-8 py-2 rounded-lg font-medium hover:bg-primary-50 transition">
                    Sign Up
                </a>
            </div>
        </div>
    @else
        <!-- Vote Status -->
        @if ($hasVoted)
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <p class="text-green-800">✓ You have already cast your vote for this voting. Thank you for your participation!</p>
            </div>
        @elseif (!$isActive)
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                <p class="text-yellow-800">
                    @if ($voting->status === 'draft')
                        Voting has not started yet
                    @else
                        Voting has ended
                    @endif
                </p>
            </div>
        @endif

        <!-- Candidates / Voting Form -->
        @if ($isActive && !$hasVoted)
            <form wire:submit.prevent="submitVote" class="space-y-6">
                <div class="bg-white rounded-lg border border-gray-200 p-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-6">Select a Candidate</h2>

                    <div class="space-y-3">
                        @foreach ($voting->candidates()->orderBy('name')->get() as $candidate)
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-primary-300 transition
                                {{ $selectedCandidate == $candidate->id ? 'border-primary-600 bg-primary-50' : '' }}
                            ">
                                <input 
                                    type="radio" 
                                    name="candidate"
                                    value="{{ $candidate->id }}"
                                    wire:model.live="selectedCandidate"
                                    class="w-4 h-4 text-primary-600"
                                >
                                <div class="ml-4 flex-1">
                                    <p class="font-medium text-gray-800">{{ $candidate->name }}</p>
                                    @if ($candidate->description)
                                        <p class="text-gray-600 text-sm mt-1">{{ $candidate->description }}</p>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>

                    @error('selectedCandidate')
                        <p class="text-red-600 text-sm mt-4">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4">
                    <button 
                        type="submit"
                        @disabled(!$selectedCandidate)
                        class="flex-1 bg-primary-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-primary-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Cast Vote
                    </button>
                </div>
            </form>
        @endif
    @endif

    <!-- Results (if voting finished or user already voted) -->
    @if ($voting->status === 'finished' || ($hasVoted && $isActive))
        <div class="bg-white rounded-lg border border-gray-200 p-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-6">Results ({{ $voting->votes()->count() }} votes)</h2>

            <div class="space-y-4">
                @php
                    $votes = $voting->candidates()
                        ->withCount('votes')
                        ->orderByDesc('votes_count')
                        ->take($voting->top_results)
                        ->get();
                    $totalVotes = $voting->votes()->count();
                @endphp

                @foreach ($votes as $candidate)
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <p class="font-medium text-gray-800">{{ $candidate->name }}</p>
                            <span class="text-sm text-gray-600">{{ $candidate->votes_count }} votes ({{ $totalVotes > 0 ? round(($candidate->votes_count / $totalVotes) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div 
                                class="bg-primary-600 h-2 rounded-full transition"
                                style="width: {{ $totalVotes > 0 ? ($candidate->votes_count / $totalVotes * 100) : 0 }}%"
                            ></div>
                        </div>
                    </div>
                @endforeach

                @if ($voting->candidates()->count() > $voting->top_results)
                    <p class="text-gray-600 text-sm mt-6 pt-6 border-t border-gray-200">
                        Showing top {{ $voting->top_results }} of {{ $voting->candidates()->count() }} candidates
                    </p>
                @endif
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
</div>
