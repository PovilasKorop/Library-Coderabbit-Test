<x-layouts::app :title="__('Manage Equipment')">
    <div class="flex flex-col gap-6">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">{{ __('Manage Equipment') }}</flux:heading>
            <flux:button :href="route('admin.equipment.create')" variant="primary" wire:navigate>
                {{ __('Add Equipment') }}
            </flux:button>
        </div>

        @if ($equipment->isEmpty())
            <flux:callout variant="secondary">
                {{ __('No equipment yet.') }}
            </flux:callout>
        @else
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>{{ __('Name') }}</flux:table.column>
                    <flux:table.column>{{ __('Category') }}</flux:table.column>
                    <flux:table.column>{{ __('Status') }}</flux:table.column>
                    <flux:table.column></flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach ($equipment as $item)
                        <flux:table.row>
                            <flux:table.cell>{{ $item->name }}</flux:table.cell>
                            <flux:table.cell>{{ $item->category }}</flux:table.cell>
                            <flux:table.cell>
                                <flux:badge :color="$item->status->value === 'active' ? 'green' : 'zinc'">
                                    {{ ucfirst($item->status->value) }}
                                </flux:badge>
                            </flux:table.cell>
                            <flux:table.cell class="text-end">
                                <flux:button :href="route('admin.equipment.edit', $item)" size="sm" variant="ghost" wire:navigate>
                                    {{ __('Edit') }}
                                </flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>

            {{ $equipment->links() }}
        @endif
    </div>
</x-layouts::app>
