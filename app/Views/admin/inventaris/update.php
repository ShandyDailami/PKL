<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>

<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom position-fixed top-0 start-0 end-0"
  style="height: 50px; z-index: 1030;">
  <img style="height: 100%;" class="ps-3" src="<?= base_url('assets/logo/ULM.png') ?>" alt="">

  <h1 class="logo fw-bold pt-2 ps-2">SIPIJAR</h1>
</nav>

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
  <?php endif ?>
</div>

<div class="container-fluid" style="padding-top: 50px;">
  <div class="row">
    <div class="col-12 py-3 bg-main">
      <div class="p card mx-auto border-0" style="max-width: 900px;">
        <div class="card-body">
          <div class="card-title mb-5 d-flex flex-column align-items-center">
            <h5 class="login-title">Edit</h5>
            <div class="line"></div>
          </div>

          <form action="" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
              <label for="pilihJenisPerangkat" class="form-label">Jenis Perangkat</label>
              <select class="form-select" name="jenis_id" id="pilihJenisPerangkat">
                <option disabled value="">Pilih Jenis</option>
                <?php foreach ($types as $type): ?>
                  <option value="<?= $type['id'] ?>" <?= (old('jenis_id', $inventaris['jenis_id'] ?? '') == $type['id']) ? 'selected' : '' ?>>
                    <?= esc($type['nama']) ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="kondisi" class="form-label">Kondisi</label>
              <select class="form-select" name="kondisi_id" id="kondisi">
                <option disabled value="">Pilih Kondisi</option>
                <?php foreach ($conditions as $condition): ?>
                  <option value="<?= $condition['id'] ?>" <?= (old('kondisi_id', $inventaris['kondisi_id']) == $condition['id']) ? 'selected' : '' ?>>
                    <?= esc($condition['nama']) ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="merek" class="form-label">Merek Perangkat</label>
              <input type="text" class="form-control" id="merek" name="merek"
                value="<?= old('merek', $inventaris['merek']) ?>" placeholder="Masukkan Merek Perangkat">
            </div>

            <div class="row">
              <div class="col-md-6" id="kiri">
                <div class="mb-3">
                  <label for="namaPerangkat" class="form-label">SSID</label>
                  <input type="text" class="form-control" id="namaPerangkat" name="SSID"
                    value="<?= old('SSID', $inventaris['SSID']) ?>" placeholder="Masukkan SSID">
                </div>
                <div class="mb-3">
                  <label for="passwordPerangkat" class="form-label">Password</label>
                  <input type="text" id="passwordPerangkat" name="password" class="form-control"
                    value="<?= old('password', $inventaris['password']) ?>" placeholder="Masukkan Password Perangkat">
                </div>
                <div class="mb-3">
                  <label for="gambar" class="form-label">Gambar</label>
                  <img class="rounded" src="<?= base_url('uploads/' . $inventaris['gambar']) ?>" style="height: 50px;"
                    alt="">
                  <input type="file" id="gambar" name="gambar" class="form-control">
                </div>
                <div class="mb-3">
                  <label for="tanggal_perolehan" class="form-label">Tanggal Perolehan</label>
                  <input type="date" class="form-control" name="tanggal_perolehan" id="tanggal_perolehan"
                    value="<?= $inventaris['tanggal_perolehan'] ?>">
                </div>
                <div class="mb-3">
                  <label for="status" class="form-label">Status</label>
                  <select class="form-select" name="status_id" id="status">
                    <option disabled value="">Pilih Status</option>
                    <?php foreach ($statuses as $status): ?>
                      <option value="<?= $status['id'] ?>" <?= (old('status_id', $inventaris['status_id']) == $status['id']) ? 'selected' : '' ?>>
                        <?= esc($status['nama']) ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>

              <div class="col-md-6" id="kanan">
                <div class="mb-3">
                  <label for="pilihTempat" class="form-label">Tempat</label>
                  <select class="form-select" name="tempat_id" id="pilihTempat">
                    <option selected disabled value="">Pilih Tempat</option>
                    <?php foreach ($places as $place): ?>
                      <option value="<?= $place['id'] ?>" <?= old('tempat_id', $inventaris['tempat_id'] ?? '') == $place['id'] ? 'selected' : '' ?>>
                        <?= esc($place['nama']) ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="latitude" class="form-label">Latitude</label>
                  <input type="text" id="latitude" name="latitude" class="form-control"
                    value="<?= old('latitude', $inventaris['latitude']) ?>" placeholder="Masukkan Titik Latitude">
                </div>
                <div class="mb-3">
                  <label for="longitude" class="form-label">Longitude</label>
                  <input type="text" id="longitude" name="longitude" class="form-control"
                    value="<?= old('longitude', $inventaris['longitude']) ?>" placeholder="Masukkan Titik Longitude">
                </div>
                <div class="mb-3">
                  <label for="lantai" class="form-label">Lantai</label>
                  <select class="form-select" name="lantai" id="lantai">
                    <option disabled value="">Pilih Lantai</option>
                    <option value="1" <?= old('lantai', $inventaris['lantai']) == '1' ? 'selected' : '' ?>>Lantai 1
                    </option>
                    <option value="2" <?= old('lantai', $inventaris['lantai']) == '2' ? 'selected' : '' ?>>Lantai 2
                    </option>
                    <option value="3" <?= old('lantai', $inventaris['lantai']) == '3' ? 'selected' : '' ?>>Lantai 3
                    </option>
                  </select>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-evenly mt-4">
              <button type="submit" name="submit" class="btn rounded-pill btn-primary w-auto mb-3">Edit</button>
              <?php
              $urlKembali = (old('status_id', $inventaris['status_id'] ?? '') == 1)
                ? '/admin/dashboard/perangkat-jaringan/'
                : '/admin/dashboard/inventaris/';
              ?>
              <a href="<?= $urlKembali ?>" class="btn rounded-pill btn-secondary w-auto mb-3">Kembali</a>
            </div>

          </form>
        </div>
      </div>
    </div>

  </div>
</div>

<?= $this->endSection('content') ?>