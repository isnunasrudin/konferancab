<img src="{{ storage_path('KOP.jpg') }}" style="width: 100%" />
<style>
    h3{
        text-align: center;
        margin: 0 !important;
        padding: 0 !important;
    }
    table{
        width: 100%;
    }
    table, th, td{
        border: 1px solid black;
        border-collapse: collapse;
    }
    th, td{
        padding: 2px 4px;
    }
</style>
<br>
<br>
<h3>DAFTAR PESERTA</h3>
<h3>KONFERENSI ANAK CABANG</h3>
<h3>IKATAN PELAJAR NAHDLATUL ULAMA'</h3>
<h3>IKATAN PELAJAR PUTRI NAHDLATUL ULAMA'</h3>
<h3>KECAMATAN WATULIMO</h3>
<br>
<table>
    <tr>
        <th>NO</th>
        <th>NAMA</th>
        <th>BANOM</th>
        <th>DELEGASI</th>
    </tr>
    @foreach($data as $i => $orang)
    <tr>
        <td style="text-align: center">{{ ++$i }}</td>
        <td>{{ $orang->name }}</td>
        <td style="text-align: center">{{ strtoupper($orang->banom) }}</td>
        <td>{{ strtoupper($orang->getDelegasi()) }}</td>
    </tr>        
    @endforeach
</table>