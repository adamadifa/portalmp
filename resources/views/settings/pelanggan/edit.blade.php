<style>
/* Floating Label — Edit Form (shared with create, but scoped to avoid conflict) */
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
.fl-input:disabled {
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

<form action="{{ route('pelanggan.update', Crypt::encrypt($pelanggan->kode_pelanggan)) }}" method="POST" id="formEditPelanggan" enctype="multipart/form-data" novalidate>
    @csrf
    @method('PUT')

    {{-- Row 1: Kode (disabled) & Tanggal Register --}}
    <div class="grid grid-cols-2 gap-3 mb-3">
        <div class="fl-group">
            <input type="text" value="{{ $pelanggan->kode_pelanggan }}" disabled placeholder=" " class="fl-input">
            <label class="fl-label">Kode Pelanggan</label>
        </div>
        <div class="fl-group">
            <input type="text" value="{{ $pelanggan->tanggal_register ? \Carbon\Carbon::parse($pelanggan->tanggal_register)->format('d/m/Y') : '' }}" disabled placeholder=" " class="fl-input">
            <label class="fl-label">Tanggal Register</label>
        </div>
    </div>

    {{-- Row 2: Nama & Telepon --}}
    <div class="grid grid-cols-2 gap-3 mb-3">
        <div class="fl-group">
            <input type="text" id="e_nama_pelanggan" name="nama_pelanggan" value="{{ $pelanggan->nama_pelanggan }}" required maxlength="100" placeholder=" " class="fl-input">
            <label class="fl-label" for="e_nama_pelanggan">Nama Pelanggan <span class="fl-req">*</span></label>
        </div>
        <div class="fl-group">
            <input type="text" id="e_no_hp" name="no_hp_pelanggan" value="{{ $pelanggan->no_hp_pelanggan }}" required maxlength="255" placeholder=" " class="fl-input">
            <label class="fl-label" for="e_no_hp">Telepon / HP <span class="fl-req">*</span></label>
        </div>
    </div>

    {{-- Row 3: NIK & No KK --}}
    <div class="grid grid-cols-2 gap-3 mb-3">
        <div class="fl-group">
            <input type="text" id="e_nik" name="nik" value="{{ $pelanggan->nik }}" maxlength="16" placeholder=" " class="fl-input">
            <label class="fl-label" for="e_nik">NIK</label>
        </div>
        <div class="fl-group">
            <input type="text" id="e_no_kk" name="no_kk" value="{{ $pelanggan->no_kk }}" maxlength="16" placeholder=" " class="fl-input">
            <label class="fl-label" for="e_no_kk">No KK</label>
        </div>
    </div>

    {{-- Row 4: Tanggal Lahir & Hari --}}
    <div class="grid grid-cols-2 gap-3 mb-3">
        <div class="fl-group">
            <input type="text" id="e_tanggal_lahir" name="tanggal_lahir" value="{{ $pelanggan->tanggal_lahir ? \Carbon\Carbon::parse($pelanggan->tanggal_lahir)->format('d/m/Y') : '' }}" placeholder=" " class="fl-input flatpickr-date" autocomplete="off">
            <label class="fl-label" for="e_tanggal_lahir">Tanggal Lahir</label>
        </div>
        <div class="fl-group">
            <input type="text" id="e_hari" name="hari" value="{{ $pelanggan->hari }}" maxlength="100" placeholder=" " class="fl-input">
            <label class="fl-label" for="e_hari">Hari Kunjungan</label>
        </div>
    </div>

    {{-- Row 5: Alamat --}}
    <div class="grid grid-cols-2 gap-3 mb-3">
        <div class="fl-group">
            <input type="text" id="e_alamat_pelanggan" name="alamat_pelanggan" value="{{ $pelanggan->alamat_pelanggan }}" required maxlength="255" placeholder=" " class="fl-input">
            <label class="fl-label" for="e_alamat_pelanggan">Alamat Pelanggan <span class="fl-req">*</span></label>
        </div>
        <div class="fl-group">
            <input type="text" id="e_alamat_toko" name="alamat_toko" value="{{ $pelanggan->alamat_toko }}" required maxlength="255" placeholder=" " class="fl-input">
            <label class="fl-label" for="e_alamat_toko">Alamat Toko <span class="fl-req">*</span></label>
        </div>
    </div>

    {{-- Row 6: GPS --}}
    <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 mb-3">
        <p class="text-[10px] font-bold text-blue-400 uppercase tracking-wider mb-2">Lokasi GPS</p>
        <div class="grid grid-cols-3 gap-3">
            <div class="fl-group">
                <input type="text" id="e_latitude" name="latitude" value="{{ $pelanggan->latitude }}" maxlength="30" placeholder=" " class="fl-input" style="background:#fff">
                <label class="fl-label" for="e_latitude">Latitude</label>
            </div>
            <div class="fl-group">
                <input type="text" id="e_longitude" name="longitude" value="{{ $pelanggan->longitude }}" maxlength="30" placeholder=" " class="fl-input" style="background:#fff">
                <label class="fl-label" for="e_longitude">Longitude</label>
            </div>
            <div class="fl-group">
                <select id="e_status_lokasi" name="status_lokasi" class="fl-select has-value" style="background:#fff">
                    <option value="1" {{ $pelanggan->status_lokasi == '1' ? 'selected' : '' }}>Sesuai</option>
                    <option value="0" {{ $pelanggan->status_lokasi == '0' ? 'selected' : '' }}>Tidak Sesuai</option>
                </select>
                <label class="fl-label" for="e_status_lokasi">Status Lokasi</label>
            </div>
        </div>
    </div>

    {{-- Row 7: LJT, Cabang, Status --}}
    <div class="grid grid-cols-3 gap-3 mb-3">
        <div class="fl-group">
            <input type="number" id="e_ljt" name="ljt" value="{{ $pelanggan->ljt }}" placeholder=" " class="fl-input">
            <label class="fl-label" for="e_ljt">LJT</label>
        </div>
        <div class="fl-group">
            <select id="e_kode_cabang" name="kode_cabang" required class="fl-select has-value">
                <option value=""></option>
                @foreach($cabang as $cab)
                    <option value="{{ $cab->kode_cabang }}" {{ $pelanggan->kode_cabang == $cab->kode_cabang ? 'selected' : '' }}>{{ $cab->nama_cabang }}</option>
                @endforeach
            </select>
            <label class="fl-label" for="e_kode_cabang">Cabang <span class="fl-req">*</span></label>
        </div>
        <div class="fl-group">
            <select id="e_status_aktif" name="status_aktif_pelanggan" required class="fl-select has-value">
                <option value="1" {{ $pelanggan->status_aktif_pelanggan == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ $pelanggan->status_aktif_pelanggan == '0' ? 'selected' : '' }}>Non-Aktif</option>
            </select>
            <label class="fl-label" for="e_status_aktif">Status <span class="fl-req">*</span></label>
        </div>
    </div>

    {{-- Foto --}}
    <div class="mb-4">
        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Foto Pelanggan / Outlet</label>
        @if($pelanggan->foto)
            <div class="flex items-center gap-3 mb-2">
                <img src="{{ asset('storage/pelanggan/' . $pelanggan->foto) }}" class="w-12 h-12 rounded-full object-cover border border-gray-200" alt="Foto">
                <span class="text-xs text-gray-400">Foto saat ini. Upload baru untuk mengganti.</span>
            </div>
        @endif
        <input type="file" id="e_foto" name="foto" accept="image/*" class="block w-full text-xs text-gray-900 bg-gray-50 border border-gray-200 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#294C9A] file:text-white hover:file:bg-[#1E3A70] transition">
    </div>

    <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
        <button type="button" onclick="closeModal('modalEdit')" class="px-4 py-2 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</button>
        <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Update Pelanggan
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
document.querySelectorAll('#formEditPelanggan .flatpickr-date').forEach(function(el) {
    flatpickr(el, {
        dateFormat: 'd/m/Y',
        locale: 'id',
        allowInput: true,
        disableMobile: true
    });
});
</script>
