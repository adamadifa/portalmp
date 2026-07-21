<div class="mb-6 border-b border-gray-200">
    <nav class="flex space-x-1" aria-label="Tabs">
        <a href="{{ route('sagudangjadi.index') }}" 
           class="border-b-2 {{ request()->routeIs('sagudangjadi.*') ? 'border-[#294C9A] text-[#294C9A] font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} px-4 py-3 text-sm flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20"></path></svg>
            Saldo Awal
        </a>
        <a href="{{ route('fsthpgudang.index') }}" 
           class="border-b-2 {{ request()->routeIs('fsthpgudang.*') ? 'border-[#294C9A] text-[#294C9A] font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} px-4 py-3 text-sm flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            FSTHP
        </a>
        <a href="#" 
           class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 px-4 py-3 text-sm font-medium flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9h4l3 3v5h-2M1 14h18M1 7h12v7H1V7z"></path></svg>
            Surat Jalan
        </a>
        <a href="{{ route('repackgudangjadi.index') }}" 
           class="border-b-2 {{ request()->routeIs('repackgudangjadi.*') ? 'border-[#294C9A] text-[#294C9A] font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} px-4 py-3 text-sm flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H18.5"></path></svg>
            Repack
        </a>
        <a href="{{ route('rejectgudangjadi.index') }}" 
           class="border-b-2 {{ request()->routeIs('rejectgudangjadi.*') ? 'border-[#294C9A] text-[#294C9A] font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} px-4 py-3 text-sm flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            Reject
        </a>
        <a href="{{ route('lainnyagudangjadi.index') }}" 
           class="border-b-2 {{ request()->routeIs('lainnyagudangjadi.*') ? 'border-[#294C9A] text-[#294C9A] font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} px-4 py-3 text-sm flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Lainnya
        </a>
    </nav>
</div>
