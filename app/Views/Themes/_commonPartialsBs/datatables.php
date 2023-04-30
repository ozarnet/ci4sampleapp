<!-- Push section css -->
<?= $this->section('css') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.<?=config('Basics')->theme['name'] == 'Bootstrap5' ? 'bootstrap5' : 'bootstrap4' ?>.min.css">
<?= $this->endSection() ?>

<?= $this->section('footerAdditions') ?>
<?= $this->include('Themes/_commonPartialsBs/_confirm2delete') ?>
<?= $this->endSection() ?>

<!-- Push additional js -->
<?= $this->section('additionalExternalJs') ?>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.24.0/min/moment-with-locales.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.<?=config('Basics')->theme['name'] == 'Bootstrap5' ? 'bootstrap5' : 'bootstrap4' ?>.min.js" defer></script>
<?= $this->endSection() ?>


<?= $this->section('additionalInlineJs') ?>
    
        moment.locale('<?=  $currentLocale ?? config('App')->defaultLocale ?>');

    <?php if (isset($usingServerSideDataTable) && $usingServerSideDataTable) : ?>
        // Pipelining function for DataTables. To be used to the `ajax` option of DataTables
        $.fn.dataTable.pipeline = function (opts) {
            // Configuration options
            let conf = $.extend({
                pages: 5,     // number of pages to cache
                url: '',
                method: 'POST',
                headers: {'X-Requested-With': 'XMLHttpRequest'}
            }, opts);

            // Private variables for storing the cache
            let cacheLower = -1;
            let cacheUpper = null;
            let cacheLastRequest = null;
            let cacheLastJson = null;

            return function (request, drawCallback, settings) {
                let ajax = false;
                let requestStart = request.start;
                let drawStart = request.start;
                let requestLength = request.length;
                let requestEnd = requestStart + requestLength;

                if (settings.clearCache) {
                    // API requested that the cache be cleared
                    ajax = true;
                    settings.clearCache = false;
                } else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
                    // outside cached data - need to make a request
                    ajax = true;
                } else if (JSON.stringify(request.order) !== JSON.stringify(cacheLastRequest.order) ||
                    JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) ||
                    JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)
                ) {
                    // properties changed (ordering, columns, searching)
                    ajax = true;
                }

                // Store the request for checking next time around
                cacheLastRequest = $.extend(true, {}, request);

                if (ajax) {
                    // Need data from the server
                    if (requestStart < cacheLower) {
                        requestStart = requestStart - (requestLength * (conf.pages - 1));

                        if (requestStart < 0) {
                            requestStart = 0;
                        }
                    }

                    cacheLower = requestStart;
                    cacheUpper = requestStart + (requestLength * conf.pages);

                    request.start = requestStart;
                    request.length = requestLength * conf.pages;

                    // Provide the same `data` options as DataTables.
                    if (typeof conf.data === 'function') {
                        // As a function it is executed with the data object as an arg
                        // for manipulation. If an object is returned, it is used as the
                        // data object to submit
                        let d = conf.data(request);
                        if (d) {
                            $.extend(request, d);
                        }
                    } else if ($.isPlainObject(conf.data)) {
                        // As an object, the data given extends the default
                        $.extend(request, conf.data);
                    }

                    request.<?=csrf_token()?> = <?=csrf_token()?>v;

                    return $.ajax({
                        "type": conf.method,
                        "url": conf.url,
                        "data": request,
                        "dataType": "json",
                        "cache": false,
                        "success": function (json) {
                            cacheLastJson = $.extend(true, {}, json);

                            if (cacheLower != drawStart) {
                                json.data.splice(0, drawStart - cacheLower);
                            }
                            if (requestLength >= -1) {
                                json.data.splice(requestLength, json.data.length);
                            }

                            drawCallback(json);

                            yeniden(json.token);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {

                            $('.dataTables_processing').hide();
                            const theData = jqXHR.responseJSON;
                            drawCallback(theData);
                            Toast.fire({
                                icon: 'error',
                                title: errorThrown,
                            });
                        }
                    });
                } else {
                    let json = $.extend(true, {}, cacheLastJson);
                    json.draw = request.draw; // Update the echo for each response
                    json.data.splice(0, requestStart - cacheLower);
                    json.data.splice(requestLength, json.data.length);

                    drawCallback(json);
                }
            }
        };

        // Register an API method that will empty the pipelined data, forcing an Ajax
        // fetch on the next draw (i.e. `table.clearPipeline().draw()`)
        $.fn.dataTable.Api.register('clearPipeline()', function () {
            return this.iterator('table', function (settings) {
                settings.clearCache = true;
            });
        });
        <?php endif; ?>

        <?php if (isset($usingClientSideDataTable) && $usingClientSideDataTable) { ?>
            let lastColNr = $(".using-data-table").find("tr:first th").length - 1;
            theTable = $('.using-data-table').DataTable({
                "responsive": true,
                "paging": true,
                "lengthMenu": [ 5, 10, 25, 50, 75, 100, 250, 500, 1000, 2500 ],
                "pageLength": 10,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "scrollX": true,
                "stateSave": true,
                "language": {
                    url: "//cdn.datatables.net/plug-ins/1.12.1/i18n/<?= config('Basics')->languages[$currentLocale] ?? config('Basics')->i18n ?>.json"
                },
                "columnDefs": [
                    {
                        orderable: false,
                        searchable: false,
                        targets: [0,lastColNr]
                    }
                ]
            });

        <?php } ?>

        $('#confirm2delete').on('show.bs.modal', function (e) {
            $(this).find('.btn-confirm').attr('href', $(e.relatedTarget).data('href'));
        });
    

        // helper function in case of using checkboxes in a column to select the rows
        function toggleAllCheckboxes($cssClass, $io=null) {
            $('.'+$cssClass).prop('checked', $io);
        }

<?= $this->endSection() ?>