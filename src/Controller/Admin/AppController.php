<?php

namespace Settings\Controller\Admin;

use App\Controller\Admin\AppController as BaseController;
use Cake\Event\Event;
use Crud\Controller\ControllerTrait;

/**
 * Settings Admin controller
 *
 * @category Controllers
 * @package  Croogo.Menus.Controller
 * @since    1.5
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class AppController extends BaseController
{
    use ControllerTrait;

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'index' => [
                    'className' => 'Crud.Index',
                ],
                'add' => [
                    'className' => 'Crud.Add',
                    'view' => 'form',
                    'messages' => [
                        'success' => [
                            'text' => __d('croogo', 'The {name} has been saved.'),
                        ],
                        'error' => [
                            'text' => __d('croogo', 'The {name} could not be saved. Please, try again.'),
                        ]
                    ],
                ],
                'edit' => [
                    'className' => 'Crud.Edit',
                    'view' => 'form',
                    'messages' => [
                        'success' => [
                            'text' => __d('croogo', 'The {name} has been saved.'),
                        ],
                        'error' => [
                            'text' => __d('croogo', 'The {name} could not be saved. Please, try again.'),
                        ]
                    ],
                ],
                'delete' => [
                    'className' => 'Crud.Delete',
                    'messages' => [
                        'success' => [
                            'text' => __d('croogo', 'The {name} has been deleted.'),
                        ],
                        'error' => [
                            'text' => __d('croogo', 'The {name} could not be deleted. Please, try again.'),
                        ]
                    ],
                ],
            ]
        ]);
    }

    /**
     * https://github.com/croogo/core/blob/52f4883491bc08c4402982349cd1579a5c7329f5/src/Controller/AppController.php#L246-L251
     */
    protected function _setupPrg()
    {
        $this->loadComponent('Search.Prg', [
            'actions' => ['index']
        ]);
    }

    /**
     * https://github.com/croogo/core/blob/52f4883491bc08c4402982349cd1579a5c7329f5/src/Controller/Admin/AppController.php#L139-L148
     *
     * @param Event $event
     * @return \Cake\Http\Response|null
     */
    protected function redirectToSelf(Event $event)
    {
        $subject = $event->subject();
        if ($subject->success) {
            if (isset($this->request->data['_apply'])) {
                $entity = $subject->entity;
                return $this->redirect(['action' => 'edit', $entity->id]);
            }
        }
    }

    public function add()
    {
        $this->Crud->execute();
    }

    public function edit()
    {
        $this->Crud->execute();
    }

    public function delete()
    {
        $this->Crud->execute();
    }
}
