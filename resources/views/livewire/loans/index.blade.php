<div class="relative h-full flex-1 overflow-hidden rounded-xl">


    <flux:table :paginate="$paginator" class=" text-sm text-left">
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
                <flux:table.row :key="$loan['id']" @class([
                    // base siempre
                    'transition-colors',

                    // negativo
                    'bg-red-80 text-red-700 dark:bg-red-600/10 dark:text-red-300' =>
                        (float) str_replace(',', '', $loan['amount']) < 0,

                    // positivo
                    'bg-green-80 text-green-700 dark:bg-green-600/10 dark:text-green-300' =>
                        (float) str_replace(',', '', $loan['amount']) > 0,

                    // cero
                    'bg-yellow-50 text-neutral-700 dark:bg-yellow-600/10 dark:text-neutral-300' =>
                        (float) str_replace(',', '', $loan['amount']) === 0.0,
                ])>
                    <flux:table.cell>{{ $loan['id'] }}</flux:table.cell>
                    <flux:table.cell>{{ $loan['person'] }}</flux:table.cell>
                    <flux:table.cell>{{ $loan['amount'] }}</flux:table.cell>
                    <flux:table.cell>{{ $loan['created_at'] }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:button variant="ghost" size="sm" icon="pencil"
                            href="{{ route('loans.edit', $loan['id']) }}">
                        </flux:button>
                        <flux:button variant="ghost" size="sm" icon="plus-circle"
                            href="{{ route('loans.edit', $loan['id']) }}">
                        </flux:button>
                        <flux:button variant="ghost" size="sm" icon="eye"
                            wire:click="showLoan({{ $loan['id'] }})">
                        </flux:button>

                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <flux:toast />
</div>
