<x-app-layout>
    <x-slot name="header">
        Laporan Produksi
    </x-slot>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <style>
    /* Floating Label with Icons */
    .fl-group { position: relative; }
    .fl-icon {
        position: absolute;
        left: 12px; top: 11px;
        width: 14px; height: 14px;
        color: #9ca3af;
        pointer-events: none;
        transition: color 0.2s;
    }
    .fl-input, .fl-select {
        display: block; width: 100%;
        padding: 11px 12px 3px 34px;
        font-size: 11px; color: #111827;
        background: #f9fafb;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        appearance: none;
    }
    .fl-input:focus, .fl-select:focus {
        border-color: #294C9A;
        box-shadow: 0 0 0 3px rgba(41,76,154,0.1);
        background: #fff;
    }
    .fl-input:focus ~ .fl-icon, .fl-select:focus ~ .fl-icon {
        color: #294C9A;
    }
    .fl-input:disabled, .fl-select:disabled {
        background: #f3f4f6;
        color: #9ca3af;
        cursor: not-allowed;
    }
    .fl-label {
        position: absolute;
        left: 34px; top: 7px;
        font-size: 11px; color: #9ca3af;
        font-weight: 500;
        pointer-events: none;
        transition: all 0.15s ease;
        transform-origin: left top;
    }
    .fl-input:focus ~ .fl-label,
    .fl-input:not(:placeholder-shown) ~ .fl-label,
    .fl-input:disabled ~ .fl-label,
    .fl-select:focus ~ .fl-label,
    .fl-select.has-value ~ .fl-label {
        top: 1px;
        font-size: 8px;
        color: #294C9A;
        font-weight: 600;
    }
    .fl-select {
        padding-top: 12px;
        padding-bottom: 2px;
    }
    .fl-req { color: #ef4444; margin-left: 2px; }

    .flatpickr-calendar {
        font-family: 'Poppins', sans-serif;
        font-size: 12px;
        border-radius: 16px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border: 1px solid #f3f4f6;
        padding: 8px;
        background: #ffffff;
    }
    .flatpickr-months {
        background: #294C9A;
        border-radius: 12px 12px 0 0;
        margin: -8px -8px 8px -8px;
        padding: 8px 0;
    }
    .flatpickr-months .flatpickr-month {
        background: transparent;
        color: white;
    }
    .flatpickr-current-month .flatpickr-monthDropdown-months {
        font-weight: 600;
        background: transparent;
        color: white;
    }
    .flatpickr-current-month input.cur-year {
        font-weight: 600;
        color: white !important;
    }
    .flatpickr-current-month .numInputWrapper span.arrowUp:after {
        border-bottom-color: white;
    }
    .flatpickr-current-month .numInputWrapper span.arrowDown:after {
        border-top-color: white;
    }
    .flatpickr-prev-month, .flatpickr-next-month {
        padding: 10px;
        color: white !important;
        fill: white !important;
    }
    .flatpickr-prev-month svg, .flatpickr-next-month svg {
        fill: white !important;
    }
    .flatpickr-prev-month:hover svg, .flatpickr-next-month:hover svg {
        fill: #d1d5db !important;
    }
    .flatpickr-weekday {
        color: #294C9A;
        font-weight: 600;
        font-size: 11px;
    }
    .flatpickr-day {
        border-radius: 50% !important;
        transition: all 0.15s ease;
        margin: 2px auto;
        font-weight: 500;
        height: 34px;
        line-height: 32px;
        width: 34px;
    }
    .flatpickr-day.today {
        border-color: #294C9A;
        color: #294C9A;
        font-weight: 700;
    }
    .flatpickr-day.today:hover {
        background: #EEF2FF;
        color: #294C9A;
    }
    .flatpickr-day.selected, .flatpickr-day.selected:hover, .flatpickr-day.selected:focus {
        background: #294C9A !important;
        border-color: #294C9A !important;
        color: #ffffff !important;
        box-shadow: 0 4px 6px -1px rgba(41, 76, 154, 0.4);
    }
    .flatpickr-day:hover, .flatpickr-day:focus {
        background: #EEF2FF !important;
        border-color: transparent !important;
        color: #294C9A !important;
    }
    .flatpickr-day.flatpickr-disabled, .flatpickr-day.flatpickr-disabled:hover {
        color: #d1d5db !important;
        background: transparent !important;
    }
    .flatpickr-day.prevMonthDay, .flatpickr-day.nextMonthDay {
        color: #9ca3af;
    }
    
    [x-cloak] { display: none !important; }
    </style>

    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Laporan Produksi</h2>
        <p class="text-sm text-gray-500 mt-1">Cetak laporan mutasi produksi dan rekap mutasi.</p>
    </div>

    @if(session('error'))
        <div class="p-4 mb-6 text-sm text-red-700 bg-red-50 rounded-xl border border-red-200 flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div x-data="{ tab: 'mutasi' }" class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
        <!-- Sidebar Menu Laporan -->
        <div class="lg:col-span-1 bg-white rounded-2xl border border-gray-100 shadow-sm p-4 space-y-2">
            <button @click="tab = 'mutasi'" :class="tab === 'mutasi' ? 'bg-[#294C9A] text-white' : 'text-gray-700 hover:bg-gray-50'" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-left text-xs font-semibold transition">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Mutasi Produksi
            </button>
            <button @click="tab = 'rekap'" :class="tab === 'rekap' ? 'bg-[#294C9A] text-white' : 'text-gray-700 hover:bg-gray-50'" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-left text-xs font-semibold transition">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Rekap Mutasi
            </button>
        </div>

        <!-- Form Area -->
        <div class="lg:col-span-3">
            <!-- Form Mutasi Produksi -->
            <div x-show="tab === 'mutasi'" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="bg-[#294C9A] px-6 py-4 border-b border-white/10 flex gap-3 text-white">
                    <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <div>
                        <h3 class="text-sm font-bold">Laporan Mutasi Produksi</h3>
                        <p class="text-[11px] text-blue-100/80 mt-0.5">Cetak laporan mutasi harian barang produksi berdasarkan tanggal dan produk.</p>
                    </div>
                </div>
                <div class="p-6">
                    @include('produksi.laporan.mutasiproduksi')
                </div>
            </div>

            <!-- Form Rekap Mutasi -->
            <div x-show="tab === 'rekap'" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" x-cloak>
                <div class="bg-[#294C9A] px-6 py-4 border-b border-white/10 flex gap-3 text-white">
                    <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <div>
                        <h3 class="text-sm font-bold">Laporan Rekap Mutasi Produksi</h3>
                        <p class="text-[11px] text-blue-100/80 mt-0.5">Cetak rekapitulasi total mutasi masuk dan keluar barang produksi per bulan.</p>
                    </div>
                </div>
                <div class="p-6">
                    @include('produksi.laporan.rekapmutasiproduksi')
                </div>
            </div>
        </div>
    </div>

    <!-- Flatpickr Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

    @push('myscript')
    <script>
        $(document).ready(function() {
            flatpickr(".flatpickr-date", {
                locale: "id",
                dateFormat: "Y-m-d"
            });

            // Handle select tag changes for floating labels
            $('.fl-select').each(function() {
                if($(this).val() !== "") {
                    $(this).addClass('has-value');
                }
            });
            $(document).on('change', '.fl-select', function() {
                if($(this).val() !== "") {
                    $(this).addClass('has-value');
                } else {
                    $(this).removeClass('has-value');
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
