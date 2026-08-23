<x-layouts::app :title="$equipment->name">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-start justify-between gap-4">
            <div class="flex flex-col gap-2">
                <flux:heading size="xl">{{ $equipment->name }}</flux:heading>
                <flux:text>{{ $equipment->category }}</flux:text>
            </div>

            @if ($equipment->isInMaintenance())
                <flux:badge color="amber" size="lg">{{ __('Unavailable') }}</flux:badge>
            @endif
        </div>

        <flux:card class="flex flex-col gap-4">
            <div>
                <flux:heading size="sm" class="mb-1">{{ __('Status') }}</flux:heading>
                <flux:text>{{ ucfirst($equipment->status->value) }}</flux:text>
            </div>

            @if ($equipment->description)
                <div>
                    <flux:heading size="sm" class="mb-1">{{ __('Description') }}</flux:heading>
                    <flux:text>{{ $equipment->description }}</flux:text>
                </div>
            @endif
        </flux:card>

        <flux:button :href="route('equipment.index')" variant="ghost" wire:navigate>
            {{ __('Back to catalog') }}
        </flux:button>
    </div>
</x-layouts::app>
