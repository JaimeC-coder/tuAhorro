<?php

use Livewire\Volt\Component;

new class extends Component {
    public array $toasts = [];

    protected $listeners = ['toast' => 'addToast'];

    public function addToast(string $message, string $type = 'success', int $duration = 4000): void
    {
        $this->toasts[] = [
            'id' => uniqid(),
            'message' => $message,
            'type' => $type,
            'duration' => $duration,
        ];
    }

    public function remove(string $id): void
    {
        $this->toasts = array_values(array_filter($this->toasts, fn($t) => $t['id'] !== $id));
    }


}; ?>

<div class="fixed bottom-4 right-4 z-50 flex flex-col gap-2" aria-live="polite">
    @foreach ($toasts as $toast)
        <div x-data="{ show: false }" x-init="$nextTick(() => { show = true });
        setTimeout(() => {
            show = false;
            setTimeout(() => $wire.remove('{{ $toast['id'] }}'), 200);
        }, {{ $toast['duration'] }});" x-show="show"
            x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
            class="flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg text-sm font-medium min-w-64 max-w-sm
                {{ match ($toast['type']) {
                    'success'
                        => 'bg-white dark:bg-zinc-800 border border-green-200 dark:border-green-800 text-zinc-800 dark:text-zinc-100',
                    'error' => 'bg-white dark:bg-zinc-800 border border-red-200 dark:border-red-800 text-zinc-800 dark:text-zinc-100',
                    'warning'
                        => 'bg-white dark:bg-zinc-800 border border-yellow-200 dark:border-yellow-800 text-zinc-800 dark:text-zinc-100',
                    default
                        => 'bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-800 dark:text-zinc-100',
                } }}">
            {{-- Ícono según tipo --}}
            @if ($toast['type'] === 'success')
                <span class="text-green-500 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </span>
            @elseif ($toast['type'] === 'error')
                <span class="text-red-500 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </span>
            @elseif ($toast['type'] === 'warning')
                <span class="text-yellow-500 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                    </svg>
                </span>
            @else
                <span class="text-blue-500 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20A10 10 0 0012 2z" />
                    </svg>
                </span>
            @endif

            <span class="flex-1">{{ $toast['message'] }}</span>

            {{-- Botón cerrar --}}
            <button wire:click="remove('{{ $toast['id'] }}')"
                class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endforeach
</div>
