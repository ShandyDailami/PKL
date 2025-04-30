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
  <div class="card col-md-4 mx-auto border-0">
    <div class="card-body">
      <div class="card-title mb-5 d-flex flex-column align-items-center">
        <h5 class="login-title">Login</h5>
        <div class="line"></div>
      </div>
      <form action="/admin/login" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
          <input type="text" class="input" id="username" name="username" value="<?= old('username') ?>"
            placeholder="Username">
        </div>
        <div class="mb-3">
          <input type="password" id="password" name="password" class="input" placeholder="Password">
        </div>
        <div class="mb-3">
          <div class="g-recaptcha" data-sitekey="6LfqXB8rAAAAAO59CfiSGwIMnOIrfO_1Crhm5KAG"></div>
        </div>
        <button type="submit" name="submit" class="btn btn-login w-100 mb-3">LOGIN</button>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection('content') ?>