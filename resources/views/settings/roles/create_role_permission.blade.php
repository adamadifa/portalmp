<x-app-layout>
    <x-slot name="header">
        Role Permissions
    </x-slot>

    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Set Permissions</h2>
            <p class="text-sm text-gray-500 mt-1">Assign access permissions for the role: <span class="font-bold text-[#294C9A]">{{ ucwords($role->name) }}</span></p>
        </div>
        <div>
            <a href="{{ route('roles.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-700 bg-green-50 rounded-xl border border-green-200 flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('warning'))
        <div class="p-4 mb-6 text-sm text-yellow-700 bg-yellow-50 rounded-xl border border-yellow-200 flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            <span>{{ session('warning') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 mb-6 text-sm text-red-700 bg-red-50 rounded-xl border border-red-200 flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <form action="{{ route('roles.storerolepermission', Crypt::encrypt($role->id)) }}" method="POST">
        @csrf
        
        <!-- Sticky Save Action Panel -->
        <div class="sticky top-16 z-20 p-5 bg-white/90 backdrop-blur-md border border-gray-100 rounded-2xl shadow-sm mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#294C9A]/10 text-[#294C9A] flex items-center justify-center font-bold text-xl">
                    {{ strtoupper(substr($role->name, 0, 1)) }}
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900 capitalize">{{ $role->name }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Role ID: #{{ $role->id }} &bull; Guard: {{ $role->guard_name }}</p>
                </div>
            </div>
            <div>
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>

        <!-- Permissions Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($permissions as $d)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition">
                    <!-- Group Header -->
                    <div class="bg-gray-50/80 px-4 py-3.5 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-gray-50 to-white">
                        <span class="text-xs font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                            <svg class="w-4.5 h-4.5 text-[#294C9A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                            {{ $d['group_name'] }}
                        </span>
                        <div class="flex items-center">
                            <input type="checkbox" onchange="toggleGroup('{{ $d['id_permission_group'] }}', this)" class="w-4 h-4 rounded border-gray-300 text-[#294C9A] focus:ring-[#294C9A] cursor-pointer" title="Select all in group">
                        </div>
                    </div>

                    <!-- Group Options -->
                    <div class="p-4 space-y-2 flex-1">
                        @foreach ($d['permissions'] as $p)
                            @php
                                $isChecked = in_array($p->name, $rolepermissions);
                            @endphp
                            <label class="flex items-center gap-3 p-2 rounded-xl hover:bg-gray-50 cursor-pointer transition select-none">
                                <input type="checkbox" name="permission[]" value="{{ $p->name }}" id="p-{{ $p->id }}" class="permission-checkbox group-{{ $d['id_permission_group'] }} w-4 h-4 rounded border-gray-300 text-[#294C9A] focus:ring-[#294C9A] cursor-pointer" {{ $isChecked ? 'checked' : '' }}>
                                <span class="text-xs font-medium text-gray-700 capitalize">
                                    {{ str_replace('.', ' ', $p->name) }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </form>

    <script>
        function toggleGroup(groupId, selectAllEl) {
            const checkboxes = document.querySelectorAll('.group-' + groupId);
            checkboxes.forEach(cb => {
                cb.checked = selectAllEl.checked;
            });
        }
    </script>
</x-app-layout>
