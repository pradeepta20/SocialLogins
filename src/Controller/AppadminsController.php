<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Network\Request;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\ORM\RulesChecker;

class AppadminsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Custom');

        $this->loadComponent('RequestHandler');

        $this->loadComponent('Flash');
        $this->loadComponent('ExportXls');
        $this->loadModel('Users');
        $this->loadModel('Settings');
        $this->loadModel('UserTwitters');
        $this->loadModel('UserInstagrams');
        $this->loadModel('UserFacebooks');
        $this->loadModel('UserGoogles');
        $this->loadModel('Tweets');
        $this->viewBuilder()->layout('admin');
    }

    public function beforeFilter(Event $event) {
        
    }

    public function index() {
        $userId = $this->Auth->user('id');
        $userTwitterInformation = $this->UserTwitters->find('all')->where(['UserTwitters.user_id' => $userId])->contain(['Tweets'])->first();
        $userInstagramInformation = $this->UserInstagrams->find('all')->where(['UserInstagrams.user_id' => $userId])->first();
        $userfacebookInformation = $this->UserFacebooks->find('all')->where(['UserFacebooks.user_id' => $userId])->first();
        $usergoogleInformation = $this->UserGoogles->find('all')->where(['UserGoogles.user_id' => $userId])->first();
        $this->set(compact('userTwitterInformation', 'userInstagramInformation', 'userfacebookInformation', 'usergoogleInformation'));
    }

    public function profileSetup() {

        $userId = $this->request->session()->read('Auth.User.id');
        $userDetail = $this->Users->find('all')->where(['Users.id' => $userId])->first();
        $user = $this->Users->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->data;
            $user = $this->Users->patchEntity($user, $data);
            if ($data['name'] == '') {
                $this->Flash->error(__("Please Enter name"));
            } else if ($data['email'] == '') {
                $this->Flash->error(__("Please Enter email"));
            } else {
                $user->id = $data['id'];
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('The Profile  has been updated.'));
                    return $this->redirect(['action' => 'profileSetup']);
                } else {
                    $this->Flash->error(__('The Profile  could not be update. Please, try again.'));
                }
            }
        }
        $this->set(compact('userDetail'));
    }

    public function changePassword() {

        $userId = $this->request->session()->read('Auth.User.id');
        $getCurPassword = $this->Users->find('all', ['fields' => ['password']])->where(['Users.id' => $userId])->first();

        $user = $this->Users->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->data;
            $user = $this->Users->patchEntity($user, $data);
            $user->id = $this->request->session()->read('Auth.User.id');

            if (!empty($data['changepassword']) == 'Change password') {
                $passCheck = $this->Users->check($data['current_password'], $getCurPassword->password);
                if ($passCheck != 1) {
                    $this->Flash->error(__('Current password is incorrect.'));
                } else if ($data['password'] != $data['retype_password']) {
                    $this->Flash->error(__('Password and confirm password are not same.'));
                } else {
                    if ($this->Users->save($user)) {
                        $this->Flash->success(__('Password change successfully.'));
                        return $this->redirect(['action' => 'changePassword']);
                    } else {
                        $this->Flash->error(__('Password could not be update. Please, try again.'));
                    }
                }
            }
        }
    }

    public function userListing() {

        $condition[] = array();
        if (!empty($this->request->query('from')) && !empty($this->request->query('to') && !empty($this->request->query('name')))) {
            $condition[] = ['Users.created >' => $this->request->query('from')];
            $condition[] = ['Users.created <' => $this->request->query('to')];
            $condition[] = ['Users.name LIKE' => '%' . $this->request->query('name') . '%'];
        } else if (!empty($this->request->query('from')) && !empty($this->request->query('name'))) {
            $condition[] = ['Users.created >' => $this->request->query('from')];
            $condition[] = ['Users.name LIKE' => '%' . $this->request->query('name') . '%'];
        } else if (!empty($this->request->query('to')) && !empty($this->request->query('name'))) {
            $condition[] = ['Users.created <' => $this->request->query('to')];
            $condition[] = ['Users.name LIKE' => '%' . $this->request->query('name') . '%'];
        } else if (!empty($this->request->query('name'))) {
            $condition[] = ['Users.name LIKE' => '%' . $this->request->query('name') . '%'];
        }

        $userListings = $this->Users->find('all')->where(['Users.type' => 2, $condition])->order(['Users.id' => 'DESC']);

        $this->set(compact('userListings', 'searchList'));
    }

    public function deactive($id = null, $table = null) {
        $userName = $this->Users->find('all')->where(['Users.id' => $id])->first();
        if ($this->$table->query()->update()->set(['is_active' => 0])->where(['id' => $id])->execute()) {
            $this->Flash->success(__('' . $userName->name . ' account has been deactivated.'));
            $this->redirect($this->referer());
        }
    }

    public function active($id = null, $table = null) {
        $userName = $this->Users->find('all')->where(['Users.id' => $id])->first();
        if ($this->$table->query()->update()->set(['is_active' => 1])->where(['id' => $id])->execute()) {
            $this->Flash->success(__('' . $userName->name . ' account  has been activated.'));
            $this->redirect($this->referer());
        }
    }

    public function delete($id = null, $table = null) {
        $data = $this->$table->find('all')->where(['id' => $id])->first();
        if ($data) {
            if ($this->$table->delete($data)) {
                $this->Flash->success(__('The data has been deleted.'));
                $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('The Data could not be deleted. Please, try again.'));
                $this->redirect($this->referer());
            }
        }
    }

/////////////  Setting  \\\\\\\\\\\\\\\\\\\\


    public function settinglist() {
        if ($this->request->session()->read('Auth.User.type') == 1) {
            $settings = $this->Settings->find('all', ['order' => 'Settings.id DESC'])
                    ->where(['Settings.type' => 2], ['Settings.is_active' => 1]);
//            pr($settings);exit;
            $this->set(compact('settings'));
        } else {
            return $this->redirect(['controller' => 'users', 'action' => 'notaccess']);
        }
    }

    public function editsetting($id) {
        if ($this->request->session()->read('Auth.User.type') == 1) {
            $settings = $this->Settings->get($id, ['contain' => []]);
// pr($settings);exit;
            if ($this->request->is(['patch', 'post', 'put'])) {
                $set = $this->Settings->patchEntity($settings, $this->request->data);
//pr($set);exit;
                if ($this->Settings->save($set)) {
                    $this->Flash->success(__('Setting updated successfully'));
                    return $this->redirect(['action' => 'settinglist']);
                } else {
                    $this->Flash->error(__('Setting not updated successfully, try again.'));
                }
            }
            $this->set(compact('settings'));
            $this->set('_serialize', ['settings']);
        } else {
            return $this->redirect(['controller' => 'users', 'action' => 'notaccess']);
        }
    }

    public function valuesetting() {

        if (($this->request->session()->read('Auth.User.type') == 1)) {
            $settings = $this->Settings->find('all', ['order' => 'Settings.id DESC'])
                    ->where(['Settings.type' => 1, 'Settings.is_active' => 1]);
//  pr($settings);exit;
            $this->set(compact('settings'));
            if ($this->request->is(['patch', 'post', 'put'])) {
//pr($this->request->data);exit;
                $set = $this->request->data;
                $count = 0;
                foreach ($set as $key => $value) {
                    $condition = array('name' => $key);
                    $this->Settings->updateAll(['value' => $value], ['name' => $key]);
                    $count++;
                }
                $this->Flash->success(__('Value Setting updated successfully.'));
                $this->redirect(HTTP_ROOT . 'appadmins/valuesetting/');
            }
        } else {
            return $this->redirect(['controller' => 'users', 'action' => 'notaccess']);
        }
    }

///////////  Ajax Search User \\\\\\\\\\\\\\\\\

    public function searchUser() {
        $this->viewBuilder()->layout('ajax');
        $query = $_REQUEST['q'];
        $condition[] = ['Users.name LIKE' => $query . "%"];
        $condition[] = ['Users.type' => 2];

        $sqlData = $this->Users->find("all")->where($condition)->toArray();
        $values = '';
        foreach ($sqlData as $getData) {
            $values.=$getData['name'] . " " . "\n";
        }
        if ($values == "") {
            echo $values = "No search found";
        } else {
            echo $values;
        }
        exit;
    }

    public function searchTwitterName() {
        $this->viewBuilder()->layout('ajax');
        $query = $_REQUEST['q'];
        $condition[] = ['UserTwitters.name LIKE' => $query . "%"];
        $sqlData = $this->UserTwitters->find("all")->where($condition)->toArray();
        $values = '';
        foreach ($sqlData as $getData) {
            $values.=$getData['name'] . " " . "\n";
        }
        if ($values == "") {
            echo $values = "No search found";
        } else {
            echo $values;
        }
        exit;
    }

///// Instagram search
    public function searchInstagramName() {
        $this->viewBuilder()->layout('ajax');
        $query = $_REQUEST['q'];
        $condition[] = ['UserInstagrams.username LIKE' => $query . "%"];
        $sqlData = $this->UserInstagrams->find("all")->where($condition)->toArray();
        $values = '';
        foreach ($sqlData as $getData) {
            $values.=$getData['username'] . " " . "\n";
        }
        if ($values == "") {
            echo $values = "No search found";
        } else {
            echo $values;
        }
        exit;
    }

//// Facebook Search

    public function searchFacebookName() {
        $this->viewBuilder()->layout('ajax');
        $query = $_REQUEST['q'];
        $condition[] = ['UserFacebooks.name LIKE' => $query . "%"];
        $sqlData = $this->UserFacebooks->find("all")->where($condition)->toArray();
        $values = '';
        foreach ($sqlData as $getData) {
            $values.=$getData['name'] . " " . "\n";
        }
        if ($values == "") {
            echo $values = "No search found";
        } else {
            echo $values;
        }
        exit;
    }

    //// Googleplus name search

    public function searchGooglePlusName() {
        $this->viewBuilder()->layout('ajax');
        $query = $_REQUEST['q'];
        $condition[] = ['UserGoogles.name LIKE' => $query . "%"];
        $sqlData = $this->UserGoogles->find("all")->where($condition)->toArray();
        $values = '';
        foreach ($sqlData as $getData) {
            $values.=$getData['name'] . " " . "\n";
        }
        if ($values == "") {
            echo $values = "No search found";
        } else {
            echo $values;
        }
        exit;
    }

//////////////////////// Data fetch from twitter table \\\\\\\\\\\\\\\\\\\\\\\\\\\\

    public function twitterListing() {
        $condition[] = array();
        if (!empty($this->request->query('name'))) {
            $condition[] = ['UserTwitters.name LIKE' => '%' . $this->request->query('name') . '%'];
        }
        $twitterListings = $this->UserTwitters->find('all')->where($condition)->order(['UserTwitters.id' => 'DESC']);
        $this->set(compact('twitterListings'));
    }

    //////  For export userdata in excel format \\\\\\\\\\\\\\\\\

    public function reports() {
        $this->viewBuilder()->layout('');

        $fileName = "twitter_report_" . date("d-m-y:h:s") . ".xls";

        $headerRow = array("Name", "Username", "UserID", 'UserHandle', "Location", 'Followers', 'Following', 'Favorites', 'Tweets', 'JoinDate', 'Description');

        $twitterDatas = $this->UserTwitters->find('all')->order(['UserTwitters.id' => 'DESC']);

        $data = [];
        foreach ($twitterDatas as $twitterData) {
            $tempData = [$twitterData->name, $twitterData->screen_name, $twitterData->twitter_id, $twitterData->user_handle, str_replace(' ', '', $twitterData->location), $twitterData->followers, $twitterData->following, $twitterData->favourites_count, $twitterData->tweet_count, str_replace(' ', '', date('F j Y', strtotime($twitterData->created_at))), str_replace(' ', '', $twitterData->description), HTTP_ROOT . DIR_TWITTER_IMAGE . $twitterData->profile_image];
            $data[] = $tempData;
        }
        $data = $this->ExportXls->export($fileName, $headerRow, $data);
    }

    ////////////////////  Data fetch from instagram \\\\\\\\\\\\\\\\\\\\\\\\\\\\

    public function instagramListing() {
        $condition[] = array();
        if (!empty($this->request->query('username'))) {
            $condition[] = ['UserInstagrams.username LIKE' => '%' . $this->request->query('username') . '%'];
        }
        $instagramListings = $this->UserInstagrams->find('all')->where($condition)->order(['UserInstagrams.id' => 'DESC']);
        $this->set(compact('instagramListings'));
    }

    ///////////   Export instagram data  \\\\\\\\\\\\\

    public function instagramReport() {
        $this->viewBuilder()->layout('');
        $fileName = "instagram_report_" . date("d-m-y:h:s") . ".xls";
        $headerRow = array("Userame", "Fullname", "bio", 'website');
        $instagramDatas = $this->UserInstagrams->find('all')->order(['UserInstagrams.id' => 'DESC']);

        $data = [];
        foreach ($instagramDatas as $instagramData) {
            $tempData = [$instagramData->username, str_replace(' ', '', $instagramData->full_name), str_replace(' ', '', $instagramData->bio), $instagramData->website];
            $data[] = $tempData;
        }
        $data = $this->ExportXls->export($fileName, $headerRow, $data);
    }

    ////////////////////  Data fetch from facebook \\\\\\\\\\\\\\\\\\\\\\\\\\\\

    public function facebookListing() {
        $condition[] = array();
        if (!empty($this->request->query('name'))) {
            $condition[] = ['UserFacebooks.name LIKE' => '%' . $this->request->query('name') . '%'];
        }
        $facebookListings = $this->UserFacebooks->find('all')->where($condition)->order(['UserFacebooks.id' => 'DESC']);
        $this->set(compact('facebookListings'));
    }

    ///////////   Export instagram data  \\\\\\\\\\\\\

    public function facebookReport() {
        $this->viewBuilder()->layout('');
        $fileName = "facebook_report_" . date("d-m-y:h:s") . ".xls";
        $headerRow = array("Name", "Email", "Gender", 'AgeRange');
        $facebookDatas = $this->UserFacebooks->find('all')->order(['UserFacebooks.id' => 'DESC']);

        $data = [];
        foreach ($facebookDatas as $facebookData) {
            $tempData = [str_replace(' ', '', $facebookData->name), $facebookData->email, $facebookData->gender, $facebookData->age_range];
            $data[] = $tempData;
        }
        $data = $this->ExportXls->export($fileName, $headerRow, $data);
    }

    /////  Data fetch from googleplus


    public function googleplusListing() {
        $condition[] = array();
        if (!empty($this->request->query('name'))) {
            $condition[] = ['UserGoogles.name LIKE' => '%' . $this->request->query('name') . '%'];
        }
        $googleplusListings = $this->UserGoogles->find('all')->where($condition)->order(['UserGoogles.id' => 'DESC']);
        $this->set(compact('googleplusListings'));
    }

    ///////////   Export instagram data  \\\\\\\\\\\\\

    public function googleplusReport() {
        $this->viewBuilder()->layout('');
        $fileName = "googleplus_report_" . date("d-m-y:h:s") . ".xls";
        $headerRow = array("Name", "Email", "Gender", 'Link');
        $googleplusDatas = $this->UserGoogles->find('all')->order(['UserGoogles.id' => 'DESC']);

        $data = [];
        foreach ($googleplusDatas as $googleplusData) {
            $tempData = [str_replace(' ', '', $googleplusData->name), $googleplusData->email, $googleplusData->gender, $googleplusData->link];
            $data[] = $tempData;
        }
        $data = $this->ExportXls->export($fileName, $headerRow, $data);
    }

}
