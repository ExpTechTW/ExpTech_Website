<?php
session_start();
$filedata="C:/Users/whes1015/Desktop/ExpTech/Json/login.json";
$fp=fopen($filedata,"r");
$size=filesize($filedata);
 $txt=json_decode(fread($fp,$size),true);
 $APIkey=$txt["APIkey"];
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
 
echo '<table class="table table-bordered table-striped table-condensed"><tr><td>名稱</td><td>數量</td></tr>';

$Data=post('{"Function":"serverData","FormatVersion":1,"Type":"BlockValue","Value":"'.$user->id.'"}');
if($Data["response"]=="No Player Data Found"){
    echo '沒有找到玩家數據';
}else{
    main($Data);
}

function main($Data){
    for ($x=0; $x<count($Data["response"]); $x++) {
        $name=BlockDecoder($Data["response"][$x]["name"]);
        $value=$Data["response"][$x]["value"];
        echo '<tr><td>'.$name.'<td><td>'.$value.'<td></tr>';
      } 
      echo '</table>';
      echo '<br>最後更新時間: '.$Data["addition"]["BlockTime"];
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
    if($res["state"]=="Success"||$res["state"]=="Warn"){
        return $res;
    }else{
        header('Location: /exptech/error.php?Function=post&Info='.$res["response"]); 
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
                        "title": "BlockDecoder",
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
                curl_close($curl);
                curl_exec($curl);
            return $Data;
        }else{
            return $GLOBALS["BlockDecoder"][$Data];
        } 
    }
     }
?>
</html>