<?php if (config('Basics')->theme['name'] == 'Bootstrap5') { ?>
    <div class="modal fade" id="confirm2delete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirm2deleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirm2deleteLabel"><?=lang('Basic.global.deleteConfirmation')?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?=lang('Basic.global.deleteConfirmationQuestion')?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?=lang('Basic.global.deleteConfirmationCancel')?></button>
                    <a class="btn btn-danger btn-confirm"> <?=lang('Basic.global.deleteConfirmationButton')?> </a>
                </div><!--//.modal-footer -->
            </div><!--//.modal-content -->
        </div><!--//.modal-dialog -->
    </div><!--//.modal -->
<?php } else { ?>
    <div id="confirm2delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirm2deleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="confirm2deleteLabel"><?=lang('Basic.global.deleteConfirmation')?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?=lang('Basic.global.deleteConfirmationQuestion')?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('Basic.global.deleteConfirmationCancel')?></button>
                    <a class="btn btn-danger btn-confirm"> <?=lang('Basic.global.deleteConfirmationButton')?> </a>
                </div><!--//.modal-footer -->
            </div><!--//.modal-content -->
        </div><!--//.modal-dialog -->
    </div><!--//.modal -->
<?php } ?>