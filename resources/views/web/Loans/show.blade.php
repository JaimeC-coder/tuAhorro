<x-layouts.app.header :title="$loan['person'] ?? null">

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="">
            <div
                class="relative  overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <flux:card>
                    <x-slot:heading>
                        Información del préstamo
                    </x-slot:heading>
                    <x-slot:text>

                    </x-slot:text>

                    <x-slot:content>
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <flux:badge color="blue">Persona</flux:badge>
                                <flux:text>{{ $loan['person'] }}</flux:text>
                            </div>
                            <div class="flex items-center gap-2">
                                <flux:badge color="blue">Monto total</flux:badge>
                                <flux:text>{{ $loan['amount'] }}</flux:text>
                            </div>

                        </div>
                    </x-slot:content>

                </flux:card>
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl
         ">
            <flux:table  class=" text-sm text-left">
                <flux:table.columns>
                    <flux:table.column>#</flux:table.column>
                    <flux:table.column>Monto</flux:table.column>
                    <flux:table.column>Descripcion</flux:table.column>
                    <flux:table.column>Fecha de creación</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($loan['loan_details'] as $key => $lo)
                        <flux:table.row class="border-b border-neutral-200 dark:border-neutral-700">
                            <flux:table.cell>{{ $key + 1 }}</flux:table.cell>
                            <flux:table.cell>{{ $lo['amount'] }}</flux:table.cell>
                            <flux:table.cell>{{ $lo['description'] }}</flux:table.cell>
                            <flux:table.cell>{{ $lo['created_at'] }}</flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>


        </div>
    </div>

</x-layouts.app.header>
