<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>

<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom position-fixed top-0 start-0 end-0"
  style="height: 50px; z-index: 1030;">
</nav>

<div class="container-fluid" style="margin-top: 50px;">
  <div class="row">
    <div class="col-3 px-3 pt-4 position-fixed" style="top: 50px; overflow-y: auto;">
      <div class="d-flex flex-column gap-2">
        <h4 class="f-main">DEVICE</h4>
        <button id="networkDevices" class="btn text-start btn-main-active btn-main border-0"><i
            class="bi bi-router-fill px-2"></i>Perangkat Jaringan</button>
        <button id="items" class="btn text-start btn-main border-0"><i
            class="bi bi-clipboard-check-fill px-2"></i>Inventaris</button>
      </div>
    </div>
    <div class="offset-3 col-9 bg-main py-3 dashboard">
      <div class="card bg-sec text-light">
        <div class="card-body">
          <div class="card-title fw-bold">Perangkat Jaringan</div>
          <div class="card-text">Komponen hardware yang digunakan untuk menghubungkan dan mengelola komunikasi antar
            perangkat dalam suatu jaringan, seperti router, switch, modem, dan access point. </div>
        </div>
      </div>
      <div class="container-fluid d-flex justify-content-start pt-4 px-0">
        <form action="" method="get" class="d-flex" role="search">
          <input class="form-control me-2" name="keyword" type="search" placeholder="Search" aria-label="Search"
            value="<?= esc($keyword) ?>">
          <button class=" btn btn-sec" type="submit"><i class="bi bi-search"></i></button>
        </form>
      </div>
      <div class="row d-flex py-4 flex-row">
        <?php if (!empty($devices)): ?>
          <?php foreach ($devices as $device): ?>
            <div class="col-sm-3">
              <div class="card text-center">
                <img src="<?php echo base_url('uploads/' . $device['gambar']); ?>" class="card-img-top px-2 pt-2"
                  style="height: 150px; object-fit: cover" alt="...">
                <div class="card-body">
                  <h5 class="card-title fw-bold" style="text-transform: capitalize;">
                    <?= esc($device['jenis_nama']) ?>
                  </h5>
                  <div class="d-flex flex-column">
                    <p class="card-text text-capitalize fs-6 m-0">SSID: <?= esc($device['SSID']) ?></p>
                    <p class="card-text text-capitalize fs-6 m-0"><?= esc($device['tempat']) ?></p>
                    <p class="card-text text-capitalize fs-6 m-0">Status : <?= esc($device['status_nama']) ?></p>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach ?>
          <div class="mt-2">
            <?= $pager->links('default', 'pagination') ?>
          </div>
        <?php else: ?>
          <p class="text-center">Data tidak ditemukan</p>
        <?php endif ?>
      </div>
      <div class="card mt-3 p-3">
        <p class="fw-bold">Mapping</p>
        <div id="map" class="rounded"></div>
      </div>
    </div>
  </div>
</div>

<?php foreach ($modals as $modal): ?>

  <div class="modal fade" id="<?= $modal['id'] ?>" tabindex="-1" aria-labelledby="<?= $modal['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="<?= $modal['id'] ?>">
            <?= esc($modal['tempat']) ?> -
            <?= esc($modal['jenis_nama']) ?>
            <?= esc($modal['merek']) ?>
          </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" data-tempat="<?= $modal['tempat'] ?>">
          <img class="img-rounded gambarPeta" style="max-width:750px; height: auto;" alt="">
        </div>
      </div>
    </div>
  </div>
<?php endforeach ?>

<?= $this->endSection('content') ?>