<?php
ini_set('max_execution_time', 300);
session_start();

$filedata="C:/Users/whes1015/Desktop/ExpTech/Json/login.json";
$fp=fopen($filedata,"r");
$size=filesize($filedata);
$txt=json_decode(fread($fp,$size),true);

$id=$txt["id"];
$token=$txt["token"];
$APIkey=$txt["APIkey"];
$bot=$txt["bot"];
$FormatVersion=1;

define('OAUTH2_CLIENT_ID',$id); 
define('OAUTH2_CLIENT_SECRET', $token); 
define('LOGIN_URL', 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']); 

$authorizeURL = 'https://discord.com/api/oauth2/authorize';
$tokenURL = 'https://discord.com/api/oauth2/token';
$apiURLBase = 'https://discord.com/api/users/@me';

if(get('action') == 'login') {
  header('Location: https://discord.com/api/oauth2/authorize?client_id=922807944431697930&redirect_uri=https%3A%2F%2Fexptech.mywire.org%2Fserver%2Flogin.php&response_type=code&scope=identify%20guilds%20guilds.join%20email');
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

function join_guild($user) 
{
    $data = json_encode(array("access_token" => $_SESSION['access_token']));
    $url = "https://discord.com/api" . "/guilds/926545182407688273/members/" . $user;
    $headers = array('Content-Type: application/json', 'Authorization: Bot ' . $GLOBALS['bot']);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($curl);
    curl_close($curl);
    $results = json_decode($response, true);
    print_r($results);
    return $results;
}

if(session('access_token')) {
  $user = apiRequest($apiURLBase);
  echo '<h3>已登入</h3>';
  echo '<h4>歡迎, ' . $user->username . '</h4>';
  echo '<pre>';
  print_r(post('{"APIke":"1"}'));
    print_r($user->id);
  echo '</pre>';
  echo '<p><a href="?action=logout">登出</a></p>';
  join_guild($user->id);
} else {
  echo '<p><a href="?action=login">登入</a></p>' ;
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

 function post($Data){
$url = "http://150.117.110.118:10150/";    
$curl = curl_init($url);
$json=json_decode($Data,true);
$json["APIkey"]=$GLOBALS["APIkey"];
$json["FormatVersion"]=$GLOBALS["FormatVersion"];
$data=json_encode($json);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_close($curl);
return curl_exec($curl);
 }

?> 