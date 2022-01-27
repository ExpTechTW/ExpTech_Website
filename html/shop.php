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
session_start();
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

if(get('action') == 'buy') {
    $Data=post('{"Function":"serverData","FormatVersion":1,"ServerUUID":"'.$_SESSION["ServerUUID"].'","Type":"list","Value":"'.$_COOKIE['user'].'"}');
    if($Data["response"]!="No Server list Data Found"){
        if(count($Data["response"])!=0){
        echo '<form action="shop.php" method="get">';
        echo '請選擇你要購買的物品:<Br>';
        echo '<Select name="shopSelect">';
        for ($x=0; $x < count($Data["response"]); $x++) { 
            $json[$Data["response"][$x]["item"]]=$Data["response"][$x]["amount"];
            echo '<Option Value='.$Data["response"][$x]["id"].'>"'."價格: ".$Data["response"][$x]["price"]." - 物品: ".BlockDecoder($Data["response"][$x]["item"])." - 數量: ".$Data["response"][$x]["amount"]." - 賣家: ".$Data["response"][$x]["player"][0].'"</Option>';
        }
        echo '</Select>';
        echo '<input type="Submit">';
        echo '</form>';
        }else{
            echo '沒有待售商品';  
            echo '<p><a href="?action=back">返回</a></p>'; 
        }
    }else{
        echo '沒有待售商品'; 
        echo '<p><a href="?action=back">返回</a></p>';  
    }
}else if(get('action') == 'sell') {
    $Data=post('{"Function":"serverData","FormatVersion":1,"ServerUUID":"'.$_SESSION["ServerUUID"].'","Type":"Inventory","Value":"'.$_COOKIE['user'].'"}');
    if($Data["response"]!="No Player Inventory Data Found"){
    echo '<form action="shop.php" method="get">';
    echo '請選擇你要賣出的物品:<Br>';
    echo '<Select name="sellSelect">';
    $json=json_decode('{}',true);
    for ($x=0; $x < 35; $x++) { 
        if($Data["response"][$x]["item"]!="null"){
        $json[$Data["response"][$x]["item"]]=$Data["response"][$x]["amount"];
        echo '<Option Value='.$Data["response"][$x]["item"].'>"'."物品: ".BlockDecoder($Data["response"][$x]["item"])." - 數量: ".$Data["response"][$x]["amount"].'"</Option>';
        }
    }
    $_SESSION['sell']=$json;
    echo '</Select>';
    echo ' 價格: <input type="text" name="price"><br>';
    if(count($json)==0){
        echo '你沒有物品可以出售';
        echo '<p><a href="?action=back">返回</a></p>';
    }else{
    echo '<input type="Submit">';
    }
    echo '</form>';
}else{
    echo '沒有玩家數據';   
    echo '<p><a href="?action=back">返回</a></p>';
}
}else if(!empty(get('sellSelect'))){
    if(empty(get('price'))){
        echo '價格不可為空';
        echo '<p><a href="?action=back">返回</a></p>';
    }else if(!is_numeric(get('price'))){
        echo '價格必須為數字';
        echo '<p><a href="?action=back">返回</a></p>';
    }else{
        echo '上架商店成功 ( 注意: 若你當前不在線上，則系統會等到下次你上線時才將物品上架到商店 ) - 待商品售出即可獲得積分';
        echo '<p><a href="?action=back">返回</a></p>';
    $Data=post('{"Function":"serverData","Price":'.get('price').',"Item":"'.get('sellSelect').'","Amount":"'.$_SESSION['sell'][get('sellSelect')].'","FormatVersion":1,"ServerUUID":"'.$_SESSION["ServerUUID"].'","Type":"sell","Value":"'.$_COOKIE['user'].'"}');
    }
}else if(!empty(get('shopSelect'))){
    $Data=post('{"Function":"serverData","Id":"'.get('shopSelect').'","FormatVersion":1,"ServerUUID":"'.$_SESSION["ServerUUID"].'","Type":"buy","Value":"'.$_COOKIE['user'].'"}');
   if($Data["response"]=="Success purchase"){
    echo '購買商品成功';
   }else if($Data["response"]=="No Commodity ID Found"){
    header('Location: shop.php?action='.$_SESSION["ServerUUID"]);
   }else{
    echo '購買商品失敗 - 積分不足';
   }
    echo '<p><a href="?action=back">返回</a></p>';
}else if(get('action') == 'back'){
    header('Location: shop.php?action='.$_SESSION["ServerUUID"]);
}else{
echo '<p><a href="?action=buy">買入</a></p>';
echo '<p><a href="?action=sell">賣出</a></p>';
Inventory();
}
function Inventory(){
    $_SESSION["ServerUUID"]=get('action');
    $filepath= 'https://150.117.110.118/InventoryImage/'.$_SESSION["ServerUUID"].'_'.$_COOKIE['user'].'.png'; 
    echo '<img src="'.$filepath.'" height="500" width="500">'; 
}

function get($key, $default=NULL) {
    return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
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
       // header('Location: /exptech/error.php?Function=post&Info='.$res["response"]);
    }
}

function BlockDecoder($Data){
    if($GLOBALS["BlockDecoder"]==null){
    $url = "https://raw.githubusercontent.com/ExpTechTW/API/%E4%B8%BB%E8%A6%81%E7%9A%84-(main)/Json/BlockDecoder/zh-Hant-TW_simple.json";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $headers = array(
       "Accept: application/json",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $data=json_decode(curl_exec($curl),true);
    curl_close($curl);
    $GLOBALS["BlockDecoder"]=$data;
    if(empty($data[$Data])){
        return $Data;
    }else{
        return $data[$Data];
    }
}else{
    if(empty($GLOBALS["BlockDecoder"][$Data])){
    if($Data!="null"){
    $url = "https://discord.com/api/webhooks/934735429939392522/OFACH06MbCAVCmehjQUIsXwCWcklpjeFVT6vCqx1kzZrMkWJxQGcdkq1s8zvTXE6LvWJ";    
    $curl = curl_init($url);
    $json=json_decode('{
        "username": "ExpTech | 探索科技",
        "avatar_url": "https://res.cloudinary.com/dh1luzdfd/image/upload/v1635819265/received_451346186125589_ii1lft.jpg",
        "embeds": [
          {
            "author": {
              "name": "📢自動反饋"
            },
            "title": "BlockDecoder-Simple",
            "description": "",
            "color": 4629503,
            "footer": {
              "text": "ExpTech 提供技術支持",
              "icon_url": "https://res.cloudinary.com/dh1luzdfd/image/upload/v1635819265/received_451346186125589_ii1lft.jpg"
            }
          }
        ]
      }',true);
    $json["embeds"][0]["description"]=$Data;
    $data=json_encode($json);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_exec($curl);
    curl_close($curl);
    }
        return $Data;
    }else{
        return $GLOBALS["BlockDecoder"][$Data];
    } 
}
 }

?>
</html>
