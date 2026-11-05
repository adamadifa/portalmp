<form action="{{ route('pelanggan.store') }}" method="POST" id="formCreatePelanggan" enctype="multipart/form-data" class="space-y-4" novalidate>
    @csrf

    <!-- SECTION 1: INFORMASI UTAMA PELANGGAN -->
    <div class="space-y-3">
        <div class="flex items-center gap-2 pb-1 border-b border-slate-100 dark:border-slate-800">
            <span class="w-2 h-2 rounded-full bg-blue-600"></span>
            <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200">Informasi Utama Pelanggan</h4>
        </div>

        <!-- Row 1: Kode, Tanggal Register & Cabang -->
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-4">
                <label for="kode_pelanggan" class="flex items-center justify-between text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    <span>Kode Pelanggan <span class="text-rose-500">*</span></span>
                    <span class="text-[10px] text-slate-400 font-normal">Maks 13 digit</span>
                </label>
                <input 
                    type="text" 
                    id="kode_pelanggan" 
                    name="kode_pelanggan" 
                    required 
                    maxlength="13" 
                    class="block w-full px-3 py-2 text-xs font-mono font-semibold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: PL-001"
                >
            </div>

            <div class="sm:col-span-4">
                <label for="tanggal_register" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Tanggal Register <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="tanggal_register" 
                    name="tanggal_register" 
                    required 
                    value="{{ date('Y-m-d') }}" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs flatpickr-date" 
                    autocomplete="off"
                >
            </div>

            <div class="sm:col-span-4">
                <label for="kode_cabang" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Cabang <span class="text-rose-500">*</span>
                </label>
                <select 
                    id="kode_cabang" 
                    name="kode_cabang" 
                    required 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition cursor-pointer shadow-2xs"
                >
                    <option value="">Pilih Cabang...</option>
                    @foreach($cabang as $cab)
                        <option value="{{ $cab->kode_cabang }}">{{ $cab->nama_cabang }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Row 2: Nama Pelanggan, No Telepon & Status Aktif -->
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-6">
                <label for="nama_pelanggan" class="flex items-center justify-between text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    <span>Nama Pelanggan / Toko <span class="text-rose-500">*</span></span>
                    <span class="text-[10px] text-slate-400 font-normal">Maks 100 karakter</span>
                </label>
                <input 
                    type="text" 
                    id="nama_pelanggan" 
                    name="nama_pelanggan" 
                    required 
                    maxlength="100" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: Toko Berkah Jaya"
                >
            </div>

            <div class="sm:col-span-3">
                <label for="no_hp_pelanggan" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Telepon / No HP <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="no_hp_pelanggan" 
                    name="no_hp_pelanggan" 
                    required 
                    maxlength="255" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: 08123456789"
                >
            </div>

            <div class="sm:col-span-3">
                <label for="status_aktif_pelanggan" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Status Operasional <span class="text-rose-500">*</span>
                </label>
                <select 
                    id="status_aktif_pelanggan" 
                    name="status_aktif_pelanggan" 
                    required 
                    class="block w-full px-3 py-2 text-xs font-semibold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition cursor-pointer shadow-2xs"
                >
                    <option value="1">Aktif</option>
                    <option value="0">Non-Aktif</option>
                </select>
            </div>
        </div>
    </div>

    <!-- SECTION 2: ALAMAT & IDENTITAS -->
    <div class="space-y-3 pt-2">
        <div class="flex items-center gap-2 pb-1 border-b border-slate-100 dark:border-slate-800">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200">Alamat & Identitas</h4>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label for="alamat_pelanggan" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Alamat Pelanggan / Domisili <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="alamat_pelanggan" 
                    name="alamat_pelanggan" 
                    required 
                    maxlength="255" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Alamat rumah / pemilik pelanggan..."
                >
            </div>

            <div>
                <label for="alamat_toko" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Alamat Toko / Outlet Pengiriman <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="alamat_toko" 
                    name="alamat_toko" 
                    required 
                    maxlength="255" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Alamat tempat usaha / toko..."
                >
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div>
                <label for="nik" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    NIK KTP
                </label>
                <input 
                    type="text" 
                    id="nik" 
                    name="nik" 
                    maxlength="16" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="16 digit NIK"
                >
            </div>

            <div>
                <label for="no_kk" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    No KK
                </label>
                <input 
                    type="text" 
                    id="no_kk" 
                    name="no_kk" 
                    maxlength="16" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="16 digit No KK"
                >
            </div>

            <div>
                <label for="tanggal_lahir" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Tanggal Lahir
                </label>
                <input 
                    type="text" 
                    id="tanggal_lahir" 
                    name="tanggal_lahir" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs flatpickr-date" 
                    placeholder="Pilih tanggal..."
                    autocomplete="off"
                >
            </div>

            <div>
                <label for="hari" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Hari Kunjungan
                </label>
                <input 
                    type="text" 
                    id="hari" 
                    name="hari" 
                    maxlength="100" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: Senin"
                >
            </div>
        </div>
    </div>

    <!-- SECTION 3: KETENTUAN PIUTANG & GPS -->
    <div class="space-y-3 pt-2">
        <div class="flex items-center gap-2 pb-1 border-b border-slate-100 dark:border-slate-800">
            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200">Ketentuan Piutang, Lokasi & Foto</h4>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label for="limit_pelanggan" class="flex items-center justify-between text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    <span>Limit Piutang (Rp)</span>
                    <span class="text-[10px] text-slate-400 font-normal">Default: 50.000.000</span>
                </label>
                <input 
                    type="number" 
                    id="limit_pelanggan" 
                    name="limit_pelanggan" 
                    min="0" 
                    value="50000000" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="50000000"
                >
            </div>

            <div>
                <label for="ljt" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    LJT (Limit Jatuh Tempo - Hari)
                </label>
                <input 
                    type="number" 
                    id="ljt" 
                    name="ljt" 
                    min="0" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: 14"
                >
            </div>
        </div>

        <!-- GPS Coordinates Block -->
        <div class="p-3 rounded-lg bg-slate-50 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-700">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label for="latitude" class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">
                        Latitude GPS
                    </label>
                    <input 
                        type="text" 
                        id="latitude" 
                        name="latitude" 
                        maxlength="30" 
                        class="block w-full px-2.5 py-1.5 text-xs text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400" 
                        placeholder="-6.200000"
                    >
                </div>
                <div>
                    <label for="longitude" class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">
                        Longitude GPS
                    </label>
                    <input 
                        type="text" 
                        id="longitude" 
                        name="longitude" 
                        maxlength="30" 
                        class="block w-full px-2.5 py-1.5 text-xs text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400" 
                        placeholder="106.816666"
                    >
                </div>
                <div>
                    <label for="status_lokasi" class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">
                        Status Lokasi
                    </label>
                    <select 
                        id="status_lokasi" 
                        name="status_lokasi" 
                        class="block w-full px-2.5 py-1.5 text-xs text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition cursor-pointer"
                    >
                        <option value="1">Sesuai</option>
                        <option value="0">Tidak Sesuai</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Foto Pelanggan / Outlet -->
        <div>
            <label for="foto" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                Foto Pelanggan / Outlet Toko
            </label>
            <input 
                type="file" 
                id="foto" 
                name="foto" 
                accept="image/*" 
                class="block w-full text-xs text-slate-700 dark:text-slate-300 file:mr-4 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-100 hover:file:bg-slate-200 dark:file:bg-slate-800 dark:hover:file:bg-slate-700 file:text-slate-700 dark:file:text-slate-200 border border-slate-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 transition cursor-pointer"
            >
            <p class="text-[10px] text-slate-400 mt-1">Format: JPG, JPEG, PNG, WEBP (Maks 2MB)</p>
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
            <span>Simpan Pelanggan</span>
        </button>
    </div>
</form>

<script>
    if (typeof flatpickr !== 'undefined') {
        flatpickr('#formCreatePelanggan .flatpickr-date', {
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'd/m/Y',
            locale: 'id',
            allowInput: true
        });
    }
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
