<div>
    <flux:card>
        <x-slot:heading>
            Crear Prestamo
        </x-slot:heading>
        <x-slot:text>
            Complete el formulario para crear un nuevo prestamo.
        </x-slot:text>


        <x-slot:content>
            <form class="space-y-6 " wire:submit='save' method="POST">
                <div>
                    <flux:input type="text" label="Persona" wire:model="person" :invalid="!!$errors->first('person')" />

                </div>

                <div class="grid grid-cols-3 gap-4">

                    <flux:field>
                        <flux:label>Tipo de prestamo</flux:label>
                        <flux:select wire:model.live="type_loans">

                            <flux:select.option value="">Seleccione un tipo</flux:select.option>
                            <flux:select.option value="prestamo">Prestamo</flux:select.option>
                            <flux:select.option value="cuota">Cuota</flux:select.option>
                        </flux:select>
                        <flux:error name="type_loans" />

                    </flux:field>

                    <flux:input id="amount" type="number" label="Monto" step="0.01" wire:model="amount"
                        :disabled="$type_loans !== 'cuota'" :required="$type_loans === 'cuota'" />
                    <flux:input type="date" label="Fecha inicio" wire:model="date_init"
                        :disabled="$type_loans !== 'cuota'" :required="$type_loans === 'cuota'" />
                </div>


                @if ($type_loans === 'prestamo')

                    <div>
                        <flux:card>
                            <x-slot:heading>
                                Detalles del Monto
                            </x-slot:heading>
                            <x-slot:text>
                                Agregue los movimientos del préstamo (adelantos o préstamos parciales).
                            </x-slot:text>
                            <x-slot:content>
                                <div class="grid grid-cols-3 gap-4">
                                    <flux:field>
                                        <flux:label>Tipo </flux:label>
                                        <flux:select wire:model="newDetail.type">
                                            <flux:select.option value="">Seleccione un tipo</flux:select.option>
                                            <flux:select.option value="adelanto">Adelanto</flux:select.option>
                                            <flux:select.option value="prestamo">Prestamo</flux:select.option>
                                        </flux:select>
                                        <flux:error name="newDetail.type" />
                                    </flux:field>
                                    <flux:input label="Monto" placeholder="100" wire:model="newDetail.amount"
                                        type="number" step="0.01" />
                                    <flux:input type="date" label="Fecha" wire:model="newDetail.date" />
                                </div>


                                <div class="grid grid-cols-2 gap-4">
                                    <flux:textarea label="Descripción (opcional)" placeholder="Prestamo cuarto"
                                        rows="auto" wire:model="newDetail.description" />
                                </div>
                                <flux:button type="button" variant="outline" wire:click="addLoanDetail"
                                    wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="addLoanDetail">
                                        + Agregar detalle
                                    </span>
                                    <span wire:loading wire:target="addLoanDetail">
                                        Agregando...
                                    </span>
                                </flux:button>
                            </x-slot:content>

                        </flux:card>
                        @if (count($loan_details) > 0)
                            <flux:table>
                                <flux:table.columns>
                                    <flux:table.column>Tipo</flux:table.column>
                                    <flux:table.column>Monto</flux:table.column>
                                    <flux:table.column>Fecha</flux:table.column>
                                    <flux:table.column>Descripción</flux:table.column>
                                    <flux:table.column>Accion</flux:table.column>

                                </flux:table.columns>

                                <flux:table.rows>
                                    @foreach ($loan_details as $index => $detail)
                                        <flux:table.row>
                                            <flux:table.cell>
                                                <flux:select wire:model="loan_details.{{ $index }}.type">
                                                    <flux:select.option value="adelanto">Adelanto</flux:select.option>
                                                    <flux:select.option value="prestamo">Préstamo</flux:select.option>
                                                </flux:select>
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:input type="number" step="0.01" min="0.01"
                                                    wire:model="loan_details.{{ $index }}.amount" />
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:input type="date"
                                                    wire:model="loan_details.{{ $index }}.date" />
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:input type="text"
                                                    wire:model="loan_details.{{ $index }}.description" />
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:button type="button" variant="danger"
                                                    wire:click="removeLoanDetail({{ $index }})"
                                                    wire:confirm="¿Eliminar este detalle?">
                                                    Eliminar
                                                </flux:button>
                                            </flux:table.cell>
                                        </flux:table.row>
                                    @endforeach
                                </flux:table.rows>

                            </flux:table>
                        @else
                            <p class="text-sm text-neutral-400 italic mt-2">
                                Aún no hay detalles agregados.
                            </p>
                        @endif

                    </div>
                @elseif ($type_loans === 'cuota')
                    <div class="grid grid-cols-2 gap-4">
                        <flux:input id="number_loans_cuota" type="number" label="Número de Cuotas"
                            wire:model="number_loans_cuota" />
                        <flux:field>
                            <flux:label>Tipo de cuota</flux:label>
                            <flux:select wire:model="type_loans_cuota">
                                <flux:select.option value="">Seleccione un tipo</flux:select.option>
                                <flux:select.option value="semanal">semanal</flux:select.option>
                                <flux:select.option value="mensual">mensual</flux:select.option>
                            </flux:select>
                            <flux:error name="type_loans_cuota" />
                        </flux:field>
                    </div>
                @endif

                <div
                    class="space-y-2 mt-auto pt-6 border-t border-neutral-200 dark:border-neutral-700  flex justify-end">
                    <flux:button type="submit" variant="primary">
                        Guardar Prestamo
                    </flux:button>
                    <flux:button variant="ghost" href="{{ route('loans.index') }}">
                        Volver a la lista
                    </flux:button>
                </div>
            </form>
        </x-slot:content>







    </flux:card>
</div>
