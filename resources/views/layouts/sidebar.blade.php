<!-- SIDEBAR -->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 lg:static w-64 bg-[#162a5b] dark:bg-[#0f1d40] text-white border-r border-blue-900/40 flex flex-col justify-between shrink-0 p-5 select-none -translate-x-full lg:translate-x-0 h-full overflow-y-auto overflow-x-hidden transition-colors duration-200">
    <div>
        <!-- Brand Header -->
        <div class="brand-header flex items-center justify-between px-1 h-12 mb-5">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 min-w-0">
                <div class="w-9 h-9 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center text-white font-black text-lg shadow-sm shrink-0 p-1">
                    <img src="{{ asset('assets/img/logo/mp.png') }}" alt="Portal MP" class="w-full h-full object-contain filter brightness-0 invert" onerror="this.onerror=null; this.parentElement.innerHTML='<i data-lucide=&quot;layers&quot; class=&quot;w-5 h-5 text-white&quot;></i>';">
                </div>
                <div class="brand-text flex flex-col min-w-0">
                    <span class="font-black text-base tracking-tight text-white truncate">Portal MP</span>
                    <span class="text-[10px] font-semibold text-blue-200/70 -mt-1 truncate">Manajemen Pacific</span>
                </div>
            </a>
            
            <!-- Desktop Minimize Toggle Button -->
            <button id="toggleSidebarBtn" title="Toggle Sidebar" class="hidden lg:flex text-blue-200 hover:text-white transition p-1.5 rounded-lg hover:bg-white/10 items-center justify-center cursor-pointer">
                <i data-lucide="panel-left-close" class="w-4 h-4"></i>
            </button>

            <!-- Mobile Close Button -->
            <button id="closeMobileSidebarBtn" class="lg:hidden text-blue-200 hover:text-white p-1.5 rounded-lg hover:bg-white/10">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Main Nav Items -->
        <div class="space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" title="Dashboard" class="nav-item flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl font-semibold text-xs transition {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white border border-white/25 shadow-xs font-bold' : 'text-blue-100/75 hover:text-white hover:bg-white/10' }}">
                <i data-lucide="layout-grid" class="w-4 h-4 shrink-0 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-blue-200' }}"></i>
                <span class="nav-text truncate font-bold">Dashboard</span>
            </a>

            <!-- SECTION: OPERASIONAL & TRANSAKSI -->
            <div class="pt-3">
                <p class="section-header px-3 text-[10px] font-extrabold tracking-wider text-blue-300/60 uppercase mb-1.5">Operasional</p>

                <!-- Marketing & Penjualan -->
                @canany(['penjualanmarketing.view', 'laporanmarketing.index'])
                <div x-data="{ open: {{ (Request::is('penjualanmarketing*') || Request::is('laporanmarketing*')) ? 'true' : 'false' }} }">
                    <button @click="open = !open" type="button" class="nav-item flex items-center justify-between w-full px-3.5 py-2 rounded-xl font-medium text-xs transition hover:text-white hover:bg-white/10 cursor-pointer {{ (Request::is('penjualanmarketing*') || Request::is('laporanmarketing*')) ? 'bg-white/15 text-white font-bold border border-white/15' : 'text-blue-100/75' }}">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <i data-lucide="shopping-bag" class="w-4 h-4 shrink-0 {{ (Request::is('penjualanmarketing*') || Request::is('laporanmarketing*')) ? 'text-white' : 'text-blue-200' }}"></i>
                            <span class="nav-text truncate">Marketing</span>
                        </div>
                        <i data-lucide="chevron-down" class="chevron-icon w-3.5 h-3.5 text-blue-200/70 transition-transform duration-200 shrink-0" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-transition class="submenu-wrapper mt-1 ml-4 pl-3.5 space-y-1 border-l-2 border-white/20">
                        @can('penjualanmarketing.view')
                        <a href="{{ route('penjualanmarketing.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('penjualanmarketing*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('penjualanmarketing*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Penjualan</span>
                        </a>
                        @endcan
                        @can('laporanmarketing.index')
                        <a href="{{ route('laporanmarketing.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('laporanmarketing*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('laporanmarketing*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Laporan Marketing</span>
                        </a>
                        @endcan
                    </div>
                </div>
                @endcanany

                <!-- Pembelian -->
                @canany(['pembelian.index'])
                <div x-data="{ open: {{ (Request::is('pembelian*') || Request::is('laporanpembelian*')) ? 'true' : 'false' }} }">
                    <button @click="open = !open" type="button" class="nav-item flex items-center justify-between w-full px-3.5 py-2 rounded-xl font-medium text-xs transition hover:text-white hover:bg-white/10 cursor-pointer {{ (Request::is('pembelian*') || Request::is('laporanpembelian*')) ? 'bg-white/15 text-white font-bold border border-white/15' : 'text-blue-100/75' }}">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <i data-lucide="shopping-cart" class="w-4 h-4 shrink-0 {{ (Request::is('pembelian*') || Request::is('laporanpembelian*')) ? 'text-white' : 'text-blue-200' }}"></i>
                            <span class="nav-text truncate">Pembelian</span>
                        </div>
                        <i data-lucide="chevron-down" class="chevron-icon w-3.5 h-3.5 text-blue-200/70 transition-transform duration-200 shrink-0" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-transition class="submenu-wrapper mt-1 ml-4 pl-3.5 space-y-1 border-l-2 border-white/20">
                        @can('pembelian.index')
                        <a href="{{ route('pembelian.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ (Request::is('pembelian') || Request::is('pembelian/create') || (Request::is('pembelian/*') && !Request::is('pembelian/laporan*'))) ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ (Request::is('pembelian') || Request::is('pembelian/create') || (Request::is('pembelian/*') && !Request::is('pembelian/laporan*'))) ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Transaksi Pembelian</span>
                        </a>
                        @endcan
                        <a href="{{ route('laporanpembelian.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('laporanpembelian*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('laporanpembelian*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Laporan Pembelian</span>
                        </a>
                    </div>
                </div>
                @endcanany

                <!-- Produksi -->
                @canany(['samutasiproduksi.view'])
                <div x-data="{ open: {{ Request::is('samutasiproduksi*', 'bpbj*', 'fsthp*', 'fsthpgudang*', 'laporanproduksi*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" type="button" class="nav-item flex items-center justify-between w-full px-3.5 py-2 rounded-xl font-medium text-xs transition hover:text-white hover:bg-white/10 cursor-pointer {{ Request::is('samutasiproduksi*', 'bpbj*', 'fsthp*', 'fsthpgudang*', 'laporanproduksi*') ? 'bg-white/15 text-white font-bold border border-white/15' : 'text-blue-100/75' }}">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <i data-lucide="factory" class="w-4 h-4 shrink-0 {{ Request::is('samutasiproduksi*', 'bpbj*', 'fsthp*', 'fsthpgudang*', 'laporanproduksi*') ? 'text-white' : 'text-blue-200' }}"></i>
                            <span class="nav-text truncate">Produksi</span>
                        </div>
                        <i data-lucide="chevron-down" class="chevron-icon w-3.5 h-3.5 text-blue-200/70 transition-transform duration-200 shrink-0" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-transition class="submenu-wrapper mt-1 ml-4 pl-3.5 space-y-1 border-l-2 border-white/20">
                        @can('samutasiproduksi.view')
                        <a href="{{ route('samutasiproduksi.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('samutasiproduksi*', 'bpbj*', 'fsthp*', 'fsthpgudang*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('samutasiproduksi*', 'bpbj*', 'fsthp*', 'fsthpgudang*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Mutasi Produksi</span>
                        </a>
                        <a href="{{ route('laporanproduksi.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('laporanproduksi*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('laporanproduksi*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Laporan Produksi</span>
                        </a>
                        @endcan
                    </div>
                </div>
                @endcanany

                <!-- Gudang Jadi -->
                @canany(['sagudangjadi.view'])
                <div x-data="{ open: {{ Request::is('sagudangjadi*', 'fsthpgudang*', 'repackgudangjadi*', 'rejectgudangjadi*', 'lainnyagudangjadi*', 'laporangudangjadi*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" type="button" class="nav-item flex items-center justify-between w-full px-3.5 py-2 rounded-xl font-medium text-xs transition hover:text-white hover:bg-white/10 cursor-pointer {{ Request::is('sagudangjadi*', 'fsthpgudang*', 'repackgudangjadi*', 'rejectgudangjadi*', 'lainnyagudangjadi*', 'laporangudangjadi*') ? 'bg-white/15 text-white font-bold border border-white/15' : 'text-blue-100/75' }}">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <i data-lucide="warehouse" class="w-4 h-4 shrink-0 {{ Request::is('sagudangjadi*', 'fsthpgudang*', 'repackgudangjadi*', 'rejectgudangjadi*', 'lainnyagudangjadi*', 'laporangudangjadi*') ? 'text-white' : 'text-blue-200' }}"></i>
                            <span class="nav-text truncate">Gudang Jadi</span>
                        </div>
                        <i data-lucide="chevron-down" class="chevron-icon w-3.5 h-3.5 text-blue-200/70 transition-transform duration-200 shrink-0" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-transition class="submenu-wrapper mt-1 ml-4 pl-3.5 space-y-1 border-l-2 border-white/20">
                        @can('sagudangjadi.view')
                        <a href="{{ route('sagudangjadi.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('sagudangjadi*', 'fsthpgudang*', 'repackgudangjadi*', 'rejectgudangjadi*', 'lainnyagudangjadi*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('sagudangjadi*', 'fsthpgudang*', 'repackgudangjadi*', 'rejectgudangjadi*', 'lainnyagudangjadi*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Mutasi Produk Jadi</span>
                        </a>
                        @endcan
                        <a href="{{ route('laporangudangjadi.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('laporangudangjadi*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('laporangudangjadi*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Laporan Gudang Jadi</span>
                        </a>
                    </div>
                </div>
                @endcanany

                <!-- Gudang Bahan -->
                @canany(['sagudangbahan.index', 'sahargagb.index', 'opgudangbahan.index', 'barangmasukgb.index', 'barangkeluargb.index', 'laporangudangbahan.index'])
                <div x-data="{ open: {{ Request::is('sagudangbahan*', 'sahargagb*', 'opgudangbahan*', 'barangmasukgudangbahan*', 'barangkeluargudangbahan*', 'laporangudangbahan*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" type="button" class="nav-item flex items-center justify-between w-full px-3.5 py-2 rounded-xl font-medium text-xs transition hover:text-white hover:bg-white/10 cursor-pointer {{ Request::is('sagudangbahan*', 'sahargagb*', 'opgudangbahan*', 'barangmasukgudangbahan*', 'barangkeluargudangbahan*', 'laporangudangbahan*') ? 'bg-white/15 text-white font-bold border border-white/15' : 'text-blue-100/75' }}">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <i data-lucide="boxes" class="w-4 h-4 shrink-0 {{ Request::is('sagudangbahan*', 'sahargagb*', 'opgudangbahan*', 'barangmasukgudangbahan*', 'barangkeluargudangbahan*', 'laporangudangbahan*') ? 'text-white' : 'text-blue-200' }}"></i>
                            <span class="nav-text truncate">Gudang Bahan</span>
                        </div>
                        <i data-lucide="chevron-down" class="chevron-icon w-3.5 h-3.5 text-blue-200/70 transition-transform duration-200 shrink-0" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-transition class="submenu-wrapper mt-1 ml-4 pl-3.5 space-y-1 border-l-2 border-white/20">
                        <a href="{{ route('sagudangbahan.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('sagudangbahan*', 'sahargagb*', 'opgudangbahan*', 'barangmasukgudangbahan*', 'barangkeluargudangbahan*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('sagudangbahan*', 'sahargagb*', 'opgudangbahan*', 'barangmasukgudangbahan*', 'barangkeluargudangbahan*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Mutasi Bahan Baku</span>
                        </a>
                        @canany(['laporangudangbahan.index', 'gb.barangmasuk', 'gb.barangkeluar', 'gb.persediaan', 'gb.rekappersediaan', 'gb.kartugudang'])
                        <a href="{{ route('laporangudangbahan.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('laporangudangbahan*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('laporangudangbahan*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Laporan Gudang Bahan</span>
                        </a>
                        @endcanany
                    </div>
                </div>
                @endcanany

                <!-- Gudang Logistik -->
                @canany(['sagudanglogistik.index', 'opgudanglogistik.index', 'barangmasukgl.index', 'barangkeluargl.index', 'laporangudanglogistik.index'])
                <div x-data="{ open: {{ Request::is('sagudanglogistik*', 'opgudanglogistik*', 'barangmasukgudanglogistik*', 'barangkeluargudanglogistik*', 'laporangudanglogistik*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" type="button" class="nav-item flex items-center justify-between w-full px-3.5 py-2 rounded-xl font-medium text-xs transition hover:text-white hover:bg-white/10 cursor-pointer {{ Request::is('sagudanglogistik*', 'opgudanglogistik*', 'barangmasukgudanglogistik*', 'barangkeluargudanglogistik*', 'laporangudanglogistik*') ? 'bg-white/15 text-white font-bold border border-white/15' : 'text-blue-100/75' }}">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <i data-lucide="truck" class="w-4 h-4 shrink-0 {{ Request::is('sagudanglogistik*', 'opgudanglogistik*', 'barangmasukgudanglogistik*', 'barangkeluargudanglogistik*', 'laporangudanglogistik*') ? 'text-white' : 'text-blue-200' }}"></i>
                            <span class="nav-text truncate">Gudang Logistik</span>
                        </div>
                        <i data-lucide="chevron-down" class="chevron-icon w-3.5 h-3.5 text-blue-200/70 transition-transform duration-200 shrink-0" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-transition class="submenu-wrapper mt-1 ml-4 pl-3.5 space-y-1 border-l-2 border-white/20">
                        <a href="{{ route('barangmasukgudanglogistik.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('sagudanglogistik*', 'opgudanglogistik*', 'barangmasukgudanglogistik*', 'barangkeluargudanglogistik*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('sagudanglogistik*', 'opgudanglogistik*', 'barangmasukgudanglogistik*', 'barangkeluargudanglogistik*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Mutasi Logistik</span>
                        </a>
                        @canany(['laporangudanglogistik.index', 'gl.barangmasuk', 'gl.barangkeluar', 'gl.persediaan', 'gl.rekappersediaan', 'gl.kartugudang'])
                        <a href="{{ route('laporangudanglogistik.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('laporangudanglogistik*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('laporangudanglogistik*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Laporan Logistik</span>
                        </a>
                        @endcanany
                    </div>
                </div>
                @endcanany
            </div>

            <!-- SECTION: KEUANGAN & ACCOUNTING -->
            <div class="pt-3">
                <p class="section-header px-3 text-[10px] font-extrabold tracking-wider text-blue-300/60 uppercase mb-1.5">Keuangan</p>

                <!-- Biaya -->
                <div x-data="{ open: {{ (Request::is('biaya*') || Request::is('laporanbiaya*')) ? 'true' : 'false' }} }">
                    <button @click="open = !open" type="button" class="nav-item flex items-center justify-between w-full px-3.5 py-2 rounded-xl font-medium text-xs transition hover:text-white hover:bg-white/10 cursor-pointer {{ (Request::is('biaya*') || Request::is('laporanbiaya*')) ? 'bg-white/15 text-white font-bold border border-white/15' : 'text-blue-100/75' }}">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <i data-lucide="receipt" class="w-4 h-4 shrink-0 {{ (Request::is('biaya*') || Request::is('laporanbiaya*')) ? 'text-white' : 'text-blue-200' }}"></i>
                            <span class="nav-text truncate">Biaya Operasional</span>
                        </div>
                        <i data-lucide="chevron-down" class="chevron-icon w-3.5 h-3.5 text-blue-200/70 transition-transform duration-200 shrink-0" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-transition class="submenu-wrapper mt-1 ml-4 pl-3.5 space-y-1 border-l-2 border-white/20">
                        <a href="{{ route('biaya.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ (Request::is('biaya*') && !Request::is('laporanbiaya*')) ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ (Request::is('biaya*') && !Request::is('laporanbiaya*')) ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Daftar Biaya</span>
                        </a>
                        <a href="{{ route('laporanbiaya.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('laporanbiaya*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('laporanbiaya*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Laporan Biaya</span>
                        </a>
                    </div>
                </div>

                <!-- Accounting -->
                @canany(['coa.index', 'saldoawalbukubesar.index', 'jurnalumum.index', 'laporanaccounting.index'])
                <div x-data="{ open: {{ (Request::is('coa*', 'saldoawalbukubesar*', 'jurnalumum*', 'laporanaccounting*')) ? 'true' : 'false' }} }">
                    <button @click="open = !open" type="button" class="nav-item flex items-center justify-between w-full px-3.5 py-2 rounded-xl font-medium text-xs transition hover:text-white hover:bg-white/10 cursor-pointer {{ (Request::is('coa*', 'saldoawalbukubesar*', 'jurnalumum*', 'laporanaccounting*')) ? 'bg-white/15 text-white font-bold border border-white/15' : 'text-blue-100/75' }}">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <i data-lucide="book-open" class="w-4 h-4 shrink-0 {{ (Request::is('coa*', 'saldoawalbukubesar*', 'jurnalumum*', 'laporanaccounting*')) ? 'text-white' : 'text-blue-200' }}"></i>
                            <span class="nav-text truncate">Accounting</span>
                        </div>
                        <i data-lucide="chevron-down" class="chevron-icon w-3.5 h-3.5 text-blue-200/70 transition-transform duration-200 shrink-0" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-transition class="submenu-wrapper mt-1 ml-4 pl-3.5 space-y-1 border-l-2 border-white/20">
                        @can('coa.index')
                        <a href="{{ route('coa.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('coa*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('coa*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">COA (Bagan Akun)</span>
                        </a>
                        @endcan
                        @can('saldoawalbukubesar.index')
                        <a href="{{ route('saldoawalbukubesar.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('saldoawalbukubesar*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('saldoawalbukubesar*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Saldo Awal GL</span>
                        </a>
                        @endcan
                        @can('jurnalumum.index')
                        <a href="{{ route('jurnalumum.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('jurnalumum*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('jurnalumum*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Jurnal Umum</span>
                        </a>
                        @endcan
                        @can('laporanaccounting.index')
                        <a href="{{ route('laporanaccounting.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('laporanaccounting*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('laporanaccounting*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Laporan Accounting</span>
                        </a>
                        @endcan
                    </div>
                </div>
                @endcanany
            </div>

            <!-- SECTION: MASTER DATA -->
            @canany(['produk.view', 'produkharga.view', 'pelanggan.view', 'supplier.view', 'angkutan.view', 'tujuanangkutan.view', 'barangpembelian.view', 'barangproduksi.view'])
            <div class="pt-3">
                <p class="section-header px-3 text-[10px] font-extrabold tracking-wider text-blue-300/60 uppercase mb-1.5">Master Data</p>

                <div x-data="{ open: {{ (Request::is('produk*', 'produkharga*', 'pelanggan*', 'supplier*', 'angkutan*', 'tujuanangkutan*', 'barangpembelian*', 'barangproduksi*')) ? 'true' : 'false' }} }">
                    <button @click="open = !open" type="button" class="nav-item flex items-center justify-between w-full px-3.5 py-2 rounded-xl font-medium text-xs transition hover:text-white hover:bg-white/10 cursor-pointer {{ (Request::is('produk*', 'produkharga*', 'pelanggan*', 'supplier*', 'angkutan*', 'tujuanangkutan*', 'barangpembelian*', 'barangproduksi*')) ? 'bg-white/15 text-white font-bold border border-white/15' : 'text-blue-100/75' }}">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <i data-lucide="layers" class="w-4 h-4 shrink-0 {{ (Request::is('produk*', 'produkharga*', 'pelanggan*', 'supplier*', 'angkutan*', 'tujuanangkutan*', 'barangpembelian*', 'barangproduksi*')) ? 'text-white' : 'text-blue-200' }}"></i>
                            <span class="nav-text truncate">Data Master</span>
                        </div>
                        <i data-lucide="chevron-down" class="chevron-icon w-3.5 h-3.5 text-blue-200/70 transition-transform duration-200 shrink-0" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-transition class="submenu-wrapper mt-1 ml-4 pl-3.5 space-y-1 border-l-2 border-white/20">
                        @can('produk.view')
                        <a href="{{ route('produk.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ (Request::is('produk*') && !Request::is('produkharga*')) ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ (Request::is('produk*') && !Request::is('produkharga*')) ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Master Produk</span>
                        </a>
                        @endcan
                        @can('produkharga.view')
                        <a href="{{ route('produkharga.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('produkharga*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('produkharga*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Harga Produk</span>
                        </a>
                        @endcan
                        @can('pelanggan.view')
                        <a href="{{ route('pelanggan.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('pelanggan*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('pelanggan*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Pelanggan</span>
                        </a>
                        @endcan
                        @can('supplier.view')
                        <a href="{{ route('supplier.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('supplier*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('supplier*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Supplier</span>
                        </a>
                        @endcan
                        @can('barangpembelian.view')
                        <a href="{{ route('barangpembelian.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('barangpembelian*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('barangpembelian*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Barang Pembelian</span>
                        </a>
                        @endcan
                        @can('barangproduksi.view')
                        <a href="{{ route('barangproduksi.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('barangproduksi*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('barangproduksi*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Barang Produksi</span>
                        </a>
                        @endcan
                        @can('angkutan.view')
                        <a href="{{ route('angkutan.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('angkutan*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('angkutan*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Angkutan</span>
                        </a>
                        @endcan
                        @can('tujuanangkutan.view')
                        <a href="{{ route('tujuanangkutan.index') }}" class="nav-item flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs {{ Request::is('tujuanangkutan*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-200/75 hover:text-white hover:bg-white/10 font-medium' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ Request::is('tujuanangkutan*') ? 'bg-blue-300 ring-2 ring-blue-300/30' : 'bg-blue-300/40' }}"></span>
                            <span class="truncate">Tujuan Angkutan</span>
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
            @endcanany

            <!-- SECTION: PENGATURAN & USERS -->
            @canany(['users.view', 'roles.view'])
            <div class="pt-3">
                <p class="section-header px-3 text-[10px] font-extrabold tracking-wider text-blue-300/60 uppercase mb-1.5">Pengaturan</p>

                @can('users.view')
                <a href="{{ route('users.index') }}" title="Pengguna" class="nav-item flex items-center gap-3.5 px-3.5 py-2 rounded-xl font-medium text-xs transition {{ Request::is('users*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-100/75 hover:text-white hover:bg-white/10' }}">
                    <i data-lucide="users" class="w-4 h-4 shrink-0 {{ Request::is('users*') ? 'text-white' : 'text-blue-200' }}"></i>
                    <span class="nav-text truncate">Staf & Pengguna</span>
                </a>
                @endcan

                @can('roles.view')
                <a href="{{ route('roles.index') }}" title="Hak Akses" class="nav-item flex items-center gap-3.5 px-3.5 py-2 rounded-xl font-medium text-xs transition {{ Request::is('roles*') ? 'bg-white/20 text-white font-bold border border-white/25 shadow-2xs' : 'text-blue-100/75 hover:text-white hover:bg-white/10' }}">
                    <i data-lucide="shield-check" class="w-4 h-4 shrink-0 {{ Request::is('roles*') ? 'text-white' : 'text-blue-200' }}"></i>
                    <span class="nav-text truncate">Hak Akses & Peran</span>
                </a>
                @endcan
            </div>
            @endcanany
        </div>
    </div>

    <!-- Profile & Account Footer (Corporate Navy Theme) -->
    <div class="pt-4 border-t border-white/15">
        <div class="user-profile-box p-2.5 rounded-2xl bg-white/10 border border-white/15 hover:bg-white/15 transition-all flex items-center justify-between gap-2.5">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="relative shrink-0">
                    <div class="w-8 h-8 rounded-xl bg-white/20 border border-white/25 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                        {{ strtoupper(substr(Auth::user()->name ?? 'User', 0, 1)) }}
                    </div>
                    <span class="w-2 h-2 rounded-full bg-emerald-400 ring-2 ring-[#162a5b] absolute -bottom-0.5 -right-0.5"></span>
                </div>
                <div class="sidebar-profile-text min-w-0">
                    <div class="font-bold text-xs text-white truncate leading-tight">
                        {{ Auth::user()->name ?? 'User' }}
                    </div>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="inline-block px-1.5 py-0.2 rounded-md text-[9px] font-extrabold uppercase tracking-wider bg-white/15 text-blue-100 border border-white/20 truncate max-w-[100px]">
                            {{ ucfirst(str_replace('_', ' ', Auth::user()->roles->first()->name ?? 'User')) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" class="inline shrink-0">
                @csrf
                <button type="submit" title="Keluar / Logout" class="sidebar-profile-text w-7 h-7 rounded-lg flex items-center justify-center text-blue-200 hover:text-white hover:bg-rose-500/30 border border-transparent hover:border-rose-400/40 transition cursor-pointer">
                    <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
