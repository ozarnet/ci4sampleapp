<!-- Push section css -->
<?= $this->section('css') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section('footerAdditions') ?>
<?= $this->include('Themes/_commonPartials/_confirm2delete') ?>
<?= $this->endSection() ?>

<!-- Push section js -->
<?= $this->section('js') ?>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.24.0/min/moment-with-locales.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script>
        moment.locale('<?= config('App')->defaultLocale ?>');
    </script>
    <script>
        $.extend( true, $.fn.dataTable.defaults, {
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/<?= config('Basics')->i18n ?>.json"
            }
        });
    </script>
    <script>
        $(function () {
            $('.using-data-table').DataTable({
                "responsive": true,
                "paging": true,
                "lengthMenu": [ 5, 10, 25, 50, 75, 100, 250 ],
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "scrollX": true,
                "stateSave": true,
            });

            $('#confirm2delete').on('show.bs.modal', function (e) {
                $(this).find('.btn-confirm').attr('href', $(e.relatedTarget).data('href'));
            });
        });

        function toggleAllCheckboxes($cssClass, $io=null) {
            $('.'+$cssClass).prop('checked', $io);
        }

    </script>
<?= $this->endSection() ?>