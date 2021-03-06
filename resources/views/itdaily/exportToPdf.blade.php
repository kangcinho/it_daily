<html>
  <head>
    <title></title>
    <style >
    .textKecil{
      font-size: 12px;
    }
    .textBesar{
      font-size: 20px;
    }
      table td, table th {
        border: 1px solid #ddd;
        padding: 8px;
        vertical-align: middle;
      }
      .rataTengah{
        text-align: center;
      }
      table tr:nth-child(even){
        background-color: #f2f2f2;
      }
      table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: center;
        background-color: #4CAF50;
        color: white;
      }
      .widthTambahan{
        width: 200px;
      }
    </style>
  </head>
  <body>
    <table class='textKecil'>
      <thead>
        <tr>
          <th colspan="9">{!! $namaFile !!}</th>
        </tr>
        <tr>
          <th>No</th>
          <th class="widthTambahan">Tanggal</th>
          <th>Waktu</th>
          <th>Unit</th>
          <th>User Request</th>
          <th class="widthTambahan">Masalah</th>
          <th class="widthTambahan">Solusi</th>
          <th>Dikerjakan Oleh</th>
          <th>Status</th>
        </tr>
      </thead>

      <tbody>
        {!! "";$no=0;!!}

        @foreach($reservasies as $reservasi)
          <tr>
            <td class="rataTengah">{!! ++$no !!}</td>
            <td class="rataTengah widthTambahan">{!! tanggal($reservasi->tgl_kejadian) !!}</td>
            <td class="rataTengah">{!! $reservasi->waktu_kejadian !!}</td>
            <td class="rataTengah">{!! $reservasi->unit->nama_unit !!}</td>
            <td class="rataTengah">{!! $reservasi->nama_user_request !!}</td>
            <td class="rataTengah widthTambahan">{!! $reservasi->problem !!}</td>
            <td class="rataTengah widthTambahan">{!! $reservasi->solusi !!}</td>
            <td class="rataTengah">{!! $reservasi->it_solved_by !!}</td>
            <td class="rataTengah">{!! $reservasi->status?"Done":"Progress" !!}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>

<?php
  function tanggal($tgl){
    if($tgl==""){
      return '';
    }
    $tanggalKita = explode(' ',$tgl);
    $tgl = explode('-',$tanggalKita[0]);
    $bulan = '';
    switch($tgl[1]){
      case "01" : $bulan = "Januari"; break;
      case "02" : $bulan = "Februari"; break;
      case "03" : $bulan = "Maret"; break;
      case "04" : $bulan = "April"; break;
      case "05" : $bulan = "Mei"; break;
      case "06" : $bulan = "Juni"; break;
      case "07" : $bulan = "Juli"; break;
      case "08" : $bulan = "Agustus"; break;
      case "09" : $bulan = "September"; break;
      case "10" : $bulan = "Oktober"; break;
      case "11" : $bulan = "November"; break;
      case "12" : $bulan = "Desember"; break;
    }
    return $tgl[2].' '.$bulan.' '.$tgl[0];
  }
?>
