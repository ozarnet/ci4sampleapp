<!-- Push section css -->
<?= $this->section('css') ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css">
<?= $this->endSection() ?>

<!-- Push section js -->
<?= $this->section('js') ?>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js" defer></script>
    <script type="module">
        $(document).ready(function() {
            $('.select2bs').select2({
                allowClear: false,
            });
        });
    </script>
<?= $this->endSection() ?>