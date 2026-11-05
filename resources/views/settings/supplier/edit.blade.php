<form action="{{ route('supplier.update', Crypt::encrypt($supplier->kode_supplier)) }}" method="POST" id="formEditSupplier" class="space-y-4" novalidate>
    @csrf
    @method('PUT')

    <!-- SECTION 1: INFORMASI SUPPLIER -->
    <div class="space-y-3">
        <div class="flex items-center gap-2 pb-1 border-b border-slate-100 dark:border-slate-800">
            <span class="w-2 h-2 rounded-full bg-blue-600"></span>
            <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200">Informasi Utama Vendor</h4>
        </div>

        <!-- Row 1: Kode & Nama Supplier -->
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-4">
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Kode Supplier
                </label>
                <input 
                    type="text" 
                    disabled 
                    value="{{ $supplier->kode_supplier }}" 
                    class="block w-full px-3 py-2 text-xs font-mono font-bold text-slate-500 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg cursor-not-allowed"
                >
            </div>

            <div class="sm:col-span-8">
                <label for="e_nama_supplier" class="flex items-center justify-between text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    <span>Nama Supplier / Vendor <span class="text-rose-500">*</span></span>
                    <span class="text-[10px] text-slate-400 font-normal">Maks 100 karakter</span>
                </label>
                <input 
                    type="text" 
                    id="e_nama_supplier" 
                    name="nama_supplier" 
                    value="{{ $supplier->nama_supplier }}" 
                    required 
                    maxlength="100" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: PT. Aneka Logam Jaya"
                >
            </div>
        </div>

        <!-- Row 2: Alamat Supplier -->
        <div>
            <label for="e_alamat_supplier" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                Alamat Kantor / Pabrik Supplier
            </label>
            <input 
                type="text" 
                id="e_alamat_supplier" 
                name="alamat_supplier" 
                value="{{ $supplier->alamat_supplier }}" 
                maxlength="255" 
                class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                placeholder="Contoh: Jl. Industri Raya No. 92-94, Tasikmalaya"
            >
        </div>
    </div>

    <!-- SECTION 2: KONTAK & REKENING PEMBAYARAN -->
    <div class="space-y-3 pt-2">
        <div class="flex items-center gap-2 pb-1 border-b border-slate-100 dark:border-slate-800">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200">Kontak Person & Rekening Pembayaran</h4>
        </div>

        <!-- Row 3: Contact Person & Telepon -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label for="e_contact_person" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Contact Person (PIC)
                </label>
                <input 
                    type="text" 
                    id="e_contact_person" 
                    name="contact_person" 
                    value="{{ $supplier->contact_person }}" 
                    maxlength="100" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: Bpk. Hendi / Ibu Rini"
                >
            </div>

            <div>
                <label for="e_no_hp_supplier" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Telepon / No HP
                </label>
                <input 
                    type="text" 
                    id="e_no_hp_supplier" 
                    name="no_hp_supplier" 
                    value="{{ $supplier->no_hp_supplier }}" 
                    maxlength="100" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: 08123456789 atau 0265-331519"
                >
            </div>
        </div>

        <!-- Row 4: Email & No Rekening -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label for="e_email_supplier" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Email Supplier
                </label>
                <input 
                    type="email" 
                    id="e_email_supplier" 
                    name="email_supplier" 
                    value="{{ $supplier->email_supplier }}" 
                    maxlength="255" 
                    class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: marketing@anekalogam.co.id"
                >
            </div>

            <div>
                <label for="e_no_rekening_supplier" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Nomor Rekening Bank
                </label>
                <input 
                    type="text" 
                    id="e_no_rekening_supplier" 
                    name="no_rekening_supplier" 
                    value="{{ $supplier->no_rekening_supplier }}" 
                    maxlength="30" 
                    class="block w-full px-3 py-2 text-xs font-mono font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 shadow-2xs" 
                    placeholder="Contoh: BCA 123456789 a.n PT Aneka Logam"
                >
            </div>
        </div>
    </div>

    <!-- Form Footer Actions -->
    <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100 dark:border-slate-800">
        <button 
            type="button" 
            onclick="closeModal('modalEdit')" 
            class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition cursor-pointer"
        >
            Batal
        </button>
        <button 
            type="submit" 
            class="inline-flex items-center gap-1.5 px-5 py-2 text-xs font-bold text-white bg-[#162a5b] hover:bg-[#1c3574] rounded-lg transition shadow-xs cursor-pointer"
        >
            <i data-lucide="check" class="w-3.5 h-3.5"></i>
            <span>Update Supplier</span>
        </button>
    </div>
</form>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
