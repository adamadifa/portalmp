<form action="{{ route('coa.store') }}" method="POST" id="formCreateCoa" class="space-y-4">
    @csrf
    <div>
        <label for="kode_akun_input" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Kode Akun <span class="text-rose-500">*</span></label>
        <input type="text" name="kode_akun" id="kode_akun_input" value="{{ old('kode_akun') }}" class="w-full text-xs font-mono py-2.5 px-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition shadow-2xs" placeholder="Contoh: 1-11106" required autocomplete="off">
        <p class="text-[10px] text-gray-400 mt-1">Format kode akun, misalnya: 1-11106 atau 5-11102.</p>
    </div>

    <div>
        <label for="nama_akun_input" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Nama Akun <span class="text-rose-500">*</span></label>
        <input type="text" name="nama_akun" id="nama_akun_input" value="{{ old('nama_akun') }}" class="w-full text-xs py-2.5 px-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition shadow-2xs" placeholder="Contoh: BANK MANDIRI OPERASIONAL" required autocomplete="off">
    </div>

    <div>
        <label for="sub_akun_select" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Parent Account (Sub Dari Akun)</label>
        <select name="sub_akun" id="sub_akun_select" class="select2-parent-account w-full text-xs border-gray-200 rounded-xl">
            <option value="">-- Akun Utama / Header (Level 1) --</option>
            @foreach ($parentAccounts as $p)
                <option value="{{ $p->kode_akun }}" {{ old('sub_akun') == $p->kode_akun ? 'selected' : '' }}>
                    {{ $p->kode_akun }} - {{ $p->nama_akun }} (Lvl {{ $p->level }})
                </option>
            @endforeach
        </select>
        <p class="text-[10px] text-gray-400 mt-1">Level akun otomatis dihitung mengikuti level parent account.</p>
    </div>

    <div class="flex items-center justify-end gap-2 pt-4 border-t border-gray-100">
        <button type="button" onclick="closeModal()" class="px-4 py-2 text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
            Batal
        </button>
        <button type="submit" id="btnSubmitCoa" class="inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-1.5" style="background-color: #294C9A !important; color: #ffffff !important;">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Simpan Akun
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('.select2-parent-account').select2({
            dropdownParent: $('#modalDialog'),
            width: '100%'
        });

        $('#formCreateCoa').on('submit', function() {
            var btn = $('#btnSubmitCoa');
            btn.prop('disabled', true).text('Menyimpan...');
        });
    });
</script>
