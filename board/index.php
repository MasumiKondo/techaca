<?php
// DBと接続(getDb関数の有効化)
require_once 'DbManager.php';
// フォームバリデータ
require_once 'MyValidator.php';
// エスケープ処理(e関数の有効化)
require_once 'Encode.php';
// XSS対策
//require_once 'HTMLPurifier/HTMLPurifier.auto.php';

//初期化
$nickname = "";
$comment = "";
$now = new DateTime();
$postdate = $now -> format('Y-m-d H:i:s');

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
try {
    // データベースへの接続を確立
    $db = getDb();
?>
<?php
    //　一覧を作る
    $sttw = $db->prepare('SELECT * FROM board ORDER BY id DESC');
    $sttw ->execute();
    //結果セットの内容を順に出力
    while($row = $sttw->fetch(PDO::FETCH_ASSOC)){
        $id = $row['id'];
?>
<form action="edit.php" method="post">
<p class="nickname">投稿者:<?php e($row['nickname']); ?>[<?php e($id); ?>]
    <button class="edit" type="submit"><?php e($id); ?>を削除</button></p>
    <input type="hidden" name="id" value="<?php e($id); ?>">
<div class="comment"><?php e($row['comment']); ?></div>
<p class="postdate"><?php e($row['postdate']); ?></p>
</form>
<?php
    }
    $db = NULL;
} catch(PDOException $e) {
    die("エラーメッセージ：{$e->getMessage()}");
}

?>
<form method="POST" action="post.php">
    <p class="btn"><button type="submit" name="btn1">投稿画面へ</button></p>
</form>
</div>
</body>
