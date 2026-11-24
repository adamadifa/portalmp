<form action="/coa" method="POST" id="formCreateCoa" class="space-y-4" novalidate>
    @csrf

    <div class="space-y-3">
        <!-- Section Header -->
        <div class="flex items-center gap-2 pb-1 border-b border-slate-100 dark:border-slate-800">
            <span class="w-2 h-2 rounded-full bg-blue-600"></span>
            <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200">Informasi Kode Akun Perkiraan</h4>
        </div>

        <!-- Kode Akun -->
        <div>
            <label for="kode_akun" class="flex items-center justify-between text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                <span>Kode Akun <span class="text-rose-500">*</span></span>
                <span class="text-[10px] text-slate-400 font-normal">Format: X-XXXXX</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="hash" class="w-4 h-4"></i>
                </div>
                <input 
                    type="text" 
                    id="kode_akun" 
                    name="kode_akun" 
                    required 
                    maxlength="20" 
                    value="{{ old('kode_akun') }}" 
                    class="block w-full pl-9 pr-3 py-2 text-xs font-mono font-bold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: 1-11106 atau 5-11102"
                >
            </div>
            <p class="text-[10px] text-slate-400 mt-1">Masukkan kode unik perkiraan akuntansi.</p>
        </div>

        <!-- Nama Akun -->
        <div>
            <label for="nama_akun" class="flex items-center justify-between text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                <span>Nama Akun Perkiraan <span class="text-rose-500">*</span></span>
                <span class="text-[10px] text-slate-400 font-normal">Maks 100 karakter</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                </div>
                <input 
                    type="text" 
                    id="nama_akun" 
                    name="nama_akun" 
                    required 
                    maxlength="100" 
                    value="{{ old('nama_akun') }}" 
                    class="block w-full pl-9 pr-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: BANK MANDIRI OPERASIONAL"
                >
            </div>
        </div>

        <!-- Parent Account (Sub Dari) -->
        <div>
            <label for="sub_akun" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                Parent Account (Sub Dari Akun)
            </label>
            <select name="sub_akun" id="sub_akun" class="select2-parent-create w-full text-xs">
                <option value="">-- Akun Utama / Header (Level 1) --</option>
                @foreach ($parentAccounts as $p)
                    <option value="{{ $p->kode_akun }}" {{ old('sub_akun') == $p->kode_akun ? 'selected' : '' }}>
                        {{ $p->kode_akun }} - {{ $p->nama_akun }} (Lvl {{ $p->level }})
                    </option>
                @endforeach
            </select>
            <p class="text-[10px] text-slate-400 mt-1">Jika dipilih, level akun otomatis mengikuti turunan dari parent account.</p>
        </div>
    </div>

    <!-- Form Footer Actions -->
    <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100 dark:border-slate-800">
        <button 
            type="button" 
            onclick="closeModal('modalCreate')" 
            class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition cursor-pointer"
        >
            Batal
        </button>
        <button 
            type="submit" 
            id="btnSubmitCreateCoa" 
            class="inline-flex items-center gap-1.5 px-5 py-2 text-xs font-bold text-white bg-[#162a5b] hover:bg-[#1c3574] rounded-lg transition shadow-xs cursor-pointer"
        >
            <i data-lucide="check" class="w-3.5 h-3.5"></i>
            <span>Simpan Akun</span>
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        $('.select2-parent-create').select2({
            dropdownParent: $('#modalCreate'),
            width: '100%'
        });

        $('#formCreateCoa').on('submit', function(e) {
            var $form = $(this);
            var kode = $('#kode_akun').val().trim();
            var nama = $('#nama_akun').val().trim();

            if (!kode || !nama) {
                e.preventDefault();
                Swal.fire({
                    title: 'Peringatan',
                    text: 'Kode Akun dan Nama Akun wajib diisi!',
                    icon: 'warning',
                    confirmButtonColor: '#162a5b',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl text-xs font-bold px-4 py-2.5'
                    }
                });
                return false;
            }

            var btn = $('#btnSubmitCreateCoa');
            if ($form.data('submitting')) {
                e.preventDefault();
                return false;
            }
            $form.data('submitting', true);
            btn.addClass('opacity-75 cursor-not-allowed pointer-events-none');
            btn.html(`
                <svg class="w-3.5 h-3.5 text-white animate-spin shrink-0 inline-block mr-1" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span>Menyimpan...</span>
            `);
        });
    });
</script>
