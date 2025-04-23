<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:flex-row items-center justify-center bg-gradient-to-br from-teal-50 to-teal-100 p-4">
        <!-- Left Side: Branding & Illustration -->
        <div class="hidden lg:flex lg:w-1/2 p-10 justify-center items-center">
            <div class="text-center">
                <div class="w-full max-w-sm mx-auto mb-6">
                    <img
                        src="/Images/5124591-removebg-preview.png"
                        alt="Farmer AI Illustration"
                        class="w-full h-auto object-cover rounded-lg"
                    >
                </div>
                <h2 class="text-4xl font-bold text-teal-800 mb-4">Welcome to Farmer AI</h2>
                <p class="text-xl text-gray-600">Empowering Agriculture with Intelligent Technology</p>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 max-w-md bg-white  p-8 mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-teal-700 mb-2">Login</h1>
                <p class="text-gray-500">Access your Farmer AI dashboard</p>
            </div>

            <!-- Rest of the login form remains the same as in the previous version -->
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

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
                            autocomplete="current-password"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                            placeholder="Enter your password"
                        >
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded"
                        >
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-teal-600 hover:text-teal-800">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <div>
                    <button
                        type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition duration-300 ease-in-out transform hover:scale-105"
                    >
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Log in
                    </button>
                </div>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">
                            Or continue with
                        </span>
                    </div>
                </div>

                <!-- Social Login -->
                <div class="grid grid-cols-3 gap-3">
                    <button type="button" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Sign in with Google</span>
                        <i class="fab fa-google"></i>
                    </button>
                    <button type="button" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Sign in with Facebook</span>
                        <i class="fab fa-facebook"></i>
                    </button>
                    <button type="button" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Sign in with Apple</span>
                        <i class="fab fa-apple"></i>
                    </button>
                </div>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="font-medium text-teal-600 hover:text-teal-500">
                            Register here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
