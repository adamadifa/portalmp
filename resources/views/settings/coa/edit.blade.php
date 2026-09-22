<form action="{{ route('coa.update', $coa->kode_akun) }}" method="POST" id="formEditCoa" class="space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Kode Akun</label>
        <input type="text" value="{{ $coa->kode_akun }}" disabled class="w-full text-xs font-mono py-2.5 px-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-500 cursor-not-allowed">
    </div>

    <div>
        <label for="nama_akun_edit" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Nama Akun <span class="text-rose-500">*</span></label>
        <input type="text" name="nama_akun" id="nama_akun_edit" value="{{ old('nama_akun', $coa->nama_akun) }}" class="w-full text-xs py-2.5 px-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition shadow-2xs" required autocomplete="off">
    </div>

    <div>
        <label for="sub_akun_edit" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Parent Account (Sub Dari Akun)</label>
        <select name="sub_akun" id="sub_akun_edit" class="select2-parent-edit w-full text-xs border-gray-200 rounded-xl">
            <option value="">-- Akun Utama / Header (Level 1) --</option>
            @foreach ($parentAccounts as $p)
                <option value="{{ $p->kode_akun }}" {{ old('sub_akun', $coa->sub_akun) == $p->kode_akun ? 'selected' : '' }}>
                    {{ $p->kode_akun }} - {{ $p->nama_akun }} (Lvl {{ $p->level }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="flex items-center justify-end gap-2 pt-4 border-t border-gray-100">
        <button type="button" onclick="closeModal()" class="px-4 py-2 text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
            Batal
        </button>
        <button type="submit" id="btnUpdateCoa" class="inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-1.5" style="background-color: #294C9A !important; color: #ffffff !important;">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Simpan Perubahan
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('.select2-parent-edit').select2({
            dropdownParent: $('#modalDialog'),
            width: '100%'
        });

        $('#formEditCoa').on('submit', function() {
            var btn = $('#btnUpdateCoa');
            btn.prop('disabled', true).text('Menyimpan...');
        });
    });
</script>
