<x-layouts::app :title="__('Add Equipment')">
    <div class="max-w-2xl">
        <flux:heading size="xl" class="mb-6">{{ __('Add Equipment') }}</flux:heading>

        <form method="POST" action="{{ route('admin.equipment.store') }}" class="flex flex-col gap-6">
            @csrf

            <flux:field>
                <flux:label>{{ __('Name') }}</flux:label>
                <flux:input name="name" value="{{ old('name') }}" required />
                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Category') }}</flux:label>
                <flux:input name="category" value="{{ old('category') }}" required />
                <flux:error name="category" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Description') }}</flux:label>
                <flux:textarea name="description">{{ old('description') }}</flux:textarea>
                <flux:error name="description" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Status') }}</flux:label>
                <flux:select name="status">
                    <option value="active" @selected(old('status', 'active') === 'active')>{{ __('Active') }}</option>
                    <option value="maintenance" @selected(old('status') === 'maintenance')>{{ __('Maintenance') }}</option>
                </flux:select>
                <flux:error name="status" />
            </flux:field>

            <div class="flex gap-2">
                <flux:button type="submit" variant="primary">{{ __('Create') }}</flux:button>
                <flux:button :href="route('admin.equipment.index')" variant="ghost" wire:navigate>{{ __('Cancel') }}</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
