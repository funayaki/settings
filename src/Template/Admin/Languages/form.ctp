<?php
/**
 * @var \App\View\AppView $this
 * @var \Settings\Model\Entity\Language $language
 */

$this->extend('Cirici/AdminLTE./Common/form');

$this->Breadcrumbs->add(__d('croogo', 'Settings'),
    ['plugin' => 'Settings', 'controller' => 'settings', 'action' => 'prefix', 'Site'])
    ->add(__d('croogo', 'Language'),
        ['plugin' => 'Settings', 'controller' => 'languages', 'action' => 'index']);

if ($this->request->params['action'] == 'edit') {
    $this->Breadcrumbs->add($language->title);
}

if ($this->request->params['action'] == 'add') {
    $this->Breadcrumbs->add(__d('croogo', 'Add'), $this->request->getRequestTarget());
}

$this->append('form-start', $this->Form->create($language, [
    'novalidate' => true,
]));

//$this->start('tab-heading');
//echo $this->Croogo->adminTab(__d('croogo', 'Language'), '#language-main');
//$this->end();

$this->start('form-content');
echo $this->Form->control('title', [
    'label' => __d('croogo', 'Title'),
]);
echo $this->Form->control('native', [
    'label' => __d('croogo', 'Native'),
]);
echo $this->Form->control('locale', [
    'label' => __d('croogo', 'Locale'),
]);
echo $this->Form->control('alias', [
    'label' => __d('croogo', 'Alias'),
    'help' => __d('croogo', 'Locale alias, typically a two letter country/locale code'),
]);
echo $this->Form->control('status', [
    'label' => __d('croogo', 'Status'),
]);
$this->end();

$this->assign('form-button', $this->Form->button(__d('croogo', 'Submit')));

$this->assign('form-end', $this->Form->end());
