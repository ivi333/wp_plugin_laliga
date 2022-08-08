<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
$WPTEST_current_folder = dirname(__FILE__);
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
if(!defined('WPTEST_DIR')) define('WPTEST_DIR', $WPTEST_current_folder.DS);
define('WPTEST_FILE', WPTEST_DIR.'laliga-plugin-jornadas.php');
require_once(WPTEST_DIR.'laliga-plugin-register.php');
require_once(WPTEST_DIR.'laliga-plugin-cron.php');
require_once(WPTEST_DIR.'laliga-plugin-controller.php');
require_once(WPTEST_DIR.'laliga-plugin-query.php');
require_once(WPTEST_DIR.'laliga-plugin-loadwidget.php');
require_once(WPTEST_DIR.'lib'.DIRECTORY_SEPARATOR.'simple_html_dom.php');
?>
