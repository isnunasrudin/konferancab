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
                  <a class="nav-link active" data-bs-toggle="tab" href="#formulir" aria-selected="true" role="tab">Formulir</a>
                </li>
              </ul>
              <div class="card-body shadow">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active show" id="formulir" role="tabpanel">
                      <p class="mb-3 text-center mx-5 fw-light">Langkah terakhir, silahkan lengkapi kolom dibawah ini.</p>
                      <form action="">
                        <div class="mb-3">
                            <label for="input-wa" class="form-label">No. WhatsApp</label>
                            <input disabled type="text" class="form-control" id="input-wa" required value="+62{{ $phone->phone }}">
                          </div>
                        <div class="mb-3">
                            <label for="input-nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="input-nama" name="input-nama" required>
                          </div>
                        <div class="mb-3">
                            <label for="input-delegasi" class="form-label">Delegasi</label>
                            <select class="form-select" required id="input-delegasi" name="input-delegasi">
                                <optgroup label="IPNU">
                                    <option>PK IPNU SMA Islam Watulimo</option>
                                    <option>PK IPNU SMP Islam Watulimo</option>
                                    <option>PR IPNU Dukuh</option>
                                    <option>PR IPNU Slawe</option>
                                    <option>PR IPNU Gemaharjo</option>
                                    <option>PR IPNU Watulimo</option>
                                    <option>PR IPNU Watuagung</option>
                                    <option>PR IPNU Ngembel</option>
                                    <option>PR IPNU Pakel</option>
                                    <option>PR IPNU Sawahan</option>
                                    <option>PR IPNU Margomulyo</option>
                                    <option>PR IPNU Prigi</option>
                                    <option>PR IPNU Tasikmadu</option>
                                    <option>PR IPNU Karanggandu</option>
                                </optgroup>
                                <optgroup label="IPPNU">
                                    <option>PK IPPNU SMA Islam Watulimo</option>
                                    <option>PK IPPNU SMP Islam Watulimo</option>
                                    <option>PR IPPNU Dukuh</option>
                                    <option>PR IPPNU Slawe</option>
                                    <option>PR IPPNU Gemaharjo</option>
                                    <option>PR IPPNU Watulimo</option>
                                    <option>PR IPPNU Watuagung</option>
                                    <option>PR IPPNU Ngembel</option>
                                    <option>PR IPPNU Pakel</option>
                                    <option>PR IPPNU Sawahan</option>
                                    <option>PR IPPNU Margomulyo</option>
                                    <option>PR IPPNU Prigi</option>
                                    <option>PR IPPNU Tasikmadu</option>
                                    <option>PR IPPNU Karanggandu</option>
                                </optgroup>
                              </select>
                          </div>
                          <div class="mb-3">
                              <label for="input-as" class="form-label">Sebagai</label>
                              <select class="form-select" required id="input-as" name="input-as">
                                <option>Ketua</option>
                                <option>Sekretaris</option>
                                <option>Anggota</option>
                              </select>
                            </div>
                          <div class="mb-3">
                              <label for="input-selfie" class="form-label">Unggah Swafoto / Selfie</label>
                              <input class="form-control" type="file" id="input-selfie" name="input-selfie" accept="image/*">
                            </div>

                          <button class="mt-4 btn d-block w-100 btn-success">SIMPAN!</button>

                      </form>
                    </div>
                    <div class="tab-pane fade" id="kontak">
                      <p class="mb-3 text-center mx-5 fw-light">Perlu bantuan? Anda bisa menghubungi salah satu dari nomor dibawah ini.</p>
                      <table class="table">
                        <tbody>
                          <tr>
                            <th scope="row" class="w-auto">Ketua Pelaksana :</th>
                            <td class=""><a href="//wa.me/6282140740918">0821-4074-0918</a></td>
                          </tr>
                          <tr>
                            <th scope="row">Ghouzul Muna :</th>
                            <td><a href="//wa.me/6287789042001">0877-8904-2001</a></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
              </div>

          </div>         
    </div>
</div>
@push('footer')
<script>
document.querySelector('form').addEventListener('submit', e => {
  e.preventDefault()
  swal.fire({
    didOpen: () => {
      Swal.showLoading();
      axios.post('{{ route('simpan') }}', new FormData(e.target)).then(data => data.data).then(data => {

        if(data.status === true)
        {
          location.href = ""
        }else{
          Swal.fire('Informasi!', data.message, 'info')
        }

      }).catch(error => {
        if(error.response.status == 422) Swal.fire('Astaghfirullah!', error.response.data.message, 'warning')
        else Swal.fire('Kesalahan!', 'Terjadi kesalahan saat menghubungi server. Mohon informasikan ke kami.', 'error')
      })
    },
    allowOutsideClick: () => !Swal.isLoading(),
    title: 'Mohon Tunggu',
    text: 'Kami sedang mengolah permintaan anda'
  })
})
</script>
@endpush
@endsection