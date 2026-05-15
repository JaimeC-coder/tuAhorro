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

                <div class="grid grid-cols-2 gap-4">

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
                        :disabled=" $this->type_loans !== 'cuota'" :required=" $this->type_loans === 'cuota'" />

                </div>


                @if ($this->type_loans === 'prestamo')

                    <div>
                        <flux:card>
                            <x-slot:heading>
                                Detalles del Monto
                            </x-slot:heading>
                            <x-slot:text>
                                Agregue los detalles del monto, incluyendo monto, tipo, fecha y descripción.
                            </x-slot:text>
                            <x-slot:content>
                                <div class="grid grid-cols-2 gap-4">
                                    <flux:field>
                                        <flux:label>Tipo de prestamo</flux:label>
                                        <flux:select wire:model="loan_details_type_loans" >
                                            <flux:select.option value="">Seleccione un tipo</flux:select.option>
                                            <flux:select.option value="adelanto">Adelanto</flux:select.option>
                                            <flux:select.option value="prestamo">Prestamo</flux:select.option>
                                        </flux:select>
                                    </flux:field>
                                    <flux:input label="Monto" placeholder="100" wire:model="loan_details_amount"
                                        type="number" step="0.01" />
                                </div>


                                <div class="grid grid-cols-2 gap-4">
                                    <flux:textarea label="Descripción (opcional)" placeholder="Prestamo cuarto"
                                        rows="auto" wire:model="loan_details_description" />
                                </div>
                                <flux:button type="button" variant="outline" wire:click="addLoanDetail">
                                    Agregar Detalle
                                </flux:button>
                            </x-slot:content>

                        </flux:card>

                        <flux:table>
                            <flux:table.columns>
                                <flux:table.column>Monto</flux:table.column>
                                <flux:table.column>Tipo</flux:table.column>
                                <flux:table.column>Fecha</flux:table.column>
                                <flux:table.column>Descripción</flux:table.column>
                                <flux:table.column>Accion</flux:table.column>

                            </flux:table.columns>

                            <flux:table.rows>
                                @foreach ($loan_details as $index => $detail)
                                    <flux:table.row>
                                        <flux:table.cell>
                                            <flux:input type="number" step="0.01"
                                                wire:model="loan_details.{{ $index }}.amount" required />
                                        </flux:table.cell>
                                        <flux:table.cell>
                                            <flux:input type="text"
                                                wire:model="loan_details.{{ $index }}.type" required />
                                        </flux:table.cell>
                                        <flux:table.cell>
                                            <flux:input type="date"
                                                wire:model="loan_details.{{ $index }}.date" required />
                                        </flux:table.cell>
                                        <flux:table.cell>
                                            <flux:input type="text"
                                                wire:model="loan_details.{{ $index }}.description" required />
                                        </flux:table.cell>
                                        <flux:table.cell>
                                            <flux:button type="button" variant="danger"
                                                wire:click="removeLoanDetail({{ $index }})">
                                                Eliminar
                                            </flux:button>
                                        </flux:table.cell>
                                    </flux:table.row>
                                @endforeach
                            </flux:table.rows>

                        </flux:table>

                    </div>
                @elseif ($this->type_loans === 'cuota')
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
