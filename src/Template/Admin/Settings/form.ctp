<?php
/**
 * @var \App\View\AppView $this
 */
$this->extend('/Common/admin_form');

$this->assign('form-start', $this->Form->create($setting));

$this->start('form-content');
echo $this->Form->input('key', [
        'rel' => __d('croogo', "e.g., 'Site.title'"),
        'placeholder' => __d('croogo', 'Key'),
    ]) .
    $this->Form->input('value', [
        'placeholder' => __d('croogo', 'Value'),
    ]) .
    $this->Form->input('title', [
        'placeholder' => __d('croogo', 'Title'),
    ]) .
    $this->Form->input('description', [
        'placeholder' => __d('croogo', 'Description'),
    ]) .
    $this->Form->input('input_type', [
        'placeholder' => __d('croogo', 'Input Type'),
        'rel' => __d('croogo', "e.g., 'text' or 'textarea'"),
    ]) .
    $this->Form->input('editable', [
        'label' => __d('croogo', 'Editable'),
        'class' => false,
    ]) .
    $this->Form->input('params', [
        'placeholder' => __d('croogo', 'Params'),
    ]) .
    $this->Form->button(__d('croogo', 'Submit'));
$this->end();

$this->assign('form-end', $this->Form->end());
