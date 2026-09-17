<form action="{{ route('laporanaccounting.cetakbukubesar') }}" id="formLedger" target="_blank" method="POST" class="space-y-4">
    @csrf
    
    <!-- Format Laporan -->
    <div class="c-fl-group">
        <label class="c-fl-label">Format Laporan</label>
        <div class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </div>
        <select name="formatlaporan" id="formatlaporan_ledger" class="fi select2Single">
            <option value="">Pilih Format Laporan</option>
            <option value="1">Buku Besar</option>
            <option value="2">Neraca</option>
            <option value="3">Laba Rugi</option>
        </select>
    </div>

    <!-- COA Dari & Sampai (Hanya untuk Buku Besar) -->
    <div id="coa_ledger" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="c-fl-group">
            <label class="c-fl-label">Akun Dari</label>
            <div class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
            </div>
            <select name="kode_akun_dari" id="kode_akun_dari_ledger" class="fi select2Single">
                <option value="">Semua Akun</option>
                @foreach ($coa as $d)
                    <option value="{{ $d->kode_akun }}">{{ $d->kode_akun }} - {{ $d->nama_akun }}</option>
                @endforeach
            </select>
        </div>

        <div class="c-fl-group">
            <label class="c-fl-label">Akun Sampai</label>
            <div class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
            </div>
            <select name="kode_akun_sampai" id="kode_akun_sampai_ledger" class="fi select2Single">
                <option value="">Semua Akun</option>
                @foreach ($coa as $d)
                    <option value="{{ $d->kode_akun }}">{{ $d->kode_akun }} - {{ $d->nama_akun }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Periode Tanggal -->
    <div id="periode_ledger_container" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="c-fl-group">
            <label class="c-fl-label">Dari Tanggal</label>
            <div class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <input type="text" name="dari" id="dari_ledger" class="fi flatpickr-date" placeholder="YYYY-MM-DD" value="{{ date('Y-m-01') }}">
        </div>

        <div class="c-fl-group">
            <label class="c-fl-label">Sampai Tanggal</label>
            <div class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <input type="text" name="sampai" id="sampai_ledger" class="fi flatpickr-date" placeholder="YYYY-MM-DD" value="{{ date('Y-m-t') }}">
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
        <button type="submit" name="submitButton" 
            class="flex-1 h-11 flex items-center justify-center gap-2 bg-[#294C9A] hover:bg-[#1E3A70] text-white font-semibold rounded-xl transition shadow-sm text-sm" 
            id="submitButtonLedger">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            <span>Cetak Laporan</span>
        </button>
        <button type="submit" name="exportButton" 
            class="w-12 h-11 flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl transition shadow-sm text-sm" 
            id="exportButtonLedger" title="Export ke Excel">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </button>
    </div>
</form>
