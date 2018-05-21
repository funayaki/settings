<?php


/**
 * Settings Controller
 *
 * @category Settings.Controller
 * @package  Croogo.Settings
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
namespace Settings\Controller\Admin;

use Cake\Utility\Inflector;
use Settings\Controller\AppController;
use Settings\Model\Table\SettingsTable;

/**
 * @property SettingsTable $Settings
 */
class SettingsController extends AppController
{

    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Settings';

    /**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */
    public $uses = ['Settings.Setting'];

    /**
     * Components used by the Controller
     */
    public $components = array(
        'Search.Prg' => array(
            'presetForm' => array(
                'paramType' => 'querystring',
            ),
            'commonProcess' => array(
                'paramType' => 'querystring',
                'filterEmpty' => true,
            ),
        ),
    );

    /**
     * Helpers used by the Controller
     *
     * @var array
     * @access public
     */
    public $helpers = ['Html', 'Form'];

    /**
     * Preset Variables Search
     */
    public $presetVars = true;

    /**
     * Index
     *
     * @return void
     * @access public
     */
    public function index()
    {
        $this->set('title_for_layout', __d('croogo', 'Settings'));

        $query = $this->Settings
            ->find('search', ['search' => $this->request->getQueryParams()]);

        $settings = $this->paginate($query);

        $this->set('settings', $settings);
    }

    /**
     * Add
     *
     * @return \Cake\Http\Response|null
     * @access public
     */
    public function add()
    {
        $this->viewBuilder()->setTemplate('form');
        $this->set('title_for_layout', __d('croogo', 'Add Setting'));

        $setting = $this->Settings->newEntity();
        if ($this->request->is('post')) {
            $setting = $this->Settings->patchEntity($setting, $this->request->getData());
            if ($this->Settings->save($setting)) {
                $this->Flash->success(__d('croogo', 'The Setting has been saved'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__d('croogo', 'The Setting could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('setting'));
    }

    /**
     * Edit
     *
     * @param integer $id
     * @return \Cake\Http\Response|null
     * @access public
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->setTemplate('form');
        $this->set('title_for_layout', __d('croogo', 'Edit Setting'));

        $setting = $this->Settings->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $setting = $this->Settings->patchEntity($setting, $this->request->getData());
            if ($this->Settings->save($setting)) {
                $this->Flash->success(__d('croogo', 'The Setting has been saved'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__d('croogo', 'The Setting could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('setting'));
    }

    /**
     * Delete
     *
     * @param null $id
     * @return \Cake\Http\Response|null
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $setting = $this->Settings->get($id);
        if ($this->Settings->delete($setting)) {
            $this->Flash->success(__d('croogo', 'The setting has been saved'));
        } else {
            $this->Flash->error(__d('croogo', 'The setting could not be saved. Please, try again.'));
        }

        if (!$redirect = $this->referer()) {
            $redirect = array(
                'admin' => true,
                'plugin' => 'settings',
                'controller' => 'settings',
                'action' => 'index'
            );
        }
        return $this->redirect($redirect);
    }

    /**
     * Prefix
     *
     * @param string $prefix
     * @return \Cake\Http\Response|null
     */
    public function prefix($prefix = null)
    {
        $this->set('title_for_layout', __d('croogo', 'Settings: {0}', $prefix));

        if ($this->request->is('post')) {
            foreach ($this->request->getData() as $inputName => $value) {
                $id = str_replace('setting-', '', $inputName);
                if ($id == '_apply') {
                    continue;
                }
                $setting = $this->Settings->get($id);

                if (is_array($value)) {
                    if (isset($value['tmp_name'])) {
                        $value = $this->_handleUpload($setting, $value);
                    } else {
                        $value = json_encode($value);
                    }
                }

                $setting->value = $value;
                $this->Settings->save($setting);
            }
            $this->Flash->success(__d('croogo', 'Settings updated successfully'));
            return $this->redirect(['action' => 'prefix', $prefix]);
        }

        $settings = $this->Settings->find('all', [
            'order' => 'Settings.weight ASC',
            'conditions' => [
                'Settings.key LIKE' => $prefix . '.%',
                'Settings.editable' => 1,
            ],
        ]);

        if ($settings->count() == 0) {
            $this->Flash->error(__d('croogo', 'Invalid Setting key'));
        }

        $this->set(compact('prefix', 'settings'));
    }

    protected function _handleUpload($setting, $value)
    {
        $name = $value['name'];

        $currentBg = WWW_ROOT . $setting->value;
        if (file_exists($currentBg) && is_file($currentBg)) {
            unlink($currentBg);
        }

        $dotPosition = strripos($name, '.');
        $filename = strtolower(substr($name, 0, $dotPosition));
        $ext = strtolower(substr($name, $dotPosition + 1));

        $relativePath = DS . 'uploads' . DS .
            Inflector::slug($filename, '-') . '.' .
            $ext;
        $targetDir = WWW_ROOT . 'uploads';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777);
        }
        $targetFile = WWW_ROOT . $relativePath;
        move_uploaded_file($value['tmp_name'], $targetFile);
        $value = str_replace('\\', '/', $relativePath);
        return $value;
    }

    /**
     * Move Up
     *
     * @param null $id
     * @return \Cake\Http\Response|null
     */
    public function moveUp($id = null)
    {
        $setting = $this->Settings->get($id);
        if ($this->Settings->moveUp($setting)) {
            $this->Flash->success(__d('croogo', 'Moved up successfully'));
        } else {
            $this->Flash->error(__d('croogo', 'Could not move up'));
        }

        if (!$redirect = $this->referer()) {
            $redirect = array(
                'admin' => true,
                'plugin' => 'settings',
                'controller' => 'settings',
                'action' => 'index'
            );
        }
        return $this->redirect($redirect);
    }

    /**
     * Move Down
     *
     * @param null $id
     * @return \Cake\Http\Response|null
     */
    public function moveDown($id = null)
    {
        $setting = $this->Settings->get($id);
        if ($this->Settings->moveDown($setting)) {
            $this->Flash->success(__d('croogo', 'Moved down successfully'));
        } else {
            $this->Flash->error(__d('croogo', 'Could not move down'));
        }

        if (!$redirect = $this->referer()) {
            $redirect = array(
                'admin' => true,
                'plugin' => 'settings',
                'controller' => 'settings',
                'action' => 'index'
            );
        }
        return $this->redirect($redirect);
    }
}
