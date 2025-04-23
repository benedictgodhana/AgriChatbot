<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:flex-row items-center justify-center bg-gradient-to-br from-teal-50 to-teal-100 p-4">
        <!-- Left Side: Branding & Illustration -->
        <div class="hidden lg:flex lg:w-1/2 p-10 justify-center items-center">
            <div class="text-center">
                <div class="w-full max-w-sm mx-auto mb-6">
                    <img
                        src="/Images/5124591-removebg-preview.png"
                        alt="Farmer AI Illustration"
                        class="w-full h-auto object-cover "
                    >
                </div>
                <h2 class="text-4xl font-bold text-teal-800 mb-4">Join Farmer AI</h2>
                <p class="text-xl text-gray-600">Create Your Agricultural Intelligence Account</p>
            </div>
        </div>

        <!-- Right Side: Registration Form -->
        <div class="w-full lg:w-1/2 max-w-md bg-white p-8 mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-teal-700 mb-2">Register</h1>
                <p class="text-gray-500">Start your agricultural innovation journey</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name Input -->
                <div>
                    <label for="name" class="block text-sm font-medium text-teal-800 mb-2">
                        Full Name
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-teal-500"></i>
                        </div>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            required
                            autofocus
                            autocomplete="name"
                            :value="old('name')"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                            placeholder="Enter your full name"
                        >
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600" />
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-teal-800 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-teal-500"></i>
                        </div>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            required
                            autocomplete="username"
                            :value="old('email')"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                            placeholder="you@example.com"
                        >
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-teal-800 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-teal-500"></i>
                        </div>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            autocomplete="new-password"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                            placeholder="Create a strong password"
                        >
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
                </div>

                <!-- Confirm Password Input -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-teal-800 mb-2">
                        Confirm Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-check-circle text-teal-500"></i>
                        </div>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            required
                            autocomplete="new-password"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                            placeholder="Repeat your password"
                        >
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600" />
                </div>

                <!-- Registration Button -->
                <div>
                    <button
                        type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition duration-300 ease-in-out transform hover:scale-105"
                    >
                        <i class="fas fa-user-plus mr-2"></i>
                        Register
                    </button>
                </div>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-medium text-teal-600 hover:text-teal-500">
                            Log in here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
