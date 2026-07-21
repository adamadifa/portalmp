<form action="{{ route('laporangudangbahan.cetakrekappersediaan') }}" method="POST" id="frmRekappersediaan" target="_blank" class="space-y-6 pt-1">
    @csrf

    <div class="grid grid-cols-2 gap-4">
        <div class="c-fl-group">
            <span class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </span>
            <select name="bulan" id="bulan" class="fi">
                <option value="">Pilih Bulan</option>
                @foreach ($list_bulan as $d)
                    <option value="{{ $d['kode_bulan'] }}">{{ $d['nama_bulan'] }}</option>
                @endforeach
            </select>
            <label for="bulan" class="c-fl-label">Bulan *</label>
        </div>

        <div class="c-fl-group">
            <span class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </span>
            <select name="tahun" id="tahun" class="fi">
                <option value="">Pilih Tahun</option>
                @for ($t = $start_year; $t <= date('Y'); $t++)
                    <option value="{{ $t }}">{{ $t }}</option>
                @endfor
            </select>
            <label for="tahun" class="c-fl-label">Tahun *</label>
        </div>
    </div>

    <div class="c-fl-group">
        <span class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 11h10M7 15h10"/>
            </svg>
        </span>
        <select name="kode_kategori" id="kode_kategori" class="fi">
            <option value="">Pilih Kategori</option>
            <option value="B001">BAHAN</option>
            <option value="B002">KEMASAN</option>
        </select>
        <label for="kode_kategori" class="c-fl-label">Kategori (Bahan / Kemasan) *</label>
    </div>

    <div class="flex items-center gap-2 pt-2">
        <button type="submit" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm gap-1.5 h-[38px]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Rekap
        </button>
        <button type="submit" name="exportButton" class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition shadow-sm gap-1.5 h-[38px]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Export Excel
        </button>
    </div>
</form>
