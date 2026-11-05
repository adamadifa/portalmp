<form action="{{ route('produkharga.store') }}" method="POST" id="formCreateProdukHarga" class="space-y-3.5" novalidate>
    @csrf

    <div>
        <label for="kode_produk" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
            Pilih Produk <span class="text-rose-500">*</span>
        </label>
        <select 
            id="kode_produk" 
            name="kode_produk" 
            required 
            class="block w-full px-3 py-2 text-xs font-medium text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition cursor-pointer shadow-2xs"
        >
            <option value="">Pilih produk...</option>
            @foreach($produk as $p)
                <option value="{{ $p->kode_produk }}">{{ $p->nama_produk }} ({{ $p->kode_produk }})</option>
            @endforeach
        </select>
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
            onclick="closeModal('modalCreate')" 
            class="px-3.5 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg transition cursor-pointer flex items-center gap-1.5"
        >
            <i data-lucide="x" class="w-3.5 h-3.5"></i>
            <span>Batal</span>
        </button>
        <button 
            type="submit" 
            class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-[#162a5b] hover:bg-[#1f3a7a] rounded-lg transition shadow-xs cursor-pointer"
        >
            <i data-lucide="save" class="w-3.5 h-3.5"></i>
            <span>Simpan Harga</span>
        </button>
    </div>
</form>
