<?php

function buatkode($nomor_terakhir, $kunci, $jumlah_karakter = 0)
{
    /* mencari nomor baru dengan memecah nomor terakhir dan menambahkan 1
    string nomor baru dibawah ini harus dengan format XXX000000
    untuk penggunaan dalam format lain anda harus menyesuaikan sendiri */
    $nomor_baru = intval(substr($nomor_terakhir, strlen($kunci))) + 1;
    //    menambahkan nol didepan nomor baru sesuai panjang jumlah karakter
    $nomor_baru_plus_nol = str_pad($nomor_baru, $jumlah_karakter, "0", STR_PAD_LEFT);
    //    menyusun kunci dan nomor baru
    $kode = $kunci . $nomor_baru_plus_nol;
    return $kode;
}

function messageSuccess($message)
{
    return ['success' => $message];
}

function messageError($message)
{
    return ['error' => $message];
}

// Mengubah ke Huruf Besar
if (!function_exists('textUpperCase')) {
    function textUpperCase($value)
    {
        return strtoupper(strtolower($value));
    }
}

// Mengubah ke CamelCase
if (!function_exists('textCamelCase')) {
    function textCamelCase($value)
    {
        return ucwords(strtolower($value));
    }
}

if (!function_exists('toNumber')) {
    function toNumber($value)
    {
        if (!empty($value)) {
            return str_replace([".", ","], ["", "."], $value);
        } else {
            return 0;
        }
    }
}

if (!function_exists('formatRupiah')) {
    function formatRupiah($nilai)
    {
        return number_format($nilai, '0', ',', '.');
    }
}

if (!function_exists('formatAngka')) {
    function formatAngka($nilai)
    {
        if (!empty($nilai)) {
            return number_format($nilai, '0', ',', '.');
        }
    }
}

if (!function_exists('DateToIndo')) {
    function DateToIndo($date2)
    {
        $BulanIndo2 = array(
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        );

        if (!empty($date2)) {
            $tahun2 = substr($date2, 0, 4);
            $bulan2 = substr($date2, 5, 2);
            $tgl2 = substr($date2, 8, 2);

            $result = $tgl2 . " " . $BulanIndo2[(int) $bulan2 - 1] . " " . $tahun2;
            return ($result);
        } else {
            return "";
        }
    }
}

if (!function_exists('cektutupLaporan')) {
    function cektutupLaporan($tgl, $jenislaporan)
    {
        return 0;
    }
}

if (!function_exists('getbulandantahunlalu')) {
    function getbulandantahunlalu($bulan, $tahun, $show)
    {
        if ($bulan == 1) {
            $bulanlalu = 12;
            $tahunlalu = $tahun - 1;
        } else {
            $bulanlalu = $bulan - 1;
            $tahunlalu = $tahun;
        }

        if ($show == "tahun") {
            return $tahunlalu;
        } elseif ($show == "bulan") {
            return $bulanlalu;
        }
    }
}

if (!function_exists('getbulandantahunberikutnya')) {
    function getbulandantahunberikutnya($bulan, $tahun, $show)
    {
        if ($bulan == 12) {
            $bulanberikutnya = 1;
            $tahunberikutnya = $tahun + 1;
        } else {
            $bulanberikutnya = $bulan + 1;
            $tahunberikutnya = $tahun;
        }

        if ($show == "tahun") {
            return $tahunberikutnya;
        } elseif ($show == "bulan") {
            return $bulanberikutnya;
        }
    }
}
