<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Supplier {{ date('Y-m-d H:i:s') }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #333333;
        }
        .header {
            margin-bottom: 20px;
        }
        .header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            color: #1E3A70;
            text-transform: uppercase;
        }
        .header p {
            margin: 4px 0 0 0;
            font-size: 11px;
            color: #666;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th {
            background-color: #294C9A;
            color: #ffffff;
            font-weight: bold;
            border: 1px solid #1E3A70;
            padding: 8px 6px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
        }
        td {
            border: 1px solid #d1d5db;
            padding: 6px 8px;
            vertical-align: top;
            font-size: 11px;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .text-center {
            text-align: center;
        }
        .font-mono {
            font-family: Consolas, monospace;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>DATA MASTER SUPPLIER</h3>
        <p>Tanggal Export: {{ date('d-m-Y H:i:s') }} | Total Supplier: {{ count($supplier) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 40px;" class="text-center">NO</th>
                <th style="width: 100px;">KODE SUPPLIER</th>
                <th style="width: 250px;">NAMA SUPPLIER</th>
                <th style="width: 180px;">CONTACT PERSON</th>
                <th style="width: 130px;">NO. TELEPON / HP</th>
                <th style="width: 150px;">EMAIL</th>
                <th style="width: 180px;">NO. REKENING</th>
                <th style="width: 300px;">ALAMAT</th>
            </tr>
        </thead>
        <tbody>
            @forelse($supplier as $d)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="font-mono text-center" style="mso-number-format:'\@';">{{ $d->kode_supplier }}</td>
                    <td style="font-weight: bold;">{{ strtoupper($d->nama_supplier) }}</td>
                    <td>{!! strip_tags($d->contact_person) ?: '-' !!}</td>
                    <td style="mso-number-format:'\@';">{{ $d->no_hp_supplier ?: '-' }}</td>
                    <td>{{ $d->email_supplier ?: '-' }}</td>
                    <td class="font-mono" style="mso-number-format:'\@';">{{ $d->no_rekening_supplier ?: '-' }}</td>
                    <td>{{ $d->alamat_supplier ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px; color: #888;">Tidak ada data supplier.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
