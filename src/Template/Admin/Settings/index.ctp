<?php
/**
 * @var \App\View\AppView $this
 * @var \Settings\Model\Entity\Setting[]|\Cake\Collection\CollectionInterface $settings
 */

$this->extend('Cirici/AdminLTE./Common/index');

$this->Breadcrumbs
    ->add(__d('croogo', 'Settings'), array(
        'prefix' => 'admin',
        'plugin' => 'Settings',
        'controller' => 'Settings',
        'action' => 'index',
    ));
if (!empty($this->request->params['named']['p'])) {
    $this->Breadcrumbs->add($this->request->params['named']['p']);
}
$this->start('table-header');
$tableHeaders = $this->Html->tableHeaders(array(
    $this->Paginator->sort('id', __d('croogo', 'Id')),
    $this->Paginator->sort('key', __d('croogo', 'Key')),
    $this->Paginator->sort('value', __d('croogo', 'Value')),
    $this->Paginator->sort('editable', __d('croogo', 'Editable')),
    __d('croogo', 'Actions'),
));
echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
$rows = array();
foreach ($settings as $setting):
    $actions = array();
    $actions[] = $this->Html->link(__d('croogo', 'Move up'),
        ['controller' => 'Settings', 'action' => 'moveup', $setting->id],
        ['class' => 'btn btn-default btn-xs']
    );
    $actions[] = $this->Html->link(__d('croogo', 'Move down'),
        ['controller' => 'Settings', 'action' => 'movedown', $setting->id],
        ['class' => 'btn btn-default btn-xs']
    );
    $actions[] = $this->Html->link(__d('croogo', 'Edit this item'),
        ['controller' => 'Settings', 'action' => 'edit', $setting->id],
        ['class' => 'btn btn-default btn-xs']
    );
    $actions[] = $this->Form->postLink(__d('croogo', 'Remove this item'),
        ['controller' => 'Settings', 'action' => 'delete', $setting->id],
        ['class' => 'btn btn-danger btn-xs', 'confirm' => __d('croogo', 'Are you sure?')]
    );

    $key = $setting->key;
    $keyE = explode('.', $key);
    $keyPrefix = $keyE['0'];
    if (isset($keyE['1'])) {
        $keyTitle = '.' . $keyE['1'];
    } else {
        $keyTitle = '';
    }
    $actions = $this->Html->div('item-actions', implode(' ', $actions));
    $rows[] = array(
        $setting->id,
        $this->Html->link($keyPrefix, array('controller' => 'Settings', 'action' => 'index', '?' => array('key' => $keyPrefix))) . $keyTitle,
        $this->Text->truncate($setting->value, 20),
        $setting->editable ? $this->Html->tag('span', '', ['class' => 'glyphicon glyphicon-ok']) : '',
        [$actions, ['style' => 'white-space:nowrap']],
    );
endforeach;

echo $this->Html->tableCells($rows);
$this->end();

$this->start('page-numbers');
echo $this->Paginator->numbers();
$this->end();

$this->append('header-actions');
echo $this->Html->link(__d('croogo', 'New Setting'),
    ['action' => 'add'],
    ['class' => 'btn btn-default pull-right']
);
$this->end();
