<!-- Spotlight / Command Palette Modal (macOS Style Navigation) -->
<div id="commandPaletteBackdrop" class="fixed inset-0 z-[99999] bg-slate-950/60 backdrop-blur-md hidden transition-opacity duration-200 flex items-start justify-center pt-14 sm:pt-20 px-4 sm:px-6">
    
    <!-- Command Palette Container -->
    <div id="commandPaletteContainer" class="w-full max-w-2xl bg-white/95 dark:bg-slate-900/95 backdrop-blur-2xl rounded-2xl shadow-2xl border border-slate-200/90 dark:border-slate-800 overflow-hidden ring-1 ring-black/5 flex flex-col max-h-[82vh] sm:max-h-[78vh] transition-all">
        
        <!-- Search Input Header -->
        <div class="px-5 py-4 border-b border-slate-200/70 dark:border-slate-800 flex items-center gap-3.5 bg-slate-50/70 dark:bg-slate-800/40">
            <div class="w-9 h-9 rounded-xl bg-pacific-500/10 dark:bg-pacific-500/20 text-pacific-600 dark:text-pacific-400 flex items-center justify-center shrink-0">
                <i data-lucide="search" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
            </div>
            
            <input 
                type="text" 
                id="commandPaletteInput" 
                placeholder="Ketik nama menu, laporan, atau aksi cepat..." 
                autocomplete="off"
                spellcheck="false"
                class="flex-1 bg-transparent border-0 text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 text-sm sm:text-base font-semibold focus:outline-none focus:ring-0 p-0"
            >
            
            <div class="flex items-center gap-2">
                <button type="button" id="commandPaletteClearBtn" class="hidden text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1.5 rounded-lg hover:bg-slate-200/50 dark:hover:bg-slate-700/50 transition">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
                <kbd class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-400 dark:text-slate-500 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 px-2 py-1 rounded-lg shadow-2xs">
                    ESC
                </kbd>
            </div>
        </div>

        <!-- Filter Category Pills -->
        <div class="px-4 sm:px-5 py-2.5 bg-slate-100/40 dark:bg-slate-900/60 border-b border-slate-200/60 dark:border-slate-800 flex items-center gap-1.5 overflow-x-auto [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
            <button type="button" data-palette-filter="all" class="palette-filter-chip active px-3 py-1 rounded-full text-xs font-bold bg-blue-600 text-white shadow-2xs transition-all shrink-0 cursor-pointer">
                Semua
            </button>
            <button type="button" data-palette-filter="marketing" class="palette-filter-chip px-3 py-1 rounded-full text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-200/70 dark:hover:bg-slate-800 transition-all shrink-0 cursor-pointer">
                Marketing & Penjualan
            </button>
            <button type="button" data-palette-filter="pembelian" class="palette-filter-chip px-3 py-1 rounded-full text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-200/70 dark:hover:bg-slate-800 transition-all shrink-0 cursor-pointer">
                Pembelian
            </button>
            <button type="button" data-palette-filter="gudang" class="palette-filter-chip px-3 py-1 rounded-full text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-200/70 dark:hover:bg-slate-800 transition-all shrink-0 cursor-pointer">
                Gudang & Produksi
            </button>
            <button type="button" data-palette-filter="finance" class="palette-filter-chip px-3 py-1 rounded-full text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-200/70 dark:hover:bg-slate-800 transition-all shrink-0 cursor-pointer">
                Biaya & Accounting
            </button>
            <button type="button" data-palette-filter="master" class="palette-filter-chip px-3 py-1 rounded-full text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-200/70 dark:hover:bg-slate-800 transition-all shrink-0 cursor-pointer">
                Master Data
            </button>
        </div>

        <!-- Results List Area -->
        <div id="commandPaletteResults" class="p-3 sm:p-4 overflow-y-auto space-y-4 flex-1 [scrollbar-width:thin]">
            
            <!-- GROUP: Aksi Cepat / Quick Actions -->
            <div class="palette-group space-y-1" data-group="quick">
                <div class="px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 dark:text-slate-500 flex items-center justify-between">
                    <span>⚡ Aksi Cepat & Navigasi Utama</span>
                </div>
                
                <a href="{{ route('dashboard') }}" data-category="quick" data-keywords="dashboard beranda home ringkasan statistik" class="palette-item group flex items-center justify-between px-3 py-2.5 rounded-xl border border-transparent hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-all cursor-pointer">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="item-icon-box w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 transition-colors">
                            <i data-lucide="layout-grid" class="w-4 h-4"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="item-title font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-100 truncate">Dashboard Utama</div>
                            <div class="item-desc text-[11px] text-slate-400 dark:text-slate-500 truncate">Ringkasan statistik operasional Portal MP</div>
                        </div>
                    </div>
                    <div class="item-action-badge flex items-center gap-1.5 shrink-0 ml-2">
                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">Home</span>
                        <i data-lucide="corner-down-left" class="w-3.5 h-3.5 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </a>

                @can('penjualanmarketing.view')
                <a href="{{ route('penjualanmarketing.index') }}" data-category="marketing" data-keywords="penjualan marketing jual sales order faktur pelanggan invoice piutang" class="palette-item group flex items-center justify-between px-3 py-2.5 rounded-xl border border-transparent hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-all cursor-pointer">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="item-icon-box w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 transition-colors">
                            <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="item-title font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-100 truncate">Penjualan Marketing</div>
                            <div class="item-desc text-[11px] text-slate-400 dark:text-slate-500 truncate">Daftar transaksi penjualan, invoice & kartu piutang</div>
                        </div>
                    </div>
                    <div class="item-action-badge flex items-center gap-1.5 shrink-0 ml-2">
                        <span class="text-[10px] font-semibold text-slate-400">Marketing</span>
                        <i data-lucide="corner-down-left" class="w-3.5 h-3.5 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </a>
                @endcan

                @can('pembelian.index')
                <a href="{{ route('pembelian.index') }}" data-category="pembelian" data-keywords="pembelian beli po order pemasok supplier kontrabon hutang ap" class="palette-item group flex items-center justify-between px-3 py-2.5 rounded-xl border border-transparent hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-all cursor-pointer">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="item-icon-box w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0 transition-colors">
                            <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="item-title font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-100 truncate">Pembelian & Pengadaan</div>
                            <div class="item-desc text-[11px] text-slate-400 dark:text-slate-500 truncate">Transaksi pembelian bahan, barang, & kontrabon supplier</div>
                        </div>
                    </div>
                    <div class="item-action-badge flex items-center gap-1.5 shrink-0 ml-2">
                        <span class="text-[10px] font-semibold text-slate-400">Pembelian</span>
                        <i data-lucide="corner-down-left" class="w-3.5 h-3.5 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </a>
                @endcan
            </div>

            <!-- GROUP: Gudang & Produksi -->
            <div class="palette-group space-y-1" data-group="gudang">
                <div class="px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 dark:text-slate-500 flex items-center justify-between">
                    <span>📦 Produksi & Pergudangan</span>
                </div>

                @can('samutasiproduksi.view')
                <a href="{{ route('samutasiproduksi.index') }}" data-category="gudang" data-keywords="produksi mutasi bpbj fsthp proses pabrik hasil barang jadi" class="palette-item group flex items-center justify-between px-3 py-2.5 rounded-xl border border-transparent hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-all cursor-pointer">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="item-icon-box w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0 transition-colors">
                            <i data-lucide="factory" class="w-4 h-4"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="item-title font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-100 truncate">Mutasi Produksi (BPBJ / FSTHP)</div>
                            <div class="item-desc text-[11px] text-slate-400 dark:text-slate-500 truncate">Pencatatan produksi, mutasi barang produksi & serah terima</div>
                        </div>
                    </div>
                    <div class="item-action-badge flex items-center gap-1.5 shrink-0 ml-2">
                        <span class="text-[10px] font-semibold text-slate-400">Produksi</span>
                        <i data-lucide="corner-down-left" class="w-3.5 h-3.5 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </a>
                @endcan

                @can('sagudangjadi.view')
                <a href="{{ route('sagudangjadi.index') }}" data-category="gudang" data-keywords="gudang jadi mutasi repack reject hasil finish goods stock" class="palette-item group flex items-center justify-between px-3 py-2.5 rounded-xl border border-transparent hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-all cursor-pointer">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="item-icon-box w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 transition-colors">
                            <i data-lucide="warehouse" class="w-4 h-4"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="item-title font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-100 truncate">Gudang Jadi</div>
                            <div class="item-desc text-[11px] text-slate-400 dark:text-slate-500 truncate">Mutasi produk jadi, repack, reject & penyesuaian</div>
                        </div>
                    </div>
                    <div class="item-action-badge flex items-center gap-1.5 shrink-0 ml-2">
                        <span class="text-[10px] font-semibold text-slate-400">Gudang Jadi</span>
                        <i data-lucide="corner-down-left" class="w-3.5 h-3.5 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </a>
                @endcan

                @canany(['sagudangbahan.index', 'sahargagb.index'])
                <a href="{{ route('sagudangbahan.index') }}" data-category="gudang" data-keywords="gudang bahan baku mentah raw material masuk keluar opname" class="palette-item group flex items-center justify-between px-3 py-2.5 rounded-xl border border-transparent hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-all cursor-pointer">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="item-icon-box w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0 transition-colors">
                            <i data-lucide="boxes" class="w-4 h-4"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="item-title font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-100 truncate">Gudang Bahan Baku</div>
                            <div class="item-desc text-[11px] text-slate-400 dark:text-slate-500 truncate">Penerimaan & pengeluaran bahan mentah pabrik</div>
                        </div>
                    </div>
                    <div class="item-action-badge flex items-center gap-1.5 shrink-0 ml-2">
                        <span class="text-[10px] font-semibold text-slate-400">Gudang Bahan</span>
                        <i data-lucide="corner-down-left" class="w-3.5 h-3.5 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </a>
                @endcanany

                @canany(['sagudanglogistik.index', 'barangmasukgl.index'])
                <a href="{{ route('barangmasukgudanglogistik.index') }}" data-category="gudang" data-keywords="gudang logistik barang umum perlengkapan operasional" class="palette-item group flex items-center justify-between px-3 py-2.5 rounded-xl border border-transparent hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-all cursor-pointer">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="item-icon-box w-8 h-8 rounded-lg bg-cyan-50 dark:bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 flex items-center justify-center shrink-0 transition-colors">
                            <i data-lucide="truck" class="w-4 h-4"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="item-title font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-100 truncate">Gudang Logistik</div>
                            <div class="item-desc text-[11px] text-slate-400 dark:text-slate-500 truncate">Barang operasional masuk & keluar logistik</div>
                        </div>
                    </div>
                    <div class="item-action-badge flex items-center gap-1.5 shrink-0 ml-2">
                        <span class="text-[10px] font-semibold text-slate-400">Logistik</span>
                        <i data-lucide="corner-down-left" class="w-3.5 h-3.5 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </a>
                @endcanany
            </div>

            <!-- GROUP: Biaya & Accounting -->
            <div class="palette-group space-y-1" data-group="finance">
                <div class="px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 dark:text-slate-500 flex items-center justify-between">
                    <span>💳 Biaya & Accounting</span>
                </div>

                <a href="{{ route('biaya.index') }}" data-category="finance" data-keywords="biaya operasional pengeluaran kas bon petty cash beban" class="palette-item group flex items-center justify-between px-3 py-2.5 rounded-xl border border-transparent hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-all cursor-pointer">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="item-icon-box w-8 h-8 rounded-lg bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0 transition-colors">
                            <i data-lucide="receipt" class="w-4 h-4"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="item-title font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-100 truncate">Biaya Operasional</div>
                            <div class="item-desc text-[11px] text-slate-400 dark:text-slate-500 truncate">Pencatatan pengeluaran biaya dan histori pembayaran</div>
                        </div>
                    </div>
                    <div class="item-action-badge flex items-center gap-1.5 shrink-0 ml-2">
                        <span class="text-[10px] font-semibold text-slate-400">Biaya</span>
                        <i data-lucide="corner-down-left" class="w-3.5 h-3.5 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </a>

                @can('jurnalumum.index')
                <a href="{{ route('jurnalumum.index') }}" data-category="finance" data-keywords="jurnal umum accounting akuntansi debit kredit coa buku besar" class="palette-item group flex items-center justify-between px-3 py-2.5 rounded-xl border border-transparent hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-all cursor-pointer">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="item-icon-box w-8 h-8 rounded-lg bg-teal-50 dark:bg-teal-500/10 text-teal-600 dark:text-teal-400 flex items-center justify-center shrink-0 transition-colors">
                            <i data-lucide="book-open" class="w-4 h-4"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="item-title font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-100 truncate">Jurnal Umum & Accounting</div>
                            <div class="item-desc text-[11px] text-slate-400 dark:text-slate-500 truncate">Entri transaksi jurnal akuntansi debit & kredit</div>
                        </div>
                    </div>
                    <div class="item-action-badge flex items-center gap-1.5 shrink-0 ml-2">
                        <span class="text-[10px] font-semibold text-slate-400">Accounting</span>
                        <i data-lucide="corner-down-left" class="w-3.5 h-3.5 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </a>
                @endcan

                @can('coa.index')
                <a href="{{ route('coa.index') }}" data-category="finance" data-keywords="coa chart of accounts bagan akun kode rekening" class="palette-item group flex items-center justify-between px-3 py-2.5 rounded-xl border border-transparent hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-all cursor-pointer">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="item-icon-box w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center shrink-0 transition-colors">
                            <i data-lucide="layers" class="w-4 h-4"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="item-title font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-100 truncate">Bagan Akun (COA)</div>
                            <div class="item-desc text-[11px] text-slate-400 dark:text-slate-500 truncate">Master kode akun akuntansi & hierarki keuangan</div>
                        </div>
                    </div>
                    <div class="item-action-badge flex items-center gap-1.5 shrink-0 ml-2">
                        <span class="text-[10px] font-semibold text-slate-400">COA</span>
                        <i data-lucide="corner-down-left" class="w-3.5 h-3.5 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </a>
                @endcan
            </div>

            <!-- GROUP: Master Data -->
            <div class="palette-group space-y-1" data-group="master">
                <div class="px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 dark:text-slate-500 flex items-center justify-between">
                    <span>🗂️ Data Master & Pengaturan</span>
                </div>

                @can('produk.view')
                <a href="{{ route('produk.index') }}" data-category="master" data-keywords="produk master barang sku barang jadi harga produk" class="palette-item group flex items-center justify-between px-3 py-2.5 rounded-xl border border-transparent hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-all cursor-pointer">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="item-icon-box w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 transition-colors">
                            <i data-lucide="package" class="w-4 h-4"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="item-title font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-100 truncate">Master Produk</div>
                            <div class="item-desc text-[11px] text-slate-400 dark:text-slate-500 truncate">Data produk, jenis, kategori & satuan</div>
                        </div>
                    </div>
                    <div class="item-action-badge flex items-center gap-1.5 shrink-0 ml-2">
                        <span class="text-[10px] font-semibold text-slate-400">Master</span>
                        <i data-lucide="corner-down-left" class="w-3.5 h-3.5 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </a>
                @endcan

                @can('pelanggan.view')
                <a href="{{ route('pelanggan.index') }}" data-category="master" data-keywords="pelanggan customer klien toko agen distributor pembeli" class="palette-item group flex items-center justify-between px-3 py-2.5 rounded-xl border border-transparent hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-all cursor-pointer">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="item-icon-box w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 transition-colors">
                            <i data-lucide="user-check" class="w-4 h-4"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="item-title font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-100 truncate">Pelanggan (Customer)</div>
                            <div class="item-desc text-[11px] text-slate-400 dark:text-slate-500 truncate">Data pelanggan, limit kredit, kontak & alamat</div>
                        </div>
                    </div>
                    <div class="item-action-badge flex items-center gap-1.5 shrink-0 ml-2">
                        <span class="text-[10px] font-semibold text-slate-400">Master</span>
                        <i data-lucide="corner-down-left" class="w-3.5 h-3.5 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </a>
                @endcan

                @can('supplier.view')
                <a href="{{ route('supplier.index') }}" data-category="master" data-keywords="supplier pemasok vendor penyedia distributor" class="palette-item group flex items-center justify-between px-3 py-2.5 rounded-xl border border-transparent hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-all cursor-pointer">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="item-icon-box w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0 transition-colors">
                            <i data-lucide="truck" class="w-4 h-4"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="item-title font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-100 truncate">Supplier & Vendor</div>
                            <div class="item-desc text-[11px] text-slate-400 dark:text-slate-500 truncate">Data rekanan pemasok dan kontak supplier</div>
                        </div>
                    </div>
                    <div class="item-action-badge flex items-center gap-1.5 shrink-0 ml-2">
                        <span class="text-[10px] font-semibold text-slate-400">Master</span>
                        <i data-lucide="corner-down-left" class="w-3.5 h-3.5 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </a>
                @endcan

                @can('users.view')
                <a href="{{ route('users.index') }}" data-category="master" data-keywords="users user pengguna staf karyawan login akun" class="palette-item group flex items-center justify-between px-3 py-2.5 rounded-xl border border-transparent hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-all cursor-pointer">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="item-icon-box w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0 transition-colors">
                            <i data-lucide="users" class="w-4 h-4"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="item-title font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-100 truncate">Manajemen Pengguna</div>
                            <div class="item-desc text-[11px] text-slate-400 dark:text-slate-500 truncate">Kelola staf, hak akses login & akun</div>
                        </div>
                    </div>
                    <div class="item-action-badge flex items-center gap-1.5 shrink-0 ml-2">
                        <span class="text-[10px] font-semibold text-slate-400">Sistem</span>
                        <i data-lucide="corner-down-left" class="w-3.5 h-3.5 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </a>
                @endcan

                @can('roles.view')
                <a href="{{ route('roles.index') }}" data-category="master" data-keywords="roles role hak akses izin permission otorisasi" class="palette-item group flex items-center justify-between px-3 py-2.5 rounded-xl border border-transparent hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-all cursor-pointer">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="item-icon-box w-8 h-8 rounded-lg bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0 transition-colors">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="item-title font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-100 truncate">Peran & Hak Akses (Roles)</div>
                            <div class="item-desc text-[11px] text-slate-400 dark:text-slate-500 truncate">Matriks izin hak akses pengguna</div>
                        </div>
                    </div>
                    <div class="item-action-badge flex items-center gap-1.5 shrink-0 ml-2">
                        <span class="text-[10px] font-semibold text-slate-400">Sistem</span>
                        <i data-lucide="corner-down-left" class="w-3.5 h-3.5 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </a>
                @endcan
            </div>

            <!-- Empty State -->
            <div id="commandPaletteEmpty" class="hidden py-12 text-center">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-3 text-slate-400">
                    <i data-lucide="search-x" class="w-6 h-6"></i>
                </div>
                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Tidak ada menu ditemukan</h4>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Coba gunakan kata kunci lain (misal: "marketing", "gudang", "pembelian").</p>
            </div>

        </div>

        <!-- Footer / Keyboard Shortcuts Guide -->
        <div class="px-5 py-3 bg-slate-50 dark:bg-slate-900 border-t border-slate-200/70 dark:border-slate-800 flex items-center justify-between text-[11px] text-slate-400 dark:text-slate-500 select-none">
            <div class="flex items-center gap-3">
                <span class="flex items-center gap-1">
                    <kbd class="px-1.5 py-0.5 rounded bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-[10px] font-bold">↑</kbd>
                    <kbd class="px-1.5 py-0.5 rounded bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-[10px] font-bold">↓</kbd>
                    <span class="hidden sm:inline">Navigasi</span>
                </span>
                <span class="flex items-center gap-1">
                    <kbd class="px-1.5 py-0.5 rounded bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-[10px] font-bold">↵</kbd>
                    <span class="hidden sm:inline">Pilih</span>
                </span>
                <span class="flex items-center gap-1">
                    <kbd class="px-1.5 py-0.5 rounded bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-[10px] font-bold">ESC</kbd>
                    <span class="hidden sm:inline">Tutup</span>
                </span>
            </div>
            <div class="font-bold text-[10px] text-slate-500 dark:text-slate-400 flex items-center gap-1">
                <span>Portal MP</span>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const backdrop = document.getElementById('commandPaletteBackdrop');
        const container = document.getElementById('commandPaletteContainer');
        const input = document.getElementById('commandPaletteInput');
        const clearBtn = document.getElementById('commandPaletteClearBtn');
        const items = document.querySelectorAll('.palette-item');
        const groups = document.querySelectorAll('.palette-group');
        const emptyState = document.getElementById('commandPaletteEmpty');
        const filterChips = document.querySelectorAll('.palette-filter-chip');
        const navSearchTrigger = document.getElementById('navSearchTrigger');
        const navSearchMobileTrigger = document.getElementById('navSearchMobileTrigger');

        let activeIndex = -1;
        let currentFilter = 'all';

        function openPalette() {
            if (!backdrop) return;
            backdrop.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                if (input) input.focus();
            }, 50);
            filterItems();
        }

        function closePalette() {
            if (!backdrop) return;
            backdrop.classList.add('hidden');
            document.body.style.overflow = '';
            if (input) {
                input.value = '';
                if (clearBtn) clearBtn.classList.add('hidden');
            }
            activeIndex = -1;
            filterItems();
        }

        if (navSearchTrigger) navSearchTrigger.addEventListener('click', openPalette);
        if (navSearchMobileTrigger) navSearchMobileTrigger.addEventListener('click', openPalette);

        if (backdrop) {
            backdrop.addEventListener('click', function (e) {
                if (e.target === backdrop) closePalette();
            });
        }

        document.addEventListener('keydown', function (e) {
            if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                if (backdrop && backdrop.classList.contains('hidden')) {
                    openPalette();
                } else {
                    closePalette();
                }
            }
            if (e.key === 'Escape' && backdrop && !backdrop.classList.contains('hidden')) {
                closePalette();
            }
        });

        if (clearBtn && input) {
            clearBtn.addEventListener('click', function () {
                input.value = '';
                clearBtn.classList.add('hidden');
                input.focus();
                filterItems();
            });
        }

        filterChips.forEach(chip => {
            chip.addEventListener('click', function () {
                filterChips.forEach(c => {
                    c.classList.remove('active', 'bg-blue-600', 'text-white', 'shadow-2xs');
                    c.classList.add('text-slate-600', 'dark:text-slate-400');
                });
                this.classList.add('active', 'bg-blue-600', 'text-white', 'shadow-2xs');
                this.classList.remove('text-slate-600', 'dark:text-slate-400');
                currentFilter = this.getAttribute('data-palette-filter') || 'all';
                filterItems();
            });
        });

        if (input) {
            input.addEventListener('input', function () {
                if (clearBtn) {
                    clearBtn.classList.toggle('hidden', this.value.trim() === '');
                }
                filterItems();
            });

            input.addEventListener('keydown', function (e) {
                const visibleItems = Array.from(items).filter(el => !el.classList.contains('hidden'));
                if (visibleItems.length === 0) return;

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    activeIndex = (activeIndex + 1) % visibleItems.length;
                    highlightItem(visibleItems, activeIndex);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    activeIndex = (activeIndex - 1 + visibleItems.length) % visibleItems.length;
                    highlightItem(visibleItems, activeIndex);
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (activeIndex >= 0 && activeIndex < visibleItems.length) {
                        visibleItems[activeIndex].click();
                    } else if (visibleItems.length > 0) {
                        visibleItems[0].click();
                    }
                }
            });
        }

        function highlightItem(visibleItems, index) {
            visibleItems.forEach((el, idx) => {
                if (idx === index) {
                    el.classList.add('bg-blue-50', 'dark:bg-blue-500/10', 'border-blue-200/60', 'dark:border-blue-500/20');
                    el.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                } else {
                    el.classList.remove('bg-blue-50', 'dark:bg-blue-500/10', 'border-blue-200/60', 'dark:border-blue-500/20');
                }
            });
        }

        function filterItems() {
            const query = (input ? input.value : '').toLowerCase().trim();
            let totalVisible = 0;

            items.forEach(item => {
                const title = item.querySelector('.item-title')?.textContent?.toLowerCase() || '';
                const desc = item.querySelector('.item-desc')?.textContent?.toLowerCase() || '';
                const keywords = item.getAttribute('data-keywords')?.toLowerCase() || '';
                const cat = item.getAttribute('data-category') || 'all';

                const matchesQuery = query === '' || title.includes(query) || desc.includes(query) || keywords.includes(query);
                const matchesCategory = currentFilter === 'all' || cat === currentFilter;

                if (matchesQuery && matchesCategory) {
                    item.classList.remove('hidden');
                    totalVisible++;
                } else {
                    item.classList.add('hidden');
                }
            });

            groups.forEach(group => {
                const hasVisible = Array.from(group.querySelectorAll('.palette-item')).some(i => !i.classList.contains('hidden'));
                group.classList.toggle('hidden', !hasVisible);
            });

            if (emptyState) {
                emptyState.classList.toggle('hidden', totalVisible > 0);
            }
        }
    });
</script>
