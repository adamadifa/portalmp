<!-- TOP NAVBAR -->
<header class="px-6 lg:px-10 py-3.5 flex items-center justify-between gap-4 border-b border-slate-200/80 dark:border-slate-800 shrink-0 bg-white dark:bg-slate-900 sticky top-0 z-30 transition-colors duration-200">
    <div class="flex items-center gap-3.5">
        <!-- Mobile Hamburger Menu Button -->
        <button id="openMobileSidebarBtn" class="lg:hidden p-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 cursor-pointer">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>
        <span class="text-sm font-bold text-slate-800 dark:text-white tracking-tight sm:hidden">{{ $header ?? ($headerTitle ?? 'Dashboard') }}</span>
    </div>

    <div class="flex items-center gap-3 ml-auto">
        <!-- Mobile Search Trigger Button -->
        <button type="button" id="navSearchMobileTrigger" title="Cari Menu (Ctrl + K)" class="sm:hidden p-2 text-slate-500 dark:text-slate-300 hover:text-slate-700 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800 border border-slate-200/70 dark:border-slate-700 rounded-xl transition flex items-center justify-center cursor-pointer">
            <i data-lucide="search" class="w-4 h-4"></i>
        </button>

        <!-- Desktop Search Trigger Bar (Mac Spotlight / Command Palette) -->
        <button type="button" id="navSearchTrigger" title="Cari Menu & Navigasi Cepat (Ctrl + K)" class="relative hidden sm:flex items-center text-left pl-10 pr-16 py-2 bg-slate-50 dark:bg-slate-800/90 hover:bg-slate-100/90 dark:hover:bg-slate-800 border border-slate-200/80 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-500 dark:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition w-64 lg:w-72 shadow-2xs group cursor-pointer">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 group-hover:text-blue-500 transition-colors absolute left-3.5 pointer-events-none"></i>
            <span class="truncate">Cari menu & navigasi cepat...</span>
            <div class="absolute right-2.5 flex items-center gap-0.5 text-[10px] font-bold text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-200 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 px-1.5 py-0.5 rounded-md shadow-2xs transition-colors">
                <span class="text-[9px]">⌘</span> K
            </div>
        </button>

        <!-- Dark / Light Theme Toggle Button -->
        <button id="themeToggleBtn" type="button" title="Toggle Tema Gelap / Terang" class="p-2 text-slate-500 dark:text-slate-300 hover:text-slate-700 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800 border border-slate-200/70 dark:border-slate-700 rounded-xl transition flex items-center justify-center cursor-pointer">
            <i data-lucide="moon" class="w-4 h-4 block dark:hidden text-slate-500 hover:text-slate-700"></i>
            <i data-lucide="sun" class="w-4 h-4 hidden dark:block text-amber-400"></i>
        </button>

        <!-- User Profile Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.outside="open = false" type="button" class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent hover:border-slate-200/70 dark:hover:border-slate-700 transition cursor-pointer">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="hidden md:flex flex-col text-left">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200 leading-tight truncate max-w-[120px]">{{ Auth::user()->name ?? 'User' }}</span>
                    <span class="text-[10px] text-slate-400 dark:text-slate-500 truncate max-w-[120px]">{{ Auth::user()->roles->first()->name ?? 'User' }}</span>
                </div>
                <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 hidden md:block" :class="{ 'rotate-180': open }"></i>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" x-transition class="absolute right-0 mt-2 w-56 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xl py-1.5 z-50 text-xs">
                <div class="px-4 py-2.5 border-b border-slate-100 dark:border-slate-800">
                    <p class="font-bold text-slate-900 dark:text-white truncate">{{ Auth::user()->name ?? 'User' }}</p>
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 truncate mt-0.5">{{ Auth::user()->email ?? 'user@pacific.id' }}</p>
                </div>
                <div class="p-1 space-y-0.5">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition">
                        <i data-lucide="user" class="w-4 h-4 text-slate-400"></i>
                        <span>Profil Pengguna</span>
                    </a>
                    @can('users.view')
                    <a href="{{ route('users.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition">
                        <i data-lucide="users" class="w-4 h-4 text-slate-400"></i>
                        <span>Kelola Pengguna</span>
                    </a>
                    @endcan
                </div>
                <div class="p-1 border-t border-slate-100 dark:border-slate-800">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2.5 w-full text-left px-3 py-2 rounded-xl text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-500/10 font-medium transition cursor-pointer">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            <span>Keluar (Logout)</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
