<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? ($header ?? config('app.name', 'Portal MP')) }} - Pacific</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Compiled Tailwind CSS & JS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- ApexCharts for rich analytics charts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Flatpickr (Modern Datepicker) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

    <!-- Select2 (Searchable Select) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets/js/easy-number-separator.js') }}"></script>

    <!-- Theme Initializer (Default: Light Mode) -->
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Poppins', sans-serif;
        }

        /* Sidebar collapse transition */
        #sidebar {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), padding 0.3s ease;
        }
        .sidebar-collapsed {
            width: 5rem !important; /* w-20 */
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
        .sidebar-collapsed .nav-text,
        .sidebar-collapsed .section-header,
        .sidebar-collapsed .sidebar-profile-text,
        .sidebar-collapsed .brand-text,
        .sidebar-collapsed .submenu-wrapper,
        .sidebar-collapsed .chevron-icon {
            display: none !important;
        }
        .sidebar-collapsed .nav-item {
            justify-content: center !important;
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }
        .sidebar-collapsed .brand-header {
            justify-content: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        .sidebar-collapsed .user-profile-box {
            justify-content: center !important;
            padding: 0.5rem 0 !important;
        }

        /* Modern Flatpickr Tweaks */
        .flatpickr-calendar {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            border-radius: 1rem !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
            z-index: 99999 !important;
        }
        .dark .flatpickr-calendar {
            background: #0f172a !important;
            border-color: #334155 !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5) !important;
        }
        .dark .flatpickr-calendar .flatpickr-month {
            background: #0f172a !important;
            color: #f8fafc !important;
            fill: #f8fafc !important;
        }
        .dark .flatpickr-calendar .flatpickr-weekday {
            background: #0f172a !important;
            color: #94a3b8 !important;
        }
        .dark .flatpickr-calendar .flatpickr-day {
            color: #cbd5e1 !important;
        }
        .dark .flatpickr-calendar .flatpickr-day.today {
            border-color: #3b82f6 !important;
        }
        .flatpickr-day.selected {
            background: #2563eb !important;
            border-color: #2563eb !important;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        .dark ::-webkit-scrollbar-track {
            background: #0f172a;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: #334155;
        }

        /* SweetAlert2 Toast Modern Styling */
        .swal2-container.swal2-top-end,
        .swal2-container.swal2-top,
        .swal2-container:has(.swal2-toast) {
            background: transparent !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            pointer-events: none !important;
            z-index: 999999 !important;
        }
        .swal2-toast {
            pointer-events: auto !important;
            border-radius: 0.75rem !important;
            padding: 0.75rem 1rem !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
        .swal2-toast.toast-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            color: #ffffff !important;
        }
        .swal2-toast.toast-error {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%) !important;
            color: #ffffff !important;
        }
        .swal2-toast.toast-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
            color: #ffffff !important;
        }
        .swal2-toast.toast-info {
            background: linear-gradient(135deg, #162a5b 0%, #1f3a7a 100%) !important;
            color: #ffffff !important;
        }
        .swal2-toast .swal2-title {
            color: #ffffff !important;
            font-size: 0.8125rem !important;
            font-weight: 700 !important;
            margin: 0 !important;
            line-height: 1.4 !important;
        }
        .swal2-toast .swal2-icon {
            border-color: rgba(255, 255, 255, 0.9) !important;
            color: #ffffff !important;
            margin: 0 !important;
            transform: scale(0.8) !important;
        }
        .swal2-toast .swal2-close {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        .swal2-toast .swal2-timer-progress-bar {
            background: rgba(255, 255, 255, 0.4) !important;
        }
    </style>
    @stack('styles')
</head>
<body class="h-screen w-screen overflow-hidden text-slate-800 dark:text-slate-100 antialiased bg-[#f8fafc] dark:bg-slate-950 p-0 m-0 transition-colors duration-200">

    <!-- Mobile Backdrop Overlay -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-40 hidden lg:hidden transition-opacity"></div>

    <!-- Edge-to-Edge True Full Screen Flex Layout -->
    <div class="h-full w-full bg-[#f8fafc] dark:bg-slate-950 flex overflow-hidden">
        
        <!-- SIDEBAR -->
        @include('layouts.sidebar')

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 flex flex-col min-w-0 bg-[#f8fafc] dark:bg-slate-950 h-full overflow-y-auto transition-colors duration-200">
            
            <!-- TOP NAVBAR -->
            @include('layouts.header')

            <!-- PAGE HEADER: TITLE & BREADCRUMBS -->
            @if(isset($header) || isset($headerTitle))
            <div class="px-6 lg:px-10 pt-6 pb-2 shrink-0 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ $header ?? ($headerTitle ?? 'Dashboard') }}</h1>
                    @if(isset($headerDescription) && $headerDescription)
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $headerDescription }}</p>
                    @endif
                </div>

                <!-- Breadcrumbs on the right -->
                <nav class="flex items-center gap-1.5 text-xs font-medium text-slate-400 bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 px-3.5 py-1.5 rounded-xl shadow-2xs shrink-0 self-start sm:self-auto">
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition flex items-center gap-1 text-slate-500 dark:text-slate-400">
                        <i data-lucide="home" class="w-3.5 h-3.5 text-slate-400"></i>
                        <span>Home</span>
                    </a>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300 dark:text-slate-600"></i>
                    @if(isset($breadcrumbParent))
                        <span class="text-slate-500 dark:text-slate-400">{{ $breadcrumbParent }}</span>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300 dark:text-slate-600"></i>
                    @endif
                    <span class="text-slate-800 dark:text-slate-200 font-bold">{{ $breadcrumbCurrent ?? ($header ?? ($headerTitle ?? 'Dashboard')) }}</span>
                </nav>
            </div>
            @endif

            <!-- VIEW CONTENT -->
            <div class="p-6 lg:p-8 space-y-6 flex-1 bg-[#f8fafc] dark:bg-slate-950 transition-colors duration-200">
                {{ $slot ?? '' }}
                @yield('content')
            </div>

        </main>
    </div>

    <!-- Modals Portal -->
    @stack('modals')

    <!-- Spotlight Command Palette Partial -->
    @include('layouts._command_palette')

    <!-- Interactive Scripts for Sidebar, Theme Toggle, & Plugins -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            const sidebar = document.getElementById('sidebar');
            const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
            const openMobileSidebarBtn = document.getElementById('openMobileSidebarBtn');
            const closeMobileSidebarBtn = document.getElementById('closeMobileSidebarBtn');
            const sidebarBackdrop = document.getElementById('sidebarBackdrop');
            const themeToggleBtn = document.getElementById('themeToggleBtn');

            // 1. Dark / Light Mode Toggle with Persistence
            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', function () {
                    const isDark = document.documentElement.classList.toggle('dark');
                    localStorage.setItem('theme', isDark ? 'dark' : 'light');
                    if (typeof lucide !== 'undefined') lucide.createIcons();

                    window.dispatchEvent(new CustomEvent('themeChanged', { detail: { theme: isDark ? 'dark' : 'light' } }));
                });
            }

            // 2. Desktop Toggle Sidebar Minimize
            if (toggleSidebarBtn && sidebar) {
                toggleSidebarBtn.addEventListener('click', function () {
                    sidebar.classList.toggle('sidebar-collapsed');
                    
                    const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
                    const icon = toggleSidebarBtn.querySelector('i');
                    if (icon) {
                        icon.setAttribute('data-lucide', isCollapsed ? 'panel-left-open' : 'panel-left-close');
                        if (typeof lucide !== 'undefined') lucide.createIcons();
                    }

                    setTimeout(() => {
                        window.dispatchEvent(new Event('resize'));
                    }, 300);
                });
            }

            // 3. Mobile Open/Close Sidebar
            if (openMobileSidebarBtn && sidebar && sidebarBackdrop) {
                openMobileSidebarBtn.addEventListener('click', function () {
                    sidebar.classList.remove('-translate-x-full');
                    sidebarBackdrop.classList.remove('hidden');
                });
            }

            function closeMobileNav() {
                if (sidebar) sidebar.classList.add('-translate-x-full');
                if (sidebarBackdrop) sidebarBackdrop.classList.add('hidden');
            }

            if (closeMobileSidebarBtn) closeMobileSidebarBtn.addEventListener('click', closeMobileNav);
            if (sidebarBackdrop) sidebarBackdrop.addEventListener('click', closeMobileNav);

            // 4. Sidebar Scroll Position Persistence
            if (sidebar) {
                const savedScroll = sessionStorage.getItem('sidebar_scroll_top');
                if (savedScroll !== null) {
                    sidebar.scrollTop = parseInt(savedScroll, 10);
                }

                sidebar.addEventListener('scroll', function () {
                    sessionStorage.setItem('sidebar_scroll_top', sidebar.scrollTop);
                }, { passive: true });
            }

            // Flatpickr auto-init for inputs with .flatpickr-date
            if (typeof flatpickr !== 'undefined') {
                flatpickr(".flatpickr-date", {
                    dateFormat: "Y-m-d",
                    locale: "id"
                });
            }

            // Universal Modal Handler: Memastikan modal selalu berada di root <body> dan z-[100] agar menutup penuh sticky navbar & sidebar
            window.openModal = function(id) {
                const modal = document.getElementById(id);
                if (!modal) return;
                if (modal.parentElement !== document.body) {
                    document.body.appendChild(modal);
                }
                modal.classList.add('z-[100]');
                modal.classList.remove('hidden');
                const wrapper = document.getElementById(id + 'ContentWrapper') || modal.querySelector('[id$="ContentWrapper"]') || modal.firstElementChild;
                setTimeout(() => {
                    if (wrapper) {
                        wrapper.classList.remove('scale-95', 'opacity-0');
                        wrapper.classList.add('scale-100', 'opacity-100');
                    }
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                }, 50);
            };

            window.closeModal = function(id) {
                const modal = document.getElementById(id);
                if (!modal) return;
                const wrapper = document.getElementById(id + 'ContentWrapper') || modal.querySelector('[id$="ContentWrapper"]') || modal.firstElementChild;
                if (wrapper) {
                    wrapper.classList.remove('scale-100', 'opacity-100');
                    wrapper.classList.add('scale-95', 'opacity-0');
                }
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 250);
            };

            // Global Handler: Prevent Double-Submit & Show Loading Spinner on All Forms
            document.addEventListener('submit', function (e) {
                const form = e.target;
                if (!form || form.tagName !== 'FORM') return;

                // Jika validasi client-side gagal dan event dibatalkan, hentikan
                if (e.defaultPrevented) return;

                // Cari tombol submit pada form yang sedang dikirim
                const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                if (!submitBtn) return;

                // Cegah dobel klik jika sudah dalam status loading
                if (submitBtn.dataset.loading === 'true') {
                    e.preventDefault();
                    return false;
                }

                // Langsung matikan pointer-events agar klik berikutnya tidak direspons
                submitBtn.dataset.loading = 'true';
                submitBtn.style.pointerEvents = 'none';
                submitBtn.classList.add('opacity-80', 'cursor-wait');

                // Pertahankan lebar tombol agar tidak menyusut / melompat
                const btnWidth = submitBtn.offsetWidth;
                if (btnWidth > 0) {
                    submitBtn.style.minWidth = btnWidth + 'px';
                }

                // Tentukan teks loading berdasarkan teks tombol
                const originalText = (submitBtn.textContent || '').trim();
                const method = (form.getAttribute('method') || 'GET').toUpperCase();
                let loadingText = 'Memproses...';

                if (/simpan|tambah|save|store|create/i.test(originalText)) {
                    loadingText = 'Menyimpan...';
                } else if (/perbarui|update|ubah|edit/i.test(originalText)) {
                    loadingText = 'Memperbarui...';
                } else if (/hapus|delete/i.test(originalText)) {
                    loadingText = 'Menghapus...';
                } else if (/filter|cari|search/i.test(originalText) || method === 'GET') {
                    loadingText = 'Memuat...';
                }

                // Ganti konten tombol dengan spinner animasi
                submitBtn.innerHTML = `
                    <div class="inline-flex items-center justify-center gap-1.5 pointer-events-none">
                        <div class="w-3.5 h-3.5 border-2 border-current border-t-transparent rounded-full animate-spin shrink-0"></div>
                        <span>${loadingText}</span>
                    </div>
                `;

                // Disable secara native pada tick berikutnya agar browser tidak membatalkan submit
                setTimeout(function () {
                    submitBtn.disabled = true;
                }, 10);
            }, false);
        });

        // Global Toast Notification Helper
        window.showToast = function(type, message) {
            if (typeof Swal === 'undefined') {
                alert(message);
                return;
            }
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: type,
                iconColor: '#ffffff',
                title: message,
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,
                showCloseButton: true,
                customClass: {
                    popup: `toast-${type}`
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
        };
    </script>

    <!-- Session Flash Toast Alerts (Auto-Triggered on Page Load) -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.showToast('success', {!! json_encode(session('success')) !!});
            });
        </script>
    @endif

    @if(session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.showToast('success', {!! json_encode(session('status')) !!});
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.showToast('error', {!! json_encode(session('error')) !!});
            });
        </script>
    @endif

    @if(session('warning'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.showToast('warning', {!! json_encode(session('warning')) !!});
            });
        </script>
    @endif

    @if(session('info'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.showToast('info', {!! json_encode(session('info')) !!});
            });
        </script>
    @endif

    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.showToast('error', {!! json_encode($errors->first()) !!});
            });
        </script>
    @endif

    @stack('myscript')
</body>
</html>
