<x-layouts::app :title="$equipment->name">
    <div class="flex max-w-3xl flex-col gap-6">
        <div class="flex items-start justify-between gap-4">
            <div class="flex flex-col gap-2">
                <flux:heading size="xl">{{ $equipment->name }}</flux:heading>
                <flux:text>{{ $equipment->category }}</flux:text>
            </div>

            @if ($equipment->isUnavailable())
                <flux:badge color="zinc" size="lg">{{ __('Unavailable') }}</flux:badge>
            @endif
        </div>

        @if ($equipment->description)
            <flux:card>
                <flux:heading size="lg" class="mb-2">{{ __('Description') }}</flux:heading>
                <flux:text>{{ $equipment->description }}</flux:text>
            </flux:card>
        @endif

        <div>
            <flux:button :href="route('equipment.index')" variant="ghost" icon="arrow-left" wire:navigate>
                {{ __('Back to catalog') }}
            </flux:button>
        </div>
    </div>
</x-layouts::app>
