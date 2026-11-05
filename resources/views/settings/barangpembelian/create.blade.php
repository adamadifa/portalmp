<form action="{{ route('barangpembelian.store') }}" method="POST" id="formCreateBarang" class="space-y-4" novalidate>
    @csrf

    <!-- SECTION 1: INFORMASI UTAMA BARANG -->
    <div class="space-y-3">
        <div class="flex items-center gap-2 pb-1 border-b border-slate-100 dark:border-slate-800">
            <span class="w-2 h-2 rounded-full bg-blue-600"></span>
            <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200">Informasi Utama Barang</h4>
        </div>

        <!-- Row 1: Kode Barang & Nama Barang -->
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-4">
                <label for="kode_barang" class="flex items-center justify-between text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    <span>Kode Barang <span class="text-rose-500">*</span></span>
                    <span class="text-[10px] text-slate-400 font-normal">Maks 7 karakter</span>
                </label>
                <input 
                    type="text" 
                    id="kode_barang" 
                    name="kode_barang" 
                    required 
                    maxlength="7" 
                    class="block w-full px-3 py-2 text-xs font-mono font-semibold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: BR001"
                >
            </div>

            <div class="sm:col-span-8">
                <label for="nama_barang" class="flex items-center justify-between text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    <span>Nama Barang <span class="text-rose-500">*</span></span>
                    <span class="text-[10px] text-slate-400 font-normal">Maks 100 karakter</span>
                </label>
                <input 
                    type="text" 
                    id="nama_barang" 
                    name="nama_barang" 
                    required 
                    maxlength="100" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: Plastik Seal 12x20cm"
                >
            </div>
        </div>

        <!-- Row 2: Satuan & Status -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label for="satuan" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Satuan Barang <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="satuan" 
                    name="satuan" 
                    required 
                    maxlength="20" 
                    class="block w-full px-3 py-2 text-xs font-semibold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: Pcs / Kg / Roll"
                >
            </div>

            <div>
                <label for="status" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Status Barang <span class="text-rose-500">*</span>
                </label>
                <select 
                    id="status" 
                    name="status" 
                    required 
                    class="block w-full px-3 py-2 text-xs font-semibold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition cursor-pointer shadow-2xs"
                >
                    <option value="1">Aktif</option>
                    <option value="0">Non-Aktif</option>
                </select>
            </div>
        </div>
    </div>

    <!-- SECTION 2: KLASIFIKASI & DEPARTEMEN -->
    <div class="space-y-3 pt-2">
        <div class="flex items-center gap-2 pb-1 border-b border-slate-100 dark:border-slate-800">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200">Klasifikasi & Departemen</h4>
        </div>

        <!-- Row 3: Jenis Barang, Kategori & Group -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label for="kode_jenis_barang" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Jenis Barang <span class="text-rose-500">*</span>
                </label>
                <select 
                    id="kode_jenis_barang" 
                    name="kode_jenis_barang" 
                    required 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition cursor-pointer shadow-2xs"
                >
                    <option value="">Pilih Jenis...</option>
                    @foreach ($list_jenis_barang as $d)
                        <option value="{{ $d['kode_jenis_barang'] }}">{{ $d['nama_jenis_barang'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="kode_kategori" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Kategori <span class="text-rose-500">*</span>
                </label>
                <select 
                    id="kode_kategori" 
                    name="kode_kategori" 
                    required 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition cursor-pointer shadow-2xs"
                >
                    <option value="">Pilih Kategori...</option>
                    @foreach ($kategori as $kat)
                        <option value="{{ $kat->kode_kategori }}">{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="kode_group" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Group Departemen <span class="text-rose-500">*</span>
                </label>
                <select 
                    id="kode_group" 
                    name="kode_group" 
                    required 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition cursor-pointer shadow-2xs"
                >
                    <option value="">Pilih Group...</option>
                    @foreach ($list_group as $g)
                        <option value="{{ $g['kode_group'] }}">{{ $g['nama_group'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Form Footer Actions -->
    <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100 dark:border-slate-800">
        <button 
            type="button" 
            onclick="closeModal('modalCreate')" 
            class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition cursor-pointer"
        >
            Batal
        </button>
        <button 
            type="submit" 
            class="inline-flex items-center gap-1.5 px-5 py-2 text-xs font-bold text-white bg-[#162a5b] hover:bg-[#1c3574] rounded-lg transition shadow-xs cursor-pointer"
        >
            <i data-lucide="check" class="w-3.5 h-3.5"></i>
            <span>Simpan Barang</span>
        </button>
    </div>
</form>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
