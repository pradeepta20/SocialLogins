<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Network\Request;
use Cake\ORM\TableRegistry;
use TwitterOAuth;
use OAuthConsumer;

class TwittersController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Custom');
        $this->loadModel('Users');
        $this->loadModel('UserTwitters');
        $this->loadModel('Tweets');
    }

    public function beforeFilter(Event $event) {
        require_once(ROOT . DS . 'vendor' . DS . 'oauth' . DS . 'twitteroauth.php');
        
    }

  

    public function index() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $session = $this->request->session();

        /* If the oauth_token is old redirect to the connect page. */
        if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
            return $this->redirect(['controller' => 'twitters', 'action' => 'clearsessions']);
        }


        /* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

        /* Request access tokens from twitter */
        $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

        /* Save the access tokens. Normally these would be saved in a database for future use. */
        $_SESSION['access_token'] = $access_token;

        /* Remove no longer needed request tokens */
        unset($_SESSION['oauth_token']);
        unset($_SESSION['oauth_token_secret']);


        /* If HTTP response is 200 continue otherwise send to connect page to retry */
        if (200 == $connection->http_code) {
            /* The user has been verified and the access tokens can be saved for future use */
            $_SESSION['status'] = 'verified';
            //$userInfo = $connection->get('account/verify_credentials');
            //$twitterUser = $field_twitter_url;
            //$userInfo = $connection->get('statuses/home_timeline', array('screen_name' => $twitterUser));
            $content = $connection->get('account/verify_credentials', ['include_email' => 'true']);
            $this->request->session()->write('twitter_data', $content);
//            echo "<pre>";
//            print_r($content);
//            pj($content);
//            exit;
            $notweets = 50;
            $tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $content->screen_name . "&count=" . $notweets);
            //pj($tweets);exit;
//            echo "<pre>";
//            print_r($tweets);
//            exit;

            if (!empty($content)) {
                $userId = $this->Auth->user('id');
                $getUserDetails = $this->UserTwitters->find('all')->where(['user_id' => $userId]);
                $getUserDetail = $this->UserTwitters->find('all')->where(['screen_name' => $content->screen_name])->first();

                unlink(WWW_ROOT . DIR_TWITTER_IMAGE . @$getUserDetail->profile_image); //For unlinking image

                $picUrl = $content->profile_image_url;
                $dir_to_save = WWW_ROOT . DIR_TWITTER_IMAGE;
                $profileImage = "image" . rand() . '.jpg';
                $fileName = $dir_to_save . $profileImage;
                file_put_contents($fileName, file_get_contents($picUrl));

                $userLoginId = $this->Auth->user('id');
                $user = $this->UserTwitters->newEntity();
                $id = $getUserDetail->id;
                $date = strtotime($content->created_at);
                $joinDate = date("Y-m-d", $date);

                $user->name = $content->name;
                $user->screen_name = $content->screen_name;
                $user->email = $content->email;
                $user->location = $content->location;
                $user->description = $content->description;
                $user->last_update = date('Y-m-d H:i:s');
                $user->followers = $content->followers_count;
                $user->following = $content->friends_count;
                $user->profile_image = $profileImage;
                $user->user_id = $userId;
                $user->twitter_id = $content->id_str;
                $user->favourites_count = $content->favourites_count;
                $user->tweet_count = $content->statuses_count;
                $user->created_at = $joinDate;
                $user->user_handle = '@' . $content->screen_name;
                $user->retweet_count = $content->status->retweet_count;

                if ($getUserDetails->count() != 0) { ////if usertname already exist or second time login through twitter////
                    //session_destroy();
                    $user->id = $id;
                    $saveTwitter = $this->UserTwitters->save($user);
                    $twitterUserId = $saveTwitter->id;
                    $this->Tweets->deleteAll(['Tweets.user_twitter_id' => $twitterUserId]);

                    foreach ($tweets as $tweet) {
//                        echo "<pre>";
//                        print_r($tweet);
                        //pj($tweet);

                        $twitter = $this->Tweets->newEntity();
                        $tdate = strtotime($tweet->created_at);
                        $tweetDate = date("Y-m-d H:i:s", $tdate);
                        $twitter->user_twitter_id = $twitterUserId;
                        $twitter->tweet_id = $tweet->id_str;
                        $twitter->tweet_content = $tweet->text;
                        $twitter->date_of_tweet = $tweetDate;

                        if (@$tweet->retweeted_status) {
                            $twitter->retweet_count = @$tweet->retweeted_status->retweet_count;
                            $twitter->favorite_count = @$tweet->retweeted_status->favorite_count;
                        } else {
                            $twitter->retweet_count = $tweet->retweet_count;
                            $twitter->favorite_count = $tweet->favorite_count;
                        }

                        $twitterhash = array();
                        foreach ($tweet->entities->hashtags as $hashTag) {
                            if (!empty($hashTag)) {
                                $twitterhash[] = $hashTag->text;
                            }
                        }
                        $twitter->hashtags = implode(",", $twitterhash);
                        $this->Tweets->save($twitter);
                    }

                    $this->Flash->success(__('You have successfully  updated data from  twitter.'));
                    return $this->redirect(HTTP_ROOT . 'appadmins');
                } else {////**Important Section***if username doesnot exist and first time login through twitter***Important Section***///////  
                    $saveTwitter = $this->UserTwitters->save($user);
                    $twitterUserId = $saveTwitter->id;
                    foreach ($tweets as $tweet) {
                        $twitter = $this->Tweets->newEntity();
                        $tdate = strtotime($tweet->created_at);
                        $tweetDate = date("Y-m-d H:i:s", $tdate);
                        $twitter->user_twitter_id = $twitterUserId;
                        $twitter->tweet_id = $tweet->id_str;
                        $twitter->tweet_content = $tweet->text;
                        $twitter->date_of_tweet = $tweetDate;
                        $twitter->retweet_count = $tweet->retweet_count;
                        $twitter->favorite_count = $tweet->favorite_count;
                        $twitterhash = array();
                        foreach ($tweet->entities->hashtags as $hashTag) {
                            if (!empty($hashTag)) {
                                $twitterhash[] = $hashTag->text;
                            }
                        }
                        $twitter->hashtags = implode(",", $twitterhash);
                        $this->Tweets->save($twitter);
                    }

                    $this->Flash->success(__('You have successfully  fetch data from  twitter.'));
                    return $this->redirect(HTTP_ROOT . 'appadmins');
                }
            }
        }
    }

    public function tweetcall() {
        $this->layout = 'innerdefault';
        /* If the oauth_token is old redirect to the connect page. */
        if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
            $_SESSION['oauth_status'] = 'oldtoken';
            $this->redirect("twitters/clearsessions");
        }

        /* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

        /* Request access tokens from twitter */
        $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

        /* Save the access tokens. Normally these would be saved in a database for future use. */
        $_SESSION['access_token'] = $access_token;

        /* Remove no longer needed request tokens */
        unset($_SESSION['oauth_token']);
        unset($_SESSION['oauth_token_secret']);

        /* If HTTP response is 200 continue otherwise send to connect page to retry */
        if (200 == $connection->http_code) {
            /* The user has been verified and the access tokens can be saved for future use */
            $_SESSION['status'] = 'verified';
            $this->redirect("/twitters");
        } else {
            /* Save HTTP status for error dialog on connnect page. */
            $this->redirect("/twitters/clearsessions");
        }
    }

    public function clearsessions() {
        session_start();
        session_destroy();
        $this->redirect("/twitters/connect");
    }

    public function connect() {
        //echo 'Jai Jagannath Swami';exit;
        $this->layout = 'innerdefault';
        App::import('Vendor', 'twitter/twitteroauth-master/config');
        if (CONSUMER_KEY === '' || CONSUMER_SECRET === '' || CONSUMER_KEY === 'CONSUMER_KEY_HERE' || CONSUMER_SECRET === 'CONSUMER_SECRET_HERE') {
            echo 'You need a consumer key and secret to test the sample code. Get one from <a href="http://192.168.1.120/sma/apps">http://192.168.1.120/sma/apps</a>';
            exit;
        }

        /* Build an image link to start the redirect process. */
        echo '<a href="' . HTTP_ROOT . '/twitters/redirect11"><img src="' . HTTP_ROOT . 'img/darker.png" alt="Sign in with Twitter"/></a>';
        exit;
        /* Include HTML to display on the page. */
//        include('html.inc');
    }

    public function twitterlogin() {

        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

        $request_token = $connection->getRequestToken(OAUTH_CALLBACK);
        // pj($connection);
        // pj($request_token); 
        // $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
        // echo "</br>";
        //   $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
        //   exit;
        $token = $request_token['oauth_token'];
        $session = $this->request->session();
        $session->write('oauth_token', $request_token['oauth_token']); //Write
        $session->write('oauth_token_secret', $request_token['oauth_token_secret']); //Write
        // echo $session->read('oauth_token');
        // echo $session->read('oauth_token_secret');
        // exit; //To read the session value   o/p:$100,00,00
        //  $this->Session->write('oauth_token', $request_token['oauth_token']);
        //$this->Session->write('oauth_token_secret', $request_token['oauth_token_secret']);
        //   echo $green = $this->Session->read('oauth_token');
        // exit;
        switch ($connection->http_code) {
            case 200:
                $url = $connection->getAuthorizeURL($token);
                //echo $url;exit;
                $this->redirect($url);

                break;
            default:
                echo 'Could not connect to Twitter. Refresh the page or try again later.';
        }
    }

}

?>