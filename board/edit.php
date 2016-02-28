<?php
// DBと接続(getDb関数の有効化)
require_once 'DbManager.php';
// エスケープ処理(e関数の有効化)
require_once 'Encode.php';

try {
    // データベースへの接続を確立
    $db = getDb();
    // deleteボタン
    if ( $_SERVER["REQUEST_METHOD"] === "POST" ) {
        $id = $_POST["id"];
        $sttd = $db->prepare("DELETE FROM board WHERE id = $id");
        $sttd ->execute();
    }
    $db = NULL;
} catch(PDOException $e) {
    die("エラーメッセージ：{$e->getMessage()}");
}
// 処理後は元のフォームにリダイレクト
 header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/board.php');
