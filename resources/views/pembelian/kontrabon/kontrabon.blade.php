<div class="space-y-6">
        <!-- Search Form Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <form action="{{ request()->url() }}" id="formSearch" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <!-- Dari Tanggal -->
                <div class="md:col-span-2">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="text" name="dari" id="dari" value="{{ Request('dari') }}" class="fi flatpickr-date" placeholder="Dari Tanggal" autocomplete="off" />
                        <label for="dari" class="c-fl-label">Dari Tanggal</label>
                    </div>
                </div>

                <!-- Sampai Tanggal -->
                <div class="md:col-span-2">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="text" name="sampai" id="sampai" value="{{ Request('sampai') }}" class="fi flatpickr-date" placeholder="Sampai Tanggal" autocomplete="off" />
                        <label for="sampai" class="c-fl-label">Sampai Tanggal</label>
                    </div>
                </div>

                <!-- Supplier Select2 -->
                <div class="md:col-span-3">
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

                <!-- Status Proses -->
                <div class="md:col-span-2">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                        <select name="status_search" id="status_search" class="fi">
                            <option value="">Status Proses</option>
                            <option value="SP" {{ Request('status_search') == 'SP' ? 'selected' : '' }}>Sudah di Proses</option>
                            <option value="BP" {{ Request('status_search') === 'BP' ? 'selected' : '' }}>Belum di Proses</option>
                        </select>
                        <label for="status_search" class="c-fl-label">Status Proses</label>
                    </div>
                </div>

                <!-- Jenis Pengajuan -->
                <div class="md:col-span-2">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </span>
                        <select name="kategori_search" id="kategori_search" class="fi">
                            <option value="">Jenis Pengajuan</option>
                            <option {{ Request('kategori_search') == 'KB' ? 'selected' : '' }} value="KB">Kontra BON</option>
                            <option {{ Request('kategori_search') == 'IM' ? 'selected' : '' }} value="IM">Internal Memo</option>
                            <option {{ Request('kategori_search') == 'TN' ? 'selected' : '' }} value="TN">Tunai</option>
                        </select>
                        <label for="kategori_search" class="c-fl-label">Jenis Pengajuan</label>
                    </div>
                </div>

                <!-- Cari Button -->
                <div class="md:col-span-1">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-1.5 h-[38px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
        <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gradient-to-r from-[#294C9A] to-[#1E3A70] text-white">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <h3 class="font-bold text-base">Data Kontra Bon</h3>
            </div>
            @can('kontrabonpmb.create')
            <a href="{{ route('kontrabonpmb.create') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-[#294C9A] bg-white rounded-xl hover:bg-gray-50 transition shadow-sm gap-1.5" id="btnCreate">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Kontra Bon
            </a>
            @endcan
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-gray-600">
                <thead class="text-xs uppercase bg-gradient-to-r from-[#294C9A] to-[#1E3A70] text-white">
                    <tr>
                        <th class="px-4 py-3 font-bold">No. Kontra BON</th>
                        <th class="px-4 py-3 font-bold">No Dok</th>
                        <th class="px-4 py-3 font-bold">Tanggal</th>
                        <th class="px-4 py-3 font-bold">Supplier</th>
                        <th class="px-4 py-3 font-bold text-center">Kategori</th>
                        <th class="px-4 py-3 font-bold text-end">Total Bayar</th>
                        <th class="px-4 py-3 font-bold text-center">Status Bayar</th>
                        <th class="px-4 py-3 font-bold text-center">Jenis Bayar</th>
                        <th class="px-4 py-3 font-bold text-center">Status</th>
                        <th class="px-4 py-3 font-bold text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($kontrabon as $d)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-4 py-3 font-bold text-[#294C9A] font-mono">{{ $d->no_kontrabon }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $d->no_dokumen }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ formatIndo($d->tanggal) }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $d->nama_supplier }}</td>
                            <td class="px-4 py-3 text-center">
                                @if ($d->kategori == 'TN')
                                    <span class="px-2 py-0.5 text-[10px] font-bold bg-emerald-50 text-emerald-700 rounded-md border border-emerald-250">Tunai</span>
                                @elseif ($d->kategori == 'KB')
                                    <span class="px-2 py-0.5 text-[10px] font-bold bg-blue-50 text-blue-700 rounded-md border border-blue-250">Kontra Bon</span>
                                @elseif ($d->kategori == 'IM')
                                    <span class="px-2 py-0.5 text-[10px] font-bold bg-cyan-50 text-cyan-700 rounded-md border border-cyan-250">Internal Memo</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-end font-bold text-gray-900">{{ formatAngkaDesimal($d->jumlah) }}</td>
                            <td class="px-4 py-3 text-center">
                                @if (empty($d->tglbayar))
                                    <span class="px-2 py-0.5 text-[10px] font-bold bg-rose-50 text-rose-700 rounded-md border border-rose-250">Belum Bayar</span>
                                @else
                                    <span class="px-2 py-0.5 text-[10px] font-bold bg-emerald-50 text-emerald-700 rounded-md border border-emerald-250">{{ formatIndo($d->tglbayar) }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-0.5 text-[10px] font-bold {{ $d->jenis_bayar == 'TN' ? 'bg-cyan-50 text-cyan-700 border-cyan-200' : 'bg-gray-50 text-gray-700 border-gray-200' }} rounded-md border">
                                    {{ $d->jenis_bayar == 'TN' ? 'Tunai' : 'Transfer' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if ($d->status == 1)
                                    @if (!empty($d->tglbayar))
                                        <span class="px-2 py-0.5 text-[10px] font-bold bg-emerald-50 text-emerald-700 rounded-md border border-emerald-250">Selesai ({{ $d->nama_bank }})</span>
                                    @else
                                        <span class="px-2 py-0.5 text-[10px] font-bold bg-blue-50 text-blue-700 rounded-md border border-blue-250">Approved</span>
                                    @endif
                                @else
                                    @if (!empty($d->tglbayar))
                                        <span class="px-2 py-0.5 text-[10px] font-bold bg-emerald-50 text-emerald-700 rounded-md border border-emerald-250">Selesai ({{ $d->nama_bank }})</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-amber-600 font-bold" title="Menunggu Approval">
                                            <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Pending
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @can('kontrabonpmb.show')
                                        <a href="{{ route('kontrabonpmb.cetak', Crypt::encrypt($d->no_kontrabon)) }}" target="_blank" class="p-1 text-gray-400 hover:text-[#294C9A] transition" title="Cetak">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        </a>
                                        <button no_kontrabon="{{ Crypt::encrypt($d->no_kontrabon) }}" class="btnShow p-1 text-gray-400 hover:text-cyan-600 transition" title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </button>
                                    @endcan
                                    @can('kontrabonpmb.edit')
                                        @if ($d->kategori != 'TN' && $d->status === '0')
                                            <a href="{{ route('kontrabonpmb.edit', Crypt::encrypt($d->no_kontrabon)) }}" class="p-1 text-gray-400 hover:text-emerald-600 transition" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                        @endif
                                    @endcan
                                    @can('kontrabonpmb.approve')
                                        @if ($d->kategori != 'TN')
                                            @if ($d->status === '0')
                                                <a href="{{ route('kontrabonpmb.approve', Crypt::encrypt($d->no_kontrabon)) }}" class="p-1 text-gray-400 hover:text-emerald-600 transition" title="Approve">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </a>
                                            @elseif (empty($d->tglbayar))
                                                <a href="{{ route('kontrabonpmb.cancel', Crypt::encrypt($d->no_kontrabon)) }}" class="p-1 text-gray-400 hover:text-rose-600 transition" title="Batalkan Approval">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </a>
                                            @endif
                                        @endif
                                    @endcan
                                    @can('kontrabonpmb.proses')
                                        @if (($d->status === '1' && $d->kategori != 'TN' && empty($d->tglbayar)) || ($d->status === '0' && $d->kategori == 'TN' && empty($d->tglbayar)))
                                            <button no_kontrabon="{{ Crypt::encrypt($d->no_kontrabon) }}" class="btnProses p-1 text-gray-400 hover:text-amber-600 transition" title="Proses Bayar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7M3 17V7"></path></svg>
                                            </button>
                                        @elseif (($d->status === '1' && $d->kategori != 'TN' && !empty($d->tglbayar)) || ($d->status === '0' && $d->kategori == 'TN' && !empty($d->tglbayar)))
                                            <form method="POST" name="deleteform" class="deleteform inline" action="{{ route('kontrabonpmb.cancelproses', Crypt::encrypt($d->no_kontrabon)) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="cancel-confirm p-1 text-gray-400 hover:text-rose-650 transition" title="Batalkan Proses">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        @endif
                                    @endcan
                                    @can('kontrabonpmb.delete')
                                        @if ($d->kategori != 'TN' && $d->status === '0')
                                            <form method="POST" name="deleteform" class="deleteform inline" action="{{ route('kontrabonpmb.delete', Crypt::encrypt($d->no_kontrabon)) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-confirm p-1 text-gray-400 hover:text-rose-600 transition" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
            {{ $kontrabon->links() }}
        </div>
    </div>
</div>

    <!-- Modal Dialog -->
    <div id="modalDialog" class="fixed inset-0 z-[9999] hidden overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="relative w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all modal-dialog">
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

@push('myscript')
    <script>
        function openModal(title, url, sizeClass = "max-w-4xl") {
            $("#modalTitle").text(title);
            $("#modalBody").html(`
                <div class="flex items-center justify-center py-8">
                    <svg class="w-8 h-8 text-[#294C9A] animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
            `);
            $("#modalDialog").find(".modal-dialog").removeClass("max-w-xl max-w-4xl max-w-6xl max-w-full").addClass(sizeClass);
            $("#modalDialog").removeClass("hidden");
            $("#modalBody").load(url);
        }

        function closeModal() {
            $("#modalDialog").addClass("hidden");
        }

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
                var no_kontrabon = $(this).attr("no_kontrabon");
                openModal("Detail Kontrabon", `/kontrabonpembelian/${no_kontrabon}/show`, "max-w-4xl");
            });

            $(".btnProses").click(function(e) {
                e.preventDefault();
                var no_kontrabon = $(this).attr("no_kontrabon");
                openModal("Proses Kontrabon", `/kontrabonpembelian/${no_kontrabon}/proses`, "max-w-4xl");
            });

            $(document).on('click', '.btnShowpembelian', function(e) {
                e.preventDefault();
                var no_bukti = $(this).attr("no_bukti");
                openModal("Detail Pembelian", `/pembelian/${no_bukti}/show`, "max-w-6xl");
            });
        });
    </script>
@endpush
