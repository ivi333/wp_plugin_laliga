<?php
/*
Plugin Name: La Liga Resultados
Plugin URI: https://todo.com
Description: Resultados Liga Española
Version: 1.0
Author: Ivan Gomez
Author URI: https://todo.com
License: GPLv2 or later
Text Domain: laligaresultados
*/

// Restrict direct file access
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

// Plugin starter
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'laliga-plugin-starter.php');

function add_query_vars_filter( $vars ){
    $vars[] = "week";
    return $vars;
}
  
function ivan_wordpress_plugin_demo($atts) {
	$Content = "<style>\r\n";
	$Content .= "h3.demoClass {\r\n";
	$Content .= "color: #26b158;\r\n";
	$Content .= "}\r\n";
	$Content .= "</style>\r\n";
	$Content .= '<h3 class="demoClass">Check it out!</h3>';
    //error_log ("ivan wordpress plugin demo attrs:" . $atts);
    echo "<pre > ID = " . get_query_var('week') . "</pre>";
    return $Content;
}

//https://www.jnorton.co.uk/wordpress-tutorial-cron-jobs-scheduled-tasks

/*function my_cron_schedules($schedules){
    if(!isset($schedules["2min"])){
        $schedules["2min"] = array(
            'interval' => 2*60,
            'display' => __('Once every 2 minutes'));
    }
    if(!isset($schedules["70sec"])){
        $schedules["70sec"] = array(
            'interval' => 70,
            'display' => __('Once Every 70 seconds'));
    }
    return $schedules;
}    

function my_task_function() {
    error_log ('Cron Task Function has been called!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
    $content = "some text here";
    $fp = fopen("/tmp/myText.txt","wb");
    fwrite($fp,$content);
    fclose($fp);
}

//error_log ("disable_wp_cron:" . DISABLE_WP_CRON);
//error_log (print_r(_get_cron_array()));
//error_log ("time:" . time());

error_log("now is:" . date('d-m-y h:i:s'));

add_filter('cron_schedules','my_cron_schedules');
if (!wp_next_scheduled('my_task_hook')) {
    error_log ('Scheduling my_task_hook!!');
    wp_schedule_event( time(), '2min', 'my_task_hook' );
} else {
    error_log ('my_task_hook was already scheduled!');
}
add_action ( 'my_task_hook', 'my_task_function');
*/


function my_task_function() {
    error_log ('Cron Task Function has been called!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
    $content = "some text here";
    $fp = fopen("/tmp/myText.txt","wb");
    fwrite($fp,$content);
    fclose($fp);
}

add_filter( 'cron_schedules', 'LaLigaCron::my_cron_schedules' );
LaLigaCron::enableCron();
add_action ( 'my_task_hook', ['LaLigaCron','my_task_function' ]);

register_activation_hook(WPTEST_FILE, array( 'wp_pt_registerhook', 'activation' ));
register_deactivation_hook(WPTEST_FILE, array( 'wp_pt_registerhook', 'deactivation' ));

add_shortcode('ivan-plugin-demo', 'ivan_wordpress_plugin_demo');
add_filter( 'query_vars', 'add_query_vars_filter' );

//LaLigaController::getJornada("https://www.laliga.com/laliga-santander/resultados/2022-23/jornada-1");
/*LaLigaController::getAllJornadas(
    array
    (
        "https://www.laliga.com/laliga-santander/resultados/2022-23/jornada-1",
        "https://www.laliga.com/laliga-santander/resultados/2022-23/jornada-2"
    )
);*/
//LaLigaQuery::pluginActivation();
//WordPressHttpContent::simplehtmldom();
//LaLigaQuery::loadInitData();
//LaLigaController::reloadJornadas();