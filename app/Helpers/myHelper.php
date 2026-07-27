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

if (!function_exists('lockreport')) {
    function lockreport($tanggal)
    {
        $start_year = config('global.start_year');
        $lock_date = $start_year . "-01-01";

        if ($tanggal < $lock_date && !empty($tanggal)) {
            return "error";
        } else {
            return "success";
        }
    }
}

if (!function_exists('formatAngkaDesimal')) {
    function formatAngkaDesimal($nilai)
    {
        if (!empty($nilai)) {
            return number_format($nilai, '2', ',', '.');
        }
        return '0,00';
    }
}

if (!function_exists('formatAngkaDesimal3')) {
    function formatAngkaDesimal3($nilai)
    {
        if (!empty($nilai)) {
            return number_format($nilai, '3', ',', '.');
        }
        return '0,000';
    }
}

if (!function_exists('formatAngkaDesimal5')) {
    function formatAngkaDesimal5($nilai)
    {
        if (!empty($nilai)) {
            return number_format($nilai, '5', ',', '.');
        }
        return '0,00000';
    }
}

if (!function_exists('getBeratliter')) {
    function getBeratliter($tanggal)
    {
        if ($tanggal <= "2022-03-01") {
            $berat = 0.9064;
        } else {
            $berat = 1;
        }
        return $berat;
    }
}

if (!function_exists('formatIndo')) {
    function formatIndo($date)
    {
        $tanggal = !empty($date) ? date('d-m-Y', strtotime($date)) : '';
        return $tanggal;
    }
}

if (!function_exists('formatIndo2')) {
    function formatIndo2($date)
    {
        $tanggal = !empty($date) ? date('d-m-y', strtotime($date)) : '';
        return $tanggal;
    }
}

if (!function_exists('penyebut')) {
    function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }
}

if (!function_exists('terbilang')) {
    function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim(penyebut($nilai));
        } else {
            $hasil = trim(penyebut($nilai));
        }
        return $hasil;
    }
}

if (!function_exists('removeSpecialCharacters')) {
    function removeSpecialCharacters($string)
    {
        return preg_replace('/[^a-zA-Z0-9]/', '', $string);
    }
}



