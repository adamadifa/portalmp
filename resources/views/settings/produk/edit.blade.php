<form action="{{ route('produk.update', Crypt::encrypt($produk->kode_produk)) }}" method="POST" id="formEditProduk" class="space-y-3.5" novalidate>
    @csrf
    @method('PUT')

    <!-- SECTION 1: INFORMASI UTAMA PRODUK -->
    <div class="space-y-3">
        <!-- Row 1: Kode & Nama Produk -->
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-4">
                <label class="flex items-center justify-between text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1">
                    <span>Kode Produk</span>
                    <span class="text-[10px] text-slate-400 font-normal">Terkunci</span>
                </label>
                <input 
                    type="text" 
                    value="{{ $produk->kode_produk }}" 
                    disabled 
                    class="block w-full px-3 py-2 text-xs font-mono font-semibold text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg focus:outline-none cursor-not-allowed shadow-2xs"
                >
            </div>
            <div class="sm:col-span-8">
                <label for="nama_produk" class="flex items-center justify-between text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    <span>Nama Produk <span class="text-rose-500">*</span></span>
                    <span class="text-[10px] text-slate-400 font-normal">Maks 30 karakter</span>
                </label>
                <input 
                    type="text" 
                    id="nama_produk" 
                    name="nama_produk" 
                    value="{{ $produk->nama_produk }}" 
                    required 
                    maxlength="30" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: Pacific Gold 500ml"
                >
            </div>
        </div>

        <!-- Row 2: Kategori & Jenis Produk -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label for="kode_kategori_produk" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Kategori Produk <span class="text-rose-500">*</span>
                </label>
                <select 
                    id="kode_kategori_produk" 
                    name="kode_kategori_produk" 
                    required 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition cursor-pointer shadow-2xs"
                >
                    <option value="">Pilih kategori...</option>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->kode_kategori_produk }}" {{ $produk->kode_kategori_produk == $kat->kode_kategori_produk ? 'selected' : '' }}>
                            {{ $kat->nama_kategori_produk }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="kode_jenis_produk" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Jenis Produk <span class="text-rose-500">*</span>
                </label>
                <select 
                    id="kode_jenis_produk" 
                    name="kode_jenis_produk" 
                    required 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition cursor-pointer shadow-2xs"
                >
                    <option value="">Pilih jenis...</option>
                    @foreach($jenis as $jen)
                        <option value="{{ $jen->kode_jenis_produk }}" {{ $produk->kode_jenis_produk == $jen->kode_jenis_produk ? 'selected' : '' }}>
                            {{ $jen->nama_jenis_produk }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Row 3: Satuan Utama, Urutan & Status Produk -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label for="satuan" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Satuan Utama <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="satuan" 
                    name="satuan" 
                    value="{{ $produk->satuan }}" 
                    required 
                    maxlength="4" 
                    class="block w-full px-3 py-2 text-xs font-semibold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: Dus"
                >
            </div>
            <div>
                <label for="urutan" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Urutan Tampilan
                </label>
                <input 
                    type="number" 
                    id="urutan" 
                    name="urutan" 
                    value="{{ $produk->urutan }}" 
                    min="0" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: 1"
                >
            </div>
            <div>
                <label for="status_aktif_produk" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Status Produk <span class="text-rose-500">*</span>
                </label>
                <select 
                    id="status_aktif_produk" 
                    name="status_aktif_produk" 
                    required 
                    class="block w-full px-3 py-2 text-xs font-semibold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition cursor-pointer shadow-2xs"
                >
                    <option value="1" {{ $produk->status_aktif_produk == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $produk->status_aktif_produk == '0' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>
        </div>
    </div>

    <!-- SECTION 2: KONFIGURASI ISI KEMASAN -->
    <div class="rounded-lg border border-slate-200 dark:border-slate-700/80 p-3 space-y-2.5">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-1.5">
                <i data-lucide="package" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400"></i>
                <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Konfigurasi Isi Kemasan</span>
            </div>
            <span class="text-[11px] text-slate-400">Rasio kemasan produk</span>
        </div>

        <div class="grid grid-cols-3 gap-2.5">
            <!-- Isi Pcs / Dus -->
            <div>
                <label for="isi_pcs_dus" class="block text-[11px] font-medium text-slate-600 dark:text-slate-400 mb-1">
                    Pcs per Dus <span class="text-rose-500">*</span>
                </label>
                <div class="relative flex items-center">
                    <input 
                        type="number" 
                        id="isi_pcs_dus" 
                        name="isi_pcs_dus" 
                        value="{{ $produk->isi_pcs_dus }}" 
                        min="0" 
                        required 
                        class="block w-full pr-9 pl-2.5 py-1.5 text-xs font-semibold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs"
                    >
                    <span class="absolute right-2.5 text-[11px] text-slate-400 pointer-events-none">pcs</span>
                </div>
            </div>

            <!-- Isi Pack / Dus -->
            <div>
                <label for="isi_pack_dus" class="block text-[11px] font-medium text-slate-600 dark:text-slate-400 mb-1">
                    Pack per Dus <span class="text-rose-500">*</span>
                </label>
                <div class="relative flex items-center">
                    <input 
                        type="number" 
                        id="isi_pack_dus" 
                        name="isi_pack_dus" 
                        value="{{ $produk->isi_pack_dus }}" 
                        min="0" 
                        required 
                        class="block w-full pr-11 pl-2.5 py-1.5 text-xs font-semibold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs"
                    >
                    <span class="absolute right-2.5 text-[11px] text-slate-400 pointer-events-none">pack</span>
                </div>
            </div>

            <!-- Isi Pcs / Pack -->
            <div>
                <label for="isi_pcs_pack" class="block text-[11px] font-medium text-slate-600 dark:text-slate-400 mb-1">
                    Pcs per Pack <span class="text-rose-500">*</span>
                </label>
                <div class="relative flex items-center">
                    <input 
                        type="number" 
                        id="isi_pcs_pack" 
                        name="isi_pcs_pack" 
                        value="{{ $produk->isi_pcs_pack }}" 
                        min="0" 
                        required 
                        class="block w-full pr-9 pl-2.5 py-1.5 text-xs font-semibold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs"
                    >
                    <span class="absolute right-2.5 text-[11px] text-slate-400 pointer-events-none">pcs</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
        <button 
            type="button" 
            onclick="closeModal('modalEdit')" 
            class="px-3.5 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg transition cursor-pointer flex items-center gap-1.5"
        >
            <i data-lucide="x" class="w-3.5 h-3.5"></i>
            <span>Batal</span>
        </button>
        <button 
            type="submit" 
            class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-[#162a5b] hover:bg-[#1f3a7a] rounded-lg transition shadow-xs cursor-pointer"
        >
            <i data-lucide="check" class="w-3.5 h-3.5"></i>
            <span>Perbarui Produk</span>
        </button>
    </div>
</form>
