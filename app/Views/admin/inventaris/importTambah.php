<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>

<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom position-fixed top-0 start-0 end-0"
  style="height: 50px; z-index: 1030;">
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

<div class="container-fluid" style="padding-top: 60px;">
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
        <button id="tambahInventaris" class="btn text-start btn-main-active border-0"><i
            class="bi bi-plus-circle-fill px-2"></i>Tambah Perangkat</button>
        <a class="btn btn-outline-danger text-start" href="/admin/logout"><i
            class="px-2 bi bi-door-open-fill"></i>Logout</a>
      </div>
    </div>
    <div class="offset-3 col-9">
      <div class="card mx-auto border-0" style="max-width: 500px;">
        <div class="card-body">
          <div class="card-title mb-5 d-flex flex-column align-items-center">
            <h5 class="login-title">Tambah</h5>
            <div class="line"></div>
          </div>

          <form action="" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
              <label for="file" class="form-label">Import File (Excel/CSV)</label>
              <input type="file" class="form-control" name="file_excel" id="file" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-2">Import Data</button>
          </form>
          <a href="<?= base_url('template/Template_Import.xlsx') ?>" class="w-100 btn btn-success">
            Download Template Excel
          </a>

          <div class="text-center my-3">
            <span>atau</span>
          </div>

          <div class="d-grid">
            <a href="<?= base_url('/admin/dashboard/inventaris/tambah') ?>" class="mb-2 btn btn-primary">Input
              Manual</a>
            <a href="/admin/dashboard/perangkat-jaringan" class="btn btn-secondary w-auto mb-3">Kembali</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?= $this->endSection('content') ?>