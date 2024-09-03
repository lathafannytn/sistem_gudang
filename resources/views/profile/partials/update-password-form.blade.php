<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        <!-- Current Password -->
        <div>
            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" required>
        </div>

        <!-- New Password -->
        <div>
            <label for="password">New Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <!-- Confirm New Password -->
        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit">Update Password</button>
    </form>

</section>
