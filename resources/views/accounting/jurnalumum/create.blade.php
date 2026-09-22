<form action="{{ route('jurnalumum.store') }}" method="POST" id="formJurnalumum" class="space-y-4">
    @csrf
    <div class="bg-gray-50/70 p-4 rounded-xl border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
            <div class="md:col-span-4">
                <div class="c-fl-group">
                    <span class="c-fl-icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </span>
                    <input type="text" name="tanggal" id="tanggal" class="fi flatpickr-date" placeholder="Tanggal" value="{{ date('Y-m-d') }}" autocomplete="off" />
                    <label for="tanggal" class="c-fl-label">Tanggal Transaksi</label>
                </div>
            </div>
            <div class="md:col-span-8">
                <div class="c-fl-group">
                    <span class="c-fl-icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </span>
                    <select name="kode_akun" id="kode_akun" class="fi select2Modal">
                        <option value="">Pilih Akun (COA)</option>
                        @foreach ($coa as $d)
                            <option value="{{ $d->kode_akun }}">{{ $d->kode_akun }} - {{ $d->nama_akun }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="md:col-span-6">
                <div class="c-fl-group">
                    <span class="c-fl-icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    </span>
                    <input type="text" name="keterangan" id="keterangan" class="fi" placeholder="Keterangan transaksi" autocomplete="off" />
                    <label for="keterangan" class="c-fl-label">Keterangan</label>
                </div>
            </div>
            <div class="md:col-span-3">
                <div class="c-fl-group">
                    <span class="c-fl-icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
                    </span>
                    <select name="debet_kredit" id="debet_kredit" class="fi">
                        <option value="">Pilih Posisi</option>
                        <option value="D">Debet</option>
                        <option value="K">Kredit</option>
                    </select>
                    <label for="debet_kredit" class="c-fl-label">Posisi</label>
                </div>
            </div>
            <div class="md:col-span-3">
                <div class="c-fl-group">
                    <span class="c-fl-icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </span>
                    <input type="text" name="jumlah" id="jumlah" class="fi text-right number-separator" placeholder="0" autocomplete="off" />
                    <label for="jumlah" class="c-fl-label">Jumlah (Rp)</label>
                </div>
            </div>
        </div>

        <div class="pt-3 flex justify-end">
            <button type="button" id="btnTambahItem" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-1.5 h-[38px]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Tambah Baris</span>
            </button>
        </div>
    </div>

    <!-- Table Item Preview -->
    <div class="border border-gray-100 rounded-2xl overflow-hidden shadow-xs">
        <table class="w-full text-xs text-left text-gray-600">
            <thead class="text-xs uppercase bg-gradient-to-r from-[#294C9A] to-[#1E3A70] text-white">
                <tr>
                    <th class="px-3.5 py-2.5 font-bold">Tanggal</th>
                    <th class="px-3.5 py-2.5 font-bold">Akun</th>
                    <th class="px-3.5 py-2.5 font-bold">Keterangan</th>
                    <th class="px-3.5 py-2.5 font-bold text-end">Debet</th>
                    <th class="px-3.5 py-2.5 font-bold text-end">Kredit</th>
                    <th class="px-3.5 py-2.5 font-bold text-center w-12">Aksi</th>
                </tr>
            </thead>
            <tbody id="loadjurnalumum" class="divide-y divide-gray-100 bg-white">
                <!-- Data item diisi dinamis via JS -->
            </tbody>
            <tfoot class="bg-gray-50/80 font-bold text-gray-900 border-t border-gray-200">
                <tr>
                    <td colspan="3" class="px-3.5 py-2.5 text-end uppercase text-[11px] tracking-wider">TOTAL :</td>
                    <td class="px-3.5 py-2.5 text-end text-xs text-[#294C9A] font-bold whitespace-nowrap" id="total_debet">0</td>
                    <td class="px-3.5 py-2.5 text-end text-xs text-[#294C9A] font-bold whitespace-nowrap" id="total_kredit">0</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-3">
        <label class="inline-flex items-center text-xs text-gray-600 cursor-pointer">
            <input type="checkbox" id="agreement" class="rounded border-gray-300 text-[#294C9A] focus:ring-[#294C9A] mr-2">
            <span>Yakin data jurnal umum sudah benar dan seimbang?</span>
        </label>
        <button type="submit" id="btnSimpan" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>Simpan Jurnal Umum</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        let total_debet_set = 0;
        let total_kredit_set = 0;
        let baris = 0;
        const form = $('#formJurnalumum');

        $(".flatpickr-date").flatpickr({
            dateFormat: "Y-m-d"
        });

        $('.select2Modal').select2({
            width: '100%',
            dropdownParent: $('#modalJurnalUmum')
        });

        easyNumberSeparator({
            selector: '.number-separator',
            separator: '.',
            decimalSeparator: ',',
        });

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID').format(angka);
        }

        function hitungTotal() {
            total_debet_set = 0;
            total_kredit_set = 0;

            $('#loadjurnalumum tr').each(function() {
                const dk = $(this).find('input[name="debet_kredit_item[]"]').val();
                let jmlStr = $(this).find('input[name="jumlah_item[]"]').val() || '0';
                jmlStr = jmlStr.replace(/\./g, '').replace(/,/g, '.');
                const jml = parseFloat(jmlStr) || 0;

                if (dk === 'D') {
                    total_debet_set += jml;
                } else {
                    total_kredit_set += jml;
                }
            });

            $('#total_debet').text(formatRupiah(total_debet_set));
            $('#total_kredit').text(formatRupiah(total_kredit_set));
        }

        $('#btnTambahItem').on('click', function(e) {
            e.preventDefault();
            const tanggal = form.find('#tanggal').val();
            const kode_akun = form.find('#kode_akun').val();
            const nama_akun = form.find('#kode_akun option:selected').text();
            const keterangan = form.find('#keterangan').val();
            const debet_kredit = form.find('#debet_kredit').val();
            const jumlah = form.find('#jumlah').val();

            if (!tanggal) {
                Swal.fire({ title: 'Peringatan', text: 'Tanggal harus diisi!', icon: 'warning', confirmButtonColor: '#294C9A' });
                return;
            }
            if (!kode_akun) {
                Swal.fire({ title: 'Peringatan', text: 'Akun COA harus dipilih!', icon: 'warning', confirmButtonColor: '#294C9A' });
                return;
            }
            if (!keterangan) {
                Swal.fire({ title: 'Peringatan', text: 'Keterangan harus diisi!', icon: 'warning', confirmButtonColor: '#294C9A' });
                return;
            }
            if (!debet_kredit) {
                Swal.fire({ title: 'Peringatan', text: 'Pilih Debet atau Kredit!', icon: 'warning', confirmButtonColor: '#294C9A' });
                return;
            }
            if (!jumlah || jumlah === '0') {
                Swal.fire({ title: 'Peringatan', text: 'Jumlah harus lebih dari 0!', icon: 'warning', confirmButtonColor: '#294C9A' });
                return;
            }

            baris++;
            const debetText = debet_kredit === 'D' ? jumlah : '-';
            const kreditText = debet_kredit === 'K' ? jumlah : '-';

            const row = `
                <tr id="baris_${baris}" class="hover:bg-gray-50/80 transition">
                    <td class="px-3.5 py-2.5 font-medium text-gray-900 whitespace-nowrap">${tanggal}
                        <input type="hidden" name="tanggal_item[]" value="${tanggal}">
                    </td>
                    <td class="px-3.5 py-2.5 whitespace-nowrap">
                        <span class="font-bold text-[#294C9A]">${kode_akun}</span>
                        <input type="hidden" name="kode_akun_item[]" value="${kode_akun}">
                        <span class="text-gray-500 block text-[10px]">${nama_akun}</span>
                    </td>
                    <td class="px-3.5 py-2.5 text-gray-700 font-medium">
                        ${keterangan}
                        <input type="hidden" name="keterangan_item[]" value="${keterangan}">
                    </td>
                    <td class="px-3.5 py-2.5 text-end font-semibold text-gray-900 whitespace-nowrap">${debetText}</td>
                    <td class="px-3.5 py-2.5 text-end font-semibold text-gray-900 whitespace-nowrap">${kreditText}
                        <input type="hidden" name="debet_kredit_item[]" value="${debet_kredit}">
                        <input type="hidden" name="jumlah_item[]" value="${jumlah}">
                    </td>
                    <td class="px-3.5 py-2.5 text-center whitespace-nowrap">
                        <button type="button" class="btnHapusItem p-1 text-red-600 hover:text-red-800 transition" data-baris="${baris}" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </td>
                </tr>
            `;

            $('#loadjurnalumum').append(row);
            hitungTotal();

            // Reset input item
            form.find('#kode_akun').val('').trigger('change');
            form.find('#keterangan').val('');
            form.find('#debet_kredit').val('');
            form.find('#jumlah').val('');
        });

        $(document).on('click', '.btnHapusItem', function(e) {
            e.preventDefault();
            const barisId = $(this).data('baris');
            $(`#baris_${barisId}`).remove();
            hitungTotal();
        });

        form.on('submit', function(e) {
            const rowCount = $('#loadjurnalumum tr').length;
            if (rowCount === 0) {
                e.preventDefault();
                Swal.fire({ title: 'Peringatan', text: 'Tambahkan minimal satu baris transaksi!', icon: 'warning', confirmButtonColor: '#294C9A' });
                return false;
            }

            if (total_debet_set !== total_kredit_set) {
                e.preventDefault();
                Swal.fire({
                    title: 'Jurnal Tidak Seimbang!',
                    text: `Total Debet (Rp ${formatRupiah(total_debet_set)}) tidak sama dengan Total Kredit (Rp ${formatRupiah(total_kredit_set)}).`,
                    icon: 'warning',
                    confirmButtonColor: '#294C9A'
                });
                return false;
            }

            if (!$('#agreement').is(':checked')) {
                e.preventDefault();
                Swal.fire({ title: 'Peringatan', text: 'Centang kotak persetujuan sebelum menyimpan!', icon: 'warning', confirmButtonColor: '#294C9A' });
                return false;
            }

            $('#btnSimpan').prop('disabled', true).text('Menyimpan...');
        });
    });
</script>
