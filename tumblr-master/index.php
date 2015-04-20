<?php
session_start();
define( 'ABSPATH', dirname(__FILE__) );
include_once (ABSPATH.DIRECTORY_SEPARATOR.'conf'.DIRECTORY_SEPARATOR.'_connect.php');

$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRIPPED);

include_once (VIEW_DIR.'header.php');

if(file_exists(VIEW_DIR.$page.'.php')) {
    include_once (VIEW_DIR.$page.'.php');
} else {
    include_once (VIEW_DIR.'default.php');
}


include_once (VIEW_DIR.'footer.php');
?>
