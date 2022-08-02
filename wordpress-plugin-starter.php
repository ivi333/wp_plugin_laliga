<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
$WPTEST_current_folder = dirname(__FILE__);
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
if(!defined('WPTEST_DIR')) define('WPTEST_DIR', $WPTEST_current_folder.DS);
define('WPTEST_FILE', WPTEST_DIR.'wordpress-plugin-test.php');
require_once(WPTEST_DIR.'wordpress-plugin-register.php');
require_once(WPTEST_DIR.'WordPressCron.php');
require_once(WPTEST_DIR.'WordPressLaLiga.php');
require_once(WPTEST_DIR.'simple_html_dom.php');
?>
