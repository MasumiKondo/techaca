<?php
// 共通の設定を読み込む
require_once( '../data/utilities/common.php' );

// Smartyオブジェクト取得
$smarty =& getSmartyObj();

// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$smarty->assign( 'content_tpl', 'post.tpl' );

//初期化
$nickname = "";
$comment = "";
$now = new DateTime();
$postDate = $now -> format('Y-m-d H:i:s');
$errorMessage = array();
$isSuccess = false ;
$smarty->assign( 'params', NULL );


if ( $_SERVER["REQUEST_METHOD"] === "POST" ) {// フォームからPOSTによって要求された場合

    //バリデータ
    $validate = new MyValidator();
    $validate->requiredCheck($_POST['nickname'],'投稿者名'); //必須検証
    $validate->requiredCheck($_POST['comment'],'投稿内容'); //必須検証
    $validate->lengthCheck($_POST['nickname'],'投稿者名',255); //文字列長検証
    $validate->lengthCheck($_POST['comment'],'投稿内容',255); //文字列長検証


    if($validate->isErrorMessageExist()){ //エラーがあったら
        $errorMessage = $validate->geterrorMessage();
        //SmartyにerrorMessageという名前で配列を渡す
        $smarty->assign('errorMessage', $errorMessage);

    } else { //エラーがなかったら

        // 変数に代入
        $nickname = $_POST['nickname'];
        $comment = $_POST['comment'];

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

            // 処理成功フラグ
            $isSuccess = true ;

            $db = NULL;
        } catch(PDOException $e) {
            die("エラーメッセージ：{$e->getMessage()}");
        }

    }//エラー有る無しのif文end

    // Smartyテンプレートに渡すパラメータ配列
    // POSTされたデータを入れる(表示用)
    $params = array(
        'nickname' => $_POST['nickname'],
        'comment' => $_POST['comment'],
        'postDate' => $postDate,
        'isSuccess' => $isSuccess
    );
    $smarty->assign( 'params', $params );
}

$smarty->display( 'site_frame.tpl' );
