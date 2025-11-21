@extends('layouts.app')

@section('title', 'Account Settings')

@section('content')
<div class="mb-8" x-data="{ showDeleteModal: false }">
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
    <div class="space-y-6" x-data="{ showDeleteModal: false }">
        <!-- Delete Account Section -->
        <div class="bg-red-50 border border-red-200 rounded-lg p-8">
            <h2 class="text-xl font-semibold text-red-800 mb-3">Delete Account</h2>
            <p class="text-red-700 text-sm mb-6">Once you delete your account, there is no going back. Please be certain.</p>
            
            <button 
                type="button"
                @click="showDeleteModal = true"
                class="w-full bg-red-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-red-700 transition"
            >
                Delete Account Permanently
            </button>

            <form id="delete-account-form" action="{{ route('voter.account.delete') }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>

        <!-- Delete Account Confirmation Modal -->
        <div class="fixed inset-0 z-50 flex items-center justify-center" :class="{ 'hidden': !showDeleteModal }" x-show="showDeleteModal">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black bg-opacity-50" @click="showDeleteModal = false"></div>

            <!-- Modal -->
            <div class="relative bg-white rounded-lg p-6 max-w-sm mx-4 shadow-xl">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Delete Account</h3>
                
                <p class="text-gray-600 mb-2">
                    Are you absolutely sure you want to delete your account?
                </p>
                <p class="text-sm mb-6 text-red-600">
                    ⚠️ This action cannot be undone. All your votings, votes, and data will be permanently deleted.
                </p>
                
                <div class="flex gap-3 justify-end">
                    <button @click="showDeleteModal = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition">
                        Cancel
                    </button>
                    <button @click="document.getElementById('delete-account-form').submit()" class="px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                        Delete My Account
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
