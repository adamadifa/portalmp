<form action="{{ route('laporanaccounting.cetakjurnalumum') }}" id="formJurnalUmumReport" target="_blank" method="POST" class="space-y-4">
    @csrf
    
    <!-- Akun COA Filter -->
    <div class="c-fl-group">
        <label class="c-fl-label">Akun (Opsional)</label>
        <div class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
        </div>
        <select name="kode_akun" id="kode_akun_ju_report" class="fi select2Single">
            <option value="">Semua Akun</option>
            @foreach ($coa as $d)
                <option value="{{ $d->kode_akun }}">{{ $d->kode_akun }} - {{ $d->nama_akun }}</option>
            @endforeach
        </select>
    </div>

    <!-- Periode Tanggal -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="c-fl-group">
            <label class="c-fl-label">Dari Tanggal</label>
            <div class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <input type="text" name="dari" id="dari_ju_report" class="fi flatpickr-date" placeholder="YYYY-MM-DD" value="{{ date('Y-m-01') }}">
        </div>

        <div class="c-fl-group">
            <label class="c-fl-label">Sampai Tanggal</label>
            <div class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <input type="text" name="sampai" id="sampai_ju_report" class="fi flatpickr-date" placeholder="YYYY-MM-DD" value="{{ date('Y-m-t') }}">
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center gap-3 pt-3">
        <button type="submit" name="submitButton" value="preview" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            <span>Cetak / Preview</span>
        </button>

        <button type="submit" name="exportButton" value="export" class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-xl transition shadow-sm gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span>Export Excel</span>
        </button>
    </div>
</form>
