<x-layouts::app :title="$equipment->name">
    <div class="max-w-2xl flex flex-col gap-6">
        <flux:heading size="xl">{{ $equipment->name }}</flux:heading>

        <flux:card class="flex flex-col gap-4">
            <div>
                <flux:text class="font-medium">{{ __('Category') }}</flux:text>
                <flux:text>{{ $equipment->category }}</flux:text>
            </div>

            <div>
                <flux:text class="font-medium">{{ __('Status') }}</flux:text>
                <flux:badge :color="$equipment->status->value === 'active' ? 'green' : 'zinc'">
                    {{ ucfirst($equipment->status->value) }}
                </flux:badge>
            </div>

            @if ($equipment->description)
                <div>
                    <flux:text class="font-medium">{{ __('Description') }}</flux:text>
                    <flux:text>{{ $equipment->description }}</flux:text>
                </div>
            @endif
        </flux:card>

        <flux:button :href="route('admin.equipment.edit', $equipment)" variant="primary" wire:navigate>
            {{ __('Edit') }}
        </flux:button>
    </div>
</x-layouts::app>
