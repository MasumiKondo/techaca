<?php
// フォームバリデータ
require_once 'MyValidator.php';
// エスケープ処理(e関数の有効化)
require_once 'Encode.php';

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>掲示板(サインアップ・ログイン)</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="main">
<h1>掲示板(ログイン)</h1>

<form method="POST" action="login_confirm.php">
    <dl>
        <dt>ユーザーID</dt>
        <dd><input type="text" name="userid"></dd>
        <dt>パスワード：</dt>
        <dd><input type="password" name="password"></dd>
    </dl>
    <p class="btn"><button type="submit" name="btn1">ログイン</button></p>
</form>

<h1>サインアップ</h1>
<p>会員登録がまだの方はこちらから登録してください</p>
<form method="POST" action="signup.php">
    <dl>
        <dt>ユーザーID</dt>
        <dd><input type="text" name="userid"></dd>
        <dt>パスワード</dt>
        <dd><input type="password" name="password"></dd>
    </dl>
    <p class="btn"><button type="submit" name="btn1">登録する</button></p>
</form>
</div>
</body>
</html>
