@props(['variant' => 'default'])

<td {{ $attributes->class([
    'px-4 py-3 text-zinc-600 dark:text-zinc-300',
    'font-semibold text-zinc-900 dark:text-zinc-100' => $variant === 'strong',
]) }}>
    {{ $slot }}
</td>
