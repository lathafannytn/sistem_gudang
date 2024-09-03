<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    <p>Name: {{ $user->name }}</p>
                    <p>Email: {{ $user->email }}</p>
                        {{ __('Update Profile Information') }}
                    </h3>
                    @include('profile.partials.update-profile-information-form', ['user' => $user])
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Update Password') }}
                    </h3>
                    @include('profile.partials.update-password-form', ['user' => $user])
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Delete Account') }}
                    </h3>
                    @include('profile.partials.delete-user-form', ['user' => $user])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
