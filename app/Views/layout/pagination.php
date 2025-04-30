<?php
use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
  <ul class="pagination justify-content-center">

    <!-- Tombol Previous -->
    <?php if ($pager->hasPreviousPage()): ?>
      <li class="page-item">
        <a class="page-link" href="<?= $pager->getPreviousPage() ?>" aria-label="<?= lang('Pager.previous') ?>">
          &laquo; <?= lang('Pager.previous') ?>
        </a>
      </li>
    <?php else: ?>
      <li class="page-item disabled">
        <span class="page-link" tabindex="-1" aria-disabled="true">
          &laquo; <?= lang('Pager.previous') ?>
        </span>
      </li>
    <?php endif; ?>

    <!-- Nomor Halaman -->
    <?php foreach ($pager->links() as $link): ?>
      <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
        <a class="page-link" href="<?= $link['uri'] ?>">
          <?= $link['title'] ?>
        </a>
      </li>
    <?php endforeach ?>

    <!-- Tombol Next -->
    <?php if ($pager->hasNextPage()): ?>
      <li class="page-item">
        <a class="page-link" href="<?= $pager->getNextPage() ?>" aria-label="<?= lang('Pager.next') ?>">
          <?= lang('Pager.next') ?> &raquo;
        </a>
      </li>
    <?php else: ?>
      <li class="page-item disabled">
        <span class="page-link" tabindex="-1" aria-disabled="true">
          <?= lang('Pager.next') ?> &raquo;
        </span>
      </li>
    <?php endif; ?>

  </ul>
</nav>