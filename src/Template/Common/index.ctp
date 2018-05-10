<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="index large-12 medium-12 columns content">
    <table cellpadding="0" cellspacing="0">
        <?= $this->fetch('table-header'); ?>
        <?= $this->fetch('table-body'); ?>
    </table>
    <div class="paginator">
        <?= $this->fetch('page-numbers'); ?>
        <?= $this->fetch('page-counter'); ?>
    </div>
</div>