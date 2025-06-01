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
  <title>Export Inventaris</title>
  <style>
    body {
      font-family: "Montserrat", sans-serif;
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
      border-color: #FAFAFA;
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
  </style>
</head>

<body>
  <h2 class="f-main">Data Inventaris</h2>
  <p style="padding: 0; margin: 0;">Hari/Tanggal: <?= formatTanggal(date('d-m-Y')) ?></p>
  <div" class="table-custom">
    <table style="margin: 0;">
      <thead>
        <tr>
          <th>No</th>
          <th>Jenis</th>
          <th>Merek</th>
          <th>SSID</th>
          <th>Kata Sandi</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($items)): ?>
          <?php foreach ($items as $key => $item): ?>
            <tr>
              <td><?= $key + 1 ?></td>
              <td><?= esc($item['jenis_nama']) ?></td>
              <td><?= esc($item['merek']) ?></td>
              <td><?= esc($item['SSID']) ?></td>
              <td><?= esc($item['password']) ?></td>
              <td><?= esc($item['status_nama']) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="14">Belum Ada Data</td>
          </tr>
        <?php endif ?>
      </tbody>
    </table>
    </div>
</body>

</html>