<x-layouts.app :title="__('Loans')">

    <div class="flex h-full w-full flex-1 flex-col gap-1 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-1">
            <div
                class="    rounded-xl border border-neutral-200 dark:border-neutral-700">


                @livewire('Loans.create')


            </div>

        </div>

    </div>
</x-layouts.app>
