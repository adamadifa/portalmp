<style>
/* Floating Label */
.fl-group { position: relative; }
.fl-input, .fl-select {
    display: block; width: 100%;
    padding: 14px 14px 4px;
    font-size: 12px; color: #111827;
    background: #f9fafb;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    appearance: none;
}
.fl-input:focus, .fl-select:focus {
    border-color: #294C9A;
    box-shadow: 0 0 0 3px rgba(41,76,154,0.1);
    background: #fff;
}
.fl-input.is-invalid, .fl-select.is-invalid {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239,68,68,0.1) !important;
    background: #fff5f5 !important;
}
.fl-input:disabled, .fl-select:disabled {
    background: #f3f4f6;
    color: #9ca3af;
    cursor: not-allowed;
}
.fl-label {
    position: absolute;
    left: 14px; top: 9px;
    font-size: 12px; color: #9ca3af;
    font-weight: 500;
    pointer-events: none;
    transition: all 0.15s ease;
    transform-origin: left top;
}
.fl-input:focus ~ .fl-label,
.fl-input:not(:placeholder-shown) ~ .fl-label,
.fl-input:disabled ~ .fl-label,
.fl-select:focus ~ .fl-label,
.fl-select.has-value ~ .fl-label {
    top: 3px;
    font-size: 9px;
    color: #294C9A;
    font-weight: 600;
}
.fl-input.is-invalid ~ .fl-label,
.fl-select.is-invalid ~ .fl-label {
    color: #ef4444;
}
.fl-req { color: #ef4444; margin-left: 2px; }
</style>

<form action="{{ route('pelanggan.store') }}" method="POST" id="formCreatePelanggan" enctype="multipart/form-data" novalidate>
    @csrf

    {{-- Row 1: Kode & Tanggal Register --}}
    <div class="grid grid-cols-2 gap-3 mb-3">
        <div class="fl-group">
            <input type="text" id="kode_pelanggan" name="kode_pelanggan" required maxlength="13" placeholder=" " class="fl-input uppercase">
            <label class="fl-label" for="kode_pelanggan">Kode Pelanggan <span class="fl-req">*</span></label>
        </div>
        <div class="fl-group">
            <input type="text" id="tanggal_register" name="tanggal_register" required value="{{ date('d/m/Y') }}" placeholder=" " class="fl-input flatpickr-date" autocomplete="off">
            <label class="fl-label" for="tanggal_register">Tanggal Register <span class="fl-req">*</span></label>
        </div>
    </div>

    {{-- Row 2: Nama & Telepon --}}
    <div class="grid grid-cols-2 gap-3 mb-3">
        <div class="fl-group">
            <input type="text" id="nama_pelanggan" name="nama_pelanggan" required maxlength="100" placeholder=" " class="fl-input">
            <label class="fl-label" for="nama_pelanggan">Nama Pelanggan <span class="fl-req">*</span></label>
        </div>
        <div class="fl-group">
            <input type="text" id="no_hp_pelanggan" name="no_hp_pelanggan" required maxlength="255" placeholder=" " class="fl-input">
            <label class="fl-label" for="no_hp_pelanggan">Telepon / HP <span class="fl-req">*</span></label>
        </div>
    </div>

    {{-- Row 3: NIK & No KK --}}
    <div class="grid grid-cols-2 gap-3 mb-3">
        <div class="fl-group">
            <input type="text" id="nik" name="nik" maxlength="16" placeholder=" " class="fl-input">
            <label class="fl-label" for="nik">NIK</label>
        </div>
        <div class="fl-group">
            <input type="text" id="no_kk" name="no_kk" maxlength="16" placeholder=" " class="fl-input">
            <label class="fl-label" for="no_kk">No KK</label>
        </div>
    </div>

    {{-- Row 4: Tanggal Lahir & Hari Kunjungan --}}
    <div class="grid grid-cols-2 gap-3 mb-3">
        <div class="fl-group">
            <input type="text" id="tanggal_lahir" name="tanggal_lahir" placeholder=" " class="fl-input flatpickr-date" autocomplete="off">
            <label class="fl-label" for="tanggal_lahir">Tanggal Lahir</label>
        </div>
        <div class="fl-group">
            <input type="text" id="hari" name="hari" maxlength="100" placeholder=" " class="fl-input">
            <label class="fl-label" for="hari">Hari Kunjungan</label>
        </div>
    </div>

    {{-- Row 5: Alamat --}}
    <div class="grid grid-cols-2 gap-3 mb-3">
        <div class="fl-group">
            <input type="text" id="alamat_pelanggan" name="alamat_pelanggan" required maxlength="255" placeholder=" " class="fl-input">
            <label class="fl-label" for="alamat_pelanggan">Alamat Pelanggan <span class="fl-req">*</span></label>
        </div>
        <div class="fl-group">
            <input type="text" id="alamat_toko" name="alamat_toko" required maxlength="255" placeholder=" " class="fl-input">
            <label class="fl-label" for="alamat_toko">Alamat Toko <span class="fl-req">*</span></label>
        </div>
    </div>

    {{-- Row 6: Koordinat (compact section) --}}
    <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 mb-3">
        <p class="text-[10px] font-bold text-blue-400 uppercase tracking-wider mb-2">Lokasi GPS</p>
        <div class="grid grid-cols-3 gap-3">
            <div class="fl-group">
                <input type="text" id="latitude" name="latitude" maxlength="30" placeholder=" " class="fl-input" style="background:#fff">
                <label class="fl-label" for="latitude">Latitude</label>
            </div>
            <div class="fl-group">
                <input type="text" id="longitude" name="longitude" maxlength="30" placeholder=" " class="fl-input" style="background:#fff">
                <label class="fl-label" for="longitude">Longitude</label>
            </div>
            <div class="fl-group">
                <select id="status_lokasi" name="status_lokasi" class="fl-select has-value" style="background:#fff">
                    <option value="1">Sesuai</option>
                    <option value="0">Tidak Sesuai</option>
                </select>
                <label class="fl-label" for="status_lokasi">Status Lokasi</label>
            </div>
        </div>
    </div>

    {{-- Row 7: LJT, Cabang, Status --}}
    <div class="grid grid-cols-3 gap-3 mb-3">
        <div class="fl-group">
            <input type="number" id="ljt" name="ljt" placeholder=" " class="fl-input">
            <label class="fl-label" for="ljt">LJT</label>
        </div>
        <div class="fl-group">
            <select id="kode_cabang" name="kode_cabang" required class="fl-select">
                <option value=""></option>
                @foreach($cabang as $cab)
                    <option value="{{ $cab->kode_cabang }}">{{ $cab->nama_cabang }}</option>
                @endforeach
            </select>
            <label class="fl-label" for="kode_cabang">Cabang <span class="fl-req">*</span></label>
        </div>
        <div class="fl-group">
            <select id="status_aktif_pelanggan" name="status_aktif_pelanggan" required class="fl-select has-value">
                <option value="1">Aktif</option>
                <option value="0">Non-Aktif</option>
            </select>
            <label class="fl-label" for="status_aktif_pelanggan">Status <span class="fl-req">*</span></label>
        </div>
    </div>

    {{-- Foto --}}
    <div class="mb-4">
        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Foto Pelanggan / Outlet</label>
        <input type="file" id="foto" name="foto" accept="image/*" class="block w-full text-xs text-gray-900 bg-gray-50 border border-gray-200 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#294C9A] file:text-white hover:file:bg-[#1E3A70] transition">
    </div>

    <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
        <button type="button" onclick="closeModal('modalCreate')" class="px-4 py-2 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</button>
        <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Simpan Pelanggan
        </button>
    </div>
</form>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
.flatpickr-calendar { font-family: 'Poppins', sans-serif; font-size: 12px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.12); border: 1px solid #e5e7eb; }
.flatpickr-day.selected, .flatpickr-day.selected:hover { background: #294C9A; border-color: #294C9A; }
.flatpickr-day:hover { background: #EEF2FF; }
.flatpickr-months .flatpickr-month { background: #294C9A; color: white; border-radius: 12px 12px 0 0; }
.flatpickr-current-month .flatpickr-monthDropdown-months, .flatpickr-current-month input.cur-year { color: white; }
.flatpickr-weekday { color: #294C9A; font-weight: 600; }
.flatpickr-prev-month svg, .flatpickr-next-month svg { fill: white; }
</style>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script>
// Flatpickr date pickers
function initFlatpickrCreate() {
    document.querySelectorAll('#formCreatePelanggan .flatpickr-date').forEach(function(el) {
        flatpickr(el, {
            dateFormat: 'd/m/Y',
            locale: 'id',
            allowInput: true,
            disableMobile: true,
            onReady: function(_, __, fp) {
                // trigger floating label
                if (fp.input.value) fp.input.dispatchEvent(new Event('input'));
            }
        });
    });
}

// Floating label for selects
document.querySelectorAll('#formCreatePelanggan .fl-select').forEach(function(sel) {
    sel.addEventListener('change', function() {
        this.classList.toggle('has-value', this.value !== '');
    });
    if (sel.value !== '') sel.classList.add('has-value');
});

initFlatpickrCreate();
</script>
