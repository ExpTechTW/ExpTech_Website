<?php

$filedata="C:/Users/whes1015/Desktop/ExpTech/Json/login.json";
$fp=fopen($filedata,"r");
$size=filesize($filedata);
$txt=json_decode(fread($fp,$size),true);

$APIkey=$txt["APIkey"];
$FormatVersion=1;

    session_start();
    if (!empty($_SESSION['user'])) {
        $user=$_SESSION['user'];
        echo '<p><a href="?action=logout">登出</a></p>';
    }else{
        echo '<p><a href="?action=login">登入</a></p>';
    }

    if(get('action') == 'login') {
        header('Location: login.php?action=login');
    }

    if(get('action') == 'logout') {
        session_destroy();
        header('Location: index.php');
    }

    function get($key, $default=NULL) {
        return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
    }
?>
<!doctype html>
<html class="no-js" lang="zh-Hant-TW">

<head>
    <meta charset="utf-8">
    <title>ExpTech.tw | 探索科技</title>
</head>
<body>
<?php
if(empty($user)) return;
echo '<table class="table table-bordered table-striped table-condensed"><tr><td>名稱</td><td>數量</td></tr>';

$Data=post('{"Function":"serverData","Type":"BlockValue"}')["response"];
for ($x=0; $x<count($Data); $x++) {
    $name=BlockDecoder($Data[$x]["name"]);
    $value=$Data[$x]["value"];
    echo '<tr><td>'.$name.'<td><td>'.$value.'<td></tr>';
  } 
  echo '</table>';

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
    return json_decode(curl_exec($curl),true);
     }

     function BlockDecoder($Data){
        $url = "https://raw.githubusercontent.com/ExpTechTW/API/%E4%B8%BB%E8%A6%81%E7%9A%84-(main)/Json/BlockDecoder";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
           "Accept: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_close($curl);
        $data=json_decode(curl_exec($curl),true);
        if(empty($data[$Data])){
            return $Data;
        }else{
            return $data[$Data];
        }
     }
?>
</body>
</html>