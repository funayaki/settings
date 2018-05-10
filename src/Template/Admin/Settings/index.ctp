<?php
/**
 * @var \App\View\AppView $this
 * @var \Settings\Model\Entity\Setting[]|\Cake\Collection\CollectionInterface $settings
 */
use Cake\Core\Configure;
use Cake\Utility\Inflector;

$action = Inflector::camelize($this->request->getParam('action'));

$this->extend('Cirici/AdminLTE./Common/index');

$this->assign('subtitle', $action);

$this->start('breadcrumb');
$this->Breadcrumbs
    ->add(__d('croogo', 'Settings'), ['action' => 'index'])
    ->add($action, null, ['class' => 'active']);

echo $this->Breadcrumbs->render();
$this->end();

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
        $setting->editable ? $this->Html->tag('span', '', ['class' => 'glyphicon glyphicon-ok']) : '',
        [$actions, ['class' => 'actions', 'style' => 'white-space:nowrap']],
    );
endforeach;

echo $this->Html->tag('tbody', $this->Html->tableCells($rows));
$this->end();

$this->start('page-numbers');
echo $this->Paginator->numbers();
$this->end();

$this->start('page-counter');
$pageCounter = $this->Paginator->counter(['format' => __d('croogo', 'Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]);
echo $this->Html->tag('p', $pageCounter);
$this->end();
