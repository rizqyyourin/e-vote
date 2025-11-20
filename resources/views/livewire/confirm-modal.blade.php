<div class="fixed inset-0 z-50 flex items-center justify-center" @class(['hidden' => !$open])>
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50" wire:click="close()"></div>

    <!-- Modal -->
    <div class="relative bg-white rounded-lg p-6 max-w-sm mx-4 shadow-xl">
        @if ($title)
            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $title }}</h3>
        @endif
        
        <p class="text-gray-600 mb-6">{{ $message }}</p>
        
        <div class="flex gap-3 justify-end">
            <button wire:click="close()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition">
                {{ $cancelText }}
            </button>
            <button wire:click="confirm()" class="px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                {{ $confirmText }}
            </button>
        </div>
    </div>
</div>
