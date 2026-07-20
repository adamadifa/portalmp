<x-app-layout>
    <x-slot name="header">
        Roles & Permissions
    </x-slot>

    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">System Roles</h2>
            <p class="text-sm text-gray-500 mt-1">Manage system security levels, user roles, and access controls.</p>
        </div>
        <!-- Breadcrumbs -->
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 text-xs font-semibold text-gray-500">
                <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center hover:text-gray-700">
                        <svg class="w-3 h-3 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                        Settings
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3.5 h-3.5 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-[#294C9A] font-semibold">Roles</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#294C9A'
                });
            });
        </script>
    @endif

    <!-- Filter -->
    <div class="mb-4">
        <form action="{{ route('roles.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2 w-full">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="name" value="{{ request('name') }}" class="block w-full py-3 pl-9 pr-4 text-xs text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition placeholder-gray-400 shadow-sm" placeholder="Cari Role...">
            </div>
            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                Cari
            </button>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <!-- Card Header -->
            <div class="bg-[#294C9A] px-6 py-4 flex items-center justify-between border-b border-white/10">
                <div class="flex items-center gap-2 text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <h3 class="text-sm font-semibold">Data Roles</h3>
                </div>
                <button onclick="openModalCreate()" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-[#294C9A] bg-white rounded-lg hover:bg-gray-50 transition shadow-sm">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs font-semibold uppercase tracking-wider bg-[#294C9A] text-white">
                            <th class="py-2 px-4" style="width: 8%;">No.</th>
                            <th class="py-2 px-4" style="width: 15%;">Role ID</th>
                            <th class="py-2 px-4">Role Name</th>
                            <th class="py-2 px-4">Guard</th>
                            <th class="py-2 px-4 text-center" style="width: 18%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        @forelse ($roles as $d)
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100/50 transition-colors">
                                <td class="py-1.5 px-4 text-gray-500">
                                    {{ $loop->iteration + ($roles->currentPage() - 1) * $roles->perPage() }}
                                </td>
                                <td class="py-1.5 px-4 font-mono text-xs text-gray-400">
                                    #{{ $d->id }}
                                </td>
                                <td class="py-1.5 px-4">
                                    <span class="font-semibold text-gray-900 block capitalize">{{ $d->name }}</span>
                                </td>
                                <td class="py-1.5 px-4">
                                    <span class="px-2 py-0.5 text-xs font-semibold text-blue-700 bg-blue-50 border border-blue-100 rounded-lg">
                                        {{ $d->guard_name }}
                                    </span>
                                </td>
                                <td class="py-1.5 px-4">
                                    <div class="flex items-center justify-center gap-3.5">
                                        <!-- Set Permissions -->
                                        <a href="{{ route('roles.createrolepermission', Crypt::encrypt($d->id)) }}" class="text-[#294C9A] hover:text-[#1E3A70] p-1.5 hover:bg-[#294C9A]/5 rounded-lg transition" title="Config Permissions">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                        </a>
                                        <!-- Edit -->
                                        <button onclick="openModalEdit('{{ $d->id }}')" class="text-emerald-600 hover:text-emerald-900 p-1.5 hover:bg-emerald-50 rounded-lg transition" title="Edit Role">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <!-- Delete -->
                                        <button type="button" class="btn-delete text-red-600 hover:text-red-950 p-1.5 hover:bg-red-50 rounded-lg transition" data-id="{{ Crypt::encrypt($d->id) }}" data-name="{{ $d->name }}" title="Delete Role">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 px-6 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        <span>No roles registered in the system.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($roles->hasPages())
                <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $roles->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Create -->
    <div id="modalCreate" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-xl w-full max-w-md overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalCreateContentWrapper">
            <div class="bg-[#294C9A] px-6 py-4 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-white">Tambah Role</h3>
                <button onclick="closeModal('modalCreate')" class="text-white/80 hover:text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div id="loadCreateContent" class="p-6">
                <!-- Loader -->
                <div class="flex items-center justify-center py-6">
                    <svg class="animate-spin h-6 w-6 text-[#294C9A]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="modalEdit" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-xl w-full max-w-md overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalEditContentWrapper">
            <div class="bg-[#294C9A] px-6 py-4 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-white">Edit Role</h3>
                <button onclick="closeModal('modalEdit')" class="text-white/80 hover:text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div id="loadEditContent" class="p-6">
                <!-- Loader -->
                <div class="flex items-center justify-center py-6">
                    <svg class="animate-spin h-6 w-6 text-[#294C9A]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    @push('myscript')
        <script>
            function openModal(id) {
                const modal = document.getElementById(id);
                const wrapper = document.getElementById(id + 'ContentWrapper');
                modal.classList.remove('hidden');
                setTimeout(() => {
                    wrapper.classList.remove('scale-95', 'opacity-0');
                    wrapper.classList.add('scale-100', 'opacity-100');
                }, 50);
            }

            function closeModal(id) {
                const modal = document.getElementById(id);
                const wrapper = document.getElementById(id + 'ContentWrapper');
                wrapper.classList.remove('scale-100', 'opacity-100');
                wrapper.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }

            function initFormValidation(formSelector) {
                const form = $(formSelector);
                const input = form.find('input[name="name"]');
                
                function validateInput() {
                    const value = input.val().trim();
                    let isValid = true;
                    let errorMsg = '';
                    
                    if (value === '') {
                        isValid = false;
                        errorMsg = 'Nama role tidak boleh kosong.';
                    }
                    
                    // Remove existing error message
                    form.find('.error-msg').remove();
                    
                    if (!isValid) {
                        input.removeClass('border-gray-200 focus:ring-[#294C9A] focus:border-[#294C9A]')
                             .addClass('border-red-500 focus:ring-red-500 focus:border-red-500');
                        input.after('<p class="text-xs text-red-500 mt-1.5 error-msg">' + errorMsg + '</p>');
                    } else {
                        input.removeClass('border-red-500 focus:ring-red-500 focus:border-red-500')
                             .addClass('border-gray-200 focus:ring-[#294C9A] focus:border-[#294C9A]');
                    }
                    return isValid;
                }
                
                // Realtime validation
                input.on('keyup input blur', function() {
                    validateInput();
                });
                
                // Validate on submit
                form.on('submit', function(e) {
                    if (!validateInput()) {
                        e.preventDefault();
                    }
                });
            }

            function openModalCreate() {
                openModal('modalCreate');
                $('#loadCreateContent').load('/roles/create', function() {
                    initFormValidation('#formCreateRole');
                });
            }

            function openModalEdit(id) {
                openModal('modalEdit');
                $('#loadEditContent').load('/roles/' + id + '/edit', function() {
                    initFormValidation('#formEditRole');
                });
            }

            // SweetAlert2 Delete Confirmation
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var name = $(this).data('name');
                
                Swal.fire({
                    title: 'Hapus Role?',
                    text: "Apakah Anda yakin ingin menghapus role '" + name + "'? Akses pengguna terkait mungkin terpengaruh.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#294C9A',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $('<form>', {
                            'method': 'POST',
                            'action': '/roles/' + id
                        });
                        form.append($('<input>', {
                            'name': '_token',
                            'value': $('meta[name="csrf-token"]').attr('content'),
                            'type': 'hidden'
                        }));
                        form.append($('<input>', {
                            'name': '_method',
                            'value': 'DELETE',
                            'type': 'hidden'
                        }));
                        $('body').append(form);
                        form.submit();
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
