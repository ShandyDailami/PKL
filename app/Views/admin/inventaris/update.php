<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
  <div class="position-fixed mt-2 me-2 top-0 end-0">
    <?php if (session()->getFlashdata('message')): ?>
      <div class="alert alert-success flash-message">
        <?= session()->getFlashdata('message') ?>
      </div>
    <?php elseif (session()->getFlashdata('errors')): ?>
      <?php foreach (session()->getFlashdata('errors') as $error): ?>
        <div class="alert alert-danger flash-message">
          <?= esc($error) ?>
        </div>
      <?php endforeach ?>
    <?php elseif (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger flash-message">
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif ?>
  </div>
  <div class="card col-lg-10 mx-auto border-0">
    <div class="card-body">
      <div class="card-title mb-5 d-flex flex-column align-items-center">
        <h5 class="login-title">Edit</h5>
        <div class="line"></div>
      </div>
      <form action="" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="row d-flex flex-row">
          <div class="col-6">
            <div class="mb-3">
              <label for="kondisi" class="form-label">Kondisi</label>
              <select class="form-select" name="kondisi_id" id="kondisi" aria-label="Kondisi">
                <option selected disabled>Pilih Kondisi</option>
                <?php foreach ($conditions as $index => $condition): ?>
                  <option value="<?= $index + 1 ?>" <?= $inventaris['kondisi_id'] == $index + 1 ? 'selected' : '' ?>>
                    <?= esc($condition['nama']) ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="jenisPerangkat" class="form-label">Jenis Perangkat</label>
              <select class="form-select" name="jenis_id" id="jenisPerangkat" aria-label="Type">
                <option selected disabled value="">Pilih Jenis</option>
                <?php foreach ($types as $index => $type): ?>
                  <option value="<?= $index + 1 ?>" <?= esc($inventaris['jenis_id']) == $index + 1 ? 'selected' : '' ?>>
                    <?= esc($type['nama']) ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="tipe" class="form-label">Tipe</label>
              <input type="text" id="tipe" name="tipe" class="form-control" value="<?= esc($inventaris['tipe']) ?>"
                placeholder="Masukkan Tipe">
            </div>
            <div class="mb-3">
              <label for="namaPerangkat" class="form-label">Nama Perangkat</label>
              <input type="text" class="form-control" id="namaPerangkat" name="nama"
                value="<?= esc($inventaris['nama']) ?>" placeholder="Masukkan Nama Perangkat">
            </div>
            <div class="mb-3">
              <label for="passwordPerangkat" class="form-label">Password</label>
              <input type="text" id="passwordPerangkat" name="password" class="form-control"
                value="<?= esc($inventaris['password']) ?>" placeholder="Masukkan Password Perangkat">
            </div>
            <div class="mb-3">
              <div class="d-flex flex-column">
                <label for="gambar" class="form-label mb-1">Gambar</label>
                <img class="rounded mb-2" style="width: 50px;"
                  src="<?= base_url('uploads/' . $inventaris['gambar']) ?>">
              </div>
              <input type="file" id="gambar" name="gambar" class="form-control">
            </div>
          </div>
          <div class="col-6">
            <div class="mb-3">
              <label for="tempat" class="form-label">Tempat</label>
              <input type="text" id="tempat" name="tempat" class="form-control"
                value="<?= esc($inventaris['tempat']) ?>" placeholder="Masukkan Tempat">
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select class="form-select" name="status_id" id="status" aria-label="Status">
                <option selected disabled>Pilih Status</option>
                <?php foreach ($statuses as $index => $status): ?>
                  <option value="<?= $index + 1 ?>" <?= esc($inventaris['status_id']) == $index + 1 ? 'selected' : '' ?>>
                    <?= esc($status['nama']) ?>
                  </option>
                <?php endforeach ?>

              </select>
            </div>
            <div class="mb-3">
              <label for="kuantitas" class="form-label">Kuantitas</label>
              <input type="text" id="kuantitas" name="kuantitas" class="form-control"
                value="<?= esc($inventaris['kuantitas']) ?>" placeholder="Masukkan Kuantitas">
            </div>
            <div class="mb-3">
              <label for="latitude" class="form-label">Latitude</label>
              <input type="text" id="latitude" name="latitude" class="form-control"
                value="<?= esc($inventaris['latitude']) ?>" placeholder="Masukkan Titik Latitude">
            </div>
            <div class="mb-3">
              <label for="longitude" class="form-label">Longitude</label>
              <input type="text" id="longitude" name="longitude" class="form-control"
                value="<?= esc($inventaris['longitude']) ?>" placeholder="Masukkan Titik Longitude">
            </div>
            <div class="mb-3">
              <label for="lantai" class="form-label">Lantai</label>
              <select class="form-select" name="lantai" id="lantai" aria-label="Floor">
                <option selected disabled>Pilih Lantai</option>
                <option value="1" <?= esc($inventaris['lantai']) == '1' ? 'selected' : '' ?>>Lantai 1</option>
                <option value="2" <?= esc($inventaris['lantai']) == '2' ? 'selected' : '' ?>>Lantai 2</option>
                <option value="3" <?= esc($inventaris['lantai']) == '3' ? 'selected' : '' ?>>Lantai 3</option>
              </select>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-lg-evenly">
          <button type="submit" name="submit" class="btn rounded-pill btn-primary w-auto mb-3">Edit</button>
          <button type="button" class="btn rounded-pill btn-secondary w-auto mb-3"
            onclick="history.back()">Kembali</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection('content') ?>