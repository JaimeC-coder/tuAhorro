<x-layouts.app :title="__('Loans')">

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
                    <flux:button variant="primary" size="sm" icon="plus" href="{{ route('loans.create') }}">
                        Nueva Prestamo
                    </flux:button>
                </x-slot:create>
                <flux:table.columns>

                    <flux:table.column>#</flux:table.column>
                    <flux:table.column>Persona</flux:table.column>
                    <flux:table.column>Monto</flux:table.column>
                    <flux:table.column>Fecha de creación</flux:table.column>
                    <flux:table.column>Acciones</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($data as $loan)
                        <flux:table.row :key="$loan['id']">
                            <flux:table.cell>{{ $loan['id'] }}</flux:table.cell>
                            <flux:table.cell>{{ $loan['person'] }}</flux:table.cell>
                            <flux:table.cell>{{ $loan['amount'] }}</flux:table.cell>
                            <flux:table.cell>{{ $loan['created_at'] }}</flux:table.cell>
                            <flux:table.cell>
                                <flux:button variant="ghost" size="sm" icon="pencil" href="{{ route('loans.edit', $loan['id']) }}">
                                </flux:button>
                                <flux:button variant="ghost" size="sm" icon="diamond-plus" href="{{ route('loans.edit', $loan['id']) }}">
                                </flux:button>

                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table.table>


        </div>
    </div>
</x-layouts.app>
