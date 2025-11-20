@extends('layouts.app')

@section('title', 'Buat Voting')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.dashboard') }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium">← Kembali</a>
    <h1 class="text-3xl font-bold text-gray-800 mt-4">Buat Voting Baru</h1>
</div>

<livewire:admin.create-voting />
@endsection
