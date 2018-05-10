<?php
/**
 * @var \App\View\AppView $this
 * @var \Settings\Model\Entity\Setting $setting
 */
use Cake\Core\Configure;
use Cake\Utility\Inflector;

$action = Inflector::camelize($this->request->getParam('action'));

$this->extend('Cirici/AdminLTE./Common/form');

$this->assign('subtitle', $action);

$this->start('breadcrumb');
$this->Breadcrumbs
    ->add(__d('croogo', 'Settings'), ['action' => 'index'])
    ->add(__d('croogo', $action), null, ['class' => 'active']);

echo $this->Breadcrumbs->render();
$this->end();

$this->assign('form-start', $this->Form->create($setting));

$this->start('form-content');
echo $this->Form->control('key', [
        'rel' => __d('croogo', "e.g., 'Site.title'"),
        'placeholder' => __d('croogo', 'Key'),
    ]) .
    $this->Form->control('value', [
        'placeholder' => __d('croogo', 'Value'),
    ]) .
    $this->Form->control('title', [
        'placeholder' => __d('croogo', 'Title'),
    ]) .
    $this->Form->control('description', [
        'placeholder' => __d('croogo', 'Description'),
    ]) .
    $this->Form->control('input_type', [
        'placeholder' => __d('croogo', 'Input Type'),
        'rel' => __d('croogo', "e.g., 'text' or 'textarea'"),
    ]) .
    $this->Form->control('editable', [
        'label' => __d('croogo', 'Editable'),
        'class' => false,
    ]) .
    $this->Form->control('params', [
        'placeholder' => __d('croogo', 'Params'),
    ]);
$this->end();

$this->assign('form-button', $this->Form->button(__d('croogo', 'Submit')));

$this->assign('form-end', $this->Form->end());
