<x-guest-layout>
    <div class="min-h-screen flex flex-col lg:flex-row bg-[#F8F9FA]">
        <!-- LEFT SIDE: Graphics / Showcase (Hidden on Mobile) -->
        <div class="hidden lg:flex lg:w-1/2 flex-col justify-between p-16 bg-[#294C9A] relative overflow-hidden select-none">
            <!-- Wave Ornament Background -->
            <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden">
                <svg class="absolute bottom-0 left-0 w-full" viewBox="0 0 1440 320" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.08" d="M0,96L48,112C96,128,192,160,288,186.7C384,213,480,235,576,218.7C672,203,768,149,864,128C960,107,1056,117,1152,138.7C1248,160,1344,192,1392,208L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z" fill="#FFFFFF"></path>
                    <path opacity="0.05" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,213.3C672,224,768,224,864,208C960,192,1056,160,1152,144C1248,128,1344,128,1392,128L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z" fill="#FFFFFF"></path>
                </svg>
            </div>

            <!-- Brand Logo -->
            <div class="flex items-center z-10">
                <img src="{{ asset('assets/img/logo/mp.png') }}" alt="MAKMUR PERMATA" class="h-32 object-contain" style="filter: brightness(0) invert(1);" />
            </div>

            <!-- Typography & Carousel Controls at Bottom -->
            <div class="my-auto py-12 z-10">
                <h3 class="text-4xl font-black text-white leading-tight">Welcome back!</h3>
                <p class="text-base font-semibold text-blue-100 mt-4 leading-relaxed max-w-md">
                    Start managing your finance faster and better<br>
                    Start managing your finance faster and better
                </p>

                <!-- Carousel Dot Navigation -->
                <div class="flex items-center gap-4 mt-10">
                    <!-- Left Arrow -->
                    <button type="button" class="text-blue-200 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                    <!-- Indicators -->
                    <div class="flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-blue-300/60"></span>
                        <span class="w-2 h-2 rounded-full bg-blue-300/60"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-white"></span>
                        <span class="w-2 h-2 rounded-full bg-blue-300/60"></span>
                    </div>
                    <!-- Right Arrow -->
                    <button type="button" class="text-blue-200 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE: Login Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-between p-8 sm:p-16 bg-white min-h-screen relative">
            <div></div> <!-- Spacer for vertical layout alignment -->

            <!-- Main Form Card -->
            <div class="max-w-md w-full mx-auto my-auto">
                <div class="mb-8">
                    <!-- Horizontal Logo -->
                    <div class="flex items-center mb-6 select-none">
                        <img src="{{ asset('assets/img/logo/logokanan.png') }}" alt="MAKMUR PERMATA" class="h-14 object-contain" />
                    </div>

                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Welcome back!</h2>
                    <p class="text-gray-400 text-sm mt-2">Start managing your finance faster and better</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <div class="relative flex items-center bg-[#F3F4F6] border border-transparent focus-within:border-[#294C9A] focus-within:bg-white rounded-2xl transition-all duration-200">
                            <!-- Envelope Icon -->
                            <div class="pl-4 text-[#294C9A]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                   placeholder="you@exmaple.com"
                                   class="w-full bg-transparent border-none focus:ring-0 py-4 px-3 text-gray-700 placeholder-gray-400 rounded-2xl text-sm" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <!-- Password -->
                    <div x-data="{ show: false }">
                        <div class="relative flex items-center bg-[#F3F4F6] border border-transparent focus-within:border-[#294C9A] focus-within:bg-white rounded-2xl transition-all duration-200">
                            <!-- Lock Icon -->
                            <div class="pl-4 text-[#294C9A]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </div>
                            <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password"
                                   placeholder="At least 8 characters"
                                   class="w-full bg-transparent border-none focus:ring-0 py-4 px-3 text-gray-700 placeholder-gray-400 rounded-2xl text-sm" />
                            <!-- Password Toggle Eye Icon -->
                            <button type="button" @click="show = !show" class="pr-4 text-gray-400 hover:text-gray-600 focus:outline-none">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <circle cx="12" cy="12" r="3" stroke="currentColor" fill="none" />
                                </svg>
                                <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <!-- Forgot Password Link -->
                    <div class="flex items-center justify-end text-sm">
                        @if (Route::has('password.request'))
                            <a class="font-bold text-[#294C9A] hover:text-[#1E3770] transition-colors" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-[#294C9A] hover:bg-[#1E3770] text-white font-bold py-4 px-6 rounded-2xl shadow-lg shadow-blue-900/10 hover:shadow-blue-900/20 active:scale-[0.98] transition-all duration-150">
                        Login
                    </button>
                </form>

                <!-- Separator -->
                <div class="relative flex items-center justify-center my-8">
                    <div class="border-t border-gray-150 w-full"></div>
                    <span class="absolute bg-white px-4 text-xs font-bold text-gray-300 uppercase">or</span>
                </div>

                <!-- Social Logins -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Google Button -->
                    <a href="#" class="flex items-center justify-center gap-3 py-3.5 px-4 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        <span class="text-sm font-bold text-gray-700">Google</span>
                    </a>
                    <!-- Facebook Button -->
                    <a href="#" class="flex items-center justify-center gap-3 py-3.5 px-4 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-[#1877F2]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                        <span class="text-sm font-bold text-gray-700">Facebook</span>
                    </a>
                </div>

                <!-- Sign Up Link -->
                <p class="text-center text-sm font-semibold text-gray-400 mt-8">
                    Don't you have an account? 
                    <a href="{{ route('register') }}" class="text-[#294C9A] hover:text-[#1E3770] font-bold transition-colors">Sign Up</a>
                </p>
            </div>

            <!-- Footer copyright -->
            <div class="text-right text-[10px] font-bold text-gray-300 uppercase tracking-widest mt-8">
                &copy; 2022 ALL RIGHTS RESERVED
            </div>
        </div>
    </div>
</x-guest-layout>
