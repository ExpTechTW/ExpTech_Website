<?php

$Decoder=null;
$Language="zh-Hant-TW"; //en-US

    if  (!empty($_COOKIE['user'])) {
        echo '<style>
.button {
  display: inline-block;
  padding: 10px 10px;
  font-size: 22px;
  width: 180px;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  transition: all 0.3s;
  outline: none;
  color: #fff;
  justify-content: center;
  background-color: #2894FF;
  border: none;
  height: 2.2em;
  border-radius: 16px;
  box-shadow: 0 5px #999;
  margin: 2px;
}
.button:hover {background-color: #0066cc}

.button:active {
  background-color: #0066cc;
  box-shadow: 0 2px #666;
  transform: translateY(4px);
}
.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.3s;
}

.button span:after {
  content: "\00bb";
  position: absolute;
  opacity: 0;
  top: 0;
  right: -10px;
  color: #FFFFFF;
  transition: 0.3s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}
.ahref {
  text-decoration: none;
  color: #FFFFFF;
}
.banner {
  background-attachment: fixed;
  background-image: linear-gradient(rgb(145, 232, 255), rgb(255, 255, 255));
  background-position: center;
}
.blink {
    color: #C0C0C0;
    font-size: 20px;
    font-weight: bold;
    font-family: sans-serif;
}
.logo {
		display: inline-block;
		height: inherit;
		left: 1.5em;
		line-height: inherit;
		margin: 0;
		padding: 0;
    position: absolute;
		top: 0;
}
@media (max-width: 800px){
							.button{
                font-size: 14px;
                width: 100px;
                height: 3.0em;
							}
              .logo {
                font-size: 14px;
							}
              .button:hover span {
                padding-right: 8%;
              }
}
.header {
    background: #272727;
    color: #1c1d26;
    height: 3.7em;
    left: 0;
    line-height: 3.7em;
    position: fixed;
    text-align: right;
    top: 0;
    width: 100%;
    z-index: 10001;
}
</style>
<html>
<head>
<title>ExpTech.tw | 探索科技</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width">.
<meta content="ExpTech.tw | 探索科技" property="og:title" />
<meta content="數據網站,登入可以查看數據!" property="og:description" />
<meta content="https://exptechweb.mywire.org/" property="og:url" />
<meta content="../images/head.ico" property="og:image" />
<meta content="#91e8ff" data-react-helmet="true" name="theme-color" />
<script defer src="../js/all.js"></script>
<script defer src="../js/brands.js"></script>
<script defer src="../js/solid.js"></script>
<script defer src="../js/navpanel.js"></script>
<script defer src="../js/fontawesome.js"></script>
<link href="../css/all.css" rel="stylesheet">
<link href="../css/fontawesome.css" rel="stylesheet">
<link href="../css/brands.css" rel="stylesheet">
<link href="../css/solid.css" rel="stylesheet">
</head>
<body class="banner">
<header class="header">
<h3 class="logo blink">ExpTech.tw | 探索科技</h3>
<a href="?action=block" class="ahref"><button class="button" style="vertical-align:middle"><span><i class="fas fa-cubes"></i>方塊數據</span></button></a><a href="?action=economy" class="ahref"><button class="button" style="vertical-align:middle"><span><i class="far fa-money-bill-alt"></i>經濟玩法</span></button></a><a href="?action=logout" class="ahref"><button class="button" style="vertical-align:middle"><span><i class="fas fa-sign-out-alt"></i>'.Decoder(2).'</span></button></a>
</header>
</body>
</html>
';
    }else{
        echo '<style>
.button {
  display: inline-block;
  padding: 5px 5px;
  font-size: 22px;
  width: 180px;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  transition: all 0.3s;
  outline: none;
  color: #fff;
  justify-content: center;
  background-color: #2894FF;
  border: none;
  height: 2.2em;
  border-radius: 16px;
  box-shadow: 0 5px #999;
  margin: 2px;
}
.button:hover {background-color: #0066cc}

.button:active {
  background-color: #0066cc;
  box-shadow: 0 2px #666;
  transform: translateY(4px);
}
.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.3s;
}

.button span:after {
  content: "\00bb";
  position: absolute;
  opacity: 0;
  top: 0;
  right: -10px;
  color: #FFFFFF;
  transition: 0.3s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}
.ahref {
  text-decoration: none;
  color: #FFFFFF;
}
.banner {
  background-attachment: fixed;
  background-image: linear-gradient(rgb(145, 232, 255), rgb(255, 255, 255));
  background-position: center;
}
.blink {
    color: #C0C0C0;
    font-size: 20px;
    font-weight: bold;
    font-family: sans-serif;
}
.logo {
		display: inline-block;
		height: inherit;
		left: 1.5em;
		line-height: inherit;
		margin: 0;
		padding: 0;
    position: absolute;
		top: 0;
}
@media (max-width: 800px){
							.button{
                font-size: 14px;
                width: 100px;
                height: 3.3em;
                z-index: 10002;
							}
              .logo {
                font-size: 14px;
							}
              .button:hover span {
                padding-right: 8%;
              }
}
@media (max-width: 800px){
              .header {
                height: 3em;
                line-height: 3em;
              }
}        
.header {
    background: #272727;
    color: #1c1d26;
    height: 3.7em;
    left: 0;
    line-height: 3.7em;
    position: fixed;
    text-align: right;
    top: 0;
    width: 100%;
    z-index: 10001;
}
</style>
<html>
<head>
<title>ExpTech.tw | 探索科技</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width">.
<meta content="ExpTech.tw | 探索科技" property="og:title" />
<meta content="數據網站,登入可以查看數據!" property="og:description" />
<meta content="https://exptechweb.mywire.org/" property="og:url" />
<meta content="../images/head.ico" property="og:image" />
<meta content="#91e8ff" data-react-helmet="true" name="theme-color" />
<script defer src="../js/all.js"></script>
<script defer src="../js/brands.js"></script>
<script defer src="../js/solid.js"></script>
<script defer src="../js/fontawesome.js"></script>
<link href="../css/all.css" rel="stylesheet">
<link href="../css/fontawesome.css" rel="stylesheet">
<link href="../css/brands.css" rel="stylesheet">
<link href="../css/solid.css" rel="stylesheet">
</head>
<body class="banner">
<header class="header">
<h3 class="logo blink">ExpTech.tw | 探索科技</h3>
<a href="?action=login" class="ahref"><button class="button" style="vertical-align:middle"><span><i class="fab fa-discord"></i>'.Decoder(1).'</span></button></a>
</header>
</body>
</html>';
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
            return $GLOBALS["Decoder"][$i][strtok($_SERVER['HTTP_ACCEPT_LANGUAGE'], ',')];
        }
    }
    return null;
}

?>
