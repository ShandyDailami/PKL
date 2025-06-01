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
        <button id="networkDevices" class="btn text-start btn-main border-0"><i
            class="bi bi-router-fill px-2"></i>Perangkat Jaringan</button>
        <button id="items" class="btn text-start btn-main-active border-0"><i
            class="bi bi-clipboard-check-fill px-2"></i>Inventaris</button>
      </div>
    </div>
    <div class="offset-3 col-9 bg-main pt-3 itemsView">
      <div class="card bg-sec text-light">
        <div class="card-body">
          <div class="card-title fw-bold">Inventaris</div>
          <div class="card-text">Daftar aset atau barang yang dimiliki dan dikelola oleh suatu institusi, termasuk
            informasi tentang jumlah, lokasi, dan status penggunaannya.</div>
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
        <?php if (!empty($items)): ?>
          <?php foreach ($items as $item): ?>
            <div class="col-sm-3 d-flex flex-row">
              <div class="card text-center">
                <img src="<?php echo base_url('uploads/' . $item['gambar']); ?>" class="rounded px-2 pt-2"
                  style="height: 150px; object-fit: cover" alt="<?= esc($item['jenis_nama']) ?>">
                <div class="card-body">
                  <h5 class="card-title fw-bold">
                    <?php if (strtolower(esc($item['jenis_nama'])) !== 'access point'): ?>
                      <?= esc($item['jenis_nama']) ?>
                      <?= esc($item['merek']) ?>
                    <?php else: ?>
                      <?= esc($item['jenis_nama']) ?>
                    <?php endif ?>
                  </h5>
                  <div class="d-flex align-items-center flex-column">
                    <p class="card-text m-0">SSID : <?= esc($item['SSID']) ?></p>
                    <p class="card-text m-0">Status : <?= esc($item['status_nama']) ?></p>
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
    </div>
  </div>
</div>

<?= $this->endSection('content') ?>