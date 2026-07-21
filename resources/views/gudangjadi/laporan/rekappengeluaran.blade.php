<form action="{{ route('laporangudangjadi.cetakrekappengeluaran') }}" method="POST" id="frmRekappengeluaran" target="_blank" class="space-y-3.5">
    @csrf

    <div class="grid grid-cols-2 gap-2">
        <div class="fl-group">
            <select name="bulan" id="bulan_pengeluaran" required class="fl-select">
                <option value=""></option>
                @foreach ($list_bulan as $d)
                    <option value="{{ $d['kode_bulan'] }}">{{ $d['nama_bulan'] }}</option>
                @endforeach
            </select>
            <label class="fl-label" for="bulan_pengeluaran">Bulan <span class="fl-req">*</span></label>
        </div>
        <div class="fl-group">
            <select name="tahun" id="tahun_pengeluaran" required class="fl-select">
                <option value=""></option>
                @for ($t = $start_year; $t <= date('Y'); $t++)
                    <option value="{{ $t }}">{{ $t }}</option>
                @endfor
            </select>
            <label class="fl-label" for="tahun_pengeluaran">Tahun <span class="fl-req">*</span></label>
        </div>
    </div>

    <div class="flex gap-2 pt-2">
        <button type="submit" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-xs font-bold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm h-[42px]">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak PDF
        </button>
        <button type="submit" name="exportButton" class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-bold text-white bg-green-600 hover:bg-green-700 rounded-xl transition shadow-sm h-[42px]" title="Export Excel">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
        </button>
    </div>
</form>

<script>
    $(function() {
        $("#frmRekappengeluaran").submit(function(e) {
            const bulan = $(this).find("#bulan_pengeluaran").val();
            const tahun = $(this).find("#tahun_pengeluaran").val();

            if (bulan == "") {
                Swal.fire({
                    title: "Oops!",
                    text: 'Bulan Harus Diisi !',
                    icon: "warning",
                    customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' },
                    buttonsStyling: false
                });
                return false;
            } else if (tahun == "") {
                Swal.fire({
                    title: "Oops!",
                    text: 'Tahun Harus Diisi !',
                    icon: "warning",
                    customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' },
                    buttonsStyling: false
                });
                return false;
            }
        });
    });
</script>
