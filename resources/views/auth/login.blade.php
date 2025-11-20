@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-blue-50 -mx-4 -my-8 px-4 py-8">
    <div class="w-full max-w-6xl">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <!-- Left: Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Sign In to Your Account</h1>
                    <p class="text-gray-600">Please log in to continue with your vote</p>
                </div>

                <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <div class="relative">
                            <div class="absolute left-3 top-3.5">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent transition" placeholder="email@example.com">
                        </div>
                        @error('email')
                            <p class="text-red-600 text-sm mt-1.5 flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute left-3 top-3.5">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="password" id="password" name="password" required class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent transition" placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="text-red-600 text-sm mt-1.5 flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                        <label for="remember" class="ml-2 text-sm text-gray-700">Remember me</label>
                    </div>

                    <!-- Hidden Timezone Field -->
                    <input type="hidden" name="timezone" id="timezone" value="UTC">

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-gradient-to-r from-sky-600 to-sky-700 text-white font-semibold py-2.5 rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-200 flex items-center justify-center gap-2">
                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/>
                        </svg>
                        Sign In
                    </button>
                </form>

                <!-- Register Link -->
                <p class="text-center text-sm text-gray-600 mt-6">
                    Don't have an account? <a href="{{ route('register') }}" class="text-sky-600 hover:text-sky-700 font-semibold transition">Sign up here</a>
                </p>
            </div>

            <!-- Right: Illustration (Hidden on Mobile) -->
            <div class="hidden md:flex flex-col items-center justify-center">
                <div class="w-96 h-96 bg-white rounded-3xl shadow-xl flex items-center justify-center overflow-hidden p-6">
                    <img src="https://newsroom.ucla.edu/_gallery/get_file/?file_id=5f8f0e412cfac252ec86cccb&album_id=" alt="E-Voting Illustration" class="w-full h-full object-contain">
                </div>
                <p class="text-center text-gray-600 text-sm mt-6">Join our trusted voting platform</p>
            </div>
        </div>
    </div>
</div>

<script>
    // Detect user's timezone automatically
    document.addEventListener('DOMContentLoaded', () => {
        try {
            const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            document.getElementById('timezone').value = timezone;
        } catch (error) {
            document.getElementById('timezone').value = 'UTC';
        }
    });
</script>
@endsection
