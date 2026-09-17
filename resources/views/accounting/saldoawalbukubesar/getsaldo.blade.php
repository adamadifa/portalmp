@php
    $subtotal_level_0 = 0;
    $level_0_name = '';

    $subtotal_level_1 = 0;
    $level_1_name = '';

    $subtotal_level_2 = 0;
    $level_2_name = '';

    $subtotal_aktiva = 0;
    $subtotal_hutang = 0;
    $subtotal_modal = 0;
@endphp

@foreach ($accounts as $index => $d)
    @php
        $indent = ($d->level ?? 0) * 16;
        $next_level = $accounts[$index + 1]->level ?? null;
        $next_kode_akun = $accounts[$index + 1]->kode_akun ?? null;

        $saldo_val = $saldo_map[$d->kode_akun] ?? 0;

        // Subtotal tracking
        if ($d->level == 0) {
            $level_0_name = $d->nama_akun;
        }
        $subtotal_level_0 += $saldo_val;

        if ($d->level == 1) {
            $level_1_name = $d->nama_akun;
        }
        $subtotal_level_1 += $saldo_val;

        if ($d->level == 2) {
            $level_2_name = $d->nama_akun;
        }
        $subtotal_level_2 += $saldo_val;

        if (substr($d->kode_akun, 0, 1) == '1') {
            $subtotal_aktiva += $saldo_val;
        } elseif (substr($d->kode_akun, 0, 1) == '2') {
            $subtotal_hutang += $saldo_val;
        } elseif (substr($d->kode_akun, 0, 1) == '3') {
            $subtotal_modal += $saldo_val;
        }
    @endphp

    <tr class="{{ $d->level < 3 ? 'bg-gray-50/50 font-semibold text-gray-900' : 'hover:bg-blue-50/20 text-gray-700' }}">
        <td class="px-4 py-2.5" style="padding-left: {{ max(16, $indent) }}px;">
            @if ($d->level < 3)
                <span class="text-xs font-mono font-bold text-gray-500 mr-2">{{ $d->kode_akun }}</span>
                <span class="font-bold text-gray-900">{{ $d->nama_akun }}</span>
            @else
                <span class="text-xs font-mono text-gray-400 mr-2">{{ $d->kode_akun }}</span>
                <span>{{ $d->nama_akun }}</span>
            @endif
            <input type="hidden" name="kode_akun[]" value="{{ $d->kode_akun }}">
        </td>
        <td class="px-4 py-2 text-right">
            @if ($d->level < 3)
                <span class="text-xs text-gray-400 italic">Akun Induk</span>
                <input type="hidden" name="jumlah[]" value="0">
            @else
                <input type="text" name="jumlah[]" value="{{ formatAngka($saldo_val) }}" 
                    class="w-full max-w-[200px] ml-auto text-right py-1.5 px-3 text-xs bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#294C9A] focus:outline-none transition money">
            @endif
        </td>
    </tr>
@endforeach
