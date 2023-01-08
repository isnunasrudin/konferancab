<?php

namespace App\Http\Controllers;

use App\Exports\ParticipantExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Generator;
use App\Models\Participant;
use chillerlan\QRCode\QRCode;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        return view('admin');
    }

    public function rekap()
    {
        return Excel::download(new ParticipantExport, 'peserta.xlsx');
    }

    public function daftar_peserta(Request $request)
    {
        if($request->has('type')) $data = Participant::where('banom', $request->get('type'))->get();
        else $data = Participant::all();
        return Pdf::loadView('daftar_peserta', ['data' => $data])->stream();
    }

    public function gambar(Request $request)
    {
        $user = Participant::find($request->get('id'));
        $qr = new QRCode();
        $qr->render(base64_encode(serialize([
            'id' => $user->id,
            'key' => $user->qrStr()
        ])), Storage::path('qr_temp.svg'));

        $qr = Image::make(Storage::path('qr_temp.svg'));
        $qr->resize(550, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        
        $img = Image::make(storage_path('id_peserta.jpg'));
        $img->insert($qr, 'top', 0, 130);
        

        $img->text($user->first_name, 445, 1290, function($font) {
            $font->file(storage_path('font.otf'));
            $font->size(48);
            $font->color('#000');
        });
        

        $img->text($user->getDelegasi(), 530, 1370, function($font) {
            $font->file(storage_path('font.otf'));
            $font->size(32);
            $font->color('#000');
            $font->align('center');
        });

        return $img->response('jpg');
    }
}
