<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        // 1. Master Data Stats
        $totalProduk = 0;
        $totalPelanggan = 0;
        $totalSupplier = 0;

        try {
            $totalProduk = Produk::count();
        } catch (\Throwable $e) {
        }

        try {
            $totalPelanggan = Pelanggan::count();
        } catch (\Throwable $e) {
        }

        try {
            $totalSupplier = Supplier::count();
        } catch (\Throwable $e) {
        }

        // 2. Sales & Marketing Stats
        $todaySales = 0;
        $thisMonthSales = 0;
        $todayTransactions = 0;
        $thisMonthTransactions = 0;
        $recentSales = collect();

        try {
            $salesMonthQuery = DB::table('marketing_penjualan')
                ->whereBetween('tanggal', [$startOfMonth, $endOfMonth]);
            $thisMonthTransactions = $salesMonthQuery->count();

            $thisMonthSales = DB::table('marketing_penjualan')
                ->join('marketing_penjualan_detail', 'marketing_penjualan.no_bukti', '=', 'marketing_penjualan_detail.no_bukti')
                ->whereBetween('marketing_penjualan.tanggal', [$startOfMonth, $endOfMonth])
                ->sum('marketing_penjualan_detail.subtotal');

            $todayTransactions = DB::table('marketing_penjualan')
                ->where('tanggal', $today)
                ->count();

            $todaySales = DB::table('marketing_penjualan')
                ->join('marketing_penjualan_detail', 'marketing_penjualan.no_bukti', '=', 'marketing_penjualan_detail.no_bukti')
                ->where('marketing_penjualan.tanggal', $today)
                ->sum('marketing_penjualan_detail.subtotal');

            $recentSales = DB::table('marketing_penjualan')
                ->leftJoin('pelanggan', 'marketing_penjualan.kode_pelanggan', '=', 'pelanggan.kode_pelanggan')
                ->select(
                    'marketing_penjualan.no_bukti',
                    'marketing_penjualan.tanggal',
                    'marketing_penjualan.kode_pelanggan',
                    'pelanggan.nama_pelanggan',
                    DB::raw('(SELECT SUM(subtotal) FROM marketing_penjualan_detail WHERE no_bukti = marketing_penjualan.no_bukti) as total')
                )
                ->orderBy('marketing_penjualan.tanggal', 'desc')
                ->orderBy('marketing_penjualan.no_bukti', 'desc')
                ->limit(6)
                ->get();
        } catch (\Throwable $e) {
        }

        // 3. Purchase Stats
        $thisMonthPurchases = 0;
        $thisMonthPurchaseCount = 0;
        $recentPurchases = collect();

        try {
            $thisMonthPurchaseCount = DB::table('pembelian')
                ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
                ->count();

            $thisMonthPurchases = DB::table('pembelian_detail')
                ->join('pembelian', 'pembelian_detail.no_bukti', '=', 'pembelian.no_bukti')
                ->whereBetween('pembelian.tanggal', [$startOfMonth, $endOfMonth])
                ->sum(DB::raw('pembelian_detail.jumlah * pembelian_detail.harga'));

            $recentPurchases = DB::table('pembelian')
                ->leftJoin('supplier', 'pembelian.kode_supplier', '=', 'supplier.kode_supplier')
                ->select(
                    'pembelian.no_bukti',
                    'pembelian.tanggal',
                    'pembelian.kode_supplier',
                    'supplier.nama_supplier',
                    DB::raw('(SELECT SUM(jumlah * harga) FROM pembelian_detail WHERE no_bukti = pembelian.no_bukti) as total')
                )
                ->orderBy('pembelian.tanggal', 'desc')
                ->orderBy('pembelian.no_bukti', 'desc')
                ->limit(6)
                ->get();
        } catch (\Throwable $e) {
        }

        // 4. Biaya Stats
        $thisMonthBiaya = 0;
        try {
            $thisMonthBiaya = DB::table('biaya')
                ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
                ->sum('jumlah');
        } catch (\Throwable $e) {
        }

        // 5. Monthly Trend Chart (Last 6 Months)
        $chartLabels = [];
        $chartSalesData = [];
        $chartPurchaseData = [];

        try {
            for ($i = 5; $i >= 0; $i--) {
                $monthDate = Carbon::now()->subMonths($i);
                $monthStart = $monthDate->copy()->startOfMonth()->toDateString();
                $monthEnd = $monthDate->copy()->endOfMonth()->toDateString();

                $chartLabels[] = $monthDate->translatedFormat('M Y');

                $mSales = DB::table('marketing_penjualan_detail')
                    ->join('marketing_penjualan', 'marketing_penjualan_detail.no_bukti', '=', 'marketing_penjualan.no_bukti')
                    ->whereBetween('marketing_penjualan.tanggal', [$monthStart, $monthEnd])
                    ->sum('marketing_penjualan_detail.subtotal');

                $mPurchases = DB::table('pembelian_detail')
                    ->join('pembelian', 'pembelian_detail.no_bukti', '=', 'pembelian.no_bukti')
                    ->whereBetween('pembelian.tanggal', [$monthStart, $monthEnd])
                    ->sum(DB::raw('pembelian_detail.jumlah * pembelian_detail.harga'));

                $chartSalesData[] = (float) $mSales;
                $chartPurchaseData[] = (float) $mPurchases;
            }
        } catch (\Throwable $e) {
            $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
            $chartSalesData = [0, 0, 0, 0, 0, 0];
            $chartPurchaseData = [0, 0, 0, 0, 0, 0];
        }

        return view('dashboard', compact(
            'totalProduk',
            'totalPelanggan',
            'totalSupplier',
            'todaySales',
            'thisMonthSales',
            'todayTransactions',
            'thisMonthTransactions',
            'thisMonthPurchases',
            'thisMonthPurchaseCount',
            'thisMonthBiaya',
            'chartLabels',
            'chartSalesData',
            'chartPurchaseData',
            'recentSales',
            'recentPurchases'
        ));
    }
}
