@extends('_template')

@section('title', 'Isi Formulir')
@section('content')
<div class="row my-5 justify-content-center">
    <div class="col-lg-5 my-auto d-flex">
        <div class="text-center mx-auto mb-3">
          <p class="h4 mb-4">KONFERENSI ANAK CABANG XV</p>
          <img src="{{ asset('img/logo.webp') }}" class="img-fluid logo-utama">
          <h1 class="h6 mt-4 powerd-by">
              PIMPINAN ANAK CABANG<br />
              IKATAN PELAJAR NAHDLATUL ULAMA'<br />
              IKATAN PELAJAR PUTRI NAHDLATUL ULAMA'<br />
              KECAMATAN WATULIMO
          </h1>
        </div>
    </div>
    <div class="col-lg-4">
          <div class="card">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <a class="nav-link active" data-bs-toggle="tab" href="#done" aria-selected="true" role="tab">Bukti Pendaftaran</a>
                </li>
              </ul>
              <div class="card-body shadow">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active show" id="done" role="tabpanel">
                      <p class="mb-3 text-center mx-5 fw-light">Pendaftaran Berhasil.</p>
                      <div class="text-center mb-3">
                        {!! QrCode::size(120)->generate($participant->qrStr()); !!}
                      </div>
                      <table class="table">
                        <tbody>
                          <tr>
                            <th scope="row" class="w-auto">Nama</th>
                            <td> : </td>
                            <td class="">{{ $participant->name }}</td>
                          </tr>
                          <tr>
                            <th scope="row">Delegasi</th>
                            <td> : </td>
                            <td>{{ $participant->getDelegasi() }}</td>
                          </tr>
                          <tr>
                            <th scope="row">Terdaftar Pada</th>
                            <td> : </td>
                            <td>{{ $participant->created_at->format('Y-m-d | H:i:s') }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
              </div>

          </div>         
    </div>
</div>
@endsection