<form action="{{ route('jurnalumum.update', Crypt::encrypt($jurnalumum->kode_ju)) }}" id="formJurnalumumEdit" method="POST" class="space-y-4">
    @csrf
    @method('PUT')
    
    <div class="bg-gray-50/70 p-4 rounded-xl border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
            <div class="md:col-span-4">
                <div class="c-fl-group">
                    <span class="c-fl-icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </span>
                    <input type="text" name="tanggal" id="tanggal_edit" class="fi flatpickr-date" value="{{ $jurnalumum->tanggal }}" autocomplete="off" />
                    <label for="tanggal_edit" class="c-fl-label">Tanggal Transaksi</label>
                </div>
            </div>
            <div class="md:col-span-8">
                <div class="c-fl-group">
                    <span class="c-fl-icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </span>
                    <select name="kode_akun" id="kode_akun_edit" class="fi select2ModalEdit">
                        <option value="">Pilih Akun (COA)</option>
                        @foreach ($coa as $d)
                            <option value="{{ $d->kode_akun }}" {{ $jurnalumum->kode_akun == $d->kode_akun ? 'selected' : '' }}>
                                {{ $d->kode_akun }} - {{ $d->nama_akun }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="md:col-span-6">
                <div class="c-fl-group">
                    <span class="c-fl-icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    </span>
                    <input type="text" name="keterangan" id="keterangan_edit" class="fi" value="{{ $jurnalumum->keterangan }}" autocomplete="off" />
                    <label for="keterangan_edit" class="c-fl-label">Keterangan</label>
                </div>
            </div>
            <div class="md:col-span-3">
                <div class="c-fl-group">
                    <span class="c-fl-icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
                    </span>
                    <select name="debet_kredit" id="debet_kredit_edit" class="fi">
                        <option value="D" {{ $jurnalumum->debet_kredit == 'D' ? 'selected' : '' }}>Debet</option>
                        <option value="K" {{ $jurnalumum->debet_kredit == 'K' ? 'selected' : '' }}>Kredit</option>
                    </select>
                    <label for="debet_kredit_edit" class="c-fl-label">Posisi</label>
                </div>
            </div>
            <div class="md:col-span-3">
                <div class="c-fl-group">
                    <span class="c-fl-icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </span>
                    <input type="text" name="jumlah" id="jumlah_edit" class="fi text-right number-separator" value="{{ formatAngkaDesimal($jurnalumum->jumlah) }}" autocomplete="off" />
                    <label for="jumlah_edit" class="c-fl-label">Jumlah (Rp)</label>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-3 flex justify-end gap-2 border-t border-gray-100">
        <button type="button" onclick="closeModal()" class="px-4 py-2 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
            Batal
        </button>
        <button type="submit" id="btnSimpanEdit" class="inline-flex items-center px-5 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-1.5 h-[38px]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>Simpan Perubahan</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        $(".flatpickr-date").flatpickr({
            dateFormat: "Y-m-d"
        });

        $('.select2ModalEdit').select2({
            width: '100%',
            dropdownParent: $('#modalJurnalUmum')
        });

        easyNumberSeparator({
            selector: '.number-separator',
            separator: '.',
            decimalSeparator: ',',
        });

        $('#formJurnalumumEdit').on('submit', function(e) {
            const tgl = $('#tanggal_edit').val();
            const akun = $('#kode_akun_edit').val();
            const ket = $('#keterangan_edit').val();
            const jml = $('#jumlah_edit').val();

            if (!tgl || !akun || !ket || !jml) {
                e.preventDefault();
                Swal.fire({ title: 'Peringatan', text: 'Semua kolom wajib diisi!', icon: 'warning', confirmButtonColor: '#294C9A' });
                return false;
            }

            $('#btnSimpanEdit').prop('disabled', true).text('Menyimpan...');
        });
    });
</script>
