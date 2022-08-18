<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
$WLST_WP_current_folder = dirname(dirname(__FILE__));
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
if(!defined('WLST_WP_DIR')) define('WLST_WP_DIR', $WLST_WP_current_folder.DS);
define('WLST_WP_FILE', WLST_WP_DIR.'world-league-soccer-main.php');
require_once(WLST_WP_DIR.'classes'.DIRECTORY_SEPARATOR.'world-league-soccer-register.php');
require_once(WLST_WP_DIR.'classes'.DIRECTORY_SEPARATOR.'world-league-soccer-cron.php');
require_once(WLST_WP_DIR.'classes'.DIRECTORY_SEPARATOR.'world-league-soccer-controller.php');
require_once(WLST_WP_DIR.'classes'.DIRECTORY_SEPARATOR.'world-league-soccer-query.php');
require_once(WLST_WP_DIR.'classes'.DIRECTORY_SEPARATOR.'world-league-soccer-loadwidget.php');
require_once(WLST_WP_DIR.'classes'.DIRECTORY_SEPARATOR.'world-league-soccer-soccer.php');
require_once(WLST_WP_DIR.'lib'.DIRECTORY_SEPARATOR.'simple_html_dom.php');

?>
