<x-app-layout>
    <x-slot name="header">
        Chart of Accounts (COA)
    </x-slot>

    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Chart of Accounts (COA)</h2>
            <p class="text-sm text-gray-500 mt-1">Daftar kode perkiraan akuntansi (COA) untuk pencatatan transaksi keuangan.</p>
        </div>
        <!-- Breadcrumbs -->
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 text-xs font-semibold text-gray-500">
                <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center hover:text-gray-700">
                        <svg class="w-3 h-3 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        Accounting
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3.5 h-3.5 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-[#294C9A] font-semibold">COA</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Compact Container -->
    <div class="max-w-4xl">
        <!-- Filter -->
        <div class="mb-4">
            <form action="{{ route('coa.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2 w-full">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="nama_akun" value="{{ request('nama_akun') }}" class="block w-full py-3 pl-9 pr-4 text-xs text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition placeholder-gray-400 shadow-sm" placeholder="Cari Kode atau Nama Akun...">
                </div>
                <div>
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-8">
            <div class="bg-[#294C9A] px-6 py-4 flex items-center justify-between border-b border-white/10">
                <div class="flex items-center gap-2 text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <h3 class="text-sm font-semibold">Buku Daftar Akun (Chart of Accounts)</h3>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs font-semibold uppercase tracking-wider bg-[#294C9A] text-white">
                            <th class="py-3 px-6" style="width: 25%;">Kode Akun</th>
                            <th class="py-3 px-6">Nama Akun</th>
                            <th class="py-3 px-6 text-center" style="width: 15%;">Level</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        @forelse ($coa as $d)
                            @php
                                // Set padding based on indentation level
                                $paddingLeft = 'ps-6';
                                if ($d->level == 2) {
                                    $paddingLeft = 'ps-10';
                                } elseif ($d->level == 3) {
                                    $paddingLeft = 'ps-16';
                                } elseif ($d->level == 4) {
                                    $paddingLeft = 'ps-20';
                                } elseif ($d->level >= 5) {
                                    $paddingLeft = 'ps-24';
                                }
                            @endphp
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100/50 transition-colors">
                                <td class="py-2.5 px-6 font-mono text-xs font-bold text-[#294C9A]">
                                    {{ $d->kode_akun }}
                                </td>
                                <td class="py-2.5 px-6 {{ $paddingLeft }} font-medium text-gray-900">
                                    @if($d->level == 1)
                                        <span class="font-bold text-gray-900 uppercase">{{ $d->nama_akun }}</span>
                                    @elseif($d->level == 2)
                                        <span class="font-semibold text-gray-800">{{ $d->nama_akun }}</span>
                                    @else
                                        <span class="text-gray-600">{{ $d->nama_akun }}</span>
                                    @endif
                                </td>
                                <td class="py-2.5 px-6 text-center">
                                    <span class="px-2 py-0.5 text-[10px] font-semibold rounded-md border
                                        @if($d->level == 1)
                                            bg-blue-50 text-blue-700 border-blue-200
                                        @elseif($d->level == 2)
                                            bg-emerald-50 text-emerald-700 border-emerald-200
                                        @else
                                            bg-gray-50 text-gray-700 border-gray-200
                                        @endif">
                                        Lvl {{ $d->level }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-12 px-6 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        <span>Belum ada data Chart of Accounts.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
