<x-layouts::app :title="__('Equipment Catalog')">
    <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <flux:heading size="xl">{{ __('Equipment Catalog') }}</flux:heading>

            <form method="GET" action="{{ route('equipment.index') }}" class="flex gap-2">
                <flux:input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="{{ __('Search by name or category...') }}"
                />
                <flux:button type="submit" variant="primary">{{ __('Search') }}</flux:button>
            </form>
        </div>

        @if ($equipment->isEmpty())
            <flux:callout variant="secondary">
                {{ __('No equipment found.') }}
            </flux:callout>
        @else
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($equipment as $item)
                    <flux:card class="flex flex-col gap-3">
                        <div class="flex items-start justify-between gap-2">
                            <flux:heading size="lg">
                                <a href="{{ route('equipment.show', $item) }}" class="hover:underline" wire:navigate>
                                    {{ $item->name }}
                                </a>
                            </flux:heading>

                            @if ($item->isUnavailable())
                                <flux:badge color="zinc">{{ __('Unavailable') }}</flux:badge>
                            @endif
                        </div>

                        <flux:text>{{ $item->category }}</flux:text>

                        @if ($item->description)
                            <flux:text class="line-clamp-2">{{ $item->description }}</flux:text>
                        @endif

                        <div class="mt-auto">
                            <flux:button :href="route('equipment.show', $item)" variant="ghost" size="sm" wire:navigate>
                                {{ __('View details') }}
                            </flux:button>
                        </div>
                    </flux:card>
                @endforeach
            </div>

            {{ $equipment->links() }}
        @endif
    </div>
</x-layouts::app>
