<form action="{{ route('produkharga.update', Crypt::encrypt($produkharga->kode_produk)) }}" method="POST" id="formEditProdukHarga" class="space-y-3.5" novalidate>
    @csrf
    @method('PUT')

    <div>
        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1">
            Produk
        </label>
        <input 
            type="text" 
            value="{{ $produkharga->produk->nama_produk ?? $produkharga->nama_produk }} ({{ $produkharga->kode_produk }})" 
            disabled 
            class="block w-full px-3 py-2 text-xs font-semibold text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg focus:outline-none cursor-not-allowed shadow-2xs"
        >
    </div>

    <div>
        <label for="harga" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
            Harga Beli <span class="text-rose-500">*</span>
        </label>
        <div class="relative flex items-center">
            <span class="absolute left-3 text-xs font-bold text-slate-400 pointer-events-none">Rp</span>
            <input 
                type="text" 
                id="harga" 
                name="harga" 
                value="{{ number_format($produkharga->harga, 0, ',', '.') }}" 
                required 
                class="money block w-full pl-9 pr-3 py-2 text-xs font-semibold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition placeholder-slate-400 text-right shadow-2xs" 
                placeholder="Contoh: 150.000"
            >
        </div>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
        <button 
            type="button" 
            onclick="closeModal('modalEdit')" 
            class="px-3.5 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg transition cursor-pointer flex items-center gap-1.5"
        >
            <i data-lucide="x" class="w-3.5 h-3.5"></i>
            <span>Batal</span>
        </button>
        <button 
            type="submit" 
            class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-[#162a5b] hover:bg-[#1f3a7a] rounded-lg transition shadow-xs cursor-pointer"
        >
            <i data-lucide="check" class="w-3.5 h-3.5"></i>
            <span>Perbarui Harga</span>
        </button>
    </div>
</form>
