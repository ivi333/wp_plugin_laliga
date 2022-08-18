<?php
/*
Plugin Name: Soccer World Leagues
Plugin URI: https://todo.com
Description: Show information about your prefered leagues around the world
Version: 1.0
Author: Ivan Gomez
Author URI: https://todo.com
License: GPLv2 or later
Text Domain: world-league-soccer
Domain Path: /lang
*/

// Restrict direct file access
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

// Plugin starter
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'world-league-soccer-starter.php');

function add_query_vars_filter( $vars ){
    $vars[] = "week";
    return $vars;
}
  
//error_log("now is:" . date('d-m-y h:i:s'));

function my_task_function() {
    error_log ('Cron Task Function has been called!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
    $content = "some text here";
    $fp = fopen("/tmp/myText.txt","wb");
    fwrite($fp,$content);
    fclose($fp);
}

function registerCSS () {
    wp_register_style('word-league-soccer_style', plugins_url('word-league-soccer.css',WLST_WP_DIR.'css'.DS.'word-league-soccer.css'));
    wp_enqueue_style('word-league-soccer_style');        
}

//Enable cron and fire function
add_filter( 'cron_schedules', 'wlsc_wp_Cron::my_cron_schedules' );
wlsc_wp_Cron::enableCron();
add_action ( 'my_task_hook', ['wlsc_wp_Cron','my_task_function' ]);

//Enable plugin start/stop
register_activation_hook(WLST_WP_FILE, array( 'wp_pt_registerhook', 'activation' ));
register_deactivation_hook(WLST_WP_FILE, array( 'wp_pt_registerhook', 'deactivation' ));

//Enable read variables from request
add_shortcode('world-league-soccer', 'wlsc_wp_LoadWidget::laliga_shortcode_int');
add_filter( 'query_vars', 'add_query_vars_filter' );

//Register scripts and css
add_action('wp_enqueue_scripts', 'registerCSS');

// For localization
function laliga_textdomain() 
{
	  load_plugin_textdomain('world-league-soccer' , false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
}
add_action('init', 'laliga_textdomain');


//DEBUG CALLS
//Load Image from plugin: 
//esc_url(plugins_url( 'images/image.png', __FILE__ ));
//'<img src="' .$img . '" width="300" height="300"> </img>';
//wlsc_wp_Controller::getJornada("https://www.laliga.com/laliga-santander/resultados/2022-23/jornada-1");
/*wlsc_wp_Controller::getAllJornadas(
    array
    (
        "https://www.laliga.com/laliga-santander/resultados/2022-23/jornada-1",
        "https://www.laliga.com/laliga-santander/resultados/2022-23/jornada-2"
    )
);*/
//wlsc_wp_Query::pluginActivation();
//WordPressHttpContent::simplehtmldom();
//wlsc_wp_Query::loadInitData();
//wlsc_wp_Controller::reloadJornadas();
