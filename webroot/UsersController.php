<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Network\Request;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Validation\Validation;
use Cake\Datasource\ConnectionManager;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
        //Load Components
        $this->loadComponent('Custom');
        //Load Model
        $this->loadModel('Users');
        $this->loadModel('BodyTypes');
        $this->loadModel('Makes');
        $this->loadModel('Models');
        $this->loadModel('MailTemplates');
        $this->loadModel('AdminSettings');
    }

    public function beforeFilter(Event $event) {
        $this->Auth->allow();
    }

    public function gmailLogin() {
        $this->layout = '';
        ########## Google Settings.. Client ID, Client Secret #############
        $google_client_id = '107449298193-1jt79jtsiqq8eatql8ovfetqcd2h801u.apps.googleusercontent.com';
        $google_client_secret = 'K86Syt8J2XF8PL6ESNOPvXmx';
        $google_redirect_url = HTTP_ROOT . 'users/gmailLogin';

        //include google api files
        require_once 'gmail/src/Google_Client.php';
        require_once 'gmail/src/contrib/Google_Oauth2Service.php';

        //Start Session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $gClient = new \Google_Client();
        $gClient->setApplicationName('Login to CarFinder.bcity.me');
        $gClient->setClientId($google_client_id);
        $gClient->setClientSecret($google_client_secret);
        $gClient->setRedirectUri($google_redirect_url);
        $google_oauthV2 = new \Google_Oauth2Service($gClient);
        //If user wish to log out, we just unset Session variable
        if (isset($_REQUEST['reset'])) {
            $this->request->session()->delete('token');
            $gClient->revokeToken();
            header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
        }
        //Redirect user to google authentication page for code, if code is empty.
        //Code is required to aquire Access Token from google
        //Once we have access token, assign token to session variable
        //and we can redirect user back to page and login.
        if (isset($_GET['code'])) {
            $gClient->authenticate($_GET['code']);
            $token = $gClient->getAccessToken();
            $this->request->session()->write('token', $token);
            $this->request->session()->read('token');
            //header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
            return $this->redirect($google_redirect_url);
            return;
        }
        if ($this->request->session()->read('token')) {
            $gClient->setAccessToken($this->request->session()->read('token'));
        }
        if ($gClient->getAccessToken()) {
            //Get user details if user is logged in
            $user = $google_oauthV2->userinfo->get();
            /*
              $user_id = $user['id'];
              $user_name = filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
              $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
              $profile_url = filter_var($user['link'], FILTER_VALIDATE_URL);
              $profile_image_url = filter_var($user['picture'], FILTER_VALIDATE_URL);
              $personMarkup = "$email<div><img src='$profile_image_url?sz=50'></div>";
             */
            $token = $gClient->getAccessToken();
            $this->request->session()->write('token', $token);
            $user['type'] = 4;
            $user['login_type'] = 2;

            $this->loadModel('Visitors');

            $query = $this->Visitors->find()->where(['Visitors.social_id' => $user['id'], 'Visitors.login_type' => 2]);
            if ($query->count()) {
                $user['visitor_id'] = $query->first()->id;
                $this->Visitors->query()->update()->set(["lastlogin" => date('Y-m-d H:i:s')])->where(['social_id' => $user['id']])->execute();
            } else {
                $visitor = $this->Visitors->newEntity();
                $visitor->name = $user['name'];
                $visitor->email = $user['email'];
                $visitor->login_type = 2;
                $visitor->social_id = $user['id'];
                $visitor->created = date('Y-m-d H:i:s');
                $visitor->modified = date('Y-m-d H:i:s');
                $visitor->lastlogin = date('Y-m-d H:i:s');
                $this->Visitors->save($visitor);
                $user['visitor_id'] = $visitor->id;
            }

            $this->request->session()->write('Auth.User', $user);
            return $this->redirect(HTTP_ROOT . 'customer-quote-requests');
        } else {
            //Get google login url
            $authUrl = $gClient->createAuthUrl();
        }
        return $this->redirect(HTTP_ROOT . "login");
        exit;
    }

}
