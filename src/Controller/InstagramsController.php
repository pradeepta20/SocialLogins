<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Instagram\Instagram;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class InstagramsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Custom');
        $this->loadModel('Users');
        $this->loadModel('UserInstagrams');
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['add', 'logout', 'success', 'instgramlogin']);
    }

    public function instgramlogin() {

        require_once(ROOT . DS . "vendor" . DS . "instagram" . DS . "instagram.class.php");
        $instagram = new Instagram(array(
            'apiKey' => INSTAGRAM_CLIENT_ID,
            'apiSecret' => INSTAGRAM_SECREAT,
            'apiCallback' => INSTAGRAM_REDIRECT_URL // must point to success.php
        ));
        $loginUrl = $instagram->getLoginUrl();
        $this->set(compact('loginUrl'));

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
        $this->redirect($loginUrl);
    }

    public function success() {
        require_once(ROOT . DS . "vendor" . DS . "instagram" . DS . "instagram.class.php");
        $instagram = new Instagram(array(
            'apiKey' => INSTAGRAM_CLIENT_ID,
            'apiSecret' => INSTAGRAM_SECREAT,
            'apiCallback' => INSTAGRAM_REDIRECT_URL // must point to success.php
        ));

        // Receive OAuth code parameter
        $code = $_GET['code'];
//        pj($code);exit;
// Check whether the user has granted access
        if (true === isset($code)) { 

            // Receive OAuth token object   
            $data = $instagram->getOAuthToken($code);
            // Take a look at the API response
            pj($data);exit;
            $userId = $this->Auth->user('id');

            $picUrl = $data->user->profile_picture;
            $dir_to_save = WWW_ROOT . DIR_INSTAGRAM_IMAGE;
            $profileImage = "image" . rand() . '.jpg';
            $fileName = $dir_to_save . $profileImage;
            file_put_contents($fileName, file_get_contents($picUrl));

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $getUserDetails = $this->UserInstagrams->find('all')->where(['user_id' => $userId]);
            $getUserDetail = $this->UserInstagrams->find('all')->where(['user_id' => $userId])->first();
            $user = $this->UserInstagrams->newEntity();
            $user->username = $data->user->username;
            $user->full_name = $data->user->full_name;
            $user->bio = $data->user->bio;
            $user->website = $data->user->website;
            $user->user_id = $userId;
            $user->profile_image = $profileImage;
            $user->last_login = date('Y-m-d H:i:s');
            if ($getUserDetails->count() != 0) {
                $user->id = $getUserDetail->id;
                $this->UserInstagrams->save($user);
                $this->Flash->success(__('You have successfully  updated data from  instagrams.'));
                return $this->redirect(HTTP_ROOT . 'appadmins');
            } else {
                $this->UserInstagrams->save($user);
                $this->Flash->success(__('You have successfully  fetch data from  instagrams.'));
                return $this->redirect(HTTP_ROOT . 'appadmins');
            }
        } else {
            if (true === isset($_GET['error'])) {
                echo 'An error occurred: ' . $_GET['error_description'];
            }
        }
        exit;
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {

        if (($this->request->is('post') || $this->request->is('put')) && isset($this->data['Filter'])) {
            $filter_url['page'] = 1;
            foreach ($this->data['Filter'] as $name => $value) {
                if ($value) {
                    $filter_url[$name] = urlencode($value);
                }
            }
            return $this->redirect($filter_url);
        }

        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('Unable to add the user.'));
        }
        $this->set('user', $user);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
