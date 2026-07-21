<div class="mb-6 border-b border-gray-200">
    <nav class="flex flex-wrap -mb-px space-x-1" aria-label="Tabs">
        @can('sagudangbahan.index')
        <a href="{{ route('sagudangbahan.index') }}" 
           class="border-b-2 {{ request()->routeIs('sagudangbahan.*') ? 'border-[#294C9A] text-[#294C9A] font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} px-4 py-3 text-sm flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20"></path></svg>
            Saldo Awal
        </a>
        @endcan

        @can('sahargagb.index')
        <a href="{{ route('sahargagb.index') }}" 
           class="border-b-2 {{ request()->routeIs('sahargagb.*') ? 'border-[#294C9A] text-[#294C9A] font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} px-4 py-3 text-sm flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M10 5h4a2 2 0 012 2v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V7a2 2 0 012-2z"></path></svg>
            Saldo Awal Harga
        </a>
        @endcan

        @can('opgudangbahan.index')
        <a href="{{ route('opgudangbahan.index') }}" 
           class="border-b-2 {{ request()->routeIs('opgudangbahan.*') ? 'border-[#294C9A] text-[#294C9A] font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} px-4 py-3 text-sm flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            Opname
        </a>
        @endcan

        @can('barangmasukgb.index')
        <a href="{{ route('barangmasukgudangbahan.index') }}" 
           class="border-b-2 {{ request()->routeIs('barangmasukgudangbahan.*') ? 'border-[#294C9A] text-[#294C9A] font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} px-4 py-3 text-sm flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Barang Masuk
        </a>
        @endcan

        @can('barangkeluargb.index')
        <a href="{{ route('barangkeluargudangbahan.index') }}" 
           class="border-b-2 {{ request()->routeIs('barangkeluargudangbahan.*') ? 'border-[#294C9A] text-[#294C9A] font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} px-4 py-3 text-sm flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
            Barang Keluar
        </a>
        @endcan
    </nav>
</div>
