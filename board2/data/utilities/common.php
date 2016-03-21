<?php
define( 'SMARTY_DIR', '/Applications/MAMP/htdocs/techaca/board2/data/Smarty/' );
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
        $smarty->template_dir = '/Applications/MAMP/htdocs/techaca/board2/data/templates/';
        $smarty->compile_dir  = '/Applications/MAMP/htdocs/techaca/board2/data/templates_c/';
        $smarty->config_dir   = '/Applications/MAMP/htdocs/techaca/board2/data/configs/';
        $smarty->cache_dir    = '/Applications/MAMP/htdocs/techaca/board2/data/cache/';
    }

    return $smarty;
}
