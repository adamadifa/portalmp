<x-app-layout>
    <style>
        .welcome-card-premium {
            background: linear-gradient(135deg, #294C9A 0%, #162a5b 100%);
            border-radius: 24px;
            position: relative;
            overflow: visible;
            color: #fff;
            padding: 2.25rem 2.5rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 20px 40px -15px rgba(22, 42, 91, 0.35);
        }

        .welcome-card-premium::before {
            content: '';
            position: absolute;
            top: -15%;
            right: -5%;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.15) 0%, transparent 70%);
            z-index: 0;
            pointer-events: none;
        }

        .welcome-content {
            position: relative;
            z-index: 2;
            max-width: 65%;
        }

        .welcome-illustration {
            position: absolute;
            right: 2rem;
            bottom: -2px;
            height: 130%;
            max-height: 280px;
            z-index: 1;
            opacity: 1;
            filter: drop-shadow(0 15px 25px rgba(0, 0, 0, 0.35));
            -webkit-mask-image: linear-gradient(to bottom, black 80%, transparent 100%);
            mask-image: linear-gradient(to bottom, black 80%, transparent 100%);
        }

        .welcome-greeting {
            font-size: 1.85rem;
            font-weight: 800;
            margin-bottom: 0.6rem;
            letter-spacing: -0.5px;
            color: #fff !important;
            line-height: 1.25;
        }

        .welcome-subtext {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 1.25rem;
            line-height: 1.5;
        }

        .welcome-date-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            padding: 0.4rem 0.9rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 500;
            border: 1px solid rgba(255, 255, 255, 0.15);
            margin-bottom: 1rem;
        }

        .welcome-role-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            background: rgba(0, 210, 255, 0.12);
            color: #38bdf8;
            border: 1px solid rgba(56, 189, 248, 0.25);
            padding: 0.35rem 0.85rem;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .welcome-waves {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 70px;
            pointer-events: none;
            z-index: 0;
            border-radius: 0 0 24px 24px;
            overflow: hidden;
        }

        .welcome-waves svg {
            width: 100%;
            height: 100%;
            display: block;
        }

        .welcome-waves .wave-1 {
            animation: wave-move-1 12s linear infinite;
        }

        .welcome-waves .wave-2 {
            animation: wave-move-2 18s linear infinite;
        }

        @keyframes wave-move-1 {
            0% { transform: translateX(0) scaleY(1); }
            50% { transform: translateX(-15%) scaleY(1.08); }
            100% { transform: translateX(0) scaleY(1); }
        }

        @keyframes wave-move-2 {
            0% { transform: translateX(0) scaleY(1); }
            50% { transform: translateX(15%) scaleY(0.92); }
            100% { transform: translateX(0) scaleY(1); }
        }

        @media (max-width: 1023px) {
            .welcome-content {
                max-width: 100%;
                text-align: left;
            }
            .welcome-illustration {
                display: none;
            }
            .welcome-card-premium {
                padding: 2rem 1.5rem;
                margin-top: 1rem;
            }
        }
    </style>

    <div class="welcome-card-premium">
        @if (file_exists(public_path('karakter.png')))
            <img src="{{ asset('karakter.png') }}" alt="Welcome Character" class="welcome-illustration">
        @endif
        
        <div class="welcome-content">
            <div class="welcome-date-badge">
                <svg class="w-4 h-4 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>{{ DateToIndo(date('Y-m-d')) }}</span>
            </div>
            
            <h2 class="welcome-greeting">
                Selamat Datang, 
                @php
                    $nameParts = explode(' ', trim(Auth::user()->name ?? 'User'));
                    echo count($nameParts) > 1 ? $nameParts[0] . ' ' . $nameParts[1] : $nameParts[0];
                @endphp! 🎉
            </h2>
            
            <p class="welcome-subtext">
                Selamat bekerja di Portal MP. Silakan gunakan menu navigasi di sidebar untuk mengelola transaksi, data gudang & logistik, serta laporan operasional.
            </p>
            
            <div class="welcome-role-badge">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                <span>{{ Auth::user()->roles->pluck('name')->first() ?? 'User' }}</span>
            </div>
        </div>

        <div class="welcome-waves">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
                <path class="wave-1" fill="rgba(255, 255, 255, 0.05)" d="M0,96L48,112C96,128,192,160,288,186.7C384,213,480,235,576,213.3C672,192,768,128,864,122.7C960,117,1056,171,1152,197.3C1248,224,1344,224,1392,224L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                <path class="wave-2" fill="rgba(255, 255, 255, 0.03)" d="M0,192L48,197.3C96,203,192,213,288,202.7C384,192,480,160,576,138.7C672,117,768,107,864,122.7C960,139,1056,181,1152,181.3C1248,181,1344,139,1392,117.3L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </div>
</x-app-layout>
