@props(['paginate' => null])


<div class="space-y-3 w-full rounded-lg bg-white dark:bg-zinc-800 p-4 border border-zinc-200 dark:border-zinc-700">

    {{-- Toolbar --}}
    <div class="flex items-center justify-between gap-3">

        {{-- Lado izquierdo: botones de exportación + slots extra --}}
        <div class="flex items-center gap-2">

            {{-- Slot para botones personalizados izquierda --}}
            @if (isset($actions))
                {{ $actions }}
            @endif

            {{-- Botones de exportación --}}
            @if (isset($export))
                {{ $export }}
            @else
                {{-- Botones por defecto --}}
                <flux:button size="sm" variant="ghost" icon="document-chart-bar" title="Exportar SVG">
                    SVG
                </flux:button>
                <flux:button size="sm" variant="ghost" icon="document-text" title="Exportar PDF">
                    PDF
                </flux:button>
                <flux:button size="sm" variant="ghost" icon="table-cells" title="Exportar Excel">
                    Excel
                </flux:button>
            @endif

        </div>

        {{-- Lado derecho: botón de creación --}}
        <div>
            @if (isset($create))
                {{ $create }}
            @endif
        </div>

    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
        <table {{ $attributes->class(['w-full text-sm text-left']) }}>
            {{ $slot }}
        </table>
    </div>

    {{-- Paginación --}}
    @if ($paginate)
        <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-700">
            {{ $paginate['links'] }}
        </div>
    @endif

</div>
