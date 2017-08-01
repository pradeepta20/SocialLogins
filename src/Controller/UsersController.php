<?php

namespace App\Controller;

//ob_start();


use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Network\Request;
use Cake\ORM\TableRegistry;
use Cake\Core\App;
use Cake\I18n\Time;

/////////////////////////FOR FACEBOOK LOGIN/////////////////////
define('FACEBOOK_SDK_V4_SRC_DIR', ROOT . '/vendor/' . DS . '/fb/src/Facebook/');
require_once(ROOT . '/vendor/' . DS . '/fb/' . 'autoload.php');

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphUser;
use Facebook\GraphSessionInfo;
//////////////////FOR GOOGLE PLUS LOGIN////////////////////////////
use Google_Client;
use Google_PlusService;
use Google_Oauth2Service;
use oauth_client_class;

class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Auth');
        $this->loadComponent('Custom');
        $this->loadComponent('RequestHandler');
        $this->loadModel('Settings');
        $this->loadModel('Users');
        $this->loadModel('UserFacebooks');
        $this->loadModel('UserGoogles');
    }

    public function beforeFilter(Event $event) {
//        $this->Auth->allow(['login']);
        $this->Auth->allow(['linkdinlogin', 'login', 'ajaxforgotPassword', 'googleLoginReturn', 'fbreturn', 'googlelogin', 'fb_login', 'fblogin', 'ajaxCheckEmailAvail', 'ajaxRegister', 'success', 'confirm', 'changePassword']);
    }

    public function ajaxCheckEmailAvail() {
        $data = $this->request->input('json_decode', TRUE);
        $email = $data['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(array('status' => 'error', 'msg' => ''));
        } else {
            $query = $this->Users->find('all')
                    ->select(['Users.id', 'Users.email'])
                    ->where(['Users.email' => $email]);
            $count = $query->count();
            if ($count) {
                echo json_encode(array('status' => 'error', 'msg' => 'Email id already exists!'));
            } else {
                echo json_encode(array('status' => 'success', 'msg' => 'Email id is available.'));
            }
        }
        exit;
    }

    public function login() {
        $this->viewBuilder()->layout('login');

        if ($this->request->is('post')) {
            $data = $this->request->data;
            $user = $this->Auth->identify();

            if ($data['email'] == "") {
                $this->Flash->error(__('Please enter email'));
            } else if ($data['password'] == "") {
                $this->Flash->error(__('Please enter password'));
            } else if ($data['email'] == "" && $data['password'] == "") {
                $this->Flash->error(__('Please enter email and password'));
            } else {
                if ($user) {
                    if ($data['email']) {
                        $isactive_check = $this->Users->find('all')->where(['Users.email' => $data['email'], 'Users.is_active' => true]);
                        $isactive_counter = $isactive_check->count();
                        if ($isactive_counter > 0) {
                            $this->Auth->setUser($user);
                            if (!empty($data['remberme']) == "rember") {
                                setcookie('rememberMyLogin', $user['id'] . '-' . $user['unique_id'], time() + (86400 * 30), "/"); //For 30 day setting cookie
                            }
                            $this->Users->query()->update()->set(['last_login_ip' => $this->Custom->get_ip_address(), 'last_login_date' => date("Y-m-d H:i:s")])->where(['id' => $this->Auth->user('id')])->execute();
                            //$this->Flash->success(__('Login successful'));
                            return $this->redirect(['controller' => 'appadmins', 'action' => 'index']);
                        } else {
                            $this->Flash->error(__('Your account not activated'));
                        }
                    }
                } else {
                    $this->Flash->error(__('Invalid username or password, try again'));
                }
            }
        }
    }

    //////Ajax part \\\\\\\\\\\\\\\


    public function ajaxRegister() {
        $this->viewBuilder()->layout('ajax');
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->data;
            if ($data['name'] == "") {
                $this->Flash->error(__('Please enter name'), 'error_message');
            } else if ($data['email'] == "") {
                $this->Flash->error(__('Please enter email'), 'error_message');
            } else if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $data['email'])) {
                $this->Flash->error(__('Please enter a valid email id'));
            } else if ($data['password'] == "") {
                $this->Flash->error(__('Please enter password'), 'error_message');
            } else if ($data['confirm_password'] == "") {
                $this->Flash->error(__('Please enter confirm password'), 'error_message');
            } else if ($data['password'] != $data['confirm_password']) {
                $this->Flash->error(__('Please enter confirm password'), 'error_message');
            } else {
                $user = $this->Users->patchEntity($user, $data);
                $user->unique_id = $this->Custom->generateUniqNumber();
                $user->type = 2;
                $user->created = date('Y-m-d H:i:s');
                $user->reg_ip = $this->Custom->get_ip_address();
                if ($this->Users->save($user)) {
                    $this->loadModel('TempUsers');
                    $this->TempUsers->save($this->TempUsers->newEntity(['user_id' => $user->id, 'tmp_password' => $data['password']]));
                    $this->_sendRegistrationEmail($user->id);
                    echo json_encode(['status' => 'success', 'url' => HTTP_ROOT . "users/success/$user->id"]);
                } else {
                    echo json_encode(['status' => 'error', 'msg' => 'Some error occured']);
                }
            }
        }
        exit;
    }

    public function success($id) {
        $this->viewBuilder()->layout('');
        if ($id) {
            $userDetail = $this->Users->find()->where(['Users.id' => $id])->first();
            $adminSetting = $this->Settings->find()->where(['Settings.name' => 'FROM_EMAIL'])->first();
            $this->set(compact('userDetail', 'adminSetting'));
            if (isset($_GET['resend'])) {
                $this->_sendRegistrationEmail($id);
            }
        }
    }

    public function _sendRegistrationEmail($userId) {
        $user = $this->Users->get($userId);
        $emailTemplate = $this->Settings->find()->where(['Settings.name' => 'WELCOME_EMAIL'])->first();
        $adminSetting = $this->Settings->find()->where(['Settings.name' => 'FROM_EMAIL'])->first();
        $to = $user->email;
        $from = $adminSetting->value;
        $subject = $emailTemplate->display;
        $this->loadModel('TempUsers');
        $password = $this->TempUsers->find()->select('tmp_password')->where(['user_id' => $userId])->first()->tmp_password;
        $link = "<a target='_blank' href='" . HTTP_ROOT . "users/confirm/$user->unique_id' style='background:none repeat scroll 0 0 #C20E09;border-radius:4px;color:#ffffff;display:block;font-size:14px;font-weight:bold;margin:15px 1px;padding:5px 10px;text-align:center;width:270px;text-decoration:none'>" . __('Click here to confirm your registration') . "</a>";
        $linkText = "<a target='_blank' href='" . HTTP_ROOT . "users/confirm/$user->unique_id'>" . HTTP_ROOT . "users/confirm/$user->unique_id</a>";
        $message = $this->Custom->formatEmail($emailTemplate->value, ['NAME' => $user->name, 'EMAIL' => $user->email, 'PASSWORD' => $password, 'LINK' => $link, 'LINK_TEXT' => $linkText]);
        $this->Custom->sendEmail($to, $from, $subject, $message);
        return TRUE;
    }

    public function confirm($uniqueId) {
        $query = $this->Users->find('all')->where(['Users.unique_id' => $uniqueId]);
        if ($query->count() > 0) {
            $user = $query->first();

            $this->Users->query()->update()->set(['is_active' => 1])->where(['id' => $user->id])->execute();

            $this->loadModel('TempUsers');
            $this->TempUsers->deleteAll(["TempUsers.user_id" => $user->id]);
            //$this->Auth->setUser($user);
            $this->Flash->success(__('Your account is activated'));
            $this->redirect(HTTP_ROOT);
            ##################Manually Session Create Ends################################
        } else {
            $this->Flash->error(__('Your account already  activated'));

            $this->redirect(HTTP_ROOT);
        }
    }

    /////////////  Ajax Part\\\\\\\\\\



    public function ajaxforgotPassword() {
        //////////////////////////////////////////////SEO//////////////////////////////////////////
        $title_for_layout = "Forgot password";
        $metaKeyword = "Forgot password";
        $metaDescription = "Forgot password";
        $this->set(compact('metaDescription', 'metaKeyword', 'title_for_layout'));
        /////////////////////////////////////////////////////////////////////////////////////////////
        $this->viewBuilder()->layout('login');
        if ($this->request->is(['post'])) {
            $data = $this->request->data;
            if ($data['email'] == "") {
                $this->Flash->error(__('Email field is empty'));
            } else if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $data['email'])) {
                $this->Flash->error(__('Please enter a valid email id'));
            } else {
                $users = $this->Users->find('all')->where(['Users.email' => $data['email']]);
                $user = $users->first();
                if ($users->count() > 0) {
                    $this->Users->query()->update()->set(['qstr' => $this->Custom->generateUniqNumber()])->where(['id' => $user->id])->execute();
                    $this->loadModel('Settings');
                    $emailTemp = $this->Settings->find('all')->where(['Settings.name' => 'FORGOT_PASSWORD']);
                    $emailTemplate = $emailTemp->first();
                    $to = $user->email;
                    $fromvalue = $this->Settings->find('all')->where(['Settings.name' => 'FROM_EMAIL'])->first();
                    $from = $fromvalue->value;
                    $subject = $emailTemplate->display;
                    $link = '<a target="_blank" href=' . HTTP_ROOT . 'change-password/' . $user->unique_id . '>Click on this link to reset password</a>';
                    $message = $this->Custom->formatForgetPassword($emailTemplate->value, $user->name, $user->email, $link, SITE_NAME);
                    //echo $to, $from, $subject, $message;exit;                
                    $this->Custom->sendEmail($to, $from, $subject, $message);
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error']);
                    //return $this->redirect(HTTP_ROOT.'forgetPassword');
                }
            }
            exit;
        }
    }

    public function changePassword($uniq = null) {
        $this->viewBuilder()->layout('login');
        //////////////////////////////////////////////SEO//////////////////////////////////////////
        $title_for_layout = "Change password";
        $metaKeyword = "Change password";
        $metaDescription = "Change password";
        $this->set(compact('metaDescription', 'metaKeyword', 'title_for_layout'));
        /////////////////////////////////////////////////////////////////////////////////////////////

        if ($uniq) {
            $uniq_id = $uniq;
            $this->set('uniq_id', $uniq_id);
            $data = $this->Users->newEntity();
            $this->set(compact('data'));
        }

        if ($this->request->is(['post'])) {
            $d = $this->request->data;
            $data = $this->Users->patchEntity($data, $this->request->data);
            if ($d['password'] == "") {
                $this->Flash->error(__('Please enter password'), 'error_message');
            } else if ($d['confirm_password'] == "") {
                $this->Flash->error(__('Please enter confirm password'), 'error_message');
            } else if ($d['password'] != $d['confirm_password']) {
                $this->Flash->error(__('Please enter confirm password same as password'), 'error_message');
            } else {
                $users = $this->Users->find('all')->where(['Users.unique_id' => $uniq]);
                $user = $users->first();
//                pj($data);
//                pj($user);exit;
                if ($users->count() > 0 && $user->qstr != '') {
                    $this->Users->query()->update()->set(['password' => $data->password, 'qstr' => ''])->where(['id' => $user->id])->execute();
                    // $this->Flash->success(__('Password changed successfully now you can login.'));
                    //  return $this->redirect(['controller' => 'users', 'action' => 'login']);
                    $this->Flash->success(__('Password changed successfully now you can login.'));
                    return $this->redirect(HTTP_ROOT);
                } else {
                    $this->Flash->error(__('You have already used this link.'));
                    //return $this->redirect(HTTP_ROOT.'forgetPassword');
                }
            }
        }
    }

    /**
     * Facebook Login starts here/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     */
    public function fblogin() {
        $this->autoRender = false;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        FacebookSession::setDefaultApplication(FACEBOOK_APP_ID, FACEBOOK_APP_SECRET);
        $helper = new FacebookRedirectLoginHelper(FACEBOOK_REDIRECT_URI);
        $url = $helper->getLoginUrl(array('email'));
        $this->redirect($url);
    }

    public function fbreturn() {
        $this->viewBuilder()->layout('ajax');
        FacebookSession::setDefaultApplication(FACEBOOK_APP_ID, FACEBOOK_APP_SECRET);
        $helper = new FacebookRedirectLoginHelper(FACEBOOK_REDIRECT_URI);
        $session = $helper->getSessionFromRedirect();
        if (isset($_SESSION['token'])) {
            $session = new FacebookSession($_SESSION['token']);
            try {
                $session->validate(FACEBOOK_APP_ID, FACEBOOK_APP_SECRET);
            } catch (FacebookAuthorizationException $e) {
                echo $e->getMessage();
            }
        }

        $data = array();
        $fb_data = array();

        if (isset($session)) {
            $userId = $this->Auth->user('id');
            $_SESSION['token'] = $session->getToken();
            $request = new FacebookRequest($session, 'GET', '/me?locale=en_US&fields=name,email,gender,age_range,first_name,last_name,link,locale,picture,location,likes.summary(true),comments.summary(true)');
            $response = $request->execute();
            $graph = $response->getGraphObject(GraphUser::className());
            $fb_data = $graph->asArray();
//            pj($fb_data);
//            exit;





            $id = $graph->getId();
//            $name = $graph->getName();
//            $email = $graph->getEmail();
//            $gender = $graph->getGender();
//            $firstName = $graph->getFirstName();
//            $lastName = $graph->getLastName();




            $image = "https://graph.facebook.com/" . $id . "/picture?width=100";


            if (!empty($fb_data)) {
                $arrContextOptions = array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                    ),
                );


                $getUserDetails = $this->UserFacebooks->find('all')->where(['user_id' => $userId]);
                $getUserDetail = $this->UserFacebooks->find('all')->where(['user_id' => $userId])->first();

                unlink(WWW_ROOT . DIR_FACEBOOK_IMAGE . $getUserDetail->picture); //For unlinking image

                $dir_to_save = WWW_ROOT . DIR_FACEBOOK_IMAGE;
                $profileImage = "image" . rand() . '.jpg';
                $fileName = $dir_to_save . $profileImage;
                file_put_contents($fileName, file_get_contents($image, false, stream_context_create($arrContextOptions)));


                $user = $this->UserFacebooks->newEntity();
                $user->name = $fb_data['name'];
                $user->email = @$fb_data['email'];
                $user->gender = $fb_data['gender'];
                $user->age_range = str_rot13($fb_data['age_range']->min);
                $user->first_name = $fb_data['first_name'];
                $user->last_name = $fb_data['last_name'];
                $user->picture = $profileImage;
                $user->last_login = date('Y-m-d H:i:s');
                $user->user_id = $userId;
                $user->facebook_id = $fb_data['id'];
                ;

                if ($getUserDetails->count() != 0) {
                    $user->id = $getUserDetail->id;
                    $this->UserFacebooks->save($user);
                    $this->Flash->success(__('You have successfully  updated data from  facebook.'));
                    return $this->redirect(HTTP_ROOT . 'appadmins');
                } else {
                    $this->UserFacebooks->save($user);
                    $this->Flash->success(__('You have successfully  fetch data from  facebook.'));
                    return $this->redirect(HTTP_ROOT . 'appadmins');
                }
            } else {
                $this->Flash->error(__('Error occured'));
                return $this->redirect(HTTP_ROOT . 'appadmins');
            }
        }
    }

    /**
     * This function will makes Oauth Api reqest ////////GOOGLE LOGIN///////////////////
     */
    public function googlelogin() {
        $this->autoRender = false;

        // require_once(ROOT . '/config/google_login.php');
        require_once(ROOT . '/vendor' . DS . 'Google/src/' . 'Google_Client.php');
        $client = new Google_Client();
        $client->setScopes(array('https://www.googleapis.com/auth/plus.login', 'https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/plus.me'));
        $client->setApprovalPrompt('auto');
        $url = $client->createAuthUrl();
        $this->redirect($url);
    }

    /**
     * This function will handle Oauth Api response
     */
    public function googleLoginReturn() {

        $this->autoRender = false;
        require_once(ROOT . '/config/google_login.php');

        $client = new Google_Client();
        $client->setScopes(array('https://www.googleapis.com/auth/plus.login', 'https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/plus.me'));
        $client->setApprovalPrompt('auto');

        $plus = new Google_PlusService($client);
        $oauth2 = new Google_Oauth2Service($client);
        if (isset($_GET['code'])) {
            $client->authenticate(); // Authenticate
            $_SESSION['access_token'] = $client->getAccessToken(); // get the access token here
        }

        if (isset($_SESSION['access_token'])) {
            $client->setAccessToken($_SESSION['access_token']);
        }

        if ($client->getAccessToken()) {
            $_SESSION['access_token'] = $client->getAccessToken();
            $googleData = $oauth2->userinfo->get();

            $link = str_replace('\"', '', $googleData['link']);



            $token = json_decode($client->getAccessToken())->access_token;
            try {
                if (!empty($googleData)) {
                    $userId = $this->Auth->user('id');
                    $results = $this->UserGoogles->find('all')->where(['user_id' => $userId]);
                    $result = $this->UserGoogles->find('all')->where(['user_id' => $userId])->first();

                    unlink(WWW_ROOT . DIR_GOOGLEPLUS_IMAGE . $result->picture); //For unlinking image
                    ///Image Save and move to folder

                    $picUrl = $googleData['picture'];
                    $dir_to_save = WWW_ROOT . DIR_GOOGLEPLUS_IMAGE;
                    $profileImage = "image" . rand() . '.jpg';
                    $fileName = $dir_to_save . $profileImage;
                    file_put_contents($fileName, file_get_contents($picUrl));

                    // Image save

                    $user = $this->UserGoogles->newEntity();
                    $user->name = $googleData['name'];
                    $user->email = $googleData['email'];
                    $user->gender = $googleData['gender'];
                    $user->given_name = $googleData['given_name'];
                    $user->family_name = $googleData['family_name'];
                    $user->picture = $profileImage;
                    $user->link = $link;
                    $user->last_login = date('Y-m-d H:i:s');
                    $user->user_id = $userId;

                    if ($results->count() != 0) {
                        $user->id = $result->id;
                        $this->UserGoogles->save($user);
                        $this->Flash->success(__('You have successfully  updated data from  facebook.'));
                        return $this->redirect(HTTP_ROOT . 'appadmins');
                    } else {
                        $this->UserGoogles->save($user);
                        $this->Flash->success(__('You have successfully  updated data from  facebook.'));
                        return $this->redirect(HTTP_ROOT . 'appadmins');
                    }
                    // }
                } else {
                    $this->Flash->error(__('Error occured'));
                    return $this->redirect(HTTP_ROOT . 'appadmins');
                }
            } catch (Exception $e) {
                $this->Flash->error(__('Login failed'));
                return $this->redirect(HTTP_ROOT . 'appadmins');
            }
        }

        exit;
    }

    public function logout() {

        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach ($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time() - 1000);
                setcookie($name, '', time() - 1000, '/');
            }
        }
        $this->Flash->success(__('See u again'));

        return $this->redirect($this->Auth->logout());
    }

}
