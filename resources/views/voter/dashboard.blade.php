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

@endsection
