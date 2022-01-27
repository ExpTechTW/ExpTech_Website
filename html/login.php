<?php
$filedata="/home/pi/Desktop/Json/config.json";
$fp=fopen($filedata,"r");
$size=filesize($filedata);
$txt=json_decode(fread($fp,$size),true);

$id=$txt["id"];
$token=$txt["token"];
$bot=$txt["bot"];

ini_set('max_execution_time', 300);
session_start();

define('OAUTH2_CLIENT_ID',$id); 
define('OAUTH2_CLIENT_SECRET', $token); 
define('LOGIN_URL', 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']); 

$authorizeURL = 'https://discord.com/api/oauth2/authorize';
$tokenURL = 'https://discord.com/api/oauth2/token';
$apiURLBase = 'https://discord.com/api/users/@me';


if(get('action') == 'login') {
  header('Location: https://discord.com/api/oauth2/authorize?client_id=922807944431697930&redirect_uri=https%3A%2F%2Fexptechweb.mywire.org%2Flogin.php&response_type=code&scope=identify%20email%20guilds%20guilds.join');
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
  setcookie('user',$user->id,time()+60*24*7);
  header('Location: index.php'); 
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
