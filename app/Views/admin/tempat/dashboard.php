<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>

<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom position-fixed top-0 start-0 end-0"
  style="height: 50px;">
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
<div class="container-fluid" style="margin-top: 50px;">
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
        <button id="tempat" class="btn text-start btn-main-active border-0"><i
            class="bi bi-geo-fill px-2"></i>Tempat</button>
        <button id="tambahInventaris" class="btn text-start btn-main border-0"><i
            class="bi bi-plus-circle-fill px-2"></i>Tambah Perangkat</button>
        <a class="btn btn-outline-danger text-start" href="/admin/logout"><i
            class="px-2 bi bi-door-open-fill"></i>Logout</a>
      </div>
    </div>
    <div id="dashboard" class="offset-3 col-9 bg-main py-3">
      <div class="card">
        <div class="card-body">
          <div class="mb-3 d-flex justify-content-between align-items-center">
            <p class="fw-bold">Tempat</p>
            <button id="tambahTempat" type="submit" class="btn btn-sec">Tambah</button>
          </div>
          <div>
            <table class="table table-custom table-light table-hover table-borderer">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Tempat</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody class="text-center">
                <?php if (!empty($places)): ?>
                  <?php
                  $page = isset($_GET['page']) ? $_GET['page'] : 1;
                  $no = 1 + (10 * ($page - 1));
                  ?>
                  <?php foreach ($places as $index => $place): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= esc($place['nama']) ?></td>
                      <td>
                        <button id="editTempat" data-id="<?= esc($place['id']) ?>"
                          class="btn btn-sm btn-warning">Edit</button>
                        <button class="btn btn-sm btn-danger" data-bs-target="#hapusTempat" data-bs-toggle="modal"
                          data-id="<?= esc($place['id']) ?>">Hapus</button>
                      </td>
                    </tr>
                  <?php endforeach ?>
                <?php else: ?>
                  <tr>
                    <td colspan="3">Belum Ada Data</td>
                  </tr>
                <?php endif ?>
              </tbody>
            </table>
          </div>
        </div>
        <div>
          <?= $pager->links('default', 'pagination') ?>
        </div>
        <div class="modal fade" id="hapusTempat" tabindex=" -1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Hapus</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-primary" id="confirmTempat">Hapus</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<div id="formTambah" class="offset-3 col-9 align-items-center d-none">
  <div class="card mx-auto border-0" style="max-width: 500px;">
    <div class="card-body">
      <div class="card-title mb-5 d-flex flex-column align-items-center">
        <h5 class="login-title">Tambah</h5>
        <div class="line"></div>
      </div>

      <form action="" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
          <label for="nama" class="form-label">Tempat</label>
          <input type="text" id="nama" name="nama" class="form-control" value="<?= old('nama') ?>"
            placeholder="Masukkan Tempat">
        </div>

        <div class="d-flex justify-content-evenly mt-4">
          <button type="submit" name="submit" class="btn rounded-pill btn-primary w-auto mb-3">Tambah</button>
          <button id="kembali" type="submit" name="submit"
            class="btn rounded-pill btn-secondary w-auto mb-3">Kembali</button>
        </div>

      </form>
    </div>
  </div>

  <div class="modal fade" id="deleteDevice" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Hapus</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Apakah Anda yakin ingin menghapus data ini?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
          <button type="button" class="btn btn-primary" id="confirm">Hapus</button>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection('content') ?>