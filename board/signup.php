<?php
// フォームバリデータ
require_once 'MyValidator.php';
// エスケープ処理(e関数の有効化)
require_once 'Encode.php';

//初期化
$userid = "";
$password = "";
if ( $_SERVER["REQUEST_METHOD"] === "POST" ) {
// フォームからPOSTによって要求された場合

    // フォームに入力されてるか確認
    if ( isset ( $_POST['userid'])  &&  isset ( $_POST['password']) ) {
        //バリデータ
        $v = new MyValidator();
        $v->requiredCheck($_POST['userid'],'ユーザーID'); //必須検証
        $v->duplicateCheck($_POST['userid'],'ユーザーID',
            'SELECT nam FROM member WHERE nam = :value'); //重複検証
        $v->requiredCheck($_POST['password'],'パスワード'); //必須検証
        $v();

        // 変数に代入
        $userid = $_POST['userid'];
        $password = $_POST['password'];
    } else {
        $_error[] = '入力してください';
    }
}
try {
    // データベースへの接続を確立
    $db = getDb();
    // insert命令準備
    $stt = $db->prepare('INSERT INTO member(nam, password) VALUES(:nam, :password)');
    // INSERT命令にポストデータの内容セット
    $stt->bindValue(':nam', $userid);
    $stt->bindValue(':password', $password);
    // INSERT命令を実行
    $stt->execute();
?>
<div class="message">
    <p>以下内容で登録しました</p>
</div>
<p class="userid">ユーザーID：<?php e($userid); ?></p>
<p class="password">パスワード：<?php e($password); ?></p>
<?php
    $db = NULL;
} catch(PDOException $e) {
    die("エラーメッセージ：{$e->getMessage()}");
}
// 処理後は元のフォームにリダイレクト
// header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php');

?>
<form method="POST" action="post.php">
    <p class="btn"><button type="submit" name="btn1">投稿画面へ</button></p>
</form>
<form method="POST" action="index.php">
    <p class="btn"><button type="submit" name="btn2">一覧画面へ</button></p>
</form>
</div>
</body>
</html>
