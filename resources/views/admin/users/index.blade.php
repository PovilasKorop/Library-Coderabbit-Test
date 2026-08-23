<x-layouts::app :title="__('Manage Users')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <flux:heading size="xl">{{ __('Manage Users') }}</flux:heading>

        <flux:card>
            <flux:heading size="lg" class="mb-4">{{ __('Create account') }}</flux:heading>

            <form method="POST" action="{{ route('admin.users.store') }}" class="grid gap-4 md:grid-cols-2">
                @csrf

                <flux:field>
                    <flux:label>{{ __('Name') }}</flux:label>
                    <flux:input name="name" value="{{ old('name') }}" required />
                    <flux:error name="name" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Email') }}</flux:label>
                    <flux:input type="email" name="email" value="{{ old('email') }}" required />
                    <flux:error name="email" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Password') }}</flux:label>
                    <flux:input type="password" name="password" required />
                    <flux:error name="password" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Role') }}</flux:label>
                    <flux:select name="role" required>
                        @foreach (\App\Role::cases() as $role)
                            <flux:select.option value="{{ $role->value }}" :selected="old('role') === $role->value">
                                {{ ucfirst($role->value) }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="role" />
                </flux:field>

                <flux:field class="md:col-span-2">
                    <flux:checkbox name="is_active" value="1" :checked="old('is_active', true)" label="{{ __('Active account') }}" />
                    <flux:error name="is_active" />
                </flux:field>

                <div class="md:col-span-2">
                    <flux:button type="submit" variant="primary">{{ __('Create account') }}</flux:button>
                </div>
            </form>
        </flux:card>

        <flux:table>
            <flux:table.columns>
                <flux:table.column>{{ __('Name') }}</flux:table.column>
                <flux:table.column>{{ __('Email') }}</flux:table.column>
                <flux:table.column>{{ __('Role') }}</flux:table.column>
                <flux:table.column>{{ __('Status') }}</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($users as $user)
                    <flux:table.row>
                        <flux:table.cell colspan="5">
                            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="grid gap-4 md:grid-cols-5 md:items-end">
                                @csrf
                                @method('PUT')

                                <flux:field>
                                    <flux:label class="sr-only">{{ __('Name') }}</flux:label>
                                    <flux:input name="name" value="{{ old('name', $user->name) }}" required />
                                    <flux:error name="name" />
                                </flux:field>

                                <flux:field>
                                    <flux:label class="sr-only">{{ __('Email') }}</flux:label>
                                    <flux:input type="email" name="email" value="{{ old('email', $user->email) }}" required />
                                    <flux:error name="email" />
                                </flux:field>

                                <flux:field>
                                    <flux:label class="sr-only">{{ __('Role') }}</flux:label>
                                    <flux:select name="role" required>
                                        @foreach (\App\Role::cases() as $role)
                                            <flux:select.option
                                                value="{{ $role->value }}"
                                                :selected="old('role', $user->role->value) === $role->value"
                                            >
                                                {{ ucfirst($role->value) }}
                                            </flux:select.option>
                                        @endforeach
                                    </flux:select>
                                    <flux:error name="role" />
                                </flux:field>

                                <flux:field>
                                    <flux:checkbox name="is_active" value="1" :checked="old('is_active', $user->is_active)" label="{{ __('Active') }}" />
                                    <flux:error name="is_active" />
                                </flux:field>

                                <div>
                                    <flux:button type="submit" variant="primary" size="sm">{{ __('Update') }}</flux:button>
                                </div>
                            </form>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>

        {{ $users->links() }}
    </div>
</x-layouts::app>
