<?php
    session_start();
    if (!empty($_SESSION['user'])) {
        $user=$_SESSION['user'];
        echo '<p><a href="?action=logout">登出</a></p>';
        echo '<p><a href="?action=block">方塊數據</a></p>';
        echo '<p><a href="?action=economy">經濟玩法</a></p>';
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