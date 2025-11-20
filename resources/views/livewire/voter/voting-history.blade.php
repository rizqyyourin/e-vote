<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">My Voting History</h2>
                <p class="text-gray-600 text-sm mt-1">Total {{ $votes->total() }} votes you have participated in</p>
            </div>
            
            <!-- Filter Controls -->
            <div class="flex flex-col sm:flex-row gap-3">
                <!-- Sort By -->
                <select wire:model="sortBy" class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:border-gray-400">
                    <option value="latest">Sort: Latest</option>
                    <option value="oldest">Sort: Oldest</option>
                    <option value="voting">Sort: Voting Name</option>
                    <option value="candidate">Sort: Candidate Name</option>
                </select>

                <!-- Search Input -->
                <div class="flex gap-2">
                    <input type="text" wire:model="search" placeholder="Search voting or candidate..." class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 w-full sm:w-auto">
                    <button wire:click="applyFilters" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition inline-flex items-center gap-2">
                        <svg class="w-[18px] h-[18px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="white" stroke-linecap="round" stroke-width="1" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                        </svg>
                    </button>
                    <button wire:click="resetFilters" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition inline-flex items-center gap-2">
                        <svg class="w-[18px] h-[18px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Voting</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Chosen Candidate</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Time</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($votes as $vote)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-800 font-medium">
                            @if ($vote->voting)
                                <a href="{{ route('voting.show', $vote->voting) }}" class="text-primary-600 hover:text-primary-800">
                                    {{ $vote->voting->title }}
                                </a>
                            @else
                                <span class="text-gray-400">(Voting deleted)</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800">
                            {{ $vote->candidate->name ?? '(Deleted)' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ \App\Helpers\DateHelper::formatInUserTimezone($vote->created_at) }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if ($vote->voting)
                                <a href="{{ route('voting.show', $vote->voting) }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium inline-flex items-center gap-1">
                                    View Results
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </a>
                            @else
                                <span class="text-gray-400 text-sm">N/A</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            You haven't participated in any votes yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Smart Pagination -->
    @if ($votes->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="text-xs sm:text-sm text-gray-600">
                    Showing {{ ($votes->currentPage() - 1) * $votes->perPage() + 1 }} to {{ min($votes->currentPage() * $votes->perPage(), $votes->total()) }} of {{ $votes->total() }} votings
                </div>
                <div class="flex items-center justify-center gap-2 flex-wrap">
                <!-- Previous Button -->
                @if ($votes->onFirstPage())
                    <button disabled class="px-2 sm:px-3 py-2 border border-gray-300 text-gray-400 rounded text-xs sm:text-sm bg-gray-100">
                        « Prev
                    </button>
                @else
                    <button wire:click="gotoPage({{ $votes->currentPage() - 1 }})" class="px-2 sm:px-3 py-2 border border-gray-300 text-gray-700 rounded text-xs sm:text-sm hover:bg-gray-100 transition">
                        « Prev
                    </button>
                @endif

                <!-- Page Numbers -->
                @php
                    $lastPage = $votes->lastPage();
                    $currentPage = $votes->currentPage();
                    $range = 1; // pages to show around current
                @endphp

                @if ($lastPage <= 7)
                    <!-- Show all pages if 7 or less -->
                    @for ($i = 1; $i <= $lastPage; $i++)
                        @if ($i === $currentPage)
                            <button disabled class="px-2 sm:px-3 py-2 bg-primary-600 text-white rounded text-xs sm:text-sm font-medium">
                                {{ $i }}
                            </button>
                        @else
                            <button wire:click="gotoPage({{ $i }})" class="px-2 sm:px-3 py-2 border border-gray-300 text-gray-700 rounded text-xs sm:text-sm hover:bg-gray-100 transition">
                                {{ $i }}
                            </button>
                        @endif
                    @endfor
                @else
                    <!-- Show smart range for more pages -->
                    <!-- First page -->
                    @if ($currentPage !== 1)
                        <button wire:click="gotoPage(1)" class="px-2 sm:px-3 py-2 border border-gray-300 text-gray-700 rounded text-xs sm:text-sm hover:bg-gray-100 transition">
                            1
                        </button>
                    @endif

                    <!-- Dots before current range -->
                    @if ($currentPage > $range + 2)
                        <span class="px-1 sm:px-2 py-2 text-gray-500 text-xs sm:text-sm">...</span>
                    @endif

                    <!-- Current range -->
                    @for ($i = max(1, $currentPage - $range); $i <= min($lastPage, $currentPage + $range); $i++)
                        @if ($i === $currentPage)
                            <button disabled class="px-2 sm:px-3 py-2 bg-primary-600 text-white rounded text-xs sm:text-sm font-medium">
                                {{ $i }}
                            </button>
                        @else
                            <button wire:click="gotoPage({{ $i }})" class="px-2 sm:px-3 py-2 border border-gray-300 text-gray-700 rounded text-xs sm:text-sm hover:bg-gray-100 transition">
                                {{ $i }}
                            </button>
                        @endif
                    @endfor

                    <!-- Dots after current range -->
                    @if ($currentPage < $lastPage - $range - 1)
                        <span class="px-1 sm:px-2 py-2 text-gray-500 text-xs sm:text-sm">...</span>
                    @endif

                    <!-- Last page -->
                    @if ($currentPage !== $lastPage)
                        <button wire:click="gotoPage({{ $lastPage }})" class="px-2 sm:px-3 py-2 border border-gray-300 text-gray-700 rounded text-xs sm:text-sm hover:bg-gray-100 transition">
                            {{ $lastPage }}
                        </button>
                    @endif
                @endif

                <!-- Next Button -->
                @if ($votes->hasMorePages())
                    <button wire:click="gotoPage({{ $votes->currentPage() + 1 }})" class="px-2 sm:px-3 py-2 border border-gray-300 text-gray-700 rounded text-xs sm:text-sm hover:bg-gray-100 transition">
                        Next »
                    </button>
                @else
                    <button disabled class="px-2 sm:px-3 py-2 border border-gray-300 text-gray-400 rounded text-xs sm:text-sm bg-gray-100">
                        Next »
                    </button>
                @endif
                </div>
            </div>
        </div>
    @endif
</div>
