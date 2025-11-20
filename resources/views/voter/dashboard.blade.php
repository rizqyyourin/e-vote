@extends('layouts.app')

@section('title', 'Voter Dashboard')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Voter Dashboard</h1>
        <p class="text-gray-600 mt-2">Create and participate in voting</p>
        <p class="text-gray-500 text-xs mt-3">Times displayed in: <strong>{{ \App\Helpers\DateHelper::getUserTimezone() }}</strong></p>
    </div>
    <a href="{{ route('voter.voting.create') }}" class="bg-primary-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-primary-700 transition flex items-center justify-center gap-2 w-full sm:w-auto">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/></svg>
        Create Vote
    </a>
</div>

    <div class="grid md:grid-cols-2 gap-4 mb-8">
    <div class="bg-white p-6 rounded-lg border border-gray-200">
        <p class="text-gray-600 text-sm font-medium">Votes Created</p>
        <p class="text-3xl font-bold text-gray-800 mt-2">{{ auth()->user()->votings()->count() }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg border border-gray-200">
        <p class="text-gray-600 text-sm font-medium">Already Voted</p>
        <p class="text-3xl font-bold text-gray-800 mt-2">{{ auth()->user()->votes()->count() }}</p>
    </div>
</div>

<!-- My Votings -->
<div class="mb-12">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">My Votes</h2>
    
    <livewire:voter.my-votes-table />
</div>

<!-- Voting History -->
<div class="mt-12">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Voting History</h2>
    <livewire:voter.voting-history />
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-sm mx-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Delete Vote</h3>
        <p class="text-gray-600 mb-1">Are you sure you want to delete <strong id="deleteTitle"></strong>?</p>
        <p class="text-sm text-gray-500 mb-6">This action cannot be undone.</p>
        <div class="flex gap-3 justify-end">
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition">
                Cancel
            </button>
            <button onclick="submitDelete()" class="px-4 py-2 bg-red-500 text-white rounded-lg font-medium hover:bg-red-600 transition">
                Delete
            </button>
        </div>
    </div>
</div>

<style>
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

    .toast {
        animation: slideIn 0.3s ease-out;
    }

    .toast.remove {
        animation: slideOut 0.3s ease-out forwards;
    }
</style>

<script>
    let deleteVotingId = null;

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
        const icon = type === 'success' ? '✓' : '✕';
        
        toast.className = `toast fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 z-50`;
        toast.innerHTML = `<span class="text-xl">${icon}</span><span>${message}</span>`;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.add('remove');
            setTimeout(() => toast.remove(), 300);
        }, 2500);
    }

    function confirmDelete(votingId, votingTitle) {
        deleteVotingId = votingId;
        document.getElementById('deleteTitle').textContent = votingTitle;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        deleteVotingId = null;
    }

    function submitDelete() {
        if (deleteVotingId) {
            document.getElementById(`delete-form-${deleteVotingId}`).submit();
            closeDeleteModal();
        }
    }

    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Show toast if flash message exists
    @if (session('flash'))
        showToast('{{ session('flash') }}', 'success');
    @endif
</script>
@endsection
