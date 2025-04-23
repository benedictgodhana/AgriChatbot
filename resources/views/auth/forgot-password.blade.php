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
                <h2 class="text-4xl font-bold text-teal-800 mb-4">Reset Password</h2>
                <p class="text-xl text-gray-600">Recover Access to Your Account</p>
            </div>
        </div>

        <!-- Right Side: Forgot Password Form -->
        <div class="w-full lg:w-1/2 max-w-md bg-white p-8 mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-teal-700 mb-2">Forgot Password</h1>
                <p class="text-gray-500">Reset your Farmer AI account password</p>
            </div>

            <!-- Informational Text -->
            <div class="mb-6 text-sm text-gray-600 text-center">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
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
                            autofocus
                            :value="old('email')"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                            placeholder="Enter your registered email"
                        >
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
                </div>

                <!-- Send Reset Link Button -->
                <div>
                    <button
                        type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition duration-300 ease-in-out transform hover:scale-105"
                    >
                        <i class="fas fa-paper-plane mr-2"></i>
                        Email Password Reset Link
                    </button>
                </div>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Remember your password?
                        <a href="{{ route('login') }}" class="font-medium text-teal-600 hover:text-teal-500">
                            Back to Login
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
