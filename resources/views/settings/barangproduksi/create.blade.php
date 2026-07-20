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
.fl-select:focus ~ .fl-label,
.fl-select:not([value=""]) ~ .fl-label {
    top: 3px;
    font-size: 9px;
    color: #294C9A;
    font-weight: 600;
}
.fl-select {
    padding-top: 16px;
    padding-bottom: 2px;
}
.fl-req { color: #ef4444; margin-left: 2px; }
</style>

<form action="{{ route('barangproduksi.store') }}" method="POST" id="formCreateBarangProduksi" novalidate>
    @csrf

    {{-- Row 1: Kode Barang (Auto) & Nama Barang --}}
    <div class="grid grid-cols-2 gap-3 mb-3">
        <div class="fl-group">
            <input type="text" id="kode_barang_produksi_display" disabled value="{{ $kode_barang_produksi }}" placeholder=" " class="fl-input">
            <input type="hidden" name="kode_barang_produksi" value="{{ $kode_barang_produksi }}">
            <label class="fl-label" for="kode_barang_produksi_display">Kode Barang</label>
        </div>
        <div class="fl-group">
            <input type="text" id="nama_barang" name="nama_barang" required maxlength="255" placeholder=" " class="fl-input uppercase">
            <label class="fl-label" for="nama_barang">Nama Barang <span class="fl-req">*</span></label>
        </div>
    </div>

    {{-- Row 2: Satuan & Asal Barang --}}
    <div class="grid grid-cols-2 gap-3 mb-3">
        <div class="fl-group">
            <input type="text" id="satuan" name="satuan" required maxlength="10" placeholder=" " class="fl-input uppercase">
            <label class="fl-label" for="satuan">Satuan <span class="fl-req">*</span></label>
        </div>
        <div class="fl-group">
            <select id="kode_asal_barang" name="kode_asal_barang" required class="fl-select">
                <option value="">-- Pilih Asal --</option>
                @foreach ($asal_barang_produksi as $key => $val)
                    <option value="{{ $key }}">{{ $val }}</option>
                @endforeach
            </select>
            <label class="fl-label" for="kode_asal_barang">Asal Barang <span class="fl-req">*</span></label>
        </div>
    </div>

    {{-- Row 3: Kategori & Status --}}
    <div class="grid grid-cols-2 gap-3 mb-4">
        <div class="fl-group">
            <select id="kode_kategori" name="kode_kategori" required class="fl-select">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($list_kategori_barang_produksi as $d)
                    <option value="{{ $d['kode_kategori'] }}">{{ $d['nama_kategori'] }}</option>
                @endforeach
            </select>
            <label class="fl-label" for="kode_kategori">Kategori <span class="fl-req">*</span></label>
        </div>
        <div class="fl-group">
            <select id="status_aktif_barang" name="status_aktif_barang" required class="fl-select">
                <option value="">-- Pilih Status --</option>
                <option value="1">Aktif</option>
                <option value="0">Non-Aktif</option>
            </select>
            <label class="fl-label" for="status_aktif_barang">Status <span class="fl-req">*</span></label>
        </div>
    </div>

    <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
        <button type="button" onclick="closeModal('modalCreate')" class="px-4 py-2 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</button>
        <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Simpan Barang
        </button>
    </div>
</form>
