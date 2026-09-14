<form action="{{ route('biaya.storeprosespembayaran', Crypt::encrypt($biaya->no_bukti)) }}" method="POST" id="formProsesPembayaranBiaya" class="space-y-4">
    @csrf
    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 mb-4">
        <div class="grid grid-cols-2 gap-3 text-xs">
            <div>
                <span class="text-gray-400 block font-medium">No. Bukti Biaya:</span>
                <span class="font-bold text-gray-800 font-mono">{{ $biaya->no_bukti }}</span>
            </div>
            <div>
                <span class="text-gray-400 block font-medium">Sisa Tagihan:</span>
                <span class="font-bold text-rose-600 text-sm">Rp {{ formatAngkaDesimal($biaya->sisa_bayar) }}</span>
            </div>
        </div>
    </div>

    <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Tanggal Pembayaran *</label>
        <input type="text" name="tanggal" id="tanggal_bayar_modal" value="{{ date('Y-m-d') }}" class="w-full text-xs border-gray-300 rounded-xl focus:border-[#294C9A] focus:ring-[#294C9A] p-2.5 flatpickr-date bg-white shadow-sm" required autocomplete="off" />
    </div>

    <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Pilih Bank / Kas *</label>
        <select name="kode_bank" id="kode_bank_modal" class="w-full text-xs border-gray-300 rounded-xl focus:border-[#294C9A] focus:ring-[#294C9A] p-2.5 bg-white shadow-sm select2ModalBank" required>
            <option value="">-- Pilih Bank / Kas --</option>
            @foreach($bank as $b)
                <option value="{{ $b->kode_bank }}">{{ $b->kode_bank }} - {{ $b->nama_bank }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Jumlah Bayar *</label>
        <input type="text" name="jumlah" id="jumlah_bayar_modal" value="{{ formatAngkaDesimal($biaya->sisa_bayar) }}" class="w-full text-xs border-gray-300 rounded-xl focus:border-[#294C9A] focus:ring-[#294C9A] p-2.5 bg-white shadow-sm font-bold text-gray-900 number-separator text-right" required autocomplete="off" />
    </div>

    <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Keterangan / Catatan</label>
        <input type="text" name="keterangan" value="Pembayaran Biaya {{ $biaya->no_bukti }}" class="w-full text-xs border-gray-300 rounded-xl focus:border-[#294C9A] focus:ring-[#294C9A] p-2.5 bg-white shadow-sm" autocomplete="off" />
    </div>

    <div class="flex justify-end gap-2 pt-3 border-t border-gray-100">
        <button type="button" onclick="closeModal()" class="px-4 py-2 text-xs font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm">
            Batal
        </button>
        <button type="submit" id="btnSubmitBayar" class="px-4 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm">
            Simpan Pembayaran
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $(".flatpickr-date").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true
        });

        easyNumberSeparator({
            selector: '.number-separator',
            separator: '.',
            decimalSeparator: ',',
        });

        $('.select2ModalBank').select2({
            dropdownParent: $('#modalProsesPembayaran'),
            width: '100%'
        });
    });
</script>
