<html>
<head>
<title>ExpTech.tw | 探索科技</title>
<meta charset="utf-8"/>
<meta name="description" content="">
<meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta content="數據網站,登入可以查看數據!" name="description">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta content="exptech,探索科技,探索科技數據,exptech.tw,Exptech,Exptech.TW" name="keywords">
<meta property="og:locale" content="zh_TW" />
<meta property="og:type" content="website" />
<meta property="og:title" content="ExpTech.TW-數據網站" />
<meta property="og:description" content="數據網站,登入可以查看數據!" />
<meta property="og:url" content="https://exptechweb.mywire.org/" />
<meta property="og:site_name" content="ExpTech.TW" />
<meta property="og:image" content="https://raw.githubusercontent.com/ExpTechTW/ExpTech_Website/%E4%B8%BB%E8%A6%81%E7%9A%84-(main)/html/images/head.ico" />
<meta property="og:image:width" content="500" /><meta property="og:image:height" content="500" />
<meta property="og:image:type" content="image/x-icon" />
<link rel="icon" type="image/png" href="images/head.ico">
<script src="../js/all.js"></script>
<script src="../js/brands.js"></script>
<script src="../js/solid.js"></script>
<script src="../js/fontawesome.js"></script>
<script src="../js/main.js"></script>
<link href="../css/main.css"rel="stylesheet">
<link href="../css/all.css" rel="stylesheet">
<link href="../css/fontawesome.css" rel="stylesheet">
<link href="../css/brands.css" rel="stylesheet">
<link href="../css/solid.css" rel="stylesheet">
</head>
<body class="banner" oncontextmenu="return false" onselectstart="return false" ondragstart="return false" onbeforecopy="return false"  onmousewheel="return false;" onmouseup=document.selection.empty() oncopy=document.selection.empty() onselect=document.selection.empty()>
<?php

$Decoder=null;
$Language="zh-TW"; //en-US

    if  (!empty($_COOKIE['user'])) {
        echo '<header class="header">
<h3 class="logo logotext">ExpTech.tw | 探索科技</h3>
<a href="?action=block" class="ahref"><button class="button" style="vertical-align:middle"><span><i class="fas fa-cubes"></i>方塊數據</span></button></a><a href="?action=economy" class="ahref"><button class="button" style="vertical-align:middle"><span><i class="far fa-money-bill-alt"></i>經濟玩法</span></button></a><a href="?action=logout" class="ahref"><button class="button" style="vertical-align:middle"><span><i class="fas fa-sign-out-alt"></i>'.Decoder(2).'</span></button></a>
</header>
<div class="loginfrom">
<p class="ptext"><i class="fas fa-exclamation-triangle"></i>注意:</p>
<p class="ptext">網站目前為測試版!</p>
<p class="ptext">有問題請盡速回報!</p>
</div>';
    }else{
        echo '<header class="header">
<h3 class="logo logotext">ExpTech.tw | 探索科技</h3>
<a href="?action=login" class="ahref" target="_self"><button class="button" style="vertical-align:middle"><span><i class="fab fa-discord"></i>'.Decoder(1).'</span></button></a>
</header>
<div class="loginfrom">
<p class="ptext"><i class="fas fa-exclamation-triangle"></i>注意:</p>
<p class="ptext">網站目前為測試版!</p>
<p class="ptext">有問題請盡速回報!</p>
</div>';
    }

    if(get('action') == 'login') {
        header('Location: login.php?action=login');
    }

    if(get('action') == 'logout') {
        setcookie('user','',time()-1);
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
    
function Decoder($Data){
    if($GLOBALS["Decoder"]==null){
    $url = "https://raw.githubusercontent.com/ExpTechTW/ExpTech_Website/%E4%B8%BB%E8%A6%81%E7%9A%84-(main)/Json/website.json";
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
    $GLOBALS["Decoder"]=$data;
    } 
    for ($i=0; $i < count($GLOBALS["Decoder"]); $i++) { 
        if($GLOBALS["Decoder"][$i]["id"]==$Data){
            return $GLOBALS["Decoder"][$i][$GLOBALS["Language"]];
        }
    }
    return null;
}
?>
</body>
</html>
