<form action="{{ route('produkharga.update', Crypt::encrypt($produkharga->kode_produk)) }}" method="POST" id="formEditProdukHarga" class="space-y-4" novalidate>
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Produk
        </label>
        <input type="text" value="{{ $produkharga->produk->nama_produk }} ({{ $produkharga->kode_produk }})" class="block w-full px-4 py-2 text-sm text-gray-400 bg-gray-100 border border-gray-200 rounded-lg focus:outline-none cursor-not-allowed" readonly>
    </div>

    <div>
        <label for="harga" class="block text-sm font-semibold text-gray-700 mb-1.5">
            Harga Beli (Rp) <span class="text-red-500">*</span>
        </label>
        <input type="text" id="harga" name="harga" value="{{ number_format($produkharga->harga, 0, ',', '.') }}" required class="money block w-full px-4 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition text-right placeholder-gray-400" placeholder="e.g. 150.000">
    </div>

    <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
        <button type="button" onclick="closeModal('modalEdit')" class="px-4 py-2 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</button>
        <button type="submit" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm">
            Update Harga
        </button>
    </div>
</form>
