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
                onclick="if (confirm('Are you absolutely sure? This action cannot be undone. All your votings and data will be permanently deleted.')) { const form = document.createElement('form'); form.method = 'POST'; form.action = '{{ route('voter.account.delete') }}'; form.innerHTML = '@csrf @method(\"DELETE\")'; document.body.appendChild(form); form.submit(); }"
                class="w-full bg-red-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-red-700 transition"
            >
                Delete Account Permanently
            </button>
        </div>
    </div>
</div>

@endsection
