<?php
/**
 * @var \App\View\AppView $this
 * @var \Settings\Model\Entity\Setting $setting
 */
use Cake\Core\Configure;
use Cake\Utility\Inflector;

$action = Inflector::camelize($this->request->param('action'));

$this->assign('subtitle', $action);

$this->Breadcrumbs->add(__('Settings'), ['action' => 'index']);
$this->Breadcrumbs->add(__($action));
?>
<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->
            <?= $this->Form->create($setting, array('role' => 'form')) ?>
            <div class="box-body">
                <?php
                echo $this->Form->control('key', [
                    'rel' => __d('croogo', "e.g., 'Site.title'"),
                    'placeholder' => __d('croogo', 'Key'),
                ]);
                echo $this->Form->control('value', [
                    'placeholder' => __d('croogo', 'Value'),
                ]);
                echo $this->Form->control('title', [
                    'placeholder' => __d('croogo', 'Title'),
                ]);
                echo $this->Form->control('description', [
                    'placeholder' => __d('croogo', 'Description'),
                ]);
                echo $this->Form->control('input_type', [
                    'placeholder' => __d('croogo', 'Input Type'),
                    'rel' => __d('croogo', "e.g., 'text' or 'textarea'"),
                ]);
                echo $this->Form->control('editable', [
                    'label' => __d('croogo', 'Editable'),
                    'class' => false,
                ]);
                echo $this->Form->control('params', [
                    'placeholder' => __d('croogo', 'Params'),
                ]);
                ?>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <?= $this->Form->button(__d('croogo', 'Submit')) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

