<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class wp_pt_registerhook
{
    public static function activation()
    {
        error_log ("Plugin Activation LaLiga!");      
        //$cron = new WordPressCron ();
        //$cron ->enableCron();  
        //LaLigaQuery::pluginActivation();        
    }

    public static function deactivation()
    {
        error_log ("Plugin Dectivation LaLiga!");
        LaLigaCron::disableCron();  
        //LaLigaQuery::pluginDeactivation();
    }

}
?>