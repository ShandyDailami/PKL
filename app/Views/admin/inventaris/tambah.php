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

    <div class="col-3 px-3 pt-4 position-fixed" style="height: 100vh; top: 50px; overflow-y: auto;">
      <div class="d-flex flex-column gap-2">
        <h4 class="f-main">DEVICE</h4>
        <button id="networkDevice" class="btn text-start btn-main border-0"><i
            class="bi bi-router-fill px-2"></i>Perangkat Jaringan</button>
        <button id="item" class="btn text-start btn-main border-0"><i
            class="bi bi-clipboard-check-fill px-2"></i>Inventaris</button>
        <button id="jenisPerangkat" class="btn text-start btn-main border-0"><i class="bi bi-folder-fill px-2"></i>Jenis
          Perangkat</button>
        <button id="tempat" class="btn text-start btn-main border-0"><i class="bi bi-geo-fill px-2"></i>Tempat</button>
        <button id="tambahInventaris" class="btn text-start btn-main-active border-0"><i
            class="bi bi-plus-circle-fill px-2"></i>Tambah Perangkat</button>
        <a class="btn btn-outline-danger text-start" href="/admin/logout"><i
            class="px-2 bi bi-door-open-fill"></i>Logout</a>
      </div>
    </div>
    <div class="offset-3 col-9 py-3 bg-main">
      <div class="p card mx-auto border-0" style="max-width: 900px;">
        <div class="card-body">
          <div class="card-title mb-5 d-flex flex-column align-items-center">
            <h5 class="login-title">Tambah</h5>
            <div class="line"></div>
          </div>

          <form action="/admin/dashboard/inventaris/tambah" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
              <label for="pilihJenisPerangkat" class="form-label">Jenis Perangkat</label>
              <select class="form-select" name="jenis_id" id="pilihJenisPerangkat">
                <option selected disabled value="">Pilih Jenis</option>
                <?php foreach ($types as $index => $type): ?>
                  <option value="<?= $type['id'] ?>" <?= old('jenis_id') == $index + 1 ? 'selected' : '' ?>>
                    <?= esc($type['nama']) ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="kondisi" class="form-label">Kondisi</label>
              <select class="form-select" name="kondisi_id" id="kondisi">
                <option selected disabled>Pilih Kondisi</option>
                <?php foreach ($conditions as $index => $condition): ?>
                  <option value="<?= $condition['id'] ?>" <?= old('kondisi_id') == $index + 1 ? 'selected' : '' ?>>
                    <?= esc($condition['nama']) ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="merek" class="form-label">Merek Perangkat</label>
              <input type="text" class="form-control" id="merek" name="merek" value="<?= old('merek') ?>"
                placeholder="Masukkan Merek Perangkat">
            </div>

            <div class="row">
              <div class="col-md-6" id="kiri">
                <div class="mb-3">
                  <label for="namaPerangkat" class="form-label">SSID</label>
                  <input type="text" class="form-control" id="namaPerangkat" name="SSID" value="<?= old('SSID') ?>"
                    placeholder="Masukkan SSID">
                </div>
                <div class="mb-3">
                  <label for="passwordPerangkat" class="form-label">Password</label>
                  <input type="text" id="passwordPerangkat" name="password" class="form-control"
                    value="<?= old('password') ?>" placeholder="Masukkan Password Perangkat">
                </div>
                <div class="mb-3">
                  <label for="gambar" class="form-label">Gambar</label>
                  <input type="file" id="gambar" name="gambar" class="form-control">
                </div>
                <div class="mb-3">
                  <label for="tanggal_perolehan" class="form-label">Tanggal Perolehan</label>
                  <input type="date" id="tanggal_perolehan" name="tanggal_perolehan" class="form-control">
                </div>
                <div class="mb-3">
                  <label for="status" class="form-label">Status</label>
                  <select id="statusSelect" class="form-select" name="status_id" id="status">
                    <option selected disabled>Pilih Status</option>
                    <?php foreach ($statuses as $index => $status): ?>
                      <option value="<?= $status['id'] ?>" <?= old('status_id') == $index + 1 ? 'selected' : '' ?>>
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
                    <?php foreach ($places as $index => $place): ?>
                      <option value="<?= $place['id'] ?>" <?= old('tempat_id') == $index + 1 ? 'selected' : '' ?>>
                        <?= esc($place['nama']) ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="latitude" class="form-label">Latitude</label>
                  <input type="text" id="latitude" name="latitude" class="form-control" value="<?= old('latitude') ?>"
                    placeholder="Masukkan Titik Latitude">
                </div>
                <div class="mb-3">
                  <label for="longitude" class="form-label">Longitude</label>
                  <input type="text" id="longitude" name="longitude" class="form-control"
                    value="<?= old('longitude') ?>" placeholder="Masukkan Titik Longitude">
                </div>
                <div class="mb-3">
                  <label for="lantai" class="form-label">Lantai</label>
                  <select class="form-select" name="lantai" id="lantai">
                    <option selected disabled>Pilih Lantai</option>
                    <option value="1" <?= old('lantai') == '1' ? 'selected' : '' ?>>Lantai 1</option>
                    <option value="2" <?= old('lantai') == '2' ? 'selected' : '' ?>>Lantai 2</option>
                    <option value="3" <?= old('lantai') == '3' ? 'selected' : '' ?>>Lantai 3</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-evenly mt-4">
              <button type="submit" name="submit" class="btn rounded-pill btn-primary w-auto mb-3">Tambah</button>
              <a href="/admin/dashboard/inventaris/import"
                class="btn rounded-pill btn-secondary w-auto mb-3">Kembali</a>
            </div>

          </form>
        </div>
      </div>
    </div>

  </div>
</div>

<?= $this->endSection('content') ?>