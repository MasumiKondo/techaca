<?php
// DBと接続(getDb関数の有効化)
require_once 'DbManager.php';
// フォームバリデータ
require_once 'MyValidator.php';
// エスケープ処理(e関数の有効化)
require_once 'Encode.php';
// XSS対策
require_once 'HTMLPurifier/HTMLPurifier.auto.php';

?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>掲示板(一覧)</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="main">
<h1>掲示板</h1>
<?php
//初期化
$nickname = "";
$comment = "";
$now = new DateTime();
$postdate = $now -> format('Y-m-d H:i:s');


if ( $_SERVER["REQUEST_METHOD"] === "POST" ) {
// フォームからPOSTによって要求された場合

    // フォームに入力されてるか確認
    if ( isset ( $_POST['nickname'])  &&  isset ( $_POST['comment']) ) {
        //バリデータ
        $v = new MyValidator();
        $v->requiredCheck($_POST['nickname'],'投稿者名'); //必須検証
        $v->requiredCheck($_POST['comment'],'投稿内容'); //必須検証
        $v();

    } else {
        $_error[] = '入力してください';
    }

    // 変数に代入
    $nickname = $_POST['nickname'];
    $pur = new HTMLPurifier(); // 浄化準備
    $comment = nl2br($_POST['comment']);
}
try {
    // データベースへの接続を確立
    $db = getDb();
    // insert命令準備
    $stt = $db->prepare('INSERT INTO board(nickname, postdate, comment) VALUES(:nickname, :postdate, :comment)');
    // INSERT命令にポストデータの内容セット
    $stt->bindValue(':nickname', $nickname);
    $stt->bindValue(':postdate', $postdate);
    $stt->bindValue(':comment', $comment);
    // INSERT命令を実行
    $stt->execute();
?>
<div class="message">
    <p>以下内容が投稿されました</p>
</div>
<p class="nickname">投稿者:<?php e($nickname); ?></p>
<div class="comment"><?php e($comment); ?></div>
<p class="postdate"><?php e($postdate); ?></p>
<?php
    $db = NULL;
} catch(PDOException $e) {
    die("エラーメッセージ：{$e->getMessage()}");
}
// 処理後は元のフォームにリダイレクト
// header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php');

?>
<form method="POST" action="index.php">
    <p class="btn"><button type="submit" name="btn1">投稿画面へ</button></p>
</form>
<form method="POST" action="board.php">
    <p class="btn"><button type="submit" name="btn2">一覧画面へ</button></p>
</form>
</div>
</body>
