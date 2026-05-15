<x-layouts.app :title="__('Coins')">

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl
         ">


            <flux:table.table :paginate="$paginator" class=" text-sm text-left">
                <x-slot:create>
                    <flux:button variant="primary" size="sm" icon="plus" href="{{ route('coins.create') }}">
                        Nueva Moneda
                    </flux:button>
                </x-slot:create>
                <flux:table.columns>

                    <flux:table.column>#</flux:table.column>
                    <flux:table.column>Moneda</flux:table.column>
                    <flux:table.column>Simbolo</flux:table.column>
                    <flux:table.column>Fecha de creación</flux:table.column>
                    <flux:table.column>Acciones</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($data as $coin)
                        <flux:table.row :key="$coin['id']">
                            <flux:table.cell>{{ $coin['id'] }}</flux:table.cell>
                            <flux:table.cell>{{ $coin['type'] }}</flux:table.cell>
                            <flux:table.cell>{{ $coin['symbol'] }}</flux:table.cell>
                            <flux:table.cell>{{ $coin['created_at'] }}</flux:table.cell>
                            <flux:table.cell>
                                <flux:button variant="ghost" size="sm" icon="pencil" href="{{ route('coins.edit', $coin['id']) }}">
                                </flux:button>
                                <flux:button variant="ghost" size="sm" icon="trash"
                                    onclick="event.preventDefault(); if(confirm('¿Estás seguro de eliminar esta moneda?')) { document.getElementById('delete-form-{{ $coin['id'] }}').submit(); }">
                                </flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table.table>


        </div>
    </div>
</x-layouts.app>
