<?php
/**
 * @var \App\View\AppView $this
 * @var \Settings\Model\Entity\Setting $setting
 */
use Cake\Core\Configure;

$this->extend('/Common/form');

$this->assign('form-start', $this->Form->create($setting));

$this->assign('title', $title_for_layout);

$this->start('breadcrumb');
$this->Breadcrumbs
    ->add('<i class="fa fa-dashboard"></i> Home', Configure::read('AdminSite.home_url'))
    ->add(__d('croogo', 'Settings'), ['action' => 'index'])
    ->add(__d('croogo', $title_for_layout), null, ['class' => 'active']);

echo $this->Breadcrumbs->render();
$this->end();

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
