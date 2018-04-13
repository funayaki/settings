<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="index large-12 medium-12 columns content">
    <table cellpadding="0" cellspacing="0">
        <?= $this->fetch('table-heading'); ?>
        <?= $this->fetch('table-body'); ?>
    </table>
    <div class="paginator">
        <?= $this->fetch('pagination'); ?>
        <?= $this->fetch('page_counter'); ?>
    </div>
</div>