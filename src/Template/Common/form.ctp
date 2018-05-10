<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->
            <?= $this->fetch('form-start'); ?>
            <div class="box-body">
                <?= $this->fetch('form-content'); ?>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <?= $this->fetch('form-button'); ?>
            </div>
            <?= $this->fetch('form-end'); ?>
        </div>
    </div>
</div>
