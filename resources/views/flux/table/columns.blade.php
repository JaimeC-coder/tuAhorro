@props(['sticky' => false])

<thead {{ $attributes->class([
    'text-xs text-zinc-500 uppercase bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-400',
    'sticky top-0 z-10' => $sticky,
]) }}>
    <tr>{{ $slot }}</tr>
</thead>
