<?php

namespace App\Http\Controllers;

use App\Http\Requests\DaftarRequest;
use App\Models\Participant;
use App\Models\WhatsappToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if($request->session()->get('state', false) === 'sign-up')
        {
            $phone = WhatsappToken::withTrashed()->find(session('phone_id'));
            return view('formulir', compact('phone'));
        }
        else if($request->session()->get('state', false) === 'success')
        {
            $participant = Participant::withTrashed()->find($request->session()->get('participant_id', false));
            return view('done', compact('participant'));
        }

        return view('welcome');
    }

    public function simpan(DaftarRequest $request)
    {
        $phone = WhatsappToken::withTrashed()->find(session('phone_id'))->phone;

        $delegation = array();
        preg_match("/^(PR|PK) (IPNU|IPPNU) (.*)$/", $request->get('input-delegasi'), $delegation);
        
        $baru = new Participant();
        $baru->name = Str::of($request->get('input-nama'))->upper();
        $baru->phone = $phone;
        $baru->as = strtolower($request->get('input-as'));
        $baru->delegasi_type = strtolower($delegation[1]);
        $baru->banom = strtolower($delegation[2]);
        $baru->delegasi = $delegation[3];
        $baru->photo = $request->file('input-selfie')->storePublicly('peserta');
        $baru->save();

        $request->session()->forget('phone_id');
        $request->session()->put('state', 'success');
        $request->session()->put('participant_id', $baru->id);

        return response()->json([
            'status' => true
        ]);
    }
}
