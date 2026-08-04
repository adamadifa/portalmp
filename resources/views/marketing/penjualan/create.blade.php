<x-app-layout>
    <x-slot name="header">
        Input Penjualan Marketing
    </x-slot>

    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Point of Sale (POS) Marketing</h2>
            <p class="text-xs text-gray-500 mt-1">Sistem pencatatan penjualan cepat produk ke Portax.</p>
        </div>
        <!-- Breadcrumbs -->
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 text-xs font-semibold text-gray-500">
                <li class="inline-flex items-center">
                    <a href="{{ route('penjualanmarketing.index') }}" class="inline-flex items-center hover:text-[#294C9A] transition-colors">
                        Penjualan
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3.5 h-3.5 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-[#294C9A] font-bold">POS Kasir</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Alert Notifications -->
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

    <form action="{{ route('penjualanmarketing.store') }}" method="POST" id="formPenjualan" class="w-full" novalidate>
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <!-- Left Side: Product Selector & Item Cart -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Product Selector (c-fl-group Layout) -->
                <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Pencarian & Input Produk</h3>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                        <!-- Product Input -->
                        <div class="md:col-span-5">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </span>
                                <input type="text" id="nama_produk_select" class="fi cursor-pointer font-semibold text-gray-800" placeholder="Pilih Produk" readonly />
                                <label for="nama_produk_select" class="c-fl-label">Pilih Produk *</label>
                                <input type="hidden" id="kode_produk_select">
                                <input type="hidden" id="harga_dus_select">
                            </div>
                        </div>
                        
                        <!-- Qty Input -->
                        <div class="md:col-span-2">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"></path></svg>
                                </span>
                                <input type="number" id="qty_select" min="1" class="fi text-right font-bold text-gray-800" placeholder="Qty" />
                                <label for="qty_select" class="c-fl-label">Qty (Dus) *</label>
                            </div>
                        </div>
                        
                        <!-- Price Input -->
                        <div class="md:col-span-4">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </span>
                                <input type="text" id="harga_select" class="fi money text-right font-bold text-gray-800" placeholder="Harga" />
                                <label for="harga_select" class="c-fl-label">Harga / Dus *</label>
                            </div>
                        </div>
                        
                        <!-- Add Button -->
                        <div class="md:col-span-1">
                            <button type="button" id="btnTambahProduk" class="w-full inline-flex items-center justify-center text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition-all shadow-md active:scale-95 h-[38px] duration-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Products Table (Cart Style) -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden min-h-[350px] flex flex-col justify-between">
                    <div>
                        <div class="px-5 py-4 flex items-center justify-between bg-[#294C9A] text-white shrink-0">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                <h3 class="text-sm font-bold tracking-wide">Keranjang Belanja</h3>
                            </div>
                            <span class="px-3 py-1 bg-white/10 text-white border border-white/20 rounded-full text-xs font-bold font-mono" id="item_count_badge">0 Item</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs text-left text-gray-600 border-collapse" id="tabelproduk">
                                <thead class="bg-[#294C9A] text-white">
                                    <tr>
                                        <th class="py-3 px-6 font-bold uppercase tracking-wider whitespace-nowrap" style="width: 15%;">KODE</th>
                                        <th class="py-3 px-6 font-bold uppercase tracking-wider whitespace-nowrap" style="width: 45%;">NAMA PRODUK</th>
                                        <th class="py-3 px-6 font-bold uppercase tracking-wider text-right whitespace-nowrap" style="width: 15%;">HARGA / DUS</th>
                                        <th class="py-3 px-6 font-bold uppercase tracking-wider text-center whitespace-nowrap" style="width: 10%;">QTY</th>
                                        <th class="py-3 px-6 font-bold uppercase tracking-wider text-right whitespace-nowrap" style="width: 15%;">SUBTOTAL</th>
                                        <th class="py-3 px-6 font-bold uppercase tracking-wider text-center whitespace-nowrap" style="width: 10%;">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody id="loadproduk" class="divide-y divide-gray-50 text-gray-700 bg-white">
                                    <!-- Dynamic rows via JS -->
                                    <tr id="empty_cart_placeholder">
                                        <td colspan="6" class="py-12 text-center text-gray-400">
                                            <div class="flex flex-col items-center justify-center space-y-1">
                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                                <span class="text-xs">Keranjang masih kosong. Pilih produk untuk ditambahkan.</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Side: POS Screen Summary & Checkout Options -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- POS Big screen display for Total -->
                <div class="bg-[#294C9A] text-white rounded-3xl p-6 shadow-md relative overflow-hidden">
                    <!-- Subtle background light pattern -->
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
                    <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
                    
                    <div class="relative z-10 space-y-2">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-blue-200">TOTAL YANG HARUS DIBAYAR</span>
                        <div class="text-4xl font-extrabold tracking-tight font-mono break-all" id="total_pembelian_text">Rp 0</div>
                    </div>
                </div>

                <!-- Transaction Header Details Card -->
                <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm space-y-6">
                    <h3 class="font-bold text-sm text-gray-800 border-b border-gray-100 pb-3 flex items-center justify-between">
                        <span>Detail Checkout</span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"></path></svg>
                    </h3>
                    
                    <!-- No Bukti -->
                    <div>
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                            </span>
                            <input type="text" name="no_bukti" id="no_bukti" required class="fi font-bold text-gray-800" placeholder="No. Bukti" autocomplete="off" />
                            <label for="no_bukti" class="c-fl-label">No. Bukti *</label>
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </span>
                            <input type="text" name="tanggal" id="tanggal" required class="fi flatpickr-date font-bold text-gray-800" placeholder="Tanggal" autocomplete="off" />
                            <label for="tanggal" class="c-fl-label">Tanggal *</label>
                        </div>
                    </div>

                    <!-- Pelanggan -->
                    <div>
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </span>
                            <select name="kode_pelanggan" id="kode_pelanggan" required class="fi font-bold text-gray-800">
                                <option value="">Pelanggan</option>
                                @foreach ($pelanggan as $p)
                                    <option value="{{ $p->kode_pelanggan }}">{{ $p->nama_pelanggan }}</option>
                                @endforeach
                            </select>
                            <label for="kode_pelanggan" class="c-fl-label">Pelanggan *</label>
                        </div>
                    </div>

                    <!-- Jenis Transaksi -->
                    <div>
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </span>
                            <select name="jenis_transaksi" id="jenis_transaksi" required class="fi font-bold text-gray-800">
                                <option value="">Jenis Transaksi</option>
                                <option value="T">TUNAI</option>
                                <option value="K">KREDIT</option>
                            </select>
                            <label for="jenis_transaksi" class="c-fl-label">Jenis Transaksi *</label>
                        </div>
                    </div>

                    <!-- Jenis Bayar -->
                    <div id="wrapper_jenis_bayar" class="hidden">
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </span>
                            <select name="jenis_bayar" id="jenis_bayar" class="fi font-bold text-gray-800">
                                <option value="">Jenis Bayar</option>
                                <option value="TN">CASH</option>
                                <option value="TR">TRANSFER</option>
                            </select>
                            <label for="jenis_bayar" class="c-fl-label">Jenis Bayar *</label>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('penjualanmarketing.index') }}" class="flex-1 inline-flex items-center justify-center px-4 py-3 text-xs font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-2xl transition shadow-sm h-[44px]">
                        Batal
                    </a>
                    <button type="submit" class="flex-[2] inline-flex items-center justify-center px-4 py-3 text-xs font-bold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-2xl transition shadow-md hover:shadow-lg active:scale-95 h-[44px]">
                        Simpan Penjualan
                    </button>
                </div>

            </div>
        </div>
    </form>

    <!-- Modal Select Product -->
    <div id="modalProduk" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl w-full max-w-3xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalProdukContentWrapper">
            <div class="bg-[#294C9A] px-6 py-4 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-white">Pilih Produk</h3>
                <button type="button" onclick="closeModal('modalProduk')" class="text-white/80 hover:text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div id="loadProdukContent" class="max-h-[80vh] overflow-y-auto p-6">
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

            $(document).ready(function() {
                // Show/hide jenis bayar based on transaksi
                $('#jenis_transaksi').change(function() {
                    let val = $(this).val();
                    if(val === 'T') {
                        $('#wrapper_jenis_bayar').removeClass('hidden');
                        $('#jenis_bayar').attr('required', true);
                    } else {
                        $('#wrapper_jenis_bayar').addClass('hidden');
                        $('#jenis_bayar').removeAttr('required').val('');
                    }
                });

                // Load product modal
                $('#nama_produk_select').click(function() {
                    openModal('modalProduk');
                    $('#loadProdukContent').load('/penjualanmarketing/produk/getproduk', function() {
                        // Click product handler inside modal
                        $('.pilihProduk').click(function(e) {
                            e.preventDefault();
                            let kode = $(this).attr('kode_produk');
                            let nama = $(this).attr('nama_produk');
                            let harga = $(this).attr('harga_dus');

                            $('#kode_produk_select').val(kode);
                            $('#nama_produk_select').val(nama + ' (' + kode + ')');
                            $('#harga_dus_select').val(harga);
                            
                            // Format & fill price input
                            $('#harga_select').val(new Intl.NumberFormat('id-ID').format(harga));
                            $('#qty_select').focus();

                            closeModal('modalProduk');
                        });
                    });
                });

                // Add product to table
                $('#btnTambahProduk').click(function() {
                    let kode = $('#kode_produk_select').val();
                    let nama = $('#nama_produk_select').val();
                    let qty = $('#qty_select').val();
                    let hargaRaw = $('#harga_select').val();

                    if(!kode || !qty || !hargaRaw || qty <= 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan',
                            text: 'Pilih produk, masukkan Qty & Harga yang valid!',
                            confirmButtonColor: '#294C9A'
                        });
                        return;
                    }

                    // Check if already added
                    if($('#row_' + kode).length > 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan',
                            text: 'Produk sudah ditambahkan ke daftar!',
                            confirmButtonColor: '#294C9A'
                        });
                        return;
                    }

                    // Remove empty placeholder row if present
                    $('#empty_cart_placeholder').remove();

                    let harga = parseInt(hargaRaw.replace(/[^0-9]/g, ''));
                    let subtotal = qty * harga;

                    let row = `
                        <tr id="row_${kode}" class="hover:bg-gray-55 transition">
                            <td class="py-3 px-6 font-mono font-bold text-[#294C9A]">
                                ${kode}
                                <input type="hidden" name="kode_produk[]" value="${kode}">
                            </td>
                            <td class="py-3 px-6 font-semibold text-gray-900">${nama}</td>
                            <td class="py-3 px-6 text-right font-medium">
                                Rp ${new Intl.NumberFormat('id-ID').format(harga)}
                                <input type="hidden" name="harga_dus_produk[]" value="${harga}">
                            </td>
                            <td class="py-3 px-6 text-center font-bold text-gray-800">
                                ${qty}
                                <input type="hidden" name="jumlah_produk[]" value="${qty}">
                            </td>
                            <td class="py-3 px-6 text-right font-bold text-gray-900">
                                Rp <span class="row_subtotal_text">${new Intl.NumberFormat('id-ID').format(subtotal)}</span>
                                <input type="hidden" name="subtotal[]" class="row_subtotal" value="${subtotal}">
                            </td>
                            <td class="py-3 px-6 text-center">
                                <button type="button" onclick="hapusRow('${kode}')" class="text-red-500 hover:text-red-700 p-1.5 hover:bg-red-50 rounded-xl transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                    `;

                    $('#loadproduk').append(row);
                    hitungTotal();

                    // Reset selectors
                    $('#kode_produk_select').val('');
                    $('#nama_produk_select').val('');
                    $('#harga_dus_select').val('');
                    $('#qty_select').val('');
                    $('#harga_select').val('');
                });
            });

            function hapusRow(kode) {
                $('#row_' + kode).remove();
                hitungTotal();
                
                // Add back placeholder if cart is empty
                if ($('.row_subtotal').length === 0) {
                    let placeholder = `
                        <tr id="empty_cart_placeholder">
                            <td colspan="6" class="py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center space-y-1">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    <span class="text-xs">Keranjang masih kosong. Pilih produk untuk ditambahkan.</span>
                                </div>
                            </td>
                        </tr>
                    `;
                    $('#loadproduk').append(placeholder);
                }
            }

            function hitungTotal() {
                let total = 0;
                let count = 0;
                $('.row_subtotal').each(function() {
                    total += parseInt($(this).val()) || 0;
                    count++;
                });
                $('#total_pembelian_text').text('Rp ' + new Intl.NumberFormat('id-ID').format(total));
                $('#item_count_badge').text(count + ' Item');
            }
        </script>
    @endpush
</x-app-layout>
