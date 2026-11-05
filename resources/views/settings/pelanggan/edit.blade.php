<form action="{{ route('pelanggan.update', Crypt::encrypt($pelanggan->kode_pelanggan)) }}" method="POST" id="formEditPelanggan" enctype="multipart/form-data" class="space-y-4" novalidate>
    @csrf
    @method('PUT')

    <!-- SECTION 1: INFORMASI UTAMA PELANGGAN -->
    <div class="space-y-3">
        <div class="flex items-center gap-2 pb-1 border-b border-slate-100 dark:border-slate-800">
            <span class="w-2 h-2 rounded-full bg-blue-600"></span>
            <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200">Informasi Utama Pelanggan</h4>
        </div>

        <!-- Row 1: Kode, Tanggal Register & Cabang -->
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-4">
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Kode Pelanggan
                </label>
                <input 
                    type="text" 
                    value="{{ $pelanggan->kode_pelanggan }}" 
                    disabled 
                    class="block w-full px-3 py-2 text-xs font-mono font-bold text-slate-500 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg cursor-not-allowed"
                >
            </div>

            <div class="sm:col-span-4">
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Tanggal Register
                </label>
                <input 
                    type="text" 
                    value="{{ $pelanggan->tanggal_register ? \Carbon\Carbon::parse($pelanggan->tanggal_register)->format('d/m/Y') : '-' }}" 
                    disabled 
                    class="block w-full px-3 py-2 text-xs font-semibold text-slate-500 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg cursor-not-allowed"
                >
            </div>

            <div class="sm:col-span-4">
                <label for="e_kode_cabang" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Cabang <span class="text-rose-500">*</span>
                </label>
                <select 
                    id="e_kode_cabang" 
                    name="kode_cabang" 
                    required 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition cursor-pointer shadow-2xs"
                >
                    <option value="">Pilih Cabang...</option>
                    @foreach($cabang as $cab)
                        <option value="{{ $cab->kode_cabang }}" {{ $pelanggan->kode_cabang == $cab->kode_cabang ? 'selected' : '' }}>
                            {{ $cab->nama_cabang }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Row 2: Nama Pelanggan, No Telepon & Status Aktif -->
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-6">
                <label for="e_nama_pelanggan" class="flex items-center justify-between text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    <span>Nama Pelanggan / Toko <span class="text-rose-500">*</span></span>
                    <span class="text-[10px] text-slate-400 font-normal">Maks 100 karakter</span>
                </label>
                <input 
                    type="text" 
                    id="e_nama_pelanggan" 
                    name="nama_pelanggan" 
                    value="{{ $pelanggan->nama_pelanggan }}" 
                    required 
                    maxlength="100" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: Toko Berkah Jaya"
                >
            </div>

            <div class="sm:col-span-3">
                <label for="e_no_hp_pelanggan" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Telepon / No HP <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="e_no_hp_pelanggan" 
                    name="no_hp_pelanggan" 
                    value="{{ $pelanggan->no_hp_pelanggan }}" 
                    required 
                    maxlength="255" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: 08123456789"
                >
            </div>

            <div class="sm:col-span-3">
                <label for="e_status_aktif_pelanggan" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Status Operasional <span class="text-rose-500">*</span>
                </label>
                <select 
                    id="e_status_aktif_pelanggan" 
                    name="status_aktif_pelanggan" 
                    required 
                    class="block w-full px-3 py-2 text-xs font-semibold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition cursor-pointer shadow-2xs"
                >
                    <option value="1" {{ $pelanggan->status_aktif_pelanggan == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $pelanggan->status_aktif_pelanggan == '0' ? 'selected' : '' }}>Non-Aktif</option>
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
                <label for="e_alamat_pelanggan" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Alamat Pelanggan / Domisili <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="e_alamat_pelanggan" 
                    name="alamat_pelanggan" 
                    value="{{ $pelanggan->alamat_pelanggan }}" 
                    required 
                    maxlength="255" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Alamat rumah / domisili..."
                >
            </div>

            <div>
                <label for="e_alamat_toko" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Alamat Toko / Outlet Pengiriman <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="e_alamat_toko" 
                    name="alamat_toko" 
                    value="{{ $pelanggan->alamat_toko }}" 
                    required 
                    maxlength="255" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Alamat outlet / toko..."
                >
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div>
                <label for="e_nik" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    NIK KTP
                </label>
                <input 
                    type="text" 
                    id="e_nik" 
                    name="nik" 
                    value="{{ $pelanggan->nik }}" 
                    maxlength="16" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="16 digit NIK"
                >
            </div>

            <div>
                <label for="e_no_kk" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    No KK
                </label>
                <input 
                    type="text" 
                    id="e_no_kk" 
                    name="no_kk" 
                    value="{{ $pelanggan->no_kk }}" 
                    maxlength="16" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="16 digit No KK"
                >
            </div>

            <div>
                <label for="e_tanggal_lahir" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Tanggal Lahir
                </label>
                <input 
                    type="text" 
                    id="e_tanggal_lahir" 
                    name="tanggal_lahir" 
                    value="{{ $pelanggan->tanggal_lahir }}" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs flatpickr-date" 
                    placeholder="Pilih tanggal..."
                    autocomplete="off"
                >
            </div>

            <div>
                <label for="e_hari" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Hari Kunjungan
                </label>
                <input 
                    type="text" 
                    id="e_hari" 
                    name="hari" 
                    value="{{ $pelanggan->hari }}" 
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
                <label for="e_limit_pelanggan" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Limit Piutang (Rp)
                </label>
                <input 
                    type="number" 
                    id="e_limit_pelanggan" 
                    name="limit_pelanggan" 
                    min="0" 
                    value="{{ $pelanggan->limit_pelanggan }}" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: 50000000"
                >
            </div>

            <div>
                <label for="e_ljt" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    LJT (Limit Jatuh Tempo - Hari)
                </label>
                <input 
                    type="number" 
                    id="e_ljt" 
                    name="ljt" 
                    min="0" 
                    value="{{ $pelanggan->ljt }}" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: 14"
                >
            </div>
        </div>

        <!-- GPS Coordinates Block -->
        <div class="p-3 rounded-lg bg-slate-50 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-700">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label for="e_latitude" class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">
                        Latitude GPS
                    </label>
                    <input 
                        type="text" 
                        id="e_latitude" 
                        name="latitude" 
                        value="{{ $pelanggan->latitude }}" 
                        maxlength="30" 
                        class="block w-full px-2.5 py-1.5 text-xs text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400" 
                        placeholder="-6.200000"
                    >
                </div>
                <div>
                    <label for="e_longitude" class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">
                        Longitude GPS
                    </label>
                    <input 
                        type="text" 
                        id="e_longitude" 
                        name="longitude" 
                        value="{{ $pelanggan->longitude }}" 
                        maxlength="30" 
                        class="block w-full px-2.5 py-1.5 text-xs text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400" 
                        placeholder="106.816666"
                    >
                </div>
                <div>
                    <label for="e_status_lokasi" class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">
                        Status Lokasi
                    </label>
                    <select 
                        id="e_status_lokasi" 
                        name="status_lokasi" 
                        class="block w-full px-2.5 py-1.5 text-xs text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition cursor-pointer"
                    >
                        <option value="1" {{ $pelanggan->status_lokasi == '1' ? 'selected' : '' }}>Sesuai</option>
                        <option value="0" {{ $pelanggan->status_lokasi == '0' ? 'selected' : '' }}>Tidak Sesuai</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Foto Pelanggan / Outlet -->
        <div>
            <label for="e_foto" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                Foto Pelanggan / Outlet Toko
            </label>
            @if($pelanggan->foto)
                <div class="flex items-center gap-3 mb-2 p-2 rounded-lg bg-slate-50 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-700">
                    <img src="{{ asset('storage/pelanggan/' . $pelanggan->foto) }}" class="w-12 h-12 rounded-lg object-cover border border-slate-200 dark:border-slate-700" alt="Foto">
                    <span class="text-xs text-slate-500 dark:text-slate-400">Foto saat ini tersimpan. Pilih file baru untuk menggantinya.</span>
                </div>
            @endif
            <input 
                type="file" 
                id="e_foto" 
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
            onclick="closeModal('modalEdit')" 
            class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition cursor-pointer"
        >
            Batal
        </button>
        <button 
            type="submit" 
            class="inline-flex items-center gap-1.5 px-5 py-2 text-xs font-bold text-white bg-[#162a5b] hover:bg-[#1c3574] rounded-lg transition shadow-xs cursor-pointer"
        >
            <i data-lucide="check" class="w-3.5 h-3.5"></i>
            <span>Update Pelanggan</span>
        </button>
    </div>
</form>

<script>
    if (typeof flatpickr !== 'undefined') {
        flatpickr('#formEditPelanggan .flatpickr-date', {
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
