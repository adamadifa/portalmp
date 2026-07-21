<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
        
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Flatpickr Premium Circular Calendar Styles -->
        <style>
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

            /* Custom Select2 Overrides */
            .select2-container {
                width: 100% !important;
            }
            .select2-container--default .select2-selection--single {
                background-color: #f9fafb !important;
                border: 1.5px solid #e5e7eb !important;
                border-radius: 10px !important;
                height: 42px !important;
                padding-top: 14px !important;
                outline: none !important;
                transition: border-color 0.2s, box-shadow 0.2s;
                position: relative !important;
            }
            .select2-container--default .select2-selection--single:focus,
            .select2-container--default.select2-container--focus .select2-selection--single {
                border-color: #294C9A !important;
                box-shadow: 0 0 0 3px rgba(41,76,154,0.1) !important;
                background-color: #fff !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                color: #111827 !important;
                font-size: 12px !important;
                padding-left: 14px !important;
                padding-right: 40px !important;
                line-height: 24px !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__clear {
                position: absolute !important;
                right: 32px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                font-size: 16px !important;
                color: #9ca3af !important;
                font-weight: bold !important;
                margin-right: 0 !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__clear:hover {
                color: #ef4444 !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 40px !important;
                right: 12px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
            }
            .select2-dropdown {
                border: 1.5px solid #e5e7eb !important;
                border-radius: 10px !important;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05) !important;
                overflow: hidden !important;
                z-index: 9999 !important;
            }
            .select2-search--dropdown {
                padding: 6px 8px !important;
                background-color: #f9fafb !important;
                box-sizing: border-box !important;
            }
            .select2-search--dropdown .select2-search__field {
                border: 1.5px solid #e5e7eb !important;
                border-radius: 8px !important;
                padding: 6px 10px !important;
                font-size: 12px !important;
                outline: none !important;
                background-color: #fff !important;
                box-sizing: border-box !important;
                width: 100% !important;
            }
            .select2-container--default .select2-results__option--highlighted[aria-selected] {
                background-color: #294C9A !important;
                color: #fff !important;
            }
            .select2-container--default .select2-results__option {
                padding: 8px 14px !important;
                font-size: 12px !important;
            }
            .select2-container--default .select2-search--dropdown .select2-search__field {
                border: 1.5px solid #e5e7eb !important;
                border-radius: 8px !important;
                padding: 6px 10px !important;
                font-size: 12px !important;
                outline: none !important;
            }
            .select2-container--default .select2-search--dropdown .select2-search__field:focus {
                border-color: #294C9A !important;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-800 bg-[#f9fafb]">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="relative flex flex-col flex-1 min-w-0 overflow-y-auto overflow-x-hidden">
                <!-- Header -->
                @include('layouts.header')

                <!-- Page Content -->
                <main class="w-full p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
        <!-- Scripts & Libs -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @stack('myscript')
    </body>
</html>
