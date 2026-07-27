<?php
$start_year = 2020;
$hari_ini = date('Y-m-d');

return  [
    'nama_bulan_singkat' => ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
    'nama_bulan' => ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
    'list_bulan' => (object) [
        [
            'kode_bulan' => '1',
            'nama_bulan' => 'Januari'
        ],
        [
            'kode_bulan' => '2',
            'nama_bulan' => 'Februari'
        ],
        [
            'kode_bulan' => '3',
            'nama_bulan' => 'Maret'
        ],
        [
            'kode_bulan' => '4',
            'nama_bulan' => 'April'
        ],
        [
            'kode_bulan' => '5',
            'nama_bulan' => 'Mei'
        ],
        [
            'kode_bulan' => '6',
            'nama_bulan' => 'Juni'
        ],
        [
            'kode_bulan' => '7',
            'nama_bulan' => 'Juli'
        ],
        [
            'kode_bulan' => '8',
            'nama_bulan' => 'Agustus'
        ],
        [
            'kode_bulan' => '9',
            'nama_bulan' => 'September'
        ],
        [
            'kode_bulan' => '10',
            'nama_bulan' => 'Oktober'
        ],
        [
            'kode_bulan' => '11',
            'nama_bulan' => 'November'
        ],
        [
            'kode_bulan' => '12',
            'nama_bulan' => 'Desember'
        ],
    ],

    'start_year' => $start_year,
    'start_date' => $start_year . "-01-01",
    'end_date' => date('Y-m-t', strtotime($hari_ini)),

    'roles_access_all_cabang' => [
        'super admin',
        'gm administrasi',
        'gm marketing',
        'gm operasional',
        'manager keuangan',
        'direktur',
        'asst. manager hrd',
        'staff keuangan',
        'admin pajak',
        'manager audit',
        'audit',
        'regional operation manager',
        'crm',
        'spv accounting',
        'manager general affair',
        'general affair',
        'spv presensi',
        'manager gudang',
        'spv gudang pusat',
        'admin gudang pusat',
        'gm operasional',
        'admin pusat'
    ],
    'roles_show_cabang' => [
        'super admin',
        'gm administrasi',
        'gm marketing',
        'manager keuangan',
        'direktur',
        'staff keuangan',
        'regional sales manager',
        'asst. manager hrd',
        'admin pajak',
        'manager audit',
        'audit',
        'regional operation manager',
        'crm',
        'spv accounting',
        'manager general affair',
        'general affair',
        'spv presensi',
        'manager gudang',
        'spv gudang pusat',
        'admin gudang pusat',
        'gm operasional',
        'admin pusat'
    ],
];
