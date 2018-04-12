<?php
/**
 * @var \App\View\AppView $this
 */
$this->extend('/Common/admin_index');

$this->Html
    ->addCrumb('', '/admin')
    ->addCrumb(__d('croogo', 'Settings'), array(
        'admin' => true,
        'plugin' => 'settings',
        'controller' => 'settings',
        'action' => 'index',
    ));
if (!empty($this->request->params['named']['p'])) {
    $this->Html->addCrumb($this->request->params['named']['p']);
}

$this->start('table-heading');
$tableHeaders = $this->Html->tableHeaders(array(
    $this->Paginator->sort('id', __d('croogo', 'Id')),
    $this->Paginator->sort('key', __d('croogo', 'Key')),
    $this->Paginator->sort('value', __d('croogo', 'Value')),
    $this->Paginator->sort('editable', __d('croogo', 'Editable')),
    __d('croogo', 'Actions'),
));
echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->start('table-body');
$rows = [];
foreach ($settings as $setting):
    $actions = [];
    $actions[] = $this->Html->link(__d('croogo', 'Move up'),
        ['controller' => 'settings', 'action' => 'moveUp', $setting->id]
    );
    $actions[] = $this->Html->link(__d('croogo', 'Move down'),
        ['controller' => 'settings', 'action' => 'moveDown', $setting->id]
    );
    $actions[] = $this->Html->link(__d('croogo', 'Edit this item'),
        ['controller' => 'settings', 'action' => 'edit', $setting->id]
    );
//    $actions[] = $this->Croogo->adminRowActions($setting->id);
    $actions[] = $this->Form->postLink(__d('croogo', 'Remove this item'),
        ['controller' => 'settings', 'action' => 'delete', $setting->id],
        ['confirm' => __d('croogo', 'Are you sure?')]
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
        $this->Html->link($keyPrefix, ['controller' => 'settings', 'action' => 'index', '?' => ['key' => $keyPrefix]]) . $keyTitle,
        $this->Text->truncate($setting->value, 20),
//        $this->Html->status($setting->editable),
        h($setting->editable),
        $actions,
    );
endforeach;

echo $this->Html->tableCells($rows);
$this->end();

$this->start('pagination');
$tags = [];
$tags[] = $this->Paginator->first('<< ' . __d('croogo', 'first'));
$tags[] = $this->Paginator->prev('< ' . __d('croogo', 'previous'));
$tags[] = $this->Paginator->numbers();
$tags[] = $this->Paginator->next(__d('croogo', 'next') . ' >');
$tags[] = $this->Paginator->last(__d('croogo', 'last') . ' >>');
echo $this->Html->tag('ul', implode('', $tags), ['class' => 'pagination']);
$this->end();

$this->start('page_counter');
$pageCounter = $this->Paginator->counter(['format' => __d('croogo', 'Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]);
echo $this->Html->tag('p', $pageCounter);
$this->end();
