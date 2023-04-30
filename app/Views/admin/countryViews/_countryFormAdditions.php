<div class="modal fade" id="modalCountryForm"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCountryLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCountryLabel">Country Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="countryForm">
            
                    				<?= view("admin/countryViews/_countryFormItems") ?>
                    <?= csrf_field() ?>
            
                    <input type="hidden" name="form_action" id="formAction">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" id="btnSaveCountry">Save</button>
            </div>
        </div>
    </div>
</div>