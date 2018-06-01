<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Core\App;

$this->extend('Cirici/AdminLTE./Common/index');

$clearUrl = [
    'prefix' => 'admin',
    'plugin' => 'Settings',
    'controller' => 'Caches',
    'action' => 'clear',
];

$this->Breadcrumbs->add(__d('croogo', 'Settings'),
    ['plugin' => 'Settings', 'controller' => 'Settings', 'action' => 'prefix', 'Site'])
    ->add(__d('croogo', 'Caches'), $this->request->getUri()->getPath());

//$this->append('action-buttons');
//echo $this->Croogo->adminAction(__d('croogo', 'Clear All'), array_merge(
//    $clearUrl, ['config' => 'all']
//), [
//    'method' => 'post',
//    'tooltip' => [
//        'data-title' => __d('croogo', 'Clear all cache'),
//        'data-placement' => 'left',
//    ],
//]);
//$this->end();

$tableHeaders = $this->Html->tableHeaders([
    $this->Paginator->sort('title', __d('croogo', 'Cache')),
    __d('croogo', 'Engine'),
    __d('croogo', 'Duration'),
    __d('croogo', 'Actions')
]);
$this->append('table-header', $tableHeaders);

$rows = [];
foreach ($caches as $cache => $engine):
    $actions = [];
    $actions[] = $this->Html->link(__d('croogo', 'Clear cache: {0}', $cache),
        array_merge($clearUrl, ['config' => $cache]),
        ['class' => 'btn btn-danger btn-xs', 'confirm' => __d('croogo', 'Are you sure?')]
    );
    $actions = $this->Html->div('item-actions', implode(' ', $actions));

    $rows[] = [
        $cache,
        App::shortName(get_class($engine), 'Cache/Engine', 'Engine'),
        $engine->config('duration'),
        $actions,
    ];
endforeach;

$this->append('table-body', $this->Html->tableCells($rows));
