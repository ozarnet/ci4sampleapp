<div class="row">
    <div class="col-md-12">
        <div class="alert alert-dismissible alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fas fa-exclamation-triangle"></i> Please correct the errors below:</h4>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div><!--//.alert-->
    </div><!--//.col-->
</div><!--//.row -->