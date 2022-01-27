<?php
$filedata="/home/pi/Desktop/Json/config.json";
$fp=fopen($filedata,"r");
$size=filesize($filedata);
 $txt=json_decode(fread($fp,$size),true);
 $APIkey=$txt["APIkey"];
$FormatVersion=1;
if(empty($_COOKIE['user'])){
    header('Location: index.php'); 
}

?>
<head>
    <meta charset="utf-8">
    <title>ExpTech.tw | 探索科技</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/head.ico">
</head>
<body>
<?php
 if(get('action') == 'sign') {
    $Data=post('{"Function":"economy","FormatVersion":1,"Type":"sign","Value":"'.$_COOKIE['user'].'"}');
    if($Data["response"]=="You can not sign"){
        echo '今日已簽到 積分: '.$Data["addition"]["integral"].' 金幣: '.$Data["addition"]["coin"].' 下次簽到時間: '.$Data["addition"]["time"];
    }else if($Data["response"]=="Sign success"){
        echo '今日簽到成功 積分: '.$Data["addition"]["integral"].' 金幣: '.$Data["addition"]["coin"].' 今日獲得: '.$Data["addition"]["today"].' 下次簽到時間: '.$Data["addition"]["time"];
    }
    echo '<p><a href="?action=back">返回</a></p>';
}else if(get('action') == 'back') {
    header('Location: economy.php'); 
}else if(get('action') == 'shop'){
    $Data=post('{"Function":"serverData","FormatVersion":1,"Type":"shop","Value":"'.$_COOKIE['user'].'"}');
    echo '<form action="economy.php" method="get">';
    echo '請選擇你要進入的伺服器商城:<Br>';
    echo '<Select name="select">';
    print_r($Data);
    for ($i=0; $i < count($Data["response"]); $i++) { 
        echo '<Option Value='.$Data["response"][$i]["UUID"].'>"'.$Data["response"][$i]["ServerName"].'"</Option>';
    }
    echo '</Select>';
    echo '<input type="Submit">';
    echo '</form>';
}else if(!empty(get('select'))){
    header('Location: shop.php?action='.get('select'));
}else{
    echo '<p><a href="?action=sign">簽到</a></p>';
    echo '<p><a href="?action=shop">商城</a></p>';
    $Data=post('{"Function":"economy","FormatVersion":1,"Type":"assets","Value":"'.$_COOKIE['user'].'"}');
    if($Data["response"]!="No Player assets Data Found"){
    echo '積分: '.$Data["addition"]["integral"].' 金幣: '.$Data["addition"]["coin"].'<br>';
    }
}

function get($key, $default=NULL) {
    return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}

function main($Data){
   
}

function post($Data){
    $url = "http://150.117.110.118:10150/";    
    $curl = curl_init($url);
    $json=json_decode($Data,true);
    $json["APIkey"]=$GLOBALS["APIkey"];
    $data=json_encode($json);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    $res=json_decode(curl_exec($curl),true);
    curl_close($curl);
    //print_r($res);
    if($res["state"]=="Success"||$res["state"]=="Warn"){
        return $res;
    }else{
        //header('Location: /exptech/error.php?Function=post&Info='.$res["response"]);
    }
}

?>
</html>
