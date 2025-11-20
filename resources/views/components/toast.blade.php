<div>
    @if (session()->has('toast'))
        <div class="toast fixed top-4 right-4 {{ session('toast')['type'] === 'success' ? 'bg-green-500' : (session('toast')['type'] === 'error' ? 'bg-red-500' : 'bg-blue-500') }} text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 z-50">
            <span class="text-xl">
                @if (session('toast')['type'] === 'success')
                    ✓
                @elseif (session('toast')['type'] === 'error')
                    ✕
                @else
                    ℹ
                @endif
            </span>
            <span>{{ session('toast')['message'] }}</span>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const toast = document.querySelector('.toast');
                if (toast) {
                    setTimeout(() => {
                        toast.classList.add('remove');
                        setTimeout(() => toast.remove(), 300);
                    }, 2500);
                }
            });
        </script>
    @endif

    <script>
        // Handle Livewire flash events for toasts
        window.showToast = function(message, type = 'success') {
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : (type === 'error' ? 'bg-red-500' : 'bg-blue-500');
            const icon = type === 'success' ? '✓' : (type === 'error' ? '✕' : 'ℹ');
            
            toast.className = `toast fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 z-50`;
            toast.innerHTML = `<span class="text-xl">${icon}</span><span>${message}</span>`;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.add('remove');
                setTimeout(() => toast.remove(), 300);
            }, 2500);
        };

        // Listen for Livewire flash events
        Livewire.on('flash', (message) => {
            showToast(message, 'success');
        });
    </script>
</div>
