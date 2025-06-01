<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>

<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom position-fixed top-0 start-0 end-0"
  style="height: 50px;">
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
    <div id="formTambah" class="col-12 align-items-center mt-5">
      <div class="card mx-auto border-0" style="max-width: 500px;">
        <div class="card-body">
          <div class="card-title mb-5 d-flex flex-column align-items-center">
            <h5 class="login-title">Ubah Password</h5>
            <div class="line"></div>
          </div>

          <form action="/admin/change-password" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
              <label for="current_password" class="form-label">Password Lama</label>
              <input type="password" id="current_password" name="current_password" class="form-control"
                placeholder="Masukkan Password Lama">
            </div>

            <div class="mb-3">
              <label for="new_password" class="form-label">Password Baru</label>
              <input type="password" id="new_password" name="new_password" class="form-control"
                placeholder="Masukkan Password Baru">
            </div>

            <div class="mb-3">
              <label for="confirm_password" class="form-label">Konfirmasi Password</label>
              <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                placeholder="Konfirmasi Password">
            </div>

            <div class="d-flex justify-content-evenly mt-4">
              <button type="submit" name="submit" class="btn rounded-pill btn-primary w-auto mb-3">Ubah</button>
              <button type="button" class="btn rounded-pill btn-secondary w-auto mb-3"
                onclick="history.back()">Kembali</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection('content') ?>