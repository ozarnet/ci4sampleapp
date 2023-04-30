<!-- Push section css -->
<?= $this->section('css') ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" />
<?= $this->endSection() ?>

<!-- Push section js -->
<?= $this->section('additionalExternalJs') ?>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js" defer></script>
<?= $this->endSection() ?>


<?= $this->section('additionalInlineJs') ?>
    
        $('.select2bs').select2({
            theme: "bootstrap-5",
            allowClear: false,
        });
       
<?= $this->endSection() ?>