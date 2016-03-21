<?php
// 共通の設定を読み込む
require_once( '../data/utilities/common.php' );

// Smartyオブジェクト取得
$smarty =& getSmartyObj();

// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$smarty->assign( 'content_tpl', 'index.tpl' );

try {
    // データベースへの接続を確立
    $db = getDb();

    //　一覧を作る
    $sttw = $db->prepare('SELECT * FROM board ORDER BY id DESC');
    $sttw ->execute();
    //結果セットの内容を順に出力
    $count = 0;
    $postData = array();
    while($row = $sttw->fetch(PDO::FETCH_ASSOC)){
        $postData[] = $row;
        $count++;
    }
    //Smartyに結果セットの数を渡す
    $smarty->assign('count', $count);
    //Smartyにparamsという名前で配列を渡す
    $smarty->assign('params', $postData);

    $db = NULL;
} catch(PDOException $e) {
    die("エラーメッセージ：{$e->getMessage()}");
}
// ページを表示する
$smarty->display( 'site_frame.tpl' );
