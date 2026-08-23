@props(['equipment' => null, 'action', 'method' => 'POST'])

<form method="POST" action="{{ $action }}" class="flex flex-col gap-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <flux:field>
        <flux:label>{{ __('Name') }}</flux:label>
        <flux:input name="name" value="{{ old('name', $equipment?->name) }}" required />
        <flux:error name="name" />
    </flux:field>

    <flux:field>
        <flux:label>{{ __('Category') }}</flux:label>
        <flux:input name="category" value="{{ old('category', $equipment?->category) }}" required />
        <flux:error name="category" />
    </flux:field>

    <flux:field>
        <flux:label>{{ __('Description') }}</flux:label>
        <flux:textarea name="description" rows="4">{{ old('description', $equipment?->description) }}</flux:textarea>
        <flux:error name="description" />
    </flux:field>

    <flux:field>
        <flux:label>{{ __('Status') }}</flux:label>
        <flux:select name="status" required>
            @foreach (\App\EquipmentStatus::cases() as $status)
                <flux:select.option
                    value="{{ $status->value }}"
                    :selected="old('status', $equipment?->status?->value) === $status->value"
                >
                    {{ ucfirst($status->value) }}
                </flux:select.option>
            @endforeach
        </flux:select>
        <flux:error name="status" />
    </flux:field>

    <div class="flex gap-2">
        <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
        <flux:button :href="route('admin.equipment.index')" variant="ghost" wire:navigate>{{ __('Cancel') }}</flux:button>
    </div>
</form>
