@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
    <p class="text-gray-600 mt-2">Kelola voting Anda dan lihat hasil secara real-time</p>
</div>

<!-- Stats -->
<div class="grid md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-6 rounded-lg border border-gray-200">
        <p class="text-gray-600 text-sm font-medium">Total Voting</p>
        <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Voting::where('admin_id', auth()->id())->count() }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg border border-gray-200">
        <p class="text-gray-600 text-sm font-medium">Sedang Berjalan</p>
        <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Voting::where('admin_id', auth()->id())->where('status', 'active')->count() }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg border border-gray-200">
        <p class="text-gray-600 text-sm font-medium">Selesai</p>
        <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Voting::where('admin_id', auth()->id())->where('status', 'finished')->count() }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg border border-gray-200">
        <p class="text-gray-600 text-sm font-medium">Draf</p>
        <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Voting::where('admin_id', auth()->id())->where('status', 'draft')->count() }}</p>
    </div>
</div>

<!-- Actions -->
<div class="mb-8">
    <a href="{{ route('admin.voting.create') }}" class="bg-primary-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-primary-700 transition">
        + Buat Voting Baru
    </a>
</div>

<!-- Votings Table -->
<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Judul</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Pemilih</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Dibuat</th>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse (\App\Models\Voting::where('admin_id', auth()->id())->latest()->get() as $voting)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $voting->title }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ $voting->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                                {{ $voting->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $voting->status === 'finished' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $voting->status === 'archived' ? 'bg-red-100 text-red-800' : '' }}
                            ">
                                {{ ucfirst($voting->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $voting->votes()->count() }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $voting->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.voting.show', $voting) }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium">
                                Lihat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            Belum ada voting. <a href="{{ route('admin.voting.create') }}" class="text-primary-600 hover:text-primary-800 font-medium">Buat sekarang</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
