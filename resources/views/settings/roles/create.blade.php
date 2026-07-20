<form action="{{ route('roles.store') }}" method="POST" id="formCreateRole" class="space-y-4" novalidate>
    @csrf
    <div>
        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Role</label>
        <input type="text" id="name" name="name" required class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition placeholder-gray-400" placeholder="e.g. administrator">
    </div>

    <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
        <button type="button" onclick="closeModal('modalCreate')" class="px-4 py-2 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</button>
        <button type="submit" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm">
            Simpan
        </button>
    </div>
</form>
