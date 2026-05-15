@props(['sortable' => false, 'sorted' => false, 'direction' => 'asc'])

<th {{ $attributes->class(['px-4 py-3 font-medium']) }}>
    @if($sortable)
        <button class="flex items-center gap-1 hover:text-zinc-700 dark:hover:text-zinc-200">
            {{ $slot }}
            @if($sorted)
                @if($direction === 'asc') ↑ @else ↓ @endif
            @else
                <span class="opacity-30">↕</span>
            @endif
        </button>
    @else
        {{ $slot }}
    @endif
</th>
