<?php

    if (!empty($_COOKIE['user'])) {

        echo '<p><a href="?action=logout">登出</a></p>';

        echo '<p><a href="?action=block">方塊數據</a></p>';

        echo '<p><a href="?action=economy">經濟玩法</a></p>';

    }else{

        echo '<style>

.button {

  display: inline-block;

  padding: 10px 10px;

  font-size: 22px;

  width: 100%;

  cursor: pointer;

  text-align: center;

  text-decoration: none;

  transition: all 0.3s;

  outline: none;

  color: #fff;

  background-color: #2894FF;

  border: none;

  border-radius: 15px;

  box-shadow: 0 5px #999;

  margin: 5px;

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

.titletext {

  color: #2894FF;

  text-align: center;  

  text-decoration: none;

}

</style>

<html>

<head>

<title>ExpTech.tw | 探索科技</title>

</head>

<body class="banner">

<h1 class="titletext"><a href="https://exptech.mywire.org/" class="titletext">ExpTech.tw | 探索科技</a></h1>

<button class="button" style="vertical-align:middle"><span><a href="?action=login" class="ahref">登入</span></a></button>

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

?>

<!doctype html>

<html class="no-js" lang="zh-Hant-TW">



<head>

    <meta charset="utf-8">

    <title>ExpTech.tw | 探索科技</title>

    <meta name="description" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="images/head.ico">

</head>

<body>

</body>

</html>

