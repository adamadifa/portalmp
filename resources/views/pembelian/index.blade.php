<x-app-layout>
    <x-slot name="header">
        Pembelian
    </x-slot>

    <!-- Alert Notifications -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonColor: '#294C9A'
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonColor: '#d33'
                });
            });
        </script>
    @endif

    <!-- Header & Navigation -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Data Pembelian</h2>
        <p class="text-sm text-gray-500 mt-1">Mengelola data transaksi pembelian barang dan klaim keuangan.</p>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-4">
        <form action="{{ route('pembelian.index') }}" method="GET" id="formSearch">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                <div class="md:col-span-4">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                        </span>
                        <input type="text" name="no_bukti_search" id="no_bukti_search" value="{{ Request('no_bukti_search') }}" class="fi" placeholder="No. Bukti Pembelian" autocomplete="off" />
                        <label for="no_bukti_search" class="c-fl-label">No. Bukti Pembelian</label>
                    </div>
                </div>

                <div class="md:col-span-4">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="text" name="dari" id="dari" value="{{ Request('dari') }}" class="fi flatpickr-date" placeholder="Dari Tanggal" autocomplete="off" />
                        <label for="dari" class="c-fl-label">Dari Tanggal</label>
                    </div>
                </div>

                <div class="md:col-span-4">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="text" name="sampai" id="sampai" value="{{ Request('sampai') }}" class="fi flatpickr-date" placeholder="Sampai Tanggal" autocomplete="off" />
                        <label for="sampai" class="c-fl-label">Sampai Tanggal</label>
                    </div>
                </div>

                @can('pembelian.harga')
                    <div class="md:col-span-6">
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </span>
                            <select name="kode_supplier_search" id="kode_supplier_search" class="fi select2Kodesupplier">
                                <option value="">Semua Supplier</option>
                                @foreach ($supplier as $d)
                                    <option value="{{ $d->kode_supplier }}" {{ Request('kode_supplier_search') == $d->kode_supplier ? 'selected' : '' }}>
                                        {{ strtoupper($d->nama_supplier) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2-2 4 4m0-7l3 3m-3-3l-3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></span >
                            <select name="ppn_search" id="ppn_search" class="fi">
                                <option value="">PPN / Non PPN</option>
                                <option value="1" {{ Request('ppn_search') == '1' ? 'selected' : '' }}>PPN</option>
                                <option value="0" {{ Request('ppn_search') === '0' ? 'selected' : '' }}>Non PPN</option>
                            </select>
                            <label for="ppn_search" class="c-fl-label">PPN / Non PPN</label>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </span>
                            <select name="jenis_transaksi_search" id="jenis_transaksi_search" class="fi">
                                <option value="">Tunai / Kredit</option>
                                <option value="T" {{ Request('jenis_transaksi_search') == 'T' ? 'selected' : '' }}>Tunai</option>
                                <option value="K" {{ Request('jenis_transaksi_search') == 'K' ? 'selected' : '' }}>Kredit</option>
                            </select>
                            <label for="jenis_transaksi_search" class="c-fl-label">Tunai / Kredit</label>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-1.5 h-[38px]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Cari
                        </button>
                    </div>
                @else
                    <div class="md:col-span-10">
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </span>
                            <select name="kode_supplier_search" id="kode_supplier_search" class="fi select2Kodesupplier">
                                <option value="">Semua Supplier</option>
                                @foreach ($supplier as $d)
                                    <option value="{{ $d->kode_supplier }}" {{ Request('kode_supplier_search') == $d->kode_supplier ? 'selected' : '' }}>
                                        {{ strtoupper($d->nama_supplier) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-1.5 h-[38px]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Cari
                        </button>
                    </div>
                @endcan
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
        <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gradient-to-r from-[#294C9A] to-[#1E3A70] text-white">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <h3 class="font-bold text-base">Data Transaksi Pembelian</h3>
            </div>
            @can('pembelian.create')
            <div class="flex items-center gap-2">
                <button type="button" onclick="toggleModalImport()" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition shadow-sm gap-1.5">
                    Import Excel
                </button>
                <button type="button" onclick="toggleModalImportPembayaran()" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-white bg-teal-600 rounded-xl hover:bg-teal-700 transition shadow-sm gap-1.5">
                    Import Pembayaran
                </button>
                <button type="button" onclick="resetPembelian()" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-white bg-red-600 rounded-xl hover:bg-red-700 transition shadow-sm gap-1.5">
                    Reset Pembelian
                </button>
                <a href="{{ route('pembelian.create') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-[#294C9A] bg-white rounded-xl hover:bg-gray-50 transition shadow-sm gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Input Pembelian
                </a>
            </div>
            @endcan
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-gray-600">
                <thead class="text-xs uppercase bg-gradient-to-r from-[#294C9A] to-[#1E3A70] text-white">
                    <tr>
                        <th class="px-4 py-3 font-bold">NO. BUKTI</th>
                        <th class="px-4 py-3 font-bold">TANGGAL</th>
                        <th class="px-4 py-3 font-bold">SUPPLIER</th>
                        @can('pembelian.harga')
                            <th class="px-4 py-3 font-bold text-end">TOTAL</th>
                            <th class="px-4 py-3 font-bold text-end">BAYAR</th>
                            <th class="px-4 py-3 font-bold text-center">PPN</th>
                            <th class="px-4 py-3 font-bold text-center">KB</th>
                            <th class="px-4 py-3 font-bold text-center">KET</th>
                            <th class="px-4 py-3 font-bold text-center">T/K</th>
                        @endcan
                        <th class="px-4 py-3 font-bold text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($pembelian as $d)
                        @php
                            $total = $d->subtotal + $d->penyesuaian_jk;
                        @endphp
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-4 py-3 font-bold text-[#294C9A] font-mono">{{ $d->no_bukti }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ formatIndo($d->tanggal) }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $d->nama_supplier }}</td>
                            @can('pembelian.harga')
                                <td class="px-4 py-3 text-end font-bold text-gray-900">{{ formatAngkaDesimal($total) }}</td>
                                <td class="px-4 py-3 text-end font-bold text-emerald-600">{{ formatAngkaDesimal($d->totalbayar) }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if ($d->ppn == '1')
                                        <svg class="w-4 h-4 text-emerald-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if ($d->cek_kontrabon > 0)
                                        <span class="px-1.5 py-0.5 text-[10px] font-semibold bg-emerald-50 text-emerald-700 rounded border border-emerald-200">KB</span>
                                    @else
                                        <span class="px-1.5 py-0.5 text-[10px] font-semibold bg-amber-50 text-amber-700 rounded border border-amber-200">KB</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if ($total == $d->totalbayar)
                                        <span class="px-1.5 py-0.5 text-[10px] font-semibold bg-green-100 text-green-800 rounded-full">Lunas</span>
                                    @else
                                        <span class="px-1.5 py-0.5 text-[10px] font-semibold bg-red-100 text-red-800 rounded-full">Belum Lunas</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2 py-0.5 text-[10px] font-semibold rounded-md {{ $d->jenis_transaksi == 'T' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                        {{ $d->jenis_transaksi == 'T' ? 'Tunai' : 'Kredit' }}
                                    </span>
                                </td>
                            @endcan
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @can('pembelian.edit')
                                        <a href="{{ route('pembelian.edit', Crypt::encrypt($d->no_bukti)) }}" class="p-1 text-emerald-600 hover:text-emerald-800 transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                    @endcan
                                    @can('pembelian.show')
                                        <button type="button" class="btnShow p-1 text-sky-600 hover:text-sky-800 transition" no_bukti="{{ Crypt::encrypt($d->no_bukti) }}" title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                        <a href="{{ route('pembelian.cetak', Crypt::encrypt($d->no_bukti)) }}" target="_blank" class="p-1 text-violet-600 hover:text-violet-800 transition" title="Cetak Claim">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        </a>
                                    @endcan
                                    @can('pembelian.delete')
                                        <form method="POST" action="{{ route('pembelian.delete', Crypt::encrypt($d->no_bukti)) }}" class="inline deleteform">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 text-red-600 hover:text-red-800 transition delete-confirm" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    @endcan
                                    @can('pembelian.approvegdl')
                                        @if ($d->kode_asal_pengajuan == 'GDL')
                                            @if (empty($d->no_bukti_gdl))
                                                <button type="button" class="btnApprovegdl p-1 text-emerald-600 hover:text-emerald-800 transition" no_bukti="{{ Crypt::encrypt($d->no_bukti) }}" title="Approve GDL">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </button>
                                            @else
                                                <form method="POST" action="{{ route('pembelian.cancelapprovegdl', Crypt::encrypt($d->no_bukti)) }}" class="inline deleteform">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1 text-red-600 hover:text-red-850 transition cancel-confirm" title="Cancel GDL">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    @endcan
                                    @can('pembelian.approvemtc')
                                        @if ($d->kode_asal_pengajuan == 'GAF' && $d->cekmaintenance > 0)
                                            @if (empty($d->no_bukti_mtc))
                                                <button type="button" class="btnApprovemtc p-1 text-amber-600 hover:text-amber-800 transition" no_bukti="{{ Crypt::encrypt($d->no_bukti) }}" title="Approve MTC">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </button>
                                            @else
                                                <form method="POST" action="{{ route('pembelian.cancelapprovemtc', Crypt::encrypt($d->no_bukti)) }}" class="inline deleteform">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1 text-red-600 hover:text-red-850 transition cancel-confirm" title="Cancel MTC">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-4 py-8 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                Data Transaksi Pembelian tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-gray-100">
            {{ $pembelian->links() }}
        </div>
    </div>

    <!-- Modal Dialog -->
    <div id="modalDialog" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="relative w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-[#294C9A] text-white flex justify-between items-center">
                <h3 id="modalTitle" class="text-base font-bold">Modal Title</h3>
                <button type="button" onclick="closeModal()" class="text-white/80 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <!-- Modal Body -->
            <div id="modalBody" class="p-6 max-h-[80vh] overflow-y-auto">
                <div class="flex items-center justify-center py-8">
                    <svg class="w-8 h-8 text-[#294C9A] animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import Excel -->
    <div id="modalImport" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/40 backdrop-blur-sm overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 overflow-hidden border border-gray-100">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gradient-to-r from-[#294C9A] to-[#1E3A70] text-white">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    <h3 class="font-bold text-base text-white">Import Pembelian Excel</h3>
                </div>
                <button type="button" class="btn-close-modal text-white hover:text-gray-200 transition" onclick="toggleModalImport()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('pembelian.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pilih File Excel (.xlsx, .xls, .csv)</label>
                    <input type="file" id="file_excel" name="file_excel" accept=".xlsx,.xls,.csv" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#294C9A] hover:file:bg-blue-100 transition border border-gray-200 rounded-xl p-2" />
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pilih Sheet</label>
                    <select name="sheet_name" id="import_sheet_name" class="w-full text-sm border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 p-2.5">
                        <option value="">-- Unggah File Excel Dahulu --</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Jenis Transaksi</label>
                    <select name="jenis_transaksi" class="w-full text-sm border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 p-2.5" required>
                        <option value="K">Kredit (Tempo)</option>
                        <option value="T">Tunai (Cash)</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" class="px-4 py-2 text-xs font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition" onclick="toggleModalImport()">Batal</button>
                    <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-[#294C9A] rounded-xl hover:bg-[#1E3A70] transition shadow-sm">Proses Import</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Import Pembayaran Excel -->
    <div id="modalImportPembayaran" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/40 backdrop-blur-sm overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 overflow-hidden border border-gray-100">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gradient-to-r from-teal-600 to-teal-800 text-white">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    <h3 class="font-bold text-base text-white">Import Pembayaran Excel</h3>
                </div>
                <button type="button" class="btn-close-modal text-white hover:text-gray-200 transition" onclick="toggleModalImportPembayaran()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('pembelian.importpembayaran') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pilih File Excel (.xlsx, .xls, .csv)</label>
                    <input type="file" id="file_excel_pembayaran" name="file_excel" accept=".xlsx,.xls,.csv" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#294C9A] hover:file:bg-blue-100 transition border border-gray-200 rounded-xl p-2" />
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pilih Sheet</label>
                    <select name="sheet_name" id="import_sheet_name_pembayaran" class="w-full text-sm border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 p-2.5">
                        <option value="">-- Unggah File Excel Dahulu --</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" class="px-4 py-2 text-xs font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition" onclick="toggleModalImportPembayaran()">Batal</button>
                    <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-teal-600 hover:bg-teal-700 transition shadow-sm">Proses Import</button>
                </div>
            </form>
        </div>
    </div>

@push('myscript')
<script>
    function openModal(title, url) {
        $("#modalTitle").text(title);
        $("#modalBody").html(`
            <div class="flex items-center justify-center py-8">
                <svg class="w-8 h-8 text-[#294C9A] animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </div>
        `);
        $("#modalDialog").removeClass("hidden");
        $("#modalBody").load(url);
    }

    function closeModal() {
        $("#modalDialog").addClass("hidden");
    }

    // Modal Import Excel functions
    window.toggleModalImport = function() {
        $('#modalImport').toggleClass('hidden');
    }

    window.toggleModalImportPembayaran = function() {
        $('#modalImportPembayaran').toggleClass('hidden');
    }

    $('#file_excel_pembayaran').change(function() {
        var file = this.files[0];
        if (!file) return;

        var formData = new FormData();
        formData.append('file_excel', file);
        formData.append('_token', '{{ csrf_token() }}');

        $('#import_sheet_name_pembayaran').html('<option value="">Sedang membaca sheet...</option>');

        $.ajax({
            url: '{{ route("pembelian.getsheets") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    var options = '<option value="">-- Pilih Sheet / Deteksi Otomatis --</option>';
                    response.sheets.forEach(function(sheetName) {
                        options += '<option value="' + sheetName + '">' + sheetName + '</option>';
                    });
                    $('#import_sheet_name_pembayaran').html(options);
                } else {
                    $('#import_sheet_name_pembayaran').html('<option value="">Gagal membaca sheet: ' + response.message + '</option>');
                }
            },
            error: function() {
                $('#import_sheet_name_pembayaran').html('<option value="">Gagal menghubungi server</option>');
            }
        });
    });

    $('#file_excel').change(function() {
        var file = this.files[0];
        if (!file) return;

        var formData = new FormData();
        formData.append('file_excel', file);
        formData.append('_token', '{{ csrf_token() }}');

        $('#import_sheet_name').html('<option value="">Sedang membaca sheet...</option>');

        $.ajax({
            url: '{{ route("pembelian.getsheets") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    var options = '<option value="">-- Pilih Sheet / Deteksi Otomatis --</option>';
                    response.sheets.forEach(function(sheetName) {
                        options += '<option value="' + sheetName + '">' + sheetName + '</option>';
                    });
                    $('#import_sheet_name').html(options);
                } else {
                    $('#import_sheet_name').html('<option value="">Gagal membaca sheet: ' + response.message + '</option>');
                }
            },
            error: function() {
                $('#import_sheet_name').html('<option value="">Gagal menghubungi server</option>');
            }
        });
    });

    // SweetAlert2 Reset Pembelian Confirmation
    window.resetPembelian = function() {
        Swal.fire({
            title: 'Reset Semua Pembelian?',
            text: "Seluruh data transaksi pembelian, item detail, kontrabon, histori pembayaran, cost ratio, serta barang masuk logistik & maintenance terkait akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Reset Semua!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $('<form>', {
                    'method': 'POST',
                    'action': '{{ route("pembelian.reset") }}'
                });
                form.append($('<input>', {
                    'name': '_token',
                    'value': $('meta[name="csrf-token"]').attr('content'),
                    'type': 'hidden'
                }));
                $('body').append(form);
                form.submit();
            }
        });
    };

    $(function() {
        const select2Kodesupplier = $('.select2Kodesupplier');
        if (select2Kodesupplier.length) {
            select2Kodesupplier.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Semua Supplier',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }

        $(".btnShow").click(function(e) {
            e.preventDefault();
            var no_bukti = $(this).attr("no_bukti");
            openModal("Detail Pembelian", `/pembelian/${no_bukti}/show`);
        });

        $(".btnApprovegdl").click(function(e) {
            e.preventDefault();
            var no_bukti = $(this).attr("no_bukti");
            openModal("Approve Penerimaan Gudang Logistik", `/pembelian/${no_bukti}/approvegdl`);
        });

        $(".btnApprovemtc").click(function(e) {
            e.preventDefault();
            var no_bukti = $(this).attr("no_bukti");
            openModal("Approve Penerimaan Maintenance", `/pembelian/${no_bukti}/approvemtc`);
        });

        $(document).on('click', '.delete-confirm, .cancel-confirm', function(e) {
            var form = $(this).closest("form");
            e.preventDefault();
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Tindakan ini tidak dapat dibatalkan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Lanjutkan!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
</x-app-layout>
