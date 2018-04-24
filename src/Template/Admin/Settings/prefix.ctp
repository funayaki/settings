<?php
/**
 * @var \App\View\AppView $this
 * @var \Settings\Model\Entity\Setting[]|\Cake\Collection\CollectionInterface $settings
 */

use Cake\Core\Configure;
use Cake\Utility\Inflector;

$this->extend('/Common/form');

$this->assign('title', $title_for_layout);

$this->start('breadcrumb');
$this->Breadcrumbs
    ->add('<i class="fa fa-dashboard"></i> Home', Configure::read('AdminSite.home_url'))
    ->add(__d('croogo', 'Settings'), ['action' => 'index'])
    ->add($title_for_layout, null, ['class' => 'active']);

echo $this->Breadcrumbs->render();
$this->end();

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
$this->end();

$this->assign('form-button', $this->Form->button(__d('croogo', 'Submit')));

$this->assign('form-end', $this->Form->end());