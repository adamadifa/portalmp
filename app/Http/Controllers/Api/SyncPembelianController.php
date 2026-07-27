<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\Detailpembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SyncPembelianController extends Controller
{
    public function sync(Request $request)
    {
        $request->validate([
            'purchases' => 'required|array',
            'purchases.*.no_bukti' => 'required|string',
        ]);

        $purchases = $request->purchases;

        try {
            DB::beginTransaction();

            foreach ($purchases as $item) {
                // Prepare header data for upsert by removing attributes that are relations or timestamps
                $headerData = collect($item)->except(['details', 'created_at', 'updated_at', 'is_tax_mp'])->toArray();

                // Update or Create the Pembelian header record
                Pembelian::updateOrCreate(
                    ['no_bukti' => $headerData['no_bukti']],
                    $headerData
                );

                // Replace Pembelian details: delete first, then insert new ones
                Detailpembelian::where('no_bukti', $headerData['no_bukti'])->delete();

                if (!empty($item['details'])) {
                    foreach ($item['details'] as $detail) {
                        $detailData = collect($detail)->except(['created_at', 'updated_at'])->toArray();
                        Detailpembelian::create($detailData);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mensinkronisasi ' . count($purchases) . ' transaksi pembelian.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mensinkronisasi data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        $request->validate([
            'no_bukti' => 'required|string',
        ]);

        $no_bukti = $request->no_bukti;

        try {
            DB::beginTransaction();

            Detailpembelian::where('no_bukti', $no_bukti)->delete();
            Pembelian::where('no_bukti', $no_bukti)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil membatalkan sinkronisasi untuk transaksi ' . $no_bukti
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal membatalkan sinkronisasi: ' . $e->getMessage()
            ], 500);
        }
    }
}
