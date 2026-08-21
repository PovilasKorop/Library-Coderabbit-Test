<x-layouts::app :title="__('Edit Equipment')">
    <div class="max-w-2xl">
        <flux:heading size="xl" class="mb-6">{{ __('Edit Equipment') }}</flux:heading>

        <form method="POST" action="{{ route('admin.equipment.update', $equipment) }}" class="mb-6 flex flex-col gap-6">
            @csrf
            @method('PUT')

            <flux:field>
                <flux:label>{{ __('Name') }}</flux:label>
                <flux:input name="name" value="{{ old('name', $equipment->name) }}" required />
                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Category') }}</flux:label>
                <flux:input name="category" value="{{ old('category', $equipment->category) }}" required />
                <flux:error name="category" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Description') }}</flux:label>
                <flux:textarea name="description">{{ old('description', $equipment->description) }}</flux:textarea>
                <flux:error name="description" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Status') }}</flux:label>
                <flux:select name="status">
                    <option value="active" @selected(old('status', $equipment->status->value) === 'active')>{{ __('Active') }}</option>
                    <option value="maintenance" @selected(old('status', $equipment->status->value) === 'maintenance')>{{ __('Maintenance') }}</option>
                </flux:select>
                <flux:error name="status" />
            </flux:field>

            <div class="flex gap-2">
                <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
                <flux:button :href="route('admin.equipment.index')" variant="ghost" wire:navigate>{{ __('Back') }}</flux:button>
            </div>
        </form>

        <form method="POST" action="{{ route('admin.equipment.destroy', $equipment) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this equipment?') }}')">
            @csrf
            @method('DELETE')
            <flux:button type="submit" variant="danger">{{ __('Delete Equipment') }}</flux:button>
        </form>
    </div>
</x-layouts::app>
