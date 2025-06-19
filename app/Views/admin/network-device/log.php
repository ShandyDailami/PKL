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
<div class="container-fluid" style="margin-top: 50px;">
  <div class="row">
    <div class="col-3 px-3 pt-4 position-fixed" style="top: 50px; overflow-y: auto;">
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
    <div class="offset-3 col-9 bg-main py-3">
      <div class="card">
        <div class="card-body">
          <div class="mb-3 d-flex justify-content-between align-items-center">
            <p class="fw-bold">Logs</p>
            <div class="d-flex gap-1">
              <p></p>
              <button id="tambahLog" data-id="<?= $inventaris_id ?>" class="btn btn-sm btn-success">Tambah</button>
              <button id="backFromLog" class="btn btn-sm btn-sec">Kembali</button>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-custom table-hover table-bordered" style="  width: 100%;">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Aktivitas</th>
                  <th scope="col">Deskripsi</th>
                  <th scope="col">Dokumentasi Aktivitas</th>
                  <th scope="col">Waktu</th>
                  <th scope="col">Status</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody class="text-center">
                <?php if (!empty($logs)): ?>
                  <?php foreach ($logs as $log): ?>
                    <tr>
                      <td><?= esc($log['inventaris_id']) ?></td>
                      <td><?= esc($log['aktivitas']) ?></td>
                      <td><?= esc($log['deskripsi']) ?></td>
                      <td><img class="img-rounded" src="<?= base_url('uploads/logs/' . $log['gambar']) ?>"
                          style="height: 100px;" alt=""></td>
                      <td><?= esc($log['waktu']) ?></td>
                      <td><?= esc($log['status']) ?></td>
                      <td>
                        <a href="<?= site_url('admin/dashboard/perangkat-jaringan/logs/' . $log['inventaris_id'] . '/edit/' . $log['id']) ?>"
                          class="btn btn-sm btn-warning">
                          Edit
                        </a>
                        <button class="btn btn-sm btn-danger" data-bs-target="#deleteLog" data-bs-toggle="modal"
                          data-id="<?= esc($log['id']) ?>" data-inventaris-id="<?= esc($log['inventaris_id']) ?>">
                          Hapus
                        </button>
                      </td>
                    </tr>
                  <?php endforeach ?>
                <?php else: ?>
                  <tr>
                    <td colspan="9">Belum Ada Data</td>
                  </tr>
                <?php endif ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal fade" id="deleteLog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <button type="button" class="btn btn-primary" id="confirmDelLog">Hapus</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection('content') ?>