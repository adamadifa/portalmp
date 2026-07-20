<style>
/* Floating Label */
.fl-group { position: relative; }
.fl-input {
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
.fl-input:focus {
    border-color: #294C9A;
    box-shadow: 0 0 0 3px rgba(41,76,154,0.1);
    background: #fff;
}
.fl-input.is-invalid {
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
.fl-req { color: #ef4444; margin-left: 2px; }
</style>

<form action="{{ route('tujuanangkutan.update', Crypt::encrypt($tujuanangkutan->kode_tujuan)) }}" method="POST" id="formEditTujuan" novalidate>
    @csrf
    @method('PUT')

    <div class="mb-3 fl-group">
        <input type="text" id="kode_tujuan" name="kode_tujuan" disabled value="{{ $tujuanangkutan->kode_tujuan }}" placeholder=" " class="fl-input">
        <label class="fl-label" for="kode_tujuan">Kode Tujuan</label>
    </div>

    <div class="mb-3 fl-group">
        <input type="text" id="tujuan" name="tujuan" required maxlength="30" value="{{ $tujuanangkutan->tujuan }}" placeholder=" " class="fl-input uppercase">
        <label class="fl-label" for="tujuan">Nama Tujuan <span class="fl-req">*</span></label>
    </div>

    <div class="mb-4 fl-group">
        <input type="text" id="tarif" name="tarif" required value="{{ number_format($tujuanangkutan->tarif, 0, ',', '.') }}" placeholder=" " class="fl-input font-semibold text-right">
        <label class="fl-label" for="tarif">Tarif (Rp) <span class="fl-req">*</span></label>
    </div>

    <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
        <button type="button" onclick="closeModal('modalEdit')" class="px-4 py-2 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</button>
        <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Update Tujuan
        </button>
    </div>
</form>
