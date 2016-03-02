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
<title>掲示板(入力)</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="main">
<h1>掲示板</h1>
<div class="errormsg">

</div>

<form method="POST" action="confirm.php">
    <dl>
        <dt>投稿者：</dt>
        <dd><input type="text" name="nickname"></dd>
        <dt>内容：</dt>
        <dd><textarea name="comment" rows="8" cols="40"></textarea></dd>
    </dl>
    <p class="btn"><button type="submit" name="btn1">投稿する</button></p>
</form>
</div>
</body>
</html>
