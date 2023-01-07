<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsappMessage extends Controller
{
    public function peserta()
    {
        $ipnu; $ippnu; $total;
        $peserta_mentah = Participant::all()->groupBy('delegasi')->map( fn($delegasi) => [
            'ipnu' => $delegasi->where('banom', 'ipnu')->count(),
            'ippnu' => $delegasi->where('banom', 'ippnu')->count()
        ])->each(function($val) use( &$ipnu,  &$ippnu,  &$total) {
            $ipnu += $val['ipnu'];
            $ippnu += $val['ippnu'];
            $total += $val['ipnu'] + $val['ippnu'];
        });
        $peserta = $peserta_mentah->toArray();

        $message = "_Update Peserta (" . date('Y-m-d H:i:s') . ")_\n\n";
        $message .=
        "1. Dukuh: IPNU(".($peserta['Dukuh']["ipnu"] ?? 0).") IPPNU(".($peserta['Dukuh']["ippnu"] ?? 0).")\n".
        "2. Gemaharjo: IPNU(".($peserta['Gemaharjo']["ipnu"] ?? 0).") IPPNU(".($peserta['Gemaharjo']["ippnu"] ?? 0).")\n".
        "3. Karanggandu: IPNU(".($peserta['Karanggandu']["ipnu"] ?? 0).") IPPNU(".($peserta['Karanggandu']["ippnu"] ?? 0).")\n".
        "4. Margomulyo: IPNU(".($peserta['Margomulyo']["ipnu"] ?? 0).") IPPNU(".($peserta['Margomulyo']["ippnu"] ?? 0).")\n".
        "5. Pakel: IPNU(".($peserta['Pakel']["ipnu"] ?? 0).") IPPNU(".($peserta['Pakel']["ippnu"] ?? 0).")\n".
        "6. Prigi: IPNU(".($peserta['Prigi']["ipnu"] ?? 0).") IPPNU(".($peserta['Prigi']["ippnu"] ?? 0).")\n".
        "7. Sawahan: IPNU(".($peserta['Sawahan']["ipnu"] ?? 0).") IPPNU(".($peserta['Sawahan']["ippnu"] ?? 0).")\n".
        "8. Slawe: IPNU(".($peserta['Slawe']["ipnu"] ?? 0).") IPPNU(".($peserta['Slawe']["ippnu"] ?? 0).")\n".
        "9. Tasikmadu: IPNU(".($peserta['Tasikmadu']["ipnu"] ?? 0).") IPPNU(".($peserta['Tasikmadu']["ippnu"] ?? 0).")\n".
        "10. Watuagung: IPNU(".($peserta['Watuagung']["ipnu"] ?? 0).") IPPNU(".($peserta['Watuagung']["ippnu"] ?? 0).")\n".
        "11. Watulimo: IPNU(".($peserta['Watulimo']["ipnu"] ?? 0).") IPPNU(".($peserta['Watulimo']["ippnu"] ?? 0).")\n".
        "12. Ngembel: IPNU(".($peserta['Ngembel']["ipnu"] ?? 0).") IPPNU(".($peserta['Ngembel']["ippnu"] ?? 0).")\n".
        "13. SMPI: IPNU(".($peserta['SMP Islam Watulimo']["ipnu"] ?? 0).") IPPNU(".($peserta['SMP Islam Watulimo']["ippnu"] ?? 0).")\n".
        "14. SMAI: IPNU(".($peserta['SMA Islam Watulimo']["ipnu"] ?? 0).") IPPNU(".($peserta['SMA Islam Watulimo']["ippnu"] ?? 0).")\n\n".
        "IPNU ($ipnu) + IPPNU ($ippnu) = $total";


        Http::asForm()->post(config('app.wa_api').'/sendGroup', [
            'name' => env('GROUP_BROADCAST_NAME'),
            'message' => $message
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Rekap Peserta Berhasil Dikirim'
        ]);
    }
}
