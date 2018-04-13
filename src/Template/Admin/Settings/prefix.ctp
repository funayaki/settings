<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Utility\Inflector;

$this->extend('/Common/admin_form');

$this->Breadcrumbs->add(__d('croogo', 'Settings'),
    ['plugin' => 'Settings', 'controller' => 'Settings', 'action' => 'index'])
    ->add($prefix, $this->request->getRequestTarget());

$this->assign('form-start', $this->Form->create(null, [
    'type' => 'file',
]));

$this->start('form-content');
foreach ($settings as $setting) :
    if (!empty($setting->params['tab'])) {
        continue;
    }
    $keyE = explode('.', $setting->key);
    $keyTitle = Inflector::humanize($keyE['1']);

    $label = ($setting->title != null) ? $setting->title : $keyTitle;

    echo $this->SettingsForm->input($setting, $label);
endforeach;
echo $this->Form->button(__d('croogo', 'Submit'));
$this->end();

$this->assign('form-end', $this->Form->end());