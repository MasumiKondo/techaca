<?php
define( 'SMARTY_DIR', $_SERVER['DOCUMENT_ROOT'].'/techaca/board2/data/Smarty/' );
define( 'DATA_DIR', $_SERVER['DOCUMENT_ROOT'].'/techaca/board2/data/' );
// Smarty.classの呼び出し
require_once( SMARTY_DIR .'Smarty.class.php' );
// DBと接続(getDb関数の有効化)
require_once 'DbManager.php';
// フォームバリデータ
require_once 'MyValidator.php';


// Smartyインスタンスを生成（実際に利用出来るように実体化）
function & getSmartyObj(){
    static $smarty = null;

    if( is_null( $smarty ) ){
        $smarty = new Smarty();
        $smarty->template_dir = DATA_DIR .'templates/';
        $smarty->compile_dir  = DATA_DIR .'templates_c/';
        $smarty->config_dir   = DATA_DIR .'configs/';
        $smarty->cache_dir    = DATA_DIR .'cache/';
    }

    return $smarty;
}
