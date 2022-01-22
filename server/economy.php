<?php
session_start();
$filedata="C:/Users/whes1015/Desktop/ExpTech/Json/login.json";
$fp=fopen($filedata,"r");
$size=filesize($filedata);
 $txt=json_decode(fread($fp,$size),true);
 $APIkey=$txt["APIkey"];
$FormatVersion=1;
if(empty($_SESSION['user'])){
    header('Location: /server/'); 
}
$user=$_SESSION['user'];
$BlockDecoder=null;

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
    $Data=post('{"Function":"economy","FormatVersion":1,"Type":"sign","Value":"'.$user->id.'"}');
    if($Data["response"]=="You can not sign"){
        echo '今日已簽到 積分: '.$Data["addition"]["integral"].' 金幣: '.$Data["addition"]["coin"].' 下次簽到時間: '.$Data["addition"]["time"];
    }else if($Data["response"]=="Sign success"){
        echo '今日簽到成功 積分: '.$Data["addition"]["integral"].' 金幣: '.$Data["addition"]["coin"].' 今日獲得: '.$Data["addition"]["today"].' 下次簽到時間: '.$Data["addition"]["time"];
    }
    echo '<p><a href="?action=back">返回</a></p>';
}else if(get('action') == 'back') {
    header('Location: economy.php'); 
}else if(get('action') == 'shop'){
    $Data=post('{"Function":"serverData","FormatVersion":1,"Type":"shop","Value":"'.$user->id.'"}');
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
    
}else{
    echo '<p><a href="?action=sign">簽到</a></p>';
    echo '<p><a href="?action=shop">商城</a></p>';
    $Data=post('{"Function":"economy","FormatVersion":1,"Type":"assets","Value":"'.$GLOBALS["user"]->id.'"}');
    echo '積分: '.$Data["addition"]["integral"].' 金幣: '.$Data["addition"]["coin"].'<br>';
    Inventory();
}

function get($key, $default=NULL) {
    return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}

function Inventory(){
        $Data=post('{"Function":"serverData","FormatVersion":1,"Type":"Inventory","Value":"'.$GLOBALS["user"]->id.'"}');
        echo '物品欄<br><br>';
        echo '<table class="table table-bordered table-striped table-condensed"><tr><td>格子編號</td><td>物品</td><td>數量</td></tr>';
        for ($x=0; $x<9; $x++) {
            $name=BlockDecoder($Data["response"][$x]["item"]);
            $value=$Data["response"][$x]["amount"];
            $y=$x+1;
            echo '<tr><td>'.$y.'<td><td>'.$name.'<td><td>'.$value.'<td></tr>';
          } 
          echo '</table>';
          echo '<br>背包<br>';
          echo '<table class="table table-bordered table-striped table-condensed"><tr><td>格子編號</td><td>物品</td><td>數量</td></tr>';
        for ($x=9; $x<count($Data["response"]); $x++) {
            if($x>35) break;
            $name=BlockDecoder($Data["response"][$x]["item"]);
            $value=$Data["response"][$x]["amount"];
            $y=$x+1;
            echo '<tr><td>'.$y.'<td><td>'.$name.'<td><td>'.$value.'<td></tr>';
        } 
        echo '<br>最後更新時間: '.$Data["addition"]["InventoryTime"];
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
    curl_close($curl);
    $res=json_decode(curl_exec($curl),true);
    //print_r($res);
    if($res["state"]=="Success"){
        return $res;
    }else{
        //header('Location: /exptech/error.php?Function=post&Info='.$res["response"]);
    }
}

function BlockDecoder($Data){
    if($GLOBALS["BlockDecoder"]==null){
    $url = "https://raw.githubusercontent.com/ExpTechTW/API/%E4%B8%BB%E8%A6%81%E7%9A%84-(main)/Json/BlockDecoder/zh-Hant-TW.json";
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
    $GLOBALS["BlockDecoder"]=$data;
    if(empty($data[$Data])){
        return $Data;
    }else{
        return $data[$Data];
    }
}else{
    if(empty($GLOBALS["BlockDecoder"][$Data])){
        return $Data;
    }else{
        return $GLOBALS["BlockDecoder"][$Data];
    } 
}
 }

?>
</html>