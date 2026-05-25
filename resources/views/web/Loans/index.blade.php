<x-layouts.app :title="__('Loans')">

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <flux:card>
                    <x-slot:heading>
                        <div class="flex items-center gap-4">
                            <flux:icon.arrow-trending-up class="text-green-600 dark:text-green-500 size-32" />
                            <div class="">
                                <flux:heading size="xl" class="mb-1">Ingresos</flux:heading>
                                <flux:heading size="2xl" class="mb-1">S/.
                                    {{ number_format($information['total_positive_amount'], 2) }}</flux:heading>
                            </div>
                        </div>
                    </x-slot:heading>
                    <x-slot:text>

                    </x-slot:text>



                </flux:card>
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <flux:card>
                    <x-slot:heading>
                        <div class="flex items-center gap-4">
                            @if ($information['totalAmountPrestamo'] > 0)
                                <flux:icon.arrow-trending-up class="text-green-600 dark:text-green-500 size-32" />
                            @else
                                <flux:icon.arrow-trending-down class="text-red-600 dark:text-red-500 size-32" />
                            @endif
                            <div class="">
                                <flux:heading size="xl" class="mb-1">Balance</flux:heading>
                                <flux:heading size="2xl" class="mb-1">S/.
                                    {{ number_format($information['totalAmountPrestamo'], 2) }}
                                    </flux:heading>
                            </div>
                        </div>
                    </x-slot:heading>
                    <x-slot:text>

                    </x-slot:text>


                </flux:card>
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <flux:card>
                    <x-slot:heading>
                        <div class="flex items-center gap-4">
                            <flux:icon.arrow-trending-down class="text-red-600 dark:text-red-500 size-32" />
                            <div class="flex flex-col gap-2">
                                <flux:heading size="xl" class="mb-1">Egresos</flux:heading>
                                <flux:heading size="2xl" class="mb-1">S/.
                                    {{ number_format($information['total_negative_amount'], 2) }}</flux:heading>
                            </div>
                        </div>
                    </x-slot:heading>
                    <x-slot:text>

                    </x-slot:text>
                </flux:card>
            </div>
        </div>
        @livewire('loans.index')
    </div>
</x-layouts.app>
