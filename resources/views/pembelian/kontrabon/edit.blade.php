<x-app-layout>
    <x-slot name="header">
        Edit Kontra Bon
    </x-slot>

    <!-- Header Navigation & Title -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Edit Kontra Bon</h2>
            <p class="text-sm text-gray-500 mt-1">Ubah data kontra bon pembelian.</p>
        </div>
    </div>

    <form action="{{ route('kontrabonpmb.update', Crypt::encrypt($kontrabon->no_kontrabon)) }}" method="POST" id="formKontrabon" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left Panel (Sidebar Form) -->
            <div class="lg:col-span-4 space-y-4">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                        </span>
                        <input type="text" name="no_kontrabon" id="no_kontrabon" class="fi bg-gray-50 cursor-not-allowed" value="{{ $kontrabon->no_kontrabon }}" disabled />
                        <label for="no_kontrabon" class="c-fl-label">No. Kontra Bon</label>
                    </div>

                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="text" name="tanggal" id="tanggal" class="fi flatpickr-date" value="{{ $kontrabon->tanggal }}" placeholder="Tanggal" autocomplete="off" />
                        <label for="tanggal" class="c-fl-label">Tanggal</label>
                    </div>

                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </span>
                        <select name="kode_supplier" id="kode_supplier" class="fi select2Kodesupplier" disabled>
                            <option value="">Supplier</option>
                            @foreach ($supplier as $d)
                                <option value="{{ $d->kode_supplier }}" {{ $kontrabon->kode_supplier == $d->kode_supplier ? 'selected' : '' }}>{{ strtoupper($d->nama_supplier) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </span>
                        <select name="kategori" id="kategori" class="fi">
                            <option value="">Jenis Pengajuan</option>
                            <option value="KB" @selected($kontrabon->kategori == 'KB')>Kontra Bon</option>
                            <option value="IM" @selected($kontrabon->kategori == 'IM')>Internal Memo</option>
                        </select>
                        <label for="kategori" class="c-fl-label">Jenis Pengajuan</label>
                    </div>

                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                        </span>
                        <input type="text" name="no_dokumen" id="no_dokumen" class="fi" value="{{ $kontrabon->no_dokumen }}" placeholder="No. Dokumen" autocomplete="off" />
                        <label for="no_dokumen" class="c-fl-label">No. Dokumen</label>
                    </div>

                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </span>
                        <select name="jenis_bayar" id="jenis_bayar" class="fi">
                            <option value="">Jenis Bayar</option>
                            <option value="TN" @selected($kontrabon->jenis_bayar == 'TN')>Tunai</option>
                            <option value="TF" @selected($kontrabon->jenis_bayar == 'TF')>Transfer</option>
                        </select>
                        <label for="jenis_bayar" class="c-fl-label">Jenis Bayar</label>
                    </div>
                </div>
            </div>

            <!-- Right Panel (Items List) -->
            <div class="lg:col-span-8 space-y-4">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
                    <div class="border-b border-gray-100 pb-3 flex justify-between items-center">
                        <h3 class="font-bold text-base text-gray-800">Detail Kontrabon</h3>
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-[#294C9A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span class="text-xl font-bold text-[#294C9A]" id="grandtotal_text">0</span>
                        </div>
                    </div>

                    <!-- Input inline area -->
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                        <div class="sm:col-span-3">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                                </span>
                                <input type="text" name="no_bukti" id="no_bukti" class="fi cursor-pointer bg-gray-50" placeholder="Pilih No. Bukti" readonly />
                                <label for="no_bukti" class="c-fl-label">No. Bukti</label>
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M10 5h4a2 2 0 012 2v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V7a2 2 0 012-2z"></path></span >
                                <input type="text" name="total_pembelian" id="total_pembelian" class="fi text-right bg-gray-50 cursor-not-allowed" placeholder="Total" disabled />
                                <label for="total_pembelian" class="c-fl-label">Total</label>
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M10 5h4a2 2 0 012 2v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V7a2 2 0 012-2z"></path></svg>
                                </span>
                                <input type="text" name="jumlah" id="jumlah" class="fi number-separator text-right" placeholder="Jml Bayar" autocomplete="off" />
                                <label for="jumlah" class="c-fl-label">Jml Bayar</label>
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </span>
                                <input type="text" name="keterangan" id="keterangan" class="fi" placeholder="Keterangan" autocomplete="off" />
                                <label for="keterangan" class="c-fl-label">Keterangan</label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="button" id="btnTambahitem" class="w-full inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-[#294C9A] bg-blue-50 border border-blue-200 hover:bg-blue-100 rounded-xl transition shadow-sm gap-1.5 h-[38px]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Item
                        </button>
                    </div>

                    <!-- Items Added Table -->
                    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm mt-3">
                        <table class="w-full text-xs text-left">
                            <thead class="text-[11px] uppercase bg-gradient-to-r from-[#294C9A] to-[#1E3A70] text-white">
                                <tr>
                                    <th class="px-4 py-3 font-bold">No. Bukti</th>
                                    <th class="px-4 py-3 font-bold">Keterangan</th>
                                    <th class="px-4 py-3 font-bold text-right">Jumlah</th>
                                    <th class="px-4 py-3 font-bold text-center" style="width: 8%">#</th>
                                </tr>
                            </thead>
                            <tbody id="loadpembelian" class="divide-y divide-gray-100 bg-white">
                                @foreach ($detail as $item)
                                    <tr id="{{ removeSpecialCharacters($item->no_bukti) }}" class="hover:bg-gray-50 transition text-xs">
                                        <input type="hidden" name="no_bukti_item[]" value="{{ $item->no_bukti }}" />
                                        <input type="hidden" name="keterangan_item[]" value="{{ $item->keterangan }}" />
                                        <input type="hidden" name="jumlah_item[]" value="{{ formatAngkaDesimal($item->jumlah) }}" />
                                        <td class="px-4 py-2 font-mono font-semibold text-[#294C9A]">{{ $item->no_bukti }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ $item->keterangan }}</td>
                                        <td class="px-4 py-2 text-right font-bold text-gray-900 totalbayar">{{ formatAngkaDesimal($item->jumlah) }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <button id="{{ removeSpecialCharacters($item->no_bukti) }}" class="delete p-1 text-gray-450 hover:text-rose-600 transition">
                                                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 text-gray-900 font-bold border-t border-gray-200">
                                <tr>
                                    <td colspan="2" class="px-4 py-2.5 uppercase">TOTAL</td>
                                    <td id="grandtotal" class="px-4 py-2.5 text-right text-[#294C9A] text-sm">0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Agreement & Submit -->
                    <div class="pt-4 border-t border-gray-100 space-y-4">
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name="aggrement" value="aggrement" id="defaultCheck3" class="w-4 h-4 text-[#294C9A] border-gray-300 rounded focus:ring-[#294C9A] agreement" />
                            <label for="defaultCheck3" class="text-xs font-semibold text-gray-700 select-none">Yakin Akan Disimpan ?</label>
                        </div>
                        <div id="saveButton" class="hidden">
                            <button type="submit" id="btnSimpan" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-1.5 h-[38px]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal Pembelian (Pilih Transaksi Pembelian) -->
    <div id="modalPembelian" class="fixed inset-0 z-[9999] hidden overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="relative w-full max-w-6xl bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-[#294C9A] text-white flex justify-between items-center">
                <h3 class="text-base font-bold">Data Pembelian</h3>
                <button type="button" class="text-white/80 hover:text-white transition" onclick="$('#modalPembelian').addClass('hidden')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="p-6">
                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-full text-xs text-left" id="tabelpembelian">
                        <thead class="text-xs uppercase bg-gray-50 text-gray-700 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 font-bold">No. Bukti</th>
                                <th class="px-4 py-3 font-bold">Tanggal</th>
                                <th class="px-4 py-3 font-bold">Asal Ajuan</th>
                                <th class="px-4 py-3 font-bold text-center">PPN</th>
                                <th class="px-4 py-3 font-bold text-right">Subtotal</th>
                                <th class="px-4 py-3 font-bold text-right">Peny JK</th>
                                <th class="px-4 py-3 font-bold text-right">Total</th>
                                <th class="px-4 py-3 font-bold text-center" style="width: 5%">#</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@push('myscript')
<script>
    $(function() {
        const form = $("#formKontrabon");
        let total_pembelian = 0;
        let total_bayar = 0;
        let sisa_bayar = 0;

        function removeSpecialCharacters(str) {
            return str.replace(/[^a-zA-Z0-9]/g, '');
        }

        function loadTabelpembelian(kode_supplier) {
            $('#tabelpembelian').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, 'asc']
                ],
                ajax: `/pembelian/${kode_supplier}/getpembelianbysupplierjson`,
                bAutoWidth: false,
                bDestroy: true,
                columns: [
                    { data: 'no_bukti', name: 'no_bukti', orderable: true, searchable: true, width: '15%' },
                    { data: 'tanggal', name: 'tanggal', orderable: true, searchable: false, width: '10%' },
                    { data: 'asal_pengajuan', name: 'kode_asal_pengajuan', orderable: true, searchable: false, width: '20%' },
                    { data: 'cekppn', name: 'ppn', orderable: true, searchable: false, width: '5%', className: 'text-center' },
                    { data: 'subtotal', name: 'subtotal', orderable: true, searchable: false, width: '15%' },
                    { data: 'penyesuaianjk', name: 'penyesuaian_jk', orderable: true, searchable: false, width: '10%' },
                    { data: 'totalpembelian', name: 'total_pembelian', orderable: true, searchable: false, width: '15%' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, width: '5%', className: 'text-center' }
                ],
                columnDefs: [
                    { "targets": [4, 5, 6], "className": "text-end" }
                ]
            });
        }

        easyNumberSeparator({
            selector: '.number-separator',
            separator: '.',
            decimalSeparator: ',',
        });

        function convertNumber(number) {
            let formatted = number.replace(/\./g, '');
            formatted = formatted.replace(/,/g, '.');
            return formatted || 0;
        }

        function numberFormat(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = typeof thousands_sep === 'undefined' ? ',' : thousands_sep,
                dec = typeof dec_point === 'undefined' ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        form.find("#no_bukti").click(function(e) {
            const kode_supplier = form.find("#kode_supplier").val();
            if (kode_supplier == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Supplier Harus Diisi Terlebih Dahulu!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#kode_supplier").focus();
                    },
                });
            } else {
                $("#modalPembelian").removeClass("hidden");
                loadTabelpembelian(kode_supplier);
            }
        });

        const select2Kodesupplier = $('.select2Kodesupplier');
        if (select2Kodesupplier.length) {
            select2Kodesupplier.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Supplier',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }

        $(document).on('click', '.pilihnobukti', function(e) {
            e.preventDefault();
            const no_bukti = $(this).attr('no_bukti');
            const raw_pembelian = $(this).attr('total_pembelian');
            const raw_bayar = $(this).attr('total_bayar');
            
            total_pembelian = parseFloat(raw_pembelian) || 0;
            total_bayar = parseFloat(raw_bayar) || 0;
            sisa_bayar = total_pembelian - total_bayar;
            
            console.log("Pilih No Bukti Clicked:", { no_bukti, total_pembelian, total_bayar, sisa_bayar });
            
            form.find("#no_bukti").val(no_bukti);
            form.find("#total_pembelian").val(numberFormat(total_pembelian, '2', ',', '.'));
            $("#modalPembelian").addClass("hidden");
            form.find("#jumlah").focus();
        });

        function calculateTotal() {
            let grandTotal = 0;
            $('.totalbayar').each(function() {
                grandTotal += parseFloat(convertNumber($(this).text())) || 0;
            });
            $('#grandtotal').text(numberFormat(grandTotal, '2', ',', '.'));
            $('#grandtotal_text').text(numberFormat(grandTotal, '2', ',', '.'));
        }

        calculateTotal();

        function resetForm() {
            form.find("#no_bukti").val("");
            form.find("#jumlah").val("");
            form.find("#keterangan").val("");
            form.find("#total_pembelian").val("");
        }

        form.find("#btnTambahitem").click(function(e) {
            e.preventDefault();
            const no_bukti = form.find("#no_bukti").val();
            const jumlah = form.find("#jumlah").val();
            const jml = convertNumber(jumlah);
            const keterangan = form.find("#keterangan").val();
            const no_bukti_index = removeSpecialCharacters(no_bukti);
            if (no_bukti == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Silahkan Pilih No. Bukti Terlebih Dahulu!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#no_bukti").focus();
                    },
                });
            } else if (jumlah == "" || jumlah == 0) {
                Swal.fire({
                    title: "Oops!",
                    text: "Jumlah Harus Diisi Tidak Boleh 0!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#jumlah").focus();
                    },
                });
            } else if (jml > sisa_bayar) {
                Swal.fire({
                    title: "Oops!",
                    text: "Jumlah Bayar Melebihi Sisa Pembayaran!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#jumlah").focus();
                    },
                });
            } else if ($('#loadpembelian').find('#' + no_bukti_index).length > 0) {
                Swal.fire({
                    title: "Oops!",
                    text: "Data Sudah Ada!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#no_bukti").focus();
                    },
                });
            } else {
                let newItem = `
                    <tr id='${no_bukti_index}' class="hover:bg-gray-50 transition text-xs">
                        <input type="hidden" name="no_bukti_item[]" value="${no_bukti}"/>
                        <input type="hidden" name="keterangan_item[]" value="${keterangan}"/>
                        <input type="hidden" name="jumlah_item[]" value="${jumlah}"/>
                        <td class="px-4 py-2 font-mono font-semibold text-[#294C9A]">${no_bukti}</td>
                        <td class="px-4 py-2 text-gray-700">${keterangan}</td>
                        <td class="px-4 py-2 text-right font-bold text-gray-900 totalbayar">${jumlah}</td>
                        <td class="px-4 py-2 text-center">
                            <button id="${no_bukti_index}" class="delete p-1 text-gray-450 hover:text-rose-600 transition">
                                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </td>
                    </tr>
                `;

                form.find("#loadpembelian").append(newItem);
                calculateTotal();
                resetForm();
            }
        });

        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            let id = $(this).attr("id");
            Swal.fire({
                title: `Apakah Anda Yakin Ingin Menghapus Data Ini ?`,
                text: "Jika dihapus maka data akan hilang permanent.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#294C9A",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Hapus Saja!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $(`#${id}`).remove();
                    calculateTotal();
                }
            });
        });

        function buttonDisable() {
            $("#btnSimpan").prop('disabled', true);
            $("#btnSimpan").html(`
                <svg class="animate-spin h-4 w-4 text-white mr-1.5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                Loading..
            `);
        }

        form.find('.agreement').change(function() {
            if (this.checked) {
                form.find("#saveButton").removeClass("hidden");
            } else {
                form.find("#saveButton").addClass("hidden");
            }
        });

        form.find("#kode_supplier").change(function() {
            form.find("#loadpembelian").html("");
        });
        $(".flatpickr-date").flatpickr();

        form.submit(function(e) {
            const tanggal = form.find("#tanggal").val();
            const kode_supplier = form.find("#kode_supplier").val();
            const kategori = form.find("#kategori").val();
            const jenis_bayar = form.find("#jenis_bayar").val();
            if (tanggal == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Tanggal Harus Diisi!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#tanggal").focus();
                    },
                });
                return false;
            } else if (kode_supplier == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Supplier Harus Diisi!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#kode_supplier").focus();
                    },
                });
                return false;
            } else if (kategori == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Jenis Pengajuan Harus Diisi!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#kategori").focus();
                    },
                });
                return false;
            } else if (jenis_bayar == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Jenis Bayar Harus Diisi!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#jenis_bayar").focus();
                    },
                });
                return false;
            } else if ($('#loadpembelian tr').length == 0) {
                Swal.fire({
                    title: "Oops!",
                    text: "Detail Pembelian Tidak Boleh Kosong!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: () => {
                        form.find("#no_bukti").focus();
                    },
                });
                return false;
            } else {
                buttonDisable();
            }
        });
    });
</script>
@endpush
</x-app-layout>
