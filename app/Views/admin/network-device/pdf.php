<!DOCTYPE html>
<html>

<head>
  <title>Export Perangkat Jaringan</title>
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
  <h2 class="f-main">Data Perangkat Jaringan</h2>
  <div class="table-custom">
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Tempat</th>
          <th>Lantai</th>
          <th>Jenis</th>
          <th>Tipe</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($devices as $key => $device): ?>
          <tr>
            <td><?= $key + 1 ?></td>
            <td><?= esc($device['tempat']) ?></td>
            <td><?= esc($device['lantai']) ?></td>
            <td><?= esc($device['jenis_nama']) ?></td>
            <td><?= esc($device['tipe']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>

</html>