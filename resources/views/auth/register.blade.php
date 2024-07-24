<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- User Type Switch -->
        <div class="flex items-center mt-4">
            <input type="radio" id="job_seeker" name="role" value="job_seeker" class="mr-2" checked>
            <label for="job_seeker" class="mr-4">Regular User</label>
            
            <input type="radio" id="company" name="role" value="company" class="mr-2">
            <label for="company">Company</label>
        </div>

        <!-- Name / Company Name -->
        <div class="mt-4">
            <x-input-label for="name" id="nameLabel" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Company Logo Upload (Visible only for companies) -->
        <div id="logo-upload" class="mt-4 hidden">
            <x-input-label for="logo" :value="__('Company Logo')" />
            <x-text-input id="logo" class="block mt-1 w-full" type="file" name="logo" />
            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const companyRadio = document.getElementById('company');
            const logoUpload = document.getElementById('logo-upload');

            companyRadio.addEventListener('change', function() {
                if (this.checked) {
                    logoUpload.classList.remove('hidden');
                }
            });

            const regularRadio = document.getElementById('job_seeker');
            regularRadio.addEventListener('change', function() {
                if (this.checked) {
                    logoUpload.classList.add('hidden');
                }
            });
        });
    </script>
</x-guest-layout>



