@extends('layouts.app')

@section('title', 'Account Settings')

@section('content')
<div class="mb-8">
    <a href="{{ route('voter.dashboard') }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium">← Back to Dashboard</a>
    <h1 class="text-3xl font-bold text-gray-800 mt-4">Account Settings</h1>
</div>

<div class="grid md:grid-cols-2 gap-8">
    <!-- Profile Information -->
    <div class="bg-white rounded-lg border border-gray-200 p-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Profile Information</h2>
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                <p class="text-gray-800 font-medium">{{ auth()->user()->name }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <p class="text-gray-800 font-medium">{{ auth()->user()->email }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                <p class="text-gray-800 font-medium">{{ auth()->user()->timezone ?? 'UTC' }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Member Since</label>
                <p class="text-gray-800 font-medium">{{ auth()->user()->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Account Actions -->
    <div class="space-y-6">
        <!-- Delete Account Section -->
        <div class="bg-red-50 border border-red-200 rounded-lg p-8">
            <h2 class="text-xl font-semibold text-red-800 mb-3">Delete Account</h2>
            <p class="text-red-700 text-sm mb-6">Once you delete your account, there is no going back. Please be certain.</p>
            
            <button 
                onclick="confirmDeleteAccount()"
                class="w-full bg-red-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-red-700 transition"
            >
                Delete Account Permanently
            </button>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="deleteAccountModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-sm mx-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Delete Account</h3>
        <p class="text-gray-600 mb-2">Are you absolutely sure? This action cannot be undone.</p>
        <p class="text-sm text-gray-500 mb-6">All your votings and data will be permanently deleted.</p>
        
        <div class="flex gap-3 justify-end">
            <button onclick="closeDeleteAccountModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition">
                Cancel
            </button>
            <button onclick="submitDeleteAccount()" class="px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                Delete Account
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

    function confirmDeleteAccount() {
        document.getElementById('deleteAccountModal').classList.remove('hidden');
    }

    function closeDeleteAccountModal() {
        document.getElementById('deleteAccountModal').classList.add('hidden');
    }

    function submitDeleteAccount() {
        closeDeleteAccountModal();
        
        // Create and submit delete form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('voter.account.delete') }}';
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }

    // Close modal when clicking outside
    document.getElementById('deleteAccountModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteAccountModal();
        }
    });
</script>
@endsection
