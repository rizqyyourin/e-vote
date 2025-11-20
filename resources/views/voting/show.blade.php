@extends('layouts.app')

@section('title', $voting->title)

@section('content')
<livewire:voter.vote-form :$voting />
@endsection
