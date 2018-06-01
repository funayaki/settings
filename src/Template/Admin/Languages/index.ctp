<?php
/**
 * @var \App\View\AppView $this
 * @var \Settings\Model\Entity\Language[]|\Cake\Collection\CollectionInterface $languages
 */
$this->extend('Cirici/AdminLTE./Common/index');

$this->Breadcrumbs
    ->add(__d('croogo', 'Languages'), $this->request->getUri()->getPath());

$tableHeaders = $this->Html->tableHeaders([
    $this->Paginator->sort('title', __d('croogo', 'Title')),
    $this->Paginator->sort('native', __d('croogo', 'Native')),
    $this->Paginator->sort('alias', __d('croogo', 'Alias')),
    $this->Paginator->sort('locale', __d('croogo', 'Locale')),
    $this->Paginator->sort('status', __d('croogo', 'Status')),
    __d('croogo', 'Actions'),
]);
$this->append('table-header', $tableHeaders);

$rows = [];
foreach ($languages as $language) {
    $actions = [];
    $actions[] = $this->Html->link(__d('croogo', 'Move up'),
        ['action' => 'moveUp', $language->id],
        ['class' => 'btn btn-default btn-xs']
    );
    $actions[] = $this->Html->link(__d('croogo', 'Move down'),
        ['action' => 'moveDown', $language->id],
        ['class' => 'btn btn-default btn-xs']
    );
    $actions[] = $this->Html->link(__d('croogo', 'Edit this item'),
        ['action' => 'edit', $language->id],
        ['class' => 'btn btn-default btn-xs']
    );
    $actions[] = $this->Form->postLink(__d('croogo', 'Remove this item'),
        ['action' => 'delete', $language->id],
        ['class' => 'btn btn-danger btn-xs', 'confirm' => __d('croogo', 'Are you sure?')]
    );

    $actions = $this->Html->div('item-actions', implode(' ', $actions));

    $rows[] = [
        $language->title,
        $language->native,
        $language->alias,
        $language->locale,
        $language->status ? $this->Html->tag('span', '', ['class' => 'glyphicon glyphicon-ok']) : '',
        [$actions, ['style' => 'white-space:nowrap']],
    ];
}

$this->append('table-body', $this->Html->tableCells($rows));

$this->start('page-numbers');
echo $this->Paginator->numbers();
$this->end();
