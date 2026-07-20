<header class="sticky top-0 z-30 flex items-center justify-between px-8 py-4 bg-white border-b border-gray-100 shadow-sm">
    <!-- Page Title -->
    <div>
        <h1 class="text-xl font-bold text-gray-900">
            {{ $header ?? 'Dashboard' }}
        </h1>
    </div>

    <!-- Right Side -->
    <div class="flex items-center space-x-6">
        <!-- Avatars -->
        <div class="flex items-center">
            <div class="flex -space-x-2">
                <img class="w-8 h-8 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=User+One&background=random" alt="Avatar">
                <img class="w-8 h-8 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=User+Two&background=random" alt="Avatar">
            </div>
            <div class="flex items-center justify-center w-8 h-8 ml-2 text-xs font-medium text-indigo-600 bg-indigo-50 rounded-full border border-indigo-100">
                +2
            </div>
            <button class="flex items-center justify-center w-8 h-8 ml-2 text-gray-400 border border-gray-200 border-dashed rounded-full hover:text-gray-600 hover:border-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            </button>
        </div>

        <!-- Notification -->
        <button class="relative text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            <span class="absolute top-0 right-0 flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-red-500 border-2 border-white rounded-full -mt-1 -mr-1">
                24
            </span>
        </button>

        <!-- Search -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" class="block w-64 py-2.5 pl-10 pr-12 text-sm text-gray-900 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 placeholder-gray-400" placeholder="Search anything">
            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                <kbd class="inline-flex items-center px-2 py-0.5 text-xs font-sans font-medium text-gray-400 bg-white border border-gray-200 rounded">
                    ⌘ K
                </kbd>
            </div>
        </div>

        <!-- Profile Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.outside="open = false" class="flex items-center space-x-2 focus:outline-none">
                <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=294C9A&color=fff" alt="Profile">
                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            
            <!-- Dropdown Menu -->
            <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl border border-gray-100 shadow-lg py-1 z-50 text-sm">
                <div class="px-4 py-2 border-b border-gray-50">
                    <p class="font-bold text-gray-900 truncate">{{ Auth::user()->name ?? 'User' }}</p>
                    <p class="text-xs text-gray-500 truncate mt-0.5">{{ Auth::user()->email ?? 'user@example.com' }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 transition">My Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition font-medium">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
