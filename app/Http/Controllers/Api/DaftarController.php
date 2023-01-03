<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\WhatsappToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DaftarController extends Controller
{
    public function baru(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric'
        ]);

        if(Participant::where('phone', $request->input('phone'))->count() > 0) return response()->json([
            'status' => false,
            'message' => 'Nomor WhatsApp sudah digunakan.'
        ]);

        $data = WhatsappToken::firstOrNew([
            'phone' => $request->get('phone')
        ]);
        $data->token = \mt_rand(11111,99999);
        $data->save();

        Http::asForm()->post('http://127.0.0.1:3000/send', [
            'phone' => $data->phone,
            'message' => "Assalamu'alaikum Wr. Wb.\nKami dari Panitia KONFERANCAB XV PAC IPNU-IPPNU Watulimo.\nKode verifikasi anda adalah: *$data->token*"
        ]);

        session(['phone_id' => $data->id]);
        return response()->json([
            'status' => true
        ]);
    }

    public function verifikasi(Request $request)
    {
        $data = WhatsappToken::find(session('phone_id', 0));
        if($data == null) return redirect('/');

        $request->validate([
            'token' => 'required'
        ]);

        if($request->get('token') != $data->token) return response()->json([
            'status' => false,
            'message' => 'Kode verifikasi salah, silahkan ulangi'
        ]);

        $data->delete();
        
        session(['state' => 'sign-up']);
        $request->session()->regenerate();
        return response()->json([
            'status' => true
        ]);
    }
}
