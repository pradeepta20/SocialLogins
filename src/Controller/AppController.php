<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;

class AppController extends Controller {

    public function initialize() {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadModel('Users');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email', 'password' => 'password']
                ]
            ]
        ]);
        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
            ]
        ]);

        if (!$this->Auth->user('id') && isset($_COOKIE['rememberMyLogin'])) {
            $explodeCookieValue = explode('-', $_COOKIE['rememberMyLogin']);
            $user = $this->Users->find()->where(['id' => $explodeCookieValue[0], 'unique_id' => $explodeCookieValue[1]])->first()->toArray();
            if (!empty($user)) {
                $this->Auth->setUser($user);
            }
        }
    }

    public function beforeRender(Event $event) {
        
    }

}
