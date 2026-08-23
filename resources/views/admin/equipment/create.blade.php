<x-layouts::app :title="__('Add Equipment')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <flux:heading size="xl">{{ __('Add Equipment') }}</flux:heading>

        @include('admin.equipment._form', [
            'action' => route('admin.equipment.store'),
        ])
    </div>
</x-layouts::app>
