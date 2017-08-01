<?php

########## Google Settings.. Client ID, Client Secret #############
$google_client_id = '107449298193-1jt79jtsiqq8eatql8ovfetqcd2h801u.apps.googleusercontent.com';
$google_client_secret = 'K86Syt8J2XF8PL6ESNOPvXmx';
$google_redirect_url = 'http://localhost/2017/gmail/login.php';
$google_developer_key = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';

###################################################################
//include google api files
require_once 'src/Google_Client.php';
require_once 'src/contrib/Google_Oauth2Service.php';

//start session
session_start();

$gClient = new Google_Client();
$gClient->setApplicationName('Login to saaraan.com');
$gClient->setClientId($google_client_id);
$gClient->setClientSecret($google_client_secret);
$gClient->setRedirectUri($google_redirect_url);
$gClient->setDeveloperKey($google_developer_key);

$google_oauthV2 = new Google_Oauth2Service($gClient);

//If user wish to log out, we just unset Session variable
if (isset($_REQUEST['reset'])) {
    unset($_SESSION['token']);
    $gClient->revokeToken();
    header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
}

//Redirect user to google authentication page for code, if code is empty.
//Code is required to aquire Access Token from google
//Once we have access token, assign token to session variable
//and we can redirect user back to page and login.
if (isset($_GET['code'])) {
    $gClient->authenticate($_GET['code']);
    $_SESSION['token'] = $gClient->getAccessToken();
    header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
    return;
}

if (isset($_SESSION['token'])) {
    $gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
    //Get user details if user is logged in
    $user = $google_oauthV2->userinfo->get();
    $user_id = $user['id'];
    $user_name = filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
    $profile_url = filter_var($user['link'], FILTER_VALIDATE_URL);
    $profile_image_url = filter_var($user['picture'], FILTER_VALIDATE_URL);
    $personMarkup = "$email<div><img src='$profile_image_url?sz=50'></div>";
    $_SESSION['token'] = $gClient->getAccessToken();
} else {
    //get google login url
    $authUrl = $gClient->createAuthUrl();
}

if (isset($authUrl)) { //user is not logged in, show login button
    echo '<a class="login" href="' . $authUrl . '"><img src="images/google-login-button.png" /></a>';
} else {
    //list all user details
    echo '<pre>';
    print_r($user);
    echo '</pre>';
}
?>

