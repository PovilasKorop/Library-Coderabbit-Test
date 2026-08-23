<x-layouts::app :title="__('Manage Equipment')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between gap-4">
            <flux:heading size="xl">{{ __('Manage Equipment') }}</flux:heading>
            <flux:button :href="route('admin.equipment.create')" variant="primary" wire:navigate>
                {{ __('Add equipment') }}
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
                            <flux:table.cell>{{ ucfirst($item->status->value) }}</flux:table.cell>
                            <flux:table.cell>
                                <div class="flex justify-end gap-2">
                                    <flux:button :href="route('admin.equipment.edit', $item)" size="sm" variant="ghost" wire:navigate>
                                        {{ __('Edit') }}
                                    </flux:button>
                                    <form method="POST" action="{{ route('admin.equipment.destroy', $item) }}">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button type="submit" size="sm" variant="danger">
                                            {{ __('Delete') }}
                                        </flux:button>
                                    </form>
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>

            {{ $equipment->links() }}
        @endif
    </div>
</x-layouts::app>
