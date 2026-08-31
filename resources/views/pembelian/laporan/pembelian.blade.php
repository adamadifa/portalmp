<form action="{{ route('laporanpembelian.cetakpembelian') }}" method="POST" id="formLapPembelian" target="_blank" class="space-y-6 pt-1">
    @csrf
    
    <div class="c-fl-group">
        <span class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        </span>
        <select name="kode_supplier" id="kode_supplier_pembelian" class="select2Kodesupplier">
            <option value="">Semua Supplier</option>
            @foreach ($supplier as $d)
                <option value="{{ $d->kode_supplier }}">{{ strtoupper($d->nama_supplier) }}</option>
            @endforeach
        </select>
        <label for="kode_supplier_pembelian" class="c-fl-label">Supplier</label>
    </div>

    <div class="c-fl-group">
        <span class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </span>
        <select name="kode_asal_pengajuan" id="kode_asal_pengajuan_pembelian" class="fi">
            <option value="">Semua Asal Ajuan</option>
            @foreach ($asal_ajuan as $d)
                <option value="{{ $d['kode_group'] }}">{{ $d['nama_group'] }}</option>
            @endforeach
        </select>
        <label for="kode_asal_pengajuan_pembelian" class="c-fl-label">Asal Ajuan</label>
    </div>

    <div class="c-fl-group">
        <span class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </span>
        <select name="ppn" id="ppn_pembelian" class="fi">
            <option value="">PPN / NON PPN</option>
            <option value="1">PPN</option>
            <option value="0">NON PPN</option>
        </select>
        <label for="ppn_pembelian" class="c-fl-label">PPN Status</label>
    </div>

    <div class="c-fl-group">
        <span class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
        </span>
        <select name="kode_akun" id="kode_akun_pembelian" class="select2Kodeakun">
            <option value="">Semua Akun</option>
            @foreach ($akun as $d)
                <option value="{{ $d->kode_akun }}">{{ $d->kode_akun }} - {{ $d->nama_akun }}</option>
            @endforeach
        </select>
        <label for="kode_akun_pembelian" class="c-fl-label">Kode Akun</label>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="c-fl-group">
            <span class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </span>
            <input type="text" name="dari" id="dari_pembelian" class="fi flatpickr-date" placeholder="Pilih Tanggal" required autocomplete="off" />
            <label for="dari_pembelian" class="c-fl-label">Dari Tanggal *</label>
        </div>

        <div class="c-fl-group">
            <span class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </span>
            <input type="text" name="sampai" id="sampai_pembelian" class="fi flatpickr-date" placeholder="Pilih Tanggal" required autocomplete="off" />
            <label for="sampai_pembelian" class="c-fl-label">Sampai Tanggal *</label>
        </div>
    </div>

    <div class="flex items-center gap-2 pt-2">
        <button type="submit" name="submitButton" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm gap-1.5 h-[38px]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak
        </button>
        <button type="submit" name="exportButton" class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition shadow-sm gap-1.5 h-[38px]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Export Excel
        </button>
    </div>
</form>