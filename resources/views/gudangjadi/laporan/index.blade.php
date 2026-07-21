<x-app-layout>
    <x-slot name="header">
        Laporan Gudang Jadi
    </x-slot>

    <!-- Flatpickr & Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Laporan Gudang Jadi</h2>
        <p class="text-sm text-gray-500 mt-1">Halaman cetak laporan persediaan, produksi, kiriman dan pengeluaran.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6" x-data="{ activeTab: 'persediaan' }">
        <!-- Sidebar Navigation Tabs -->
        <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm h-fit space-y-1">
            <button @click="activeTab = 'persediaan'" 
                    :class="activeTab === 'persediaan' ? 'bg-[#294C9A] text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                    class="w-full flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-xl transition text-left">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                Persediaan
            </button>
            <button @click="activeTab = 'rekappersediaan'" 
                    :class="activeTab === 'rekappersediaan' ? 'bg-[#294C9A] text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                    class="w-full flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-xl transition text-left">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H3m18 0h-2a4 4 0 00-4 4v2m-3-15V3m0 0l-3 3m3-3l3 3M9 21h6"></path></svg>
                Rekap Persediaan
            </button>
            <button @click="activeTab = 'rekaphasilproduksi'" 
                    :class="activeTab === 'rekaphasilproduksi' ? 'bg-[#294C9A] text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                    class="w-full flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-xl transition text-left">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 9.172V5L8 4z"></path></svg>
                Hasil Produksi
            </button>
            <button @click="activeTab = 'rekappengeluaran'" 
                    :class="activeTab === 'rekappengeluaran' ? 'bg-[#294C9A] text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                    class="w-full flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-xl transition text-left">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h3a3 3 0 013 3v1"></path></svg>
                Rekap Pengeluaran
            </button>
            <button @click="activeTab = 'realisasikiriman'" 
                    :class="activeTab === 'realisasikiriman' ? 'bg-[#294C9A] text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                    class="w-full flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-xl transition text-left">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9h4l3 3v5h-2M1 14h18M1 7h12v7H1V7z"></path></svg>
                Realisasi Kiriman
            </button>
        </div>

        <!-- Form Containers -->
        <div class="md:col-span-3">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <!-- Card Header -->
                <div class="bg-[#294C9A] px-6 py-4 flex gap-3 text-white border-b border-white/10">
                    <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H3m18 0h-2a4 4 0 00-4 4v2m-3-15V3m0 0l-3 3m3-3l3 3M9 21h6"></path></svg>
                    <div>
                        <h3 class="text-sm font-bold" x-text="activeTab === 'persediaan' ? 'Laporan Persediaan' : (activeTab === 'rekappersediaan' ? 'Rekap Persediaan' : (activeTab === 'rekaphasilproduksi' ? 'Rekap Hasil Produksi' : (activeTab === 'rekappengeluaran' ? 'Rekap Pengeluaran' : 'Realisasi Kiriman')))">Laporan</h3>
                        <p class="text-[11px] text-blue-100/80 mt-0.5" x-text="activeTab === 'persediaan' ? 'Cetak riwayat saldo dan mutasi detail produk tertentu.' : (activeTab === 'rekappersediaan' ? 'Cetak rekapitulasi mutasi masuk, keluar, dan saldo akhir semua produk.' : (activeTab === 'rekaphasilproduksi' ? 'Cetak laporan ringkasan mingguan untuk hasil produksi barang.' : (activeTab === 'rekappengeluaran' ? 'Cetak laporan pengeluaran mingguan surat jalan barang jadi.' : 'Cetak perbandingan permintaan kiriman marketing vs realisasi surat jalan.')))"></p>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Tab: Persediaan -->
                    <div x-show="activeTab === 'persediaan'">
                        @include('gudangjadi.laporan.persediaan')
                    </div>

                    <!-- Tab: Rekap Persediaan -->
                    <div x-show="activeTab === 'rekappersediaan'" x-cloak>
                        @include('gudangjadi.laporan.rekappersediaan')
                    </div>

                    <!-- Tab: Hasil Produksi -->
                    <div x-show="activeTab === 'rekaphasilproduksi'" x-cloak>
                        @include('gudangjadi.laporan.rekaphasilproduksi')
                    </div>

                    <!-- Tab: Rekap Pengeluaran -->
                    <div x-show="activeTab === 'rekappengeluaran'" x-cloak>
                        @include('gudangjadi.laporan.rekappengeluaran')
                    </div>

                    <!-- Tab: Realisasi Kiriman -->
                    <div x-show="activeTab === 'realisasikiriman'" x-cloak>
                        @include('gudangjadi.laporan.realisasikiriman')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Flatpickr Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

    @push('myscript')
    <script>
        $(function() {
            flatpickr(".flatpickr-date", {
                dateFormat: "Y-m-d",
                locale: "id",
                allowInput: true
            });

            // Initialize Select2 dropdowns if present
            $('.select2Kodeproduk').select2({
                placeholder: 'Pilih Produk',
                allowClear: true
            });
        });
    </script>
    @endpush
</x-app-layout>
