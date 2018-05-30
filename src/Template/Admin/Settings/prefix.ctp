<?php
/**
 * @var \App\View\AppView $this
 * @var \Settings\Model\Entity\Setting[]|\Cake\Collection\CollectionInterface $settings
 */

use Cake\Utility\Inflector;

$this->extend('Cirici/AdminLTE./Common/form');

$this->Breadcrumbs->add(__d('croogo', 'Settings'),
    ['plugin' => 'Settings', 'controller' => 'Settings', 'action' => 'index'])
    ->add($prefix, $this->request->getRequestTarget());

$this->assign('form-start', $this->Form->create(null, [
    'class' => 'protected-form',
    'type' => 'file',
]));

//$this->append('tab-heading');
//echo $this->Croogo->adminTab($prefix, '#settings-main');
//$this->end();

$this->append('form-content');
//echo $this->Html->tabStart('settings-main');
foreach ($settings as $setting) :
    if (!empty($setting->params['tab'])) {
        continue;
    }
    $keyE = explode('.', $setting->key);
    $keyTitle = Inflector::humanize($keyE['1']);

    $label = ($setting->title != null) ? $setting->title : $keyTitle;

    echo $this->SettingsForm->input($setting, $label);
endforeach;

//echo $this->Html->tabEnd();
$this->end();

//$this->start('buttons');
//    echo $this->Html->beginBox(__d('croogo', 'Publishing'));
//    echo $this->element('Croogo/Core.admin/buttons', ['applyText' => false]);
//    echo $this->Html->endBox();
//$this->end();

$this->assign('form-button', $this->Form->button(__d('croogo', 'Submit')));

$this->assign('form-end', $this->Form->end());
