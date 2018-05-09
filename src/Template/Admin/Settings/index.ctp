<?php
/**
 * @var \App\View\AppView $this
 * @var \Settings\Model\Entity\Setting[]|\Cake\Collection\CollectionInterface $settings
 */
use Cake\Core\Configure;

$this->assign('subtitle', 'Index');

$this->Breadcrumbs->add(__('Settings'), ['action' => 'index']);
$this->Breadcrumbs->add(__('Index'));
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('id', __d('croogo', 'Id')) ?></th>
                        <th><?= $this->Paginator->sort('key', __d('croogo', 'Key')) ?></th>
                        <th><?= $this->Paginator->sort('value', __d('croogo', 'Value')) ?></th>
                        <th><?= $this->Paginator->sort('editable', __d('croogo', 'Editable')) ?></th>
                        <th><?= __d('croogo', 'Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($settings as $setting): ?>
                        <?php
                        $key = $setting->key;
                        $keyE = explode('.', $key);
                        $keyPrefix = $keyE['0'];
                        if (isset($keyE['1'])) {
                            $keyTitle = '.' . $keyE['1'];
                        } else {
                            $keyTitle = '';
                        }
                        ?>
                        <tr>
                            <td><?= $this->Number->format($setting->id) ?></td>
                            <td><?= $this->Html->link($keyPrefix, ['controller' => 'settings', 'action' => 'index', '?' => ['key' => $keyPrefix]]) . $keyTitle ?></td>
                            <td><?= $this->Text->truncate($setting->value, 20) ?></td>
                            <td><?= $setting->editable ? $this->Html->tag('span', '', ['class' => 'fa fa-check']) : '' ?></td>
                            <td class="actions" style="white-space:nowrap">
                                <?= $this->Html->link(__d('croogo', 'Move up'), ['controller' => 'settings', 'action' => 'moveUp', $setting->id], ['class' => 'btn btn-default btn-xs']) ?>
                                <?= $this->Html->link(__d('croogo', 'Move down'), ['controller' => 'settings', 'action' => 'moveDown', $setting->id], ['class' => 'btn btn-default btn-xs']) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $setting->id], ['class' => 'btn btn-default btn-xs']) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $setting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $setting->id), 'class' => 'btn btn-danger btn-xs']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <ul class="pagination pagination-sm no-margin pull-right">
                    <?php echo $this->Paginator->numbers(); ?>
                </ul>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
