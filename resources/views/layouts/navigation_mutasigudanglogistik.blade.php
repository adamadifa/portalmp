<div class="mb-6 border-b border-gray-200">
    <nav class="flex flex-wrap -mb-px space-x-1" aria-label="Tabs">
        @can('sagudanglogistik.index')
        <a href="{{ Route::has('sagudanglogistik.index') ? route('sagudanglogistik.index') : '#' }}" 
           class="border-b-2 {{ request()->routeIs('sagudanglogistik.*') ? 'border-[#294C9A] text-[#294C9A] font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} px-4 py-3 text-sm flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20"></path></svg>
            Saldo Awal
        </a>
        @endcan

        @can('opgudanglogistik.index')
        <a href="{{ Route::has('opgudanglogistik.index') ? route('opgudanglogistik.index') : '#' }}" 
           class="border-b-2 {{ request()->routeIs('opgudanglogistik.*') ? 'border-[#294C9A] text-[#294C9A] font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} px-4 py-3 text-sm flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            Opname
        </a>
        @endcan

        @can('barangmasukgl.index')
        <a href="{{ Route::has('barangmasukgudanglogistik.index') ? route('barangmasukgudanglogistik.index') : '#' }}" 
           class="border-b-2 {{ request()->routeIs('barangmasukgudanglogistik.*') ? 'border-[#294C9A] text-[#294C9A] font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} px-4 py-3 text-sm flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Barang Masuk
        </a>
        @endcan

        @can('barangkeluargl.index')
        <a href="{{ Route::has('barangkeluargudanglogistik.index') ? route('barangkeluargudanglogistik.index') : '#' }}" 
           class="border-b-2 {{ request()->routeIs('barangkeluargudanglogistik.*') ? 'border-[#294C9A] text-[#294C9A] font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} px-4 py-3 text-sm flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
            Barang Keluar
        </a>
        @endcan
    </nav>
</div>
