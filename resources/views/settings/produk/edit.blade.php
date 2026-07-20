<form action="{{ route('produk.update', Crypt::encrypt($produk->kode_produk)) }}" method="POST" id="formEditProduk" class="space-y-4" novalidate>
    @csrf
    @method('PUT')
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-semibold text-gray-500 mb-1.5">Kode Produk</label>
            <input type="text" value="{{ $produk->kode_produk }}" disabled class="block w-full px-4 py-2 text-sm text-gray-400 bg-gray-100 border border-gray-200 rounded-lg focus:outline-none cursor-not-allowed">
        </div>
        <div>
            <label for="nama_produk" class="block text-sm font-semibold text-gray-700 mb-1.5">
                Nama Produk <span class="text-red-500">*</span>
            </label>
            <input type="text" id="nama_produk" name="nama_produk" value="{{ $produk->nama_produk }}" required maxlength="30" class="block w-full px-4 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition placeholder-gray-400" placeholder="e.g. Pacific Gold">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="satuan" class="block text-sm font-semibold text-gray-700 mb-1.5">
                Satuan <span class="text-red-500">*</span>
            </label>
            <input type="text" id="satuan" name="satuan" value="{{ $produk->satuan }}" required maxlength="4" class="block w-full px-4 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition placeholder-gray-400" placeholder="e.g. DUS">
        </div>
        <div>
            <label for="urutan" class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan</label>
            <input type="number" id="urutan" name="urutan" value="{{ $produk->urutan }}" class="block w-full px-4 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition placeholder-gray-400" placeholder="e.g. 1">
        </div>
    </div>

    <div class="grid grid-cols-3 gap-2 bg-gray-50 p-3 rounded-lg border border-gray-100">
        <div>
            <label for="isi_pcs_dus" class="block text-xs font-bold text-gray-600 mb-1">
                Isi Pcs/Dus <span class="text-red-500">*</span>
            </label>
            <input type="number" id="isi_pcs_dus" name="isi_pcs_dus" value="{{ $produk->isi_pcs_dus }}" required class="block w-full px-3 py-1.5 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition">
        </div>
        <div>
            <label for="isi_pack_dus" class="block text-xs font-bold text-gray-600 mb-1">
                Isi Pack/Dus <span class="text-red-500">*</span>
            </label>
            <input type="number" id="isi_pack_dus" name="isi_pack_dus" value="{{ $produk->isi_pack_dus }}" required class="block w-full px-3 py-1.5 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition">
        </div>
        <div>
            <label for="isi_pcs_pack" class="block text-xs font-bold text-gray-600 mb-1">
                Isi Pcs/Pack <span class="text-red-500">*</span>
            </label>
            <input type="number" id="isi_pcs_pack" name="isi_pcs_pack" value="{{ $produk->isi_pcs_pack }}" required class="block w-full px-3 py-1.5 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="kode_kategori_produk" class="block text-sm font-semibold text-gray-700 mb-1.5">
                Kategori Produk <span class="text-red-500">*</span>
            </label>
            <select id="kode_kategori_produk" name="kode_kategori_produk" required class="block w-full px-4 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition">
                <option value="">Pilih Kategori...</option>
                @foreach($kategori as $kat)
                    <option value="{{ $kat->kode_kategori_produk }}" {{ $produk->kode_kategori_produk == $kat->kode_kategori_produk ? 'selected' : '' }}>{{ $kat->nama_kategori_produk }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="kode_jenis_produk" class="block text-sm font-semibold text-gray-700 mb-1.5">
                Jenis Produk <span class="text-red-500">*</span>
            </label>
            <select id="kode_jenis_produk" name="kode_jenis_produk" required class="block w-full px-4 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition">
                <option value="">Pilih Jenis...</option>
                @foreach($jenis as $jen)
                    <option value="{{ $jen->kode_jenis_produk }}" {{ $produk->kode_jenis_produk == $jen->kode_jenis_produk ? 'selected' : '' }}>{{ $jen->nama_jenis_produk }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label for="status_aktif_produk" class="block text-sm font-semibold text-gray-700 mb-1.5">
            Status Aktif <span class="text-red-500">*</span>
        </label>
        <select id="status_aktif_produk" name="status_aktif_produk" required class="block w-full px-4 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition">
            <option value="1" {{ $produk->status_aktif_produk == '1' ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ $produk->status_aktif_produk == '0' ? 'selected' : '' }}>Non-Aktif</option>
        </select>
    </div>

    <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
        <button type="button" onclick="closeModal('modalEdit')" class="px-4 py-2 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</button>
        <button type="submit" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm">
            Update Produk
        </button>
    </div>
</form>
