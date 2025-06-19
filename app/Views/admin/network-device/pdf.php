<?php
function formatTanggal($tanggal)
{
  $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
  $bulan = [
    1 => 'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  ];

  $timestamp = strtotime($tanggal);
  $hariNama = $hari[date('w', $timestamp)];
  $tgl = date('j', $timestamp);
  $bln = $bulan[date('n', $timestamp)];
  $thn = date('Y', $timestamp);

  return "$hariNama, $tgl $bln $thn";
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Export Perangkat Jaringan</title>
  <style>
    body {
      font-family: times, serif;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      overflow: hidden;
    }

    thead th {
      background-color: #D9D9D9;
      color: #000;
      font-weight: normal;
      text-align: center;
      vertical-align: middle;
    }

    th,
    td {
      border: 1px solid #e9ecef;
      padding: 8px;
      text-align: left;
      vertical-align: middle;
      font-size: small;
      text-align: center;
    }

    tbody tr {
      border-color: rgb(7, 0, 0);
      text-align: center;
    }

    tbody tr:hover {
      background-color: #f1f1f1;
      transition: background-color .3s ease;
    }

    .btn-main-active {
      color: #000;
      background-color: #78B2E3 !important;
    }

    .btn-main-active:hover,
    .btn-main-active:active {
      color: #000;
      background-color: #6fa3ce !important;
    }

    .btn-sec {
      color: white;
      background-color: #00325C !important;
    }

    .btn-sec:hover {
      color: white;
      background-color: #004074 !important;
    }

    .kop-surat,
    .kop-surat td {
      border: none !important;
      outline: none !important;
    }
  </style>
</head>

<body>
  <table class="kop-surat" style="width:100%; border: none; outline: none;">
    <tr>
      <td style="width:15%;">
        <img src="<?= $logoSrc ?>" alt=" Logo" style="width:140px;">
      </td>
      <td style="text-align: center;">
        <h2 style="margin: 0; font-weight:normal;">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN,
          <br>RISET DAN TEKNOLOGI
        </h2>
        <h2 style="margin: 0; font-weight:normal;">UNIVERSITAS LAMBUNG MANGKURAT</h2>
        <h1 style="margin: 0;">FAKULTAS TEKNIK</h1>
        <p style="margin: 0;">AIamat Jl. Achmad Yani Km. 35,5 Banjarbaru-Kalimantan Selatan 70714</p>
        <p style="margin: 0;">Telepon/Fax. : (0511) 4773858-4773868</p>
        <p style="margin: 0;">Laman: http://www.ft.ulm.ac.id, Email: dekan.ft@ulm.ac.id</p>
      </td>
    </tr>
  </table>
  <hr style="border: 2px solid black; margin-top: 5px; margin-bottom: 10px;">
  <h2 class="f-main">Data Perangkat Jaringan</h2>
  <p style="padding: 0; margin: 0;">Hari/Tanggal: <?= formatTanggal(date('d-m-Y')) ?></p>
  <div" class="table-custom">
    <table style="margin: 0;">
      <thead>
        <tr>
          <th>No</th>
          <th>ID</th>
          <th>Tempat</th>
          <th>Jenis</th>
          <th>Merek</th>
          <th>SSID</th>
          <th>Kata Sandi</th>
          <th>Tanggal Perolehan</th>
          <th>Status</th>
          <th>Lantai</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($devices)): ?>
          <?php foreach ($devices as $key => $device): ?>
            <tr>
              <td><?= $key + 1 ?></td>
              <td><?= esc($device['id']) ?></td>
              <td><?= esc($device['tempat']) ?></td>
              <td><?= esc($device['jenis_nama']) ?></td>
              <td><?= esc($device['merek']) ?></td>
              <td><?= esc($device['SSID']) ?></td>
              <td><?= esc($device['password']) ?></td>
              <td><?= esc($device['tanggal_perolehan']) ?></td>
              <td><?= esc($device['status_nama']) ?></td>
              <td><?= esc($device['lantai']) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="14">Belum Ada Data</td>
          </tr>
        <?php endif ?>
      </tbody>
    </table>

    <hr style="border: 1px solid black; margin-top: 50px; margin-bottom: 5px;">
    <h2 class="f-main">Data Log Perangkat Jaringan</h2>
    <div" class="table-custom">
      <table style="margin: 0;">
        <thead>
          <tr>
            <th>No</th>
            <th>ID Perangkat</th>
            <th>Aktivitas</th>
            <th>Deskripsi</th>
            <th>Waktu</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($logs)): ?>
            <?php foreach ($logs as $key => $log): ?>
              <tr>
                <td><?= $key + 1 ?></td>
                <td><?= esc($log['inventaris_id']) ?></td>
                <td><?= esc($log['aktivitas']) ?></td>
                <td><?= esc($log['deskripsi']) ?></td>
                <td><?= esc($log['waktu']) ?></td>
                <td><?= esc($log['status']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6">Belum Ada Data</td>
            </tr>
          <?php endif ?>
        </tbody>
      </table>
      </div>
</body>

</html>