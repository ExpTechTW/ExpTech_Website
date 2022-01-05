<?php
ini_set('max_execution_time', 300);
session_start();

$filedata="C:/Users/whes1015/Desktop/ExpTech/Json/login.json";
$fp=fopen($filedata,"r");
$size=filesize($filedata);
$txt=fread($fp,$size);
define('OAUTH2_CLIENT_ID',json_decode($txt,true)["id"] ); 
define('OAUTH2_CLIENT_SECRET', json_decode($txt,true)["token"]); 
define('LOGIN_URL', 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']); 

$authorizeURL = 'https://discord.com/api/oauth2/authorize';
$tokenURL = 'https://discord.com/api/oauth2/token';
$apiURLBase = 'https://discord.com/api/users/@me';

if(get('action') == 'login') {

  $params = array(
    'client_id' => OAUTH2_CLIENT_ID,
    'redirect_uri' => LOGIN_URL,
    'response_type' => 'code',
    'scope' => 'identify guilds'
  );

  header('Location: https://discord.com/api/oauth2/authorize' . '?' . http_build_query($params));
  die();
}

if(get('code')) {
  $token = apiRequest($tokenURL, array(
    "grant_type" => "authorization_code",
    'client_id' => OAUTH2_CLIENT_ID,
    'client_secret' => OAUTH2_CLIENT_SECRET,
    'redirect_uri' => LOGIN_URL,
    'code' => get('code')
  ));
  $logout_token = $token->access_token;
  $_SESSION['access_token'] = $token->access_token;
  header('Location: ' . $_SERVER['PHP_SELF']);
}

if(session('access_token')) {
  $user = apiRequest($apiURLBase);
  echo '<h3>已登入</h3>';
  echo '<h4>歡迎, ' . $user->username . '</h4>';
  echo '<pre>';
    print_r($user);
  echo '</pre>';
  echo '<p><a href="?action=logout">登出</a></p>';
} else {
  echo '<p><a href="?action=login">登入</a></p>';
}

if(get('action') == 'logout') {
  session_destroy();
  header('Location: ' . $_SERVER['PHP_SELF']);
}

function apiRequest($url, $post=FALSE, $headers=array()) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

  $response = curl_exec($ch);


  if($post)
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

  $headers[] = 'Accept: application/json';

  if(session('access_token'))
    $headers[] = 'Authorization: Bearer ' . session('access_token');

  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $response = curl_exec($ch);
  return json_decode($response);
}

function get($key, $default=NULL) {
  return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}

function session($key, $default=NULL) {
  return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
}

?> 