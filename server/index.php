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
        echo '<div class="topcorner"><div class="box"><button type="button" class="standard" onclick="location.href='?action=logout'">登出</button></div></div>';
        echo '<div class="topcorner-2"><div class="box"><button type="button" class="standard" onclick="location.href='?action=block'">方塊數據</button></div></div>';
        echo '<div class="topcorner-3"><div class="box"><button type="button" class="standard" onclick="location.href='?action=economy'">經濟玩法</button></div></div>';
    }else{
        echo '<div class="topcorner"><div class="box"><button type="button" class="standard" onclick="location.href='?action=login'">登入</button></div></div>';
    }

    if(get('action') == 'login') {
        header('Location: login.php?action=login');
    }

    if(get('action') == 'logout') {
        session_destroy();
        header('Location: index.php');
    }

    if(get('action') == 'block') {
        header('Location: block.php');
    }

    if(get('action') == 'economy') {
        header('Location: economy.php');
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
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/head.ico">
    <style>
        .standard{
            color:white;
            background-color:hsl(193, 58%, 52%) ;
            padding: 10px;
            font-family: sans-serif;
            margin: 50px ;
            font-size: larger;
            background-image:url('../../Downloads/homebg.png') ;
            border-radius: 10px;
        }
        .container{
            display: flex;
            justify-content: center; 
            align-items: center; 
        }
        .topcorner{
            position:absolute;
            top:0;
            right:0;
        }
        .topcorner-2{
            position:absolute;
            top:0;
            right: 80px;
        }
        .topcorner-3{
            position:absolute;
            top:0;
            right:200px;
        }
    </style>
</head>
<body bgcolor="#b0deeb">
    <br>
    <br>
    <br>
    <div class="standard">
        <h1>探索科技<br>Exptech</h1>
    </div>
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
