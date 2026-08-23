<x-layouts::app :title="__('Edit Equipment')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <flux:heading size="xl">{{ __('Edit Equipment') }}</flux:heading>

        @include('admin.equipment._form', [
            'equipment' => $equipment,
            'action' => route('admin.equipment.update', $equipment),
            'method' => 'PUT',
        ])
    </div>
</x-layouts::app>
