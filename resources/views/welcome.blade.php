@extends('_template')

@section('title', 'Selamat Datang')
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
          <div class="card mt-lg-5">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <a class="nav-link active" data-bs-toggle="tab" href="#daftar" aria-selected="true" role="tab">Daftar</a>
                </li>
                <li class="nav-item" role="presentation">
                  <a id="bantuan" class="nav-link" data-bs-toggle="tab" href="#kontak" aria-selected="false" role="tab" tabindex="-1">Kontak</a>
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
                            <label for="wa" class="form-label ps-5 d-block" style="margin-top: -8px; font-size: 11px">Masukkan No. WhatsApp Anda</label>
                        </div>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text py-1" id="inputGroup-sizing-lg">+62</span>
                            <input type="text" class="form-control" aria-describedby="inputGroup-sizing-lg" placeholder="82234567890" name="phone">
                          </div>

                          <button class="mt-4 btn d-block w-100 btn-success">LANJUTKAN!</button>
                          <button class="mt-2 btn d-block w-100 btn-primary" id="get-bantuan">BUTUH BANTUAN?</button>

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
document.getElementById('get-bantuan').addEventListener('click', e => {
  e.preventDefault()
  document.getElementById('bantuan').click()
})
document.querySelector('form').addEventListener('submit', e => {
  document.querySelector('input[name="phone"]').value = document.querySelector('input[name="phone"]').value.replace(/^\+?(0|62)/, '');
  e.preventDefault()
  swal.fire({
    didOpen: () => {
      Swal.showLoading();
      axios.post('{{ route('daftar.baru') }}', new FormData(e.target)).then(data => data.data).then(data => {

        if(data.status === true)
        {
          Swal.fire({
            title: 'Masukkan Kode Verifikasi',
            input: 'text',
            inputAttributes: {
              autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Verifikasi',
            cancelButtonText: 'Kembali',
            showLoaderOnConfirm: true,
            preConfirm: token => {
              let data = new FormData()
              data.append('token', token)
              return axios.post(`{{ route('daftar.verifikasi') }}`, data)
                .then(res => res.data).then(response => {
                  if (!response.status) {
                    throw new Error(response.message)
                  }
                  location.href = ""
                })
                .catch(error => {
                  Swal.showValidationMessage(
                    `${error}`
                  )
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
          })

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