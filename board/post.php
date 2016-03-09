<?php
// DBと接続(getDb関数の有効化)
require_once 'DbManager.php';
// フォームバリデータ
require_once 'MyValidator.php';
// エスケープ処理(e関数の有効化)
require_once 'Encode.php';

//初期化
$nickname = "";
$comment = "";
$now = new DateTime();
$postDate = $now -> format('Y-m-d H:i:s');
$errorMessage = array();

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

<?php
if ( $_SERVER["REQUEST_METHOD"] === "POST" ) {// フォームからPOSTによって要求された場合

    //バリデータ
    $validate = new MyValidator();
    $validate->requiredCheck($_POST['nickname'],'投稿者名'); //必須検証
    $validate->requiredCheck($_POST['comment'],'投稿内容'); //必須検証
    $validate->lengthCheck($_POST['nickname'],'投稿者名',255); //文字列長検証
    $validate->lengthCheck($_POST['comment'],'投稿内容',255); //文字列長検証


    if($validate->isErrorMessageExist()){ //エラーがあったら
        $errorMessage = $validate->geterrorMessage();
        print '<div class="errormsg">';
        foreach ((array)$errorMessage as $message) {
            print $message;
            print '<br>';
        }
        print '</div>';
        ?>
        <!-- エラーのときに表示する -->
        <form method="POST" action="post.php">
            <dl>
                <dt>投稿者：</dt>
                <dd><input type="text" name="nickname" value="<?php e($nickname); ?>"></dd>
                <dt>内容：</dt>
                <dd><textarea name="comment" rows="8" cols="40"><?php e($comment); ?></textarea></dd>
            </dl>
            <p class="btn"><button type="submit" name="btn1">投稿する</button></p>
        </form>

        <?php

    } else { //エラーがなかったら

        // 変数に代入
        $nickname = $_POST['nickname'];
        $comment = nl2br($_POST['comment']);

        try {
            // データベースへの接続を確立
            $db = getDb();
            // insert命令準備
            $stt = $db->prepare('INSERT INTO board(nickname, postdate, comment) VALUES(:nickname, :postdate, :comment)');
            // INSERT命令にポストデータの内容セット
            $stt->bindValue(':nickname', $nickname);
            $stt->bindValue(':postdate', $postDate);
            $stt->bindValue(':comment', $comment);
            // INSERT命令を実行
            $stt->execute();

?>
    <!-- 投稿が成功したときに表示 -->
    <div class="message">
        <p>以下内容が投稿されました</p>
    </div>
    <p class="nickname">投稿者:<?php e($nickname); ?></p>
    <div class="comment"><?php e($comment); ?></div>
    <p class="postdate"><?php e($postDate); ?></p>
    <form method="GET" action="post.php">
        <p class="btn"><button type="submit" name="btn1">投稿画面へ</button></p>
    </form>
    <form method="GET" action="index.php">
        <p class="btn"><button type="submit" name="btn2">一覧画面へ</button></p>
    </form>

<?php
            $db = NULL;
        } catch(PDOException $e) {
            die("エラーメッセージ：{$e->getMessage()}");
        }

    }//エラー有る無しのif文end

} else { //フォームからGETによって要求された場合(初めてフォームを開いたとき)

?>

<!-- GETのときに表示　-->
<form method="POST" action="post.php">
    <dl>
        <dt>投稿者：</dt>
        <dd><input type="text" name="nickname" value=""></dd>
        <dt>内容：</dt>
        <dd><textarea name="comment" rows="8" cols="40"></textarea></dd>
    </dl>
    <p class="btn"><button type="submit" name="btn1">投稿する</button></p>
</form>

<?php
} //フォームがPOSTかGETかのif文end
?>


</div>
</body>
</html>
