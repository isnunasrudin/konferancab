@extends('_template')

@section('title', 'Selamat Datang')
@section('content')
<div class="row my-5 justify-content-center">
    <div class="col-lg-5 my-auto text-center">
        <p class="h4 mb-4">KONFERENSI ANAK CABANG XV</p>
        <img src="{{ asset('img/logo.webp') }}" class="img-fluid" style="max-width: 280px">
        <h1 class="h6 mt-4">
            PIMPINAN ANAK CABANG<br />
            IKATAN PELAJAR NAHDLATUL ULAMA'<br />
            IKATAN PELAJAR PUTRI NAHDLATUL ULAMA'<br />
            KECAMATAN WATULIMO
        </h1>
    </div>
    <div class="col-lg-5">
          <div class="card mt-lg-5">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <a class="nav-link active" data-bs-toggle="tab" href="#daftar" aria-selected="true" role="tab">Daftar</a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" data-bs-toggle="tab" href="#kontak" aria-selected="false" role="tab" tabindex="-1">Kontak</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/files/TOR.pdf" role="tab" tabindex="-1">
                    TOR
                    <span class="badge rounded-pill bg-danger">PDF</span>
                  </a>
                </li>
              </ul>
              <div class="card-body shadow">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active show" id="daftar" role="tabpanel">
                      <p class="mb-3 text-center mx-5 fw-light">Untuk mendaftar sebagai peserta, silahkan isi kolom dibawah ini.</p>
                      <form action="">
                        <div class="text-center mb-3">
                            <img src="{{ asset('img/WhatsApp-Emblem.png') }}" alt="" class="img-fluid" style="max-width: 200px"><br />
                            <label for="wa" class="form-label ps-5 d-block" style="margin-top: -8px; font-size: 11px">Masukkan No. WhatsApp</label>
                        </div>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text py-1" id="inputGroup-sizing-lg">+62</span>
                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="82234567890">
                          </div>

                          <button class="mt-4 btn d-block w-100 btn-success">DAFTAR!</button>
                      </form>
                    </div>
                    <div class="tab-pane fade" id="kontak">
                      <p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater.</p>
                    </div>
                  </div>
              </div>

          </div>         
    </div>
</div>
@endsection