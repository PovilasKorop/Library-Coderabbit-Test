<x-layouts::app :title="__('Manage Users')">
    <div class="flex flex-col gap-8">
        <flux:heading size="xl">{{ __('Manage Users') }}</flux:heading>

        <flux:card>
            <flux:heading size="lg" class="mb-4">{{ __('Create Account') }}</flux:heading>

            <form method="POST" action="{{ route('admin.users.store') }}" class="flex flex-col gap-4">
                @csrf

                <div class="grid gap-4 md:grid-cols-2">
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
                        <flux:label>{{ __('Confirm Password') }}</flux:label>
                        <flux:input type="password" name="password_confirmation" required />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Role') }}</flux:label>
                        <flux:select name="role">
                            <option value="member" @selected(old('role', 'member') === 'member')>{{ __('Member') }}</option>
                            <option value="administrator" @selected(old('role') === 'administrator')>{{ __('Administrator') }}</option>
                        </flux:select>
                        <flux:error name="role" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Active') }}</flux:label>
                        <flux:switch name="is_active" value="1" :checked="old('is_active', true)" />
                        <flux:error name="is_active" />
                    </flux:field>
                </div>

                <div>
                    <flux:button type="submit" variant="primary">{{ __('Create Account') }}</flux:button>
                </div>
            </form>
        </flux:card>

        <div class="flex flex-col gap-4">
            <flux:heading size="lg">{{ __('Accounts') }}</flux:heading>

            @foreach ($users as $user)
                <flux:card>
                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="flex flex-col gap-4">
                        @csrf
                        @method('PUT')

                        <div class="grid gap-4 md:grid-cols-2">
                            <flux:field>
                                <flux:label>{{ __('Name') }}</flux:label>
                                <flux:input name="name" value="{{ old('name', $user->name) }}" required />
                                <flux:error name="name" />
                            </flux:field>

                            <flux:field>
                                <flux:label>{{ __('Email') }}</flux:label>
                                <flux:input type="email" name="email" value="{{ old('email', $user->email) }}" required />
                                <flux:error name="email" />
                            </flux:field>

                            <flux:field>
                                <flux:label>{{ __('New Password') }}</flux:label>
                                <flux:input type="password" name="password" placeholder="{{ __('Leave blank to keep current') }}" />
                                <flux:error name="password" />
                            </flux:field>

                            <flux:field>
                                <flux:label>{{ __('Confirm Password') }}</flux:label>
                                <flux:input type="password" name="password_confirmation" />
                            </flux:field>

                            <flux:field>
                                <flux:label>{{ __('Role') }}</flux:label>
                                <flux:select name="role">
                                    <option value="member" @selected(old('role', $user->role->value) === 'member')>{{ __('Member') }}</option>
                                    <option value="administrator" @selected(old('role', $user->role->value) === 'administrator')>{{ __('Administrator') }}</option>
                                </flux:select>
                                <flux:error name="role" />
                            </flux:field>

                            <flux:field>
                                <flux:label>{{ __('Active') }}</flux:label>
                                <flux:switch name="is_active" value="1" :checked="old('is_active', $user->is_active)" />
                                <flux:error name="is_active" />
                            </flux:field>
                        </div>

                        <div>
                            <flux:button type="submit" variant="primary">{{ __('Save Changes') }}</flux:button>
                        </div>
                    </form>
                </flux:card>
            @endforeach
        </div>
    </div>
</x-layouts::app>
