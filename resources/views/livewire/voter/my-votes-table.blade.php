<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <!-- Search and Filter -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">My Votes</h2>
                <p class="text-gray-600 text-sm mt-1">Total {{ $votings->total() }} votings you have created</p>
            </div>
            
            <!-- Filter Controls -->
            <div class="flex flex-col sm:flex-row gap-3">
                <!-- Status -->
                <select 
                    wire:model="status"
                    class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:border-gray-400"
                >
                    <option value="">All Status</option>
                    <option value="draft">Draft</option>
                    <option value="active">Active</option>
                    <option value="finished">Finished</option>
                    <option value="archived">Archived</option>
                </select>

                <!-- Sort By -->
                <select 
                    wire:model="sortBy"
                    class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:border-gray-400"
                >
                    <option value="latest">Latest Created</option>
                    <option value="oldest">Oldest Created</option>
                    <option value="status">Status</option>
                    <option value="votes">Most Votes</option>
                </select>

                <!-- Search Input -->
                <div class="flex gap-2">
                    <input 
                        type="text" 
                        wire:model="search"
                        placeholder="Search voting title..." 
                        class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 w-full sm:w-auto"
                    >
                    <button 
                        wire:click="applyFilters"
                        class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition inline-flex items-center justify-center"
                    >
                        <svg class="w-[18px] h-[18px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="white" stroke-linecap="round" stroke-width="1" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                        </svg>
                    </button>
                    <button 
                        wire:click="resetFilters"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition inline-flex items-center justify-center"
                    >
                        <svg class="w-[18px] h-[18px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Title</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Candidates</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Votes</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Created</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Finished</th>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($votings as $voting)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">
                            <a href="{{ route('voting.show', $voting) }}" class="text-primary-600 hover:text-primary-800">{{ $voting->title }}</a>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($voting->status === 'draft') bg-gray-100 text-gray-800
                                @elseif($voting->status === 'active') bg-green-100 text-green-800
                                @elseif($voting->status === 'finished') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800
                                @endif
                            ">
                                {{ ucfirst($voting->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-center text-gray-600">{{ $voting->candidates()->count() }}</td>
                        <td class="px-6 py-4 text-sm text-center text-gray-600">{{ $voting->votes()->count() }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ \App\Helpers\DateHelper::formatInUserTimezone($voting->created_at, 'd M Y H:i') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            @if($voting->ends_at)
                                {{ \App\Helpers\DateHelper::formatInUserTimezone($voting->ends_at, 'd M Y H:i') }}
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-sm flex flex-wrap gap-1 justify-end">
                            <a href="{{ route('voting.show', $voting) }}" class="inline-block bg-primary-600 text-white px-3 py-2 rounded font-medium hover:bg-primary-700 transition text-xs">
                                View
                            </a>
                            @if($voting->status === 'draft' || $voting->status === 'active' || $voting->status === 'finished')
                                <a href="{{ route('voter.voting.edit', $voting) }}" class="inline-block bg-gray-200 text-gray-700 px-3 py-2 rounded font-medium hover:bg-gray-300 transition text-xs">
                                    {{ $voting->status === 'finished' ? 'View Votes' : 'Edit' }}
                                </a>
                            @endif
                            <button 
                                onclick="confirmDelete({{ $voting->id }}, '{{ addslashes($voting->title) }}')" 
                                class="inline-block bg-red-500 text-white px-3 py-2 rounded font-medium hover:bg-red-600 transition text-xs"
                            >
                                Delete
                            </button>
                            <form id="delete-form-{{ $voting->id }}" action="{{ route('voter.voting.delete', $voting) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <p class="mb-4">No votings found matching your criteria.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        @if ($votings->total() > 0)
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="text-xs sm:text-sm text-gray-600">
                    @php
                        $from = ($votings->currentPage() - 1) * $votings->perPage() + 1;
                        $to = min($votings->currentPage() * $votings->perPage(), $votings->total());
                    @endphp
                    Showing {{ $from }} to {{ $to }} of {{ $votings->total() }} votings
                </div>
                
                <!-- Pagination Links with Tailwind Styling -->
                @if ($votings->hasPages())
                    <nav class="flex items-center gap-1 flex-wrap justify-center sm:justify-end">
                        {{-- Previous Page Link --}}
                        @if ($votings->onFirstPage())
                            <span class="px-2 sm:px-3 py-2 text-gray-400 bg-gray-100 rounded text-xs sm:text-sm cursor-not-allowed">
                                « Prev
                            </span>
                        @else
                            <button wire:click="previousPage" class="px-2 sm:px-3 py-2 text-gray-700 border border-gray-300 rounded hover:bg-gray-100 transition text-xs sm:text-sm font-medium">
                                « Prev
                            </button>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($votings->getUrlRange(1, $votings->lastPage()) as $page => $url)
                            @if ($page == $votings->currentPage())
                                <span class="px-3 py-2 bg-primary-600 text-white rounded-lg text-sm font-semibold">
                                    {{ $page }}
                                </span>
                            @else
                                @if ($page == 1 || $page == $votings->lastPage() || ($page >= $votings->currentPage() - 1 && $page <= $votings->currentPage() + 1))
                                    <button wire:click="gotoPage({{ $page }})" class="px-3 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 transition text-sm">
                                        {{ $page }}
                                    </button>
                                @elseif ($page == $votings->currentPage() - 2 || $page == $votings->currentPage() + 2)
                                    <span class="px-3 py-2 text-gray-500 text-sm">...</span>
                                @endif
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($votings->hasMorePages())
                            <button wire:click="nextPage" class="px-2 sm:px-3 py-2 text-gray-700 border border-gray-300 rounded hover:bg-gray-100 transition text-xs sm:text-sm font-medium">
                                Next »
                            </button>
                        @else
                            <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-lg text-sm cursor-not-allowed">
                                Next &raquo;
                            </span>
                        @endif
                    </nav>
                @endif
            </div>
        @else
            <div class="text-sm text-gray-600 text-center py-4">
                No votings to display
            </div>
        @endif
    </div>
</div>
