<?php
/**
 * @var \App\View\AppView $this
 * @var \Settings\Model\Entity\Setting $setting
 */

$this->extend('Cirici/AdminLTE./Common/form');

$this->Breadcrumbs
    ->add(__d('croogo', 'Settings'), [
        'plugin' => 'Settings',
        'controller' => 'Settings',
        'action' => 'index',
    ]);

if ($this->request->param('action') == 'edit') {
    $this->Breadcrumbs->add($setting->key, $this->request->getRequestTarget());
}

if ($this->request->param('action') == 'add') {
    $this->Breadcrumbs->add(__d('croogo', 'Add'), $this->request->getRequestTarget());
}

$this->append('form-start', $this->Form->create($setting, [
    'novalidate' => true,
]));

//$this->start('table-header');
//echo $this->Croogo->adminTab(__d('croogo', 'Settings'), '#setting-basic');
//echo $this->Croogo->adminTab(__d('croogo', 'Misc'), '#setting-misc');
//$this->end();

$this->start('form-content');
echo $this->Form->control('key', [
        'help' => __d('croogo', "e.g., 'Site.title'"),
        'label' => __d('croogo', 'Key'),
    ]) . $this->Form->control('value', [
        'label' => __d('croogo', 'Value'),
    ]) . $this->Form->control('title', [
        'label' => __d('croogo', 'Title'),
    ]) . $this->Form->control('description', [
        'label' => __d('croogo', 'Description'),
    ]) . $this->Form->control('input_type', [
        'label' => __d('croogo', 'Input Type'),
        'help' => __d('croogo', "e.g., 'text' or 'textarea'"),
    ]) . $this->Form->control('editable', [
        'label' => __d('croogo', 'Editable'),
    ]) . $this->Form->control('params', [
        'label' => __d('croogo', 'Params'),
    ]);

$this->end();

$this->assign('form-button', $this->Form->button(__d('croogo', 'Submit')));

$this->assign('form-end', $this->Form->end());
