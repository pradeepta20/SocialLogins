<?php

namespace App\Controller;

ob_start();

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Network\Request;
use Cake\ORM\TableRegistry;
use Cake\Core\App;

///////////////LINKEDIN//////////////////////////////


class LinksController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Custom');
        $this->loadModel('Users');
    }

    public function beforeFilter(Event $event) {
        $this->Auth->allow();
    }

    public function linkedinLogin() {

        $config['callback_url'] = CALLBACK_URL; //Your callback URL
        $config['Client_ID'] = CLIENT_ID; // Your LinkedIn Application Client ID
        $config['Client_Secret'] = CLIENT_SECRET; // Your LinkedIn Application Client Secret
        if ($config['Client_ID'] === '' || $config['Client_Secret'] === '') {
            echo 'You need a API Key and Secret Key to test the sample code. Get one from <a href="https://www.linkedin.com/secure/developer">https://www.linkedin.com/secure/developer</a>';
            exit;
        }
    }

    public function linkreturn() {
        $config['callback_url'] = CALLBACK_URL; //Your callback URL
        $config['Client_ID'] = CLIENT_ID; // Your LinkedIn Application Client ID
        $config['Client_Secret'] = CLIENT_SECRET; // Your LinkedIn Application Client Secret

        if (isset($_GET['code'])) {
            //echo "hii, i am in linkedin.";

            $url = 'https://www.linkedin.com/uas/oauth2/accessToken';
            $param = 'grant_type=authorization_code&code=' . $_GET['code'] . '&redirect_uri=' . $config['callback_url'] . '&client_id=' . $config['Client_ID'] . '&client_secret=' . $config['Client_Secret'];
            $return = (json_decode($this->Custom->post_curl($url, $param), true));
            $token = $return['access_token'];
            //exit;

            if (!empty($return['error']) && $return['error']) {
                echo 'Some error occured<br><br>' . $return['error_description'] . '<br><br>Please Try again.';
            } else {
                //  echo "success";
                $url = 'https://api.linkedin.com/v1/people/~:(id,firstName,lastName,pictureUrls::(original),headline,publicProfileUrl,location,industry,positions,email-address)?format=json&oauth2_access_token=' . $return['access_token'];
                //pj($url);exit;
                $User = json_decode($this->Custom->post_curl($url));
                //pj($User);
                //exit;

                $id = isset($User->id) ? $User->id : '';
                $firstName = isset($User->firstName) ? $User->firstName : '';
                $lastName = isset($User->lastName) ? $User->lastName : '';
                $emailAddress = isset($User->emailAddress) ? $User->emailAddress : '';
                $headline = isset($User->headline) ? $User->headline : '';
                $pictureUrls = isset($User->pictureUrls->values[0]) ? $User->pictureUrls->values[0] : '';
                $location = isset($User->location->name) ? $User->location->name : '';
                $positions = isset($User->positions->values[0]->company->name) ? $User->positions->values[0]->company->name : '';
                $positionstitle = isset($User->positions->values[0]->title) ? $User->positions->values[0]->title : '';
                $publicProfileUrl = isset($User->publicProfileUrl) ? $User->publicProfileUrl : '';
                //  exit;
                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                if (!empty($User)) {
                    // echo $emailAddress;
                    // echo "hii";
                    $result = $this->Users->find('all')->where(['email' => $emailAddress]);
                    $result_email = $this->Users->find('all')->where(['email' => $emailAddress])->first();
                    // pj($result);
                    //  pj($result_email);
                    // exit;
                    if ($result->count() != 0) {////if email id already exist or second time login through linkedin////
                        //if ($result_email['email'] == $fb_data['email'] && $result_email['facebook_id'] == $fb_data['id']) {
                        session_destroy();
                        $getLoginConfirmation = $this->Users->find('all')->where(['Users.id' => $result_email['id']])->first()->toArray();
                        $get_login = $this->Auth->setUser($getLoginConfirmation);
                        $user_login_id = $this->Auth->user('id');
                        if ($user_login_id) {
                            $user = $this->Users->newEntity();
                            $user->last_login_ip = $this->Custom->get_ip_address();
                            $user->last_login_date = date('Y-m-d H:i:s');
                            $user->id = $user_login_id;
                            $user->linkedin_id = $id;
                            $this->Users->save($user);
                            if ($result_email['type'] == 0) {
                                $genderOfUser = str_rot13('nogender');
                                $ageOfUser = str_rot13('noage');
                                $this->Flash->success(__('Login successfull and please edit your profile'));
                                return $this->redirect(['controller' => 'Users', 'action' => 'editprofileSocialmedia/' . $genderOfUser . '/' . $ageOfUser . '/' . str_rot13($this->Auth->user('unique_id'))]);
                            }
                            $this->Flash->success(__('Login successfull'));
                            if ($result_email['type'] == 3) {
                                return $this->redirect(['controller' => 'Publishers', 'action' => 'publisherDashboard']);
                            } else {
                                return $this->redirect(['controller' => 'Users', 'action' => 'home']);
                            }
                        } else {
                            $this->Flash->error(__('Login failed and you can register here also'));
                            return $this->redirect(['controller' => 'Users', 'action' => 'registration']);
                        }
                        // }
                    } else {
                        $user = $this->Users->newEntity();
                        $user->email = $emailAddress;
                        $user->first_name = $firstName;
                        $user->last_name = $lastName;
                        $user->linkedin_id = $id;
                        $user->token = $token;
                        $user->unique_id = $this->Custom->generateUniqNumber();
                        $user->name = $user->first_name . " " . $user->last_name;
                        $user->created = date('Y-m-d H:i:s');
                        $user->last_login_date = date('Y-m-d H:i:s');
                        $user->is_active = 1;
                        $user->reg_ip = $this->Custom->get_ip_address();
                        $user->last_login_ip = $this->Custom->get_ip_address();

                        if ($this->Users->save($user)) {
                            $data['id'] = $user->id;
                            session_destroy();
                            $getLoginConfirmation = $this->Users->find('all')->where(['Users.id' => $user->id])->first()->toArray();
                            $get_login = $this->Auth->setUser($getLoginConfirmation);
                            $user_login_id = $this->Auth->user('id');
                            if ($user_login_id) { /////if successful login goes to edit social media profile page
                                $genderOfUser = str_rot13('nogender');
                                $ageOfUser = str_rot13('noage');
                                $this->Flash->success(__('Login successfull and please edit your profile'));
                                return $this->redirect(['controller' => 'Users', 'action' => 'editprofileSocialmedia/' . $genderOfUser . '/' . $ageOfUser . '/' . str_rot13($this->Auth->user('unique_id'))]);
                            } else {
                                $this->Flash->error(__('Login failed and you can register here also'));
                                return $this->redirect(['controller' => 'Users', 'action' => 'registration']);
                            }
                        } else {
                            $this->Flash->error(__('Login failed and you can register here also'));
                            return $this->redirect(['controller' => 'Users', 'action' => 'registration']);
                        }
                    }
                } else {
                    $this->Flash->error(__('Login failed and you can register here also'));
                    return $this->redirect(['controller' => 'Users', 'action' => 'registration']);
                }
                /////////////////////////////////////////////////INSERT DATA BASE FIELD///////////////////////////////////////////////////////////////////////////////////////
            }
        } elseif (isset($_GET['error'])) {
            echo 'Some error occured<br><br>' . $_GET['error_description'] . '<br><br>Please Try again.';
        } else {
            //  echo '<a href="https://www.linkedin.com/uas/oauth2/authorization?response_type=code&client_id=' . $config['Client_ID'] . '&redirect_uri=' . $config['callback_url'] . '&state=98765EeFWf45A53sdfKef4233&scope=r_basicprofile r_emailaddress"><img src="./images/linkedin_connect_button.png" alt="Sign in with LinkedIn"/></a>';
        }
        return $this->redirect(HTTP_ROOT);
        exit;
    }

}
