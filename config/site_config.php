<?php

require_once 'messages.php';
//site specific
$domain = $_SERVER['HTTP_HOST'];
$siteName = 'http://' . $domain . '/videoportal/';
define('BASE_PATH', $siteName);
//Face book Social Logins 
define('FACEBOOK_APP_ID', '1028203903927010');
define('FACEBOOK_APP_SECRET', 'ed716c05d08c78050e2b58b916c2fb7f');
define('FACEBOOK_REDIRECT_URI', BASE_PATH . 'users/fbreturn');
//define('FACEBOOK_REDIRECT_URI', BASE_PATH);
//Google App login Details
define('GOOGLE_APP_NAME', 'videoportal');
define('GOOGLE_OAUTH_CLIENT_ID', '496377474689-7siamsqs8fm5v63ufr6hvv871kcsm59n.apps.googleusercontent.com');
define('GOOGLE_OAUTH_CLIENT_SECRET', 'LYA8Gm9qrsJOFTiJWMRHY9LJ');
define('GOOGLE_OAUTH_REDIRECT_URI', BASE_PATH . 'users/googleLoginReturn');
define("GOOGLE_SITE_NAME", 'http://dev.raddyx.in/');
///////Linkdin login api/////////////////////////
define("CALLBACK_URL", 'http://dev.raddyx.in/videoportal/links/linkreturn'); //Your callback URL
define("CLIENT_ID", '77f2ha9rtjf4u0'); // Your LinkedIn Application Client ID
define("CLIENT_SECRET", 'lXth2PmCaOtkKa6A'); // Your LinkedIn Application Client Secret
//Twitter login
define('CONSUMER_KEY', '4YCehNTgDlhPhqi5isaemcWCB');
define('CONSUMER_SECRET', '1Jb50wpSv6G2zHjdt0X6NsbFGRc1xCcx1fQlTQRI0fkPJjDejc');
define('OAUTH_CALLBACK', 'http://dev.raddyx.in/videoportal/twitters/index');
