<?php

use Livewire\Volt\Component;

new class extends Component {
    // Ya no necesitas $toasts ni addToast aquí
}; ?>

<div x-data="{
    toasts: [],
    add(message, type = 'success', duration = 4000) {
        const id = Date.now();
        this.toasts.push({ id, message, type, duration, show: false });

        // Pequeño delay para que Alpine registre el elemento antes de animar
        setTimeout(() => {
            const toast = this.toasts.find(t => t.id === id);
            if (toast) toast.show = true;
        }, 10);

        setTimeout(() => this.remove(id), duration);
    },
    remove(id) {
        const toast = this.toasts.find(t => t.id === id);
        if (toast) {
            toast.show = false;
            setTimeout(() => {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }, 150);
        }
    }
}" x-on:toast.window="add($event.detail.message, $event.detail.type, $event.detail.duration)"
    class="fixed bottom-4 right-4 z-50 flex flex-col gap-2" aria-live="polite">
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.show" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-1"
            :class="{
                'bg-white dark:bg-zinc-800 border border-green-200 dark:border-green-800': toast.type === 'success',
                'bg-white dark:bg-zinc-800 border border-red-200 dark:border-red-800': toast.type === 'error',
                'bg-white dark:bg-zinc-800 border border-yellow-200 dark:border-yellow-800': toast.type === 'warning',
                'bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700': toast.type === 'info',
            }"
            class="flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg text-sm font-medium min-w-64 max-w-sm text-zinc-800 dark:text-zinc-100">
            <span
                :class="{
                    'text-green-500': toast.type === 'success',
                    'text-red-500': toast.type === 'error',
                    'text-yellow-500': toast.type === 'warning',
                    'text-blue-500': toast.type === 'info',
                }"
                class="shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        :d="{
                            success: 'M5 13l4 4L19 7',
                            error: 'M6 18L18 6M6 6l12 12',
                            warning: 'M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z',
                            info: 'M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20A10 10 0 0012 2z',
                        } [toast.type]" />
                </svg>
            </span>

            <span class="flex-1" x-text="toast.message"></span>

            <button @click="remove(toast.id)"
                class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </template>
</div>
