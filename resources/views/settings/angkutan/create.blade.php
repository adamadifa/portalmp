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
.fl-input:not(:placeholder-shown) ~ .fl-label {
    top: 3px;
    font-size: 9px;
    color: #294C9A;
    font-weight: 600;
}
.fl-input.is-invalid ~ .fl-label {
    color: #ef4444;
}
.fl-req { color: #ef4444; margin-left: 2px; }
</style>

<form action="{{ route('angkutan.store') }}" method="POST" id="formCreateAngkutan" novalidate>
    @csrf

    {{-- Row 1: Kode (Auto) & Nama Angkutan --}}
    <div class="grid grid-cols-2 gap-3 mb-3">
        <div class="fl-group">
            <input type="text" id="kode_angkutan" name="kode_angkutan" disabled value="Auto" placeholder=" " class="fl-input">
            <label class="fl-label" for="kode_angkutan">Kode Angkutan</label>
        </div>
        <div class="fl-group">
            <input type="text" id="nama_angkutan" name="nama_angkutan" required maxlength="50" placeholder=" " class="fl-input uppercase">
            <label class="fl-label" for="nama_angkutan">Nama Angkutan <span class="fl-req">*</span></label>
        </div>
    </div>

    {{-- Row 2: Keterangan --}}
    <div class="mb-4 fl-group">
        <input type="text" id="keterangan" name="keterangan" maxlength="30" placeholder=" " class="fl-input">
        <label class="fl-label" for="keterangan">Keterangan</label>
    </div>

    <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
        <button type="button" onclick="closeModal('modalCreate')" class="px-4 py-2 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</button>
        <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Simpan Angkutan
        </button>
    </div>
</form>
