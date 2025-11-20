@extends('layouts.app')

@section('title', 'Edit Vote')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-8">Edit Vote</h1>

<livewire:voter.edit-voting :voting="$voting" />
@endsection
