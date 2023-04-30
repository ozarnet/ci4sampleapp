<!-- Push section css -->
<?= $this->section('css') ?>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.7.2/dist/sweetalert2.min.css">
<?= $this->endSection() ?>

<!-- Push additional js -->
<?= $this->section('additionalExternalJs') ?>
<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.7.2/dist/sweetalert2.all.min.js" defer></script>
<?= $this->endSection() ?>


<?= $this->section('additionalInlineJs') ?>
<?php if (session('sweet-success')) { ?>
      Toast.fire({
          icon: 'success',
          title: '<?= session('sweet-success') ?>'
      });
  <?php } ?>
  <?php if (session('sweet-warning')) { ?>
      Toast.fire({
          icon: 'warning',
          title: '<?= session('sweet-warning') ?>'
      });
  <?php } ?>
  <?php if (session('sweet-error')) { ?>
      Toast.fire({
          icon: 'error',
          title: '<?= session('sweet-error') ?>'
      });
  <?php } ?>
<?= $this->endSection() ?>
