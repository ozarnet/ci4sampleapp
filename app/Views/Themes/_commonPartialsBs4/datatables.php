<!-- Push section css -->
<?= $this->section('css') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section('footerAdditions') ?>
<?= $this->include('Themes/_commonPartials/_confirm2delete') ?>
<?= $this->endSection() ?>

<!-- Push section js -->
<?= $this->section('js') ?>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.24.0/min/moment-with-locales.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js" defer></script>
    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            moment.locale('<?= config('App')->defaultLocale ?>');
            $.extend( true, $.fn.dataTable.defaults, {
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/<?= config('Basics')->i18n ?>.json"
                }
            });

<?php if (isset($usingClientSideDataTable) && $usingClientSideDataTable == true) : ?>
            let lastColNr = $(".using-data-table").find("tr:first th").length - 1;
            $('.using-data-table').DataTable({
                "responsive": true,
                "paging": true,
                "lengthMenu": [ 5, 10, 25, 50, 75, 100, 250, 500, 1000, 2500 ],
                "pageLength": 10,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "scrollX": true,
                "stateSave": true,
                "columnDefs": [
                    {
                        orderable: false,
                        searchable: false,
                        targets: [0,lastColNr]
                    }
                ]
            });

            $('#confirm2delete').on('show.bs.modal', function (e) {
                $(this).find('.btn-confirm').attr('href', $(e.relatedTarget).data('href'));
            });
<?php endif; ?>
        });

        // helper function in case of using checkboxes in a column to select the rows
        function toggleAllCheckboxes($cssClass, $io=null) {
            $('.'+$cssClass).prop('checked', $io);
        }

    </script>
<?= $this->endSection() ?>