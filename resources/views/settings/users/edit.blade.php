<form action="{{ route('users.update', Crypt::encrypt($user->id)) }}" method="POST" id="formEditUser" class="space-y-4" novalidate>
    @csrf
    @method('PUT')
    <div>
        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
        <input type="text" id="name" name="name" value="{{ $user->name }}" required class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition placeholder-gray-400" placeholder="e.g. John Doe">
    </div>

    <div>
        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Email</label>
        <input type="email" id="email" name="email" value="{{ $user->email }}" required class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition placeholder-gray-400" placeholder="e.g. johndoe@company.com">
    </div>

    <div>
        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password <span class="text-xs text-gray-400 font-normal">(Kosongkan jika tidak ingin diubah)</span></label>
        <input type="password" id="password" name="password" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition placeholder-gray-400" placeholder="Minimal 8 karakter jika ingin diubah">
    </div>

    <div>
        <label for="role" class="block text-sm font-semibold text-gray-700 mb-1.5">Hak Akses / Role</label>
        <select id="role" name="role" required class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition placeholder-gray-400">
            <option value="">Pilih Role...</option>
            @foreach($roles as $role)
                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ ucwords($role->name) }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
        <button type="button" onclick="closeModal('modalEdit')" class="px-4 py-2 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</button>
        <button type="submit" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm">
            Update User
        </button>
    </div>
</form>
