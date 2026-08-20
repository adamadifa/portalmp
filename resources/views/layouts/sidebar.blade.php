<aside class="flex flex-col w-64 h-full bg-[#294C9A] text-white border-r border-[#294C9A] shrink-0">
    <!-- Logo -->
    <div class="flex items-center justify-between px-6 py-4 h-16 border-b border-white/10">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <img src="{{ asset('assets/img/logo/logoputih.png') }}" alt="Logo" class="h-8 object-contain" />
        </a>
        <button class="text-blue-200 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
        </button>
    </div>

    <!-- Workspace Switcher -->
    <div class="px-6 py-4">
        <button class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-white bg-white/5 border border-white/10 rounded-lg hover:bg-white/10">
            <div class="flex items-center gap-2">
                <div class="flex items-center justify-center w-6 h-6 bg-white rounded-full text-[#294C9A] text-xs font-bold">W</div>
                <span>Uxerflow</span>
            </div>
            <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-2 space-y-6 overflow-y-auto">
        <!-- Main Section -->
        <div>
            <h3 class="px-2 text-[10px] font-bold text-blue-200/50 uppercase tracking-wider mb-2">Main</h3>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center px-2 py-2 text-sm font-medium text-white bg-white/10 rounded-lg group">
                    <svg class="w-5 h-5 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                <!-- Data Master Dropdown -->
        @canany(['produk.view', 'produkharga.view', 'pelanggan.view', 'supplier.view', 'angkutan.view', 'tujuanangkutan.view', 'barangpembelian.view', 'barangproduksi.view'])
        <div x-data="{ open: {{ (Request::is('produk*') || Request::is('produkharga*') || Request::is('pelanggan*') || Request::is('supplier*') || Request::is('angkutan*') || Request::is('tujuanangkutan*') || Request::is('barangpembelian*') || Request::is('barangproduksi*')) ? 'true' : 'false' }} }">
            <button @click="open = !open" class="flex items-center justify-between w-full px-2 py-2 text-sm font-medium text-blue-100/70 hover:bg-white/5 hover:text-white rounded-lg group transition">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 text-blue-200/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                    <span>Data Master</span>
                </div>
                <svg class="w-4 h-4 text-blue-200 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-transition class="mt-1 ml-4 pl-4 space-y-0.5 border-l-2 border-white/20">
                @can('produk.view')
                <a href="{{ route('produk.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('produk*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                    <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('produk*') ? 'bg-white' : 'bg-white/30' }}"></span>
                    Produk
                </a>
                @endcan
                @can('produkharga.view')
                <a href="{{ route('produkharga.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('produkharga*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                    <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('produkharga*') ? 'bg-white' : 'bg-white/30' }}"></span>
                    Harga
                </a>
                @endcan
                @can('pelanggan.view')
                <a href="{{ route('pelanggan.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('pelanggan*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                    <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('pelanggan*') ? 'bg-white' : 'bg-white/30' }}"></span>
                    Pelanggan
                </a>
                @endcan
                @can('supplier.view')
                <a href="{{ route('supplier.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('supplier*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                    <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('supplier*') ? 'bg-white' : 'bg-white/30' }}"></span>
                    Supplier
                </a>
                @endcan
                @can('angkutan.view')
                <a href="{{ route('angkutan.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('angkutan*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                    <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('angkutan*') ? 'bg-white' : 'bg-white/30' }}"></span>
                    Angkutan
                </a>
                @endcan
                @can('tujuanangkutan.view')
                <a href="{{ route('tujuanangkutan.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('tujuanangkutan*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                    <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('tujuanangkutan*') ? 'bg-white' : 'bg-white/30' }}"></span>
                    Tujuan Angkutan
                </a>
                @endcan
                @can('barangpembelian.view')
                <a href="{{ route('barangpembelian.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('barangpembelian*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                    <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('barangpembelian*') ? 'bg-white' : 'bg-white/30' }}"></span>
                    Barang
                </a>
                @endcan
                @can('barangproduksi.view')
                <a href="{{ route('barangproduksi.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('barangproduksi*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                    <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('barangproduksi*') ? 'bg-white' : 'bg-white/30' }}"></span>
                    Barang Produksi
                </a>
                @endcan
            </div>
        </div>
        @endcanany

        <!-- Produksi Dropdown -->
        @canany(['samutasiproduksi.view'])
        <div x-data="{ open: {{ Request::is('samutasiproduksi*', 'bpbj*', 'fsthp*', 'fsthpgudang*', 'laporanproduksi*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="flex items-center justify-between w-full px-2 py-2 text-sm font-medium text-blue-100/70 hover:bg-white/5 hover:text-white rounded-lg group transition">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 text-blue-200/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span>Produksi</span>
                </div>
                <svg class="w-4 h-4 text-blue-200 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-transition class="mt-1 ml-4 pl-4 space-y-0.5 border-l-2 border-white/20">
                @can('samutasiproduksi.view')
                <a href="{{ route('samutasiproduksi.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('samutasiproduksi*', 'bpbj*', 'fsthp*', 'fsthpgudang*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                    <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('samutasiproduksi*', 'bpbj*', 'fsthp*', 'fsthpgudang*') ? 'bg-white' : 'bg-white/30' }}"></span>
                    Mutasi Produk
                </a>
                <a href="{{ route('laporanproduksi.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('laporanproduksi*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                    <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('laporanproduksi*') ? 'bg-white' : 'bg-white/30' }}"></span>
                    Laporan
                </a>
                @endcan
            </div>
        </div>
        @endcanany

        <!-- Gudang Jadi Dropdown -->
        @canany(['sagudangjadi.view'])
        <div x-data="{ open: {{ Request::is('sagudangjadi*', 'fsthpgudang*', 'repackgudangjadi*', 'rejectgudangjadi*', 'lainnyagudangjadi*', 'laporangudangjadi*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="flex items-center justify-between w-full px-2 py-2 text-sm font-medium text-blue-100/70 hover:bg-white/5 hover:text-white rounded-lg group transition">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 text-blue-200/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span>Gudang Jadi</span>
                </div>
                <svg class="w-4 h-4 text-blue-200 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-transition class="mt-1 ml-4 pl-4 space-y-0.5 border-l-2 border-white/20">
                @can('sagudangjadi.view')
                <a href="{{ route('sagudangjadi.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('sagudangjadi*', 'fsthpgudang*', 'repackgudangjadi*', 'rejectgudangjadi*', 'lainnyagudangjadi*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                    <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('sagudangjadi*', 'fsthpgudang*', 'repackgudangjadi*', 'rejectgudangjadi*', 'lainnyagudangjadi*') ? 'bg-white' : 'bg-white/30' }}"></span>
                    Mutasi Produk
                </a>
                @endcan
                <a href="{{ route('laporangudangjadi.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('laporangudangjadi*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                    <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('laporangudangjadi*') ? 'bg-white' : 'bg-white/30' }}"></span>
                    Laporan
                </a>
            </div>
        </div>
        @endcanany

        <!-- Pembelian Dropdown -->
        @canany(['pembelian.index', 'pembelian.jatuhtempo', 'kontrabonpmb.index'])
        <div x-data="{ open: {{ (Request::is('pembelian*') || Request::is('kontrabonpembelian*') || Request::is('laporanpembelian*')) ? 'true' : 'false' }} }">
            <button @click="open = !open" class="flex items-center justify-between w-full px-2 py-2 text-sm font-medium text-blue-100/70 hover:bg-white/5 hover:text-white rounded-lg group transition">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 text-blue-200/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>Pembelian</span>
                </div>
                <svg class="w-4 h-4 text-blue-200 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-transition class="mt-1 ml-4 pl-4 space-y-0.5 border-l-2 border-white/20">
                @can('pembelian.index')
                <a href="{{ route('pembelian.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ (Request::is('pembelian') || Request::is('pembelian/create') || (Request::is('pembelian/*') && !Request::is('pembelian/jatuhtempo') && !Request::is('pembelian/laporan*'))) ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                    <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ (Request::is('pembelian') || Request::is('pembelian/create') || (Request::is('pembelian/*') && !Request::is('pembelian/jatuhtempo') && !Request::is('pembelian/laporan*'))) ? 'bg-white' : 'bg-white/30' }}"></span>
                    Pembelian
                </a>
                @endcan
                @can('pembelian.jatuhtempo')
                <a href="{{ route('pembelian.jatuhtempo') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('pembelian/jatuhtempo') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                    <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('pembelian/jatuhtempo') ? 'bg-white' : 'bg-white/30' }}"></span>
                    Jatuh Tempo
                </a>
                @endcan
                @can('kontrabonpmb.index')
                <a href="{{ route('kontrabonpmb.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('kontrabonpembelian*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                    <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('kontrabonpembelian*') ? 'bg-white' : 'bg-white/30' }}"></span>
                    Kontrabon
                </a>
                @endcan
                
                <a href="{{ route('laporanpembelian.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('laporanpembelian*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                    <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('laporanpembelian*') ? 'bg-white' : 'bg-white/30' }}"></span>
                    Laporan Pembelian
                </a>
            </div>
        </div>
        @endcanany

        <!-- Marketing Dropdown -->
        @canany(['penjualanmarketing.view', 'laporanmarketing.index'])
        <div x-data="{ open: {{ (Request::is('penjualanmarketing*') || Request::is('laporanmarketing*')) ? 'true' : 'false' }} }">
            <button @click="open = !open" class="flex items-center justify-between w-full px-2 py-2 text-sm font-medium text-blue-100/70 hover:bg-white/5 hover:text-white rounded-lg group transition">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 text-blue-200/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span>Marketing</span>
                </div>
                <svg class="w-4 h-4 text-blue-200 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-transition class="mt-1 ml-4 pl-4 space-y-0.5 border-l-2 border-white/20">
                @can('penjualanmarketing.view')
                <a href="{{ route('penjualanmarketing.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('penjualanmarketing*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                    <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('penjualanmarketing*') ? 'bg-white' : 'bg-white/30' }}"></span>
                    Penjualan
                </a>
                @endcan
                @can('laporanmarketing.index')
                <a href="{{ route('laporanmarketing.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('laporanmarketing*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                    <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('laporanmarketing*') ? 'bg-white' : 'bg-white/30' }}"></span>
                    Laporan
                </a>
                @endcan
            </div>
        </div>
        @endcanany

        <!-- Gudang Bahan Dropdown -->
        @canany(['sagudangbahan.index', 'sahargagb.index', 'opgudangbahan.index', 'barangmasukgb.index', 'barangkeluargb.index', 'laporangudangbahan.index'])
        <div>
            <div x-data="{ open: {{ Request::is('sagudangbahan*', 'sahargagb*', 'opgudangbahan*', 'barangmasukgudangbahan*', 'barangkeluargudangbahan*', 'laporangudangbahan*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-2 py-2 text-sm font-medium text-blue-100/70 hover:bg-white/5 hover:text-white rounded-lg group transition">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-blue-200/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span>Gudang Bahan</span>
                    </div>
                    <svg class="w-4 h-4 text-blue-200 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" x-transition class="mt-1 ml-4 pl-4 space-y-0.5 border-l-2 border-white/20">
                    <a href="{{ route('sagudangbahan.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('sagudangbahan*', 'sahargagb*', 'opgudangbahan*', 'barangmasukgudangbahan*', 'barangkeluargudangbahan*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                        <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('sagudangbahan*', 'sahargagb*', 'opgudangbahan*', 'barangmasukgudangbahan*', 'barangkeluargudangbahan*') ? 'bg-white' : 'bg-white/30' }}"></span>
                        Mutasi Barang
                    </a>
                    @canany(['laporangudangbahan.index', 'gb.barangmasuk', 'gb.barangkeluar', 'gb.persediaan', 'gb.rekappersediaan', 'gb.kartugudang'])
                    <a href="{{ route('laporangudangbahan.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('laporangudangbahan*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                        <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('laporangudangbahan*') ? 'bg-white' : 'bg-white/30' }}"></span>
                        Laporan
                    </a>
                    @endcanany
                </div>
        </div>
        @endcanany

        <!-- Gudang Logistik Dropdown -->
        @canany(['sagudanglogistik.index', 'opgudanglogistik.index', 'barangmasukgl.index', 'barangkeluargl.index', 'laporangudanglogistik.index'])
        <div>
            <div x-data="{ open: {{ Request::is('sagudanglogistik*', 'opgudanglogistik*', 'barangmasukgudanglogistik*', 'barangkeluargudanglogistik*', 'laporangudanglogistik*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-2 py-2 text-sm font-medium text-blue-100/70 hover:bg-white/5 hover:text-white rounded-lg group transition">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-blue-200/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        <span>Gudang Logistik</span>
                    </div>
                    <svg class="w-4 h-4 text-blue-200 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" x-transition class="mt-1 ml-4 pl-4 space-y-0.5 border-l-2 border-white/20">
                    <a href="{{ route('barangmasukgudanglogistik.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('sagudanglogistik*', 'opgudanglogistik*', 'barangmasukgudanglogistik*', 'barangkeluargudanglogistik*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                        <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('sagudanglogistik*', 'opgudanglogistik*', 'barangmasukgudanglogistik*', 'barangkeluargudanglogistik*') ? 'bg-white' : 'bg-white/30' }}"></span>
                        Mutasi Barang
                    </a>
                    @canany(['laporangudanglogistik.index', 'gl.barangmasuk', 'gl.barangkeluar', 'gl.persediaan', 'gl.rekappersediaan', 'gl.kartugudang'])
                    <a href="{{ route('laporangudanglogistik.index') }}" class="relative flex items-center px-2 py-1.5 text-xs font-semibold {{ Request::is('laporangudanglogistik*') ? 'text-white bg-white/10' : 'text-blue-100/60 hover:text-white hover:bg-white/5' }} rounded-lg transition">
                        <span class="absolute -left-[21px] w-2 h-2 rounded-full {{ Request::is('laporangudanglogistik*') ? 'bg-white' : 'bg-white/30' }}"></span>
                        Laporan
                    </a>
                    @endcanany
                </div>
            </div>
        </div>
        @endcanany
            </div>
        </div>

        <!-- Settings Section -->
        <div>
            <h3 class="px-2 text-[10px] font-bold text-blue-200/50 uppercase tracking-wider mb-2">Settings</h3>
            <div class="space-y-1">
                @can('roles.view')
                <a href="{{ route('roles.index') }}" class="flex items-center px-2 py-2 text-sm font-medium text-blue-100/70 hover:bg-white/5 hover:text-white rounded-lg group">
                    <svg class="w-5 h-5 mr-3 text-blue-200/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Roles
                </a>
                @endcan
                @can('users.view')
                <a href="{{ route('users.index') }}" class="flex items-center px-2 py-2 text-sm font-medium text-blue-100/70 hover:bg-white/5 hover:text-white rounded-lg group">
                    <svg class="w-5 h-5 mr-3 text-blue-200/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Users
                </a>
                @endcan
            </div>
        </div>
    </nav>

    <!-- Bottom Actions -->
    <div class="p-4 border-t border-white/10">
        <!-- Dark Mode Toggle -->
        <div class="flex items-center justify-between px-2">
            <div class="flex items-center text-sm font-medium text-blue-100/70">
                <svg class="w-5 h-5 mr-3 text-blue-200/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                Dark Mode
            </div>
            <button class="relative inline-flex items-center h-6 rounded-full w-11 bg-white/20 focus:outline-none">
                <span class="inline-block w-4 h-4 transform bg-white rounded-full translate-x-1 transition shadow-sm"></span>
            </button>
        </div>
    </div>
</aside>
