@props(['heading' => null, 'text' => null])


<div class="flex flex-col h-auto p-6 space-y-6  ">
    <div>
        <flux:heading size="lg">{{ $heading ?? 'Titulo del formulario' }}</flux:heading>
        <flux:text class="mt-2">{{ $text ?? 'Descripcion del formulario' }}</flux:text>
    </div>

    @if (isset($content))
        <div class="space-y-6">
            {{ $content }}
        </div>
    @endif


</div>

