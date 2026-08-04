<form action="{{ route('produkharga.store') }}" method="POST" id="formCreateProdukHarga" class="space-y-4" novalidate>
    @csrf
    <div>
        <label for="kode_produk" class="block text-sm font-semibold text-gray-700 mb-1.5">
            Pilih Produk <span class="text-red-500">*</span>
        </label>
        <select id="kode_produk" name="kode_produk" required class="block w-full px-4 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition">
            <option value="">Pilih Produk...</option>
            @foreach($produk as $p)
                <option value="{{ $p->kode_produk }}">{{ $p->nama_produk }} ({{ $p->kode_produk }})</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="harga" class="block text-sm font-semibold text-gray-700 mb-1.5">
            Harga Beli (Rp) <span class="text-red-500">*</span>
        </label>
        <input type="text" id="harga" name="harga" required class="money block w-full px-4 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition text-right placeholder-gray-400" placeholder="e.g. 150.000">
    </div>

    <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
        <button type="button" onclick="closeModal('modalCreate')" class="px-4 py-2 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</button>
        <button type="submit" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm">
            Simpan Harga
        </button>
    </div>
</form>
