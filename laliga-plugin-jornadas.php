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
  

//error_log("now is:" . date('d-m-y h:i:s'));

function my_task_function() {
    error_log ('Cron Task Function has been called!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
    $content = "some text here";
    $fp = fopen("/tmp/myText.txt","wb");
    fwrite($fp,$content);
    fclose($fp);
}

function registerCSS () {
    wp_register_style('laliga_style', plugins_url('laliga.css',WPTEST_DIR.'css'.DS.'laliga.css'));
    wp_enqueue_style('laliga_style');        
}

//Enable cron and fire function
add_filter( 'cron_schedules', 'LaLigaCron::my_cron_schedules' );
LaLigaCron::enableCron();
add_action ( 'my_task_hook', ['LaLigaCron','my_task_function' ]);

//Enable plugin start/stop
register_activation_hook(WPTEST_FILE, array( 'wp_pt_registerhook', 'activation' ));
register_deactivation_hook(WPTEST_FILE, array( 'wp_pt_registerhook', 'deactivation' ));

//Enable read variables from request
add_shortcode('laligaresultados', 'LaLigaLoadWidget::laliga_shortcode_int');
add_filter( 'query_vars', 'add_query_vars_filter' );

//Register scripts and css
add_action('wp_enqueue_scripts', 'registerCSS');


//DEBUG CALLS
//Load Image from plugin: 
//esc_url(plugins_url( 'images/image.png', __FILE__ ));
//'<img src="' .$img . '" width="300" height="300"> </img>';
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
