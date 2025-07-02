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
        <button id="tambahInventaris" class="btn text-start btn-main border-0"><i
            class="bi bi-plus-circle-fill px-2"></i>Tambah Perangkat</button>
        <a class="btn btn-outline-danger text-start" href="/admin/logout"><i
            class="px-2 bi bi-door-open-fill"></i>Logout</a>
      </div>
    </div>
    <div class="offset-3 col-9 py-3 bg-main">
      <div class="p card mx-auto border-0" style="max-width: 900px;">
        <div class="card-body">
          <div class="card-title mb-5 d-flex flex-column align-items-center">
            <h5 class="login-title">Edit</h5>
            <div class="line"></div>
          </div>

          <form action="" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" id="inventaris_id" name="inventaris_id" class="form-control"
              value="<?= esc($inventaris_id) ?>" placeholder="Masukkan Jenis Perangkat">
            <div class="mb-3">
              <label for="aktivitas" class="form-label">Aktivitas</label>
              <input type="text" class="form-control" id="aktivitas" name="aktivitas"
                value="<?= esc($log['aktivitas']) ?>" placeholder="Masukkan Aktivitas">
            </div>
            <div class="mb-3">
              <label for="deskripsi" class="form-label">Deskripsi</label>
              <textarea type="text" class="form-control" id="deskripsi" name="deskripsi"
                placeholder="Masukkan Deskripsi"><?= esc($log['deskripsi']) ?></textarea>
            </div>
            <div class="mb-3">
              <label for="gambar" class="form-label">Dokumentasi Kegiatan</label>
              <img class="rounded" src="<?= base_url('uploads/logs/' . $log['gambar']) ?>" style="height: 50px;" alt="">
              <input type="file" class="form-control" id="gambar" name="gambar">
            </div>
            <div class="mb-3">
              <label for="waktu" class="form-label">Tanggal</label>
              <input type="date" value="<?= esc($log['waktu']) ?>" class="form-control" id="waktu" name="waktu">
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">Status Setelah Perbaikan</label>
              <input type="text" class="form-control" value="<?= esc($log['status']) ?>" id="status" name="status"
                placeholder="Masukkan Status" value="<?= old('status') ?>">
            </div>

            <div class=" d-flex justify-content-evenly mt-4">
              <button type="submit" name="submit" class="btn rounded-pill btn-primary w-auto mb-3">Edit</button>
              <a href="/admin/dashboard/perangkat-jaringan/logs/<?= $inventaris_id ?>"
                class="btn rounded-pill btn-secondary w-auto mb-3">Kembali</a>
            </div>

          </form>
        </div>
      </div>
    </div>

  </div>
</div>

<?= $this->endSection('content') ?>