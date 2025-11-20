@extends('layouts.app')

@section('title', 'Create Vote')

@section('content')
<div class="mb-8">
    <a href="{{ route('voter.dashboard') }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium">← Back</a>
    <h1 class="text-3xl font-bold text-gray-800 mt-4">Create New Vote</h1>
</div>

<livewire:voter.create-voting />
@endsection
