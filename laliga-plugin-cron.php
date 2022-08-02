<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class LaLigaCron
{
    public function __construct () {

    }

    public static function my_task_function() {
        error_log('Cron Task Function has been called!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
    }

    public static function enableCron () {
        //add_filter( 'cron_schedules', [ $this, 'my_cron_schedules' ] );
        if (!wp_next_scheduled('my_task_hook')) {
            error_log ("Schedule my_task_hook");
            wp_schedule_event( time(), '2min', 'my_task_hook' );
        } else {
            error_log ("Already scheduled my_task_hook");
        }
        //add_action ( 'my_task_hook', [$this, 'my_task_function'] );
    }

    public static function disableCron () {        	
        error_log ("Plugin Deactivation Test Dummy!");        
        if (wp_next_scheduled('my_task_hook')) {
            error_log ("disable existing cron!");
            $timestamp = wp_next_scheduled( 'my_task_hook' );
            wp_unschedule_event( $timestamp, 'bl_cron_hook' );
        } else {
            error_log ("my_task_hook dont exist!");
        }
    }

    public static function my_cron_schedules($schedules){
        if(!isset($schedules["5min"])){
            $schedules["5min"] = array(
                'interval' => 5*60,
                'display' => __('Once every 5 minutes'));
        }
        if(!isset($schedules["2min"])){
            $schedules["2min"] = array(
                'interval' => 120,
                'display' => __('Once Every 2 minutes'));
        }
        return $schedules;
    }    
    
}

?>