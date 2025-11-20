@extends('layouts.app')

@section('title', 'Kelola Voting - ' . $voting->title)

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.dashboard') }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium">← Kembali</a>
</div>

<livewire:admin.show-voting :$voting />
@endsection
