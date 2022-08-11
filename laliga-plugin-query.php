<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class LaLigaQuery
{

    // Plugin tables		
    public static $array_tables_to_plugin = array('laliga_jornadas');

    public function __construct () {

    }
    
    public static function pluginActivation () {
		global $wpdb;
		$prefix = $wpdb->prefix;
        
		$errors = array();
		
		// loading the sql file, load it and separate the queries
		$sql_file = WPTEST_DIR.'sql'.DS.'la-liga-tbl.sql';		
		$prefix = $wpdb->prefix;
        $handle = fopen($sql_file, 'r');
        $query = fread($handle, filesize($sql_file));
        fclose($handle);
        $query=str_replace('CREATE TABLE IF NOT EXISTS `','CREATE TABLE IF NOT EXISTS `'.$prefix, $query);
        $queries=explode('-- SQLQUERY ---', $query);

        // run the queries one by one
        $has_errors = false;
        foreach($queries as $qry)
		{
            $wpdb->query($qry);
        }
		
		// list the tables that haven't been created
        $missingtables=array();
        foreach(LaLigaQuery::$array_tables_to_plugin as $table_name)
		{
			if(strtoupper($wpdb->get_var("SHOW TABLES like  '". $prefix.$table_name . "'")) != strtoupper($prefix.$table_name))  
			{
                $missingtables[] = $prefix.$table_name;
            }
        }
		
		// add error in to array variable
        if($missingtables) 
		{
			$errors[] = __('These tables could not be created on installation ' . implode(', ',$missingtables), TCHSP_TDOMAIN);
            $has_errors=true;
        }
		
		// if error call wp_die()
        if($has_errors) 
		{
			wp_die( __( $errors[0] , TCHSP_TDOMAIN ) );
			return false;
		}
		else
		{
            LaLigaQuery::loadInitData();
		}
        return true;        
    }

    public static function loadInitData () {
        //truncate + get data from service + save in DB
        LaLigaController::reloadJornadas();
    }

    public static function saveJornada ($jornada_id, $jsonEncoded) {
        global $wpdb;
		$prefix = $wpdb->prefix;
        $table = "laliga_jornadas";
        $sql = $wpdb->prepare("INSERT INTO `".$prefix."$table` (`title`,`resultados`)        
        VALUES (%s, %s)", array("jornada" .$jornada_id, $jsonEncoded));
        $wpdb->query($sql);
    }

    public static function getJornada ($id = 1) {
		global $wpdb;
		$prefix = $wpdb->prefix;
        //$table = "laliga_jornadas";
        $arrRes = array();
        $sSql = $wpdb->prepare("SELECT * FROM `".$prefix."laliga_jornadas` where `id` = %d", array($id));

        //$sSql = $wpdb->prepare("SELECT * FROM `".$prefix."tinycarousel_image` where img_gal_id = %d and img_display = 'YES' ORDER BY rand()", array($id));

        $arrRes = $wpdb->get_results($sSql, ARRAY_A);
        return $arrRes;
    }    

    public static function jornadasCount () {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $result = 0;
        $sSql = "SELECT COUNT(*) AS `count` FROM `".$prefix."laliga_jornadas`";
        $result = $wpdb->get_var($sSql);
        return $result;
    }

    public static function truncateTable ($table) {
        global $wpdb;
		$prefix = $wpdb->prefix;
        //truncate tables
        if (LaLigaQuery::hashData($table)) {
            //erase data
            $table_name = $prefix . $table;
            $truncate = "TRUNCATE TABLE  " . $table_name;
            $wpdb->query($truncate);            
        }
    }

    public static function truncateJornadas () {
        LaLigaQuery::truncateTable ("laliga_jornadas");
    }

    public static function hashData($table)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$result = 0;		
        $sSql = "SELECT COUNT(*) AS `count` FROM `".$prefix."$table`";
		$result = $wpdb->get_var($sSql);
		return $result;
	}

    public static function pluginDeactivation () {
        global $wpdb;
		$prefix = $wpdb->prefix;
        // Plugin tables
        foreach (LaLigaQuery::$array_tables_to_plugin as $table ) {
            $table_name = $prefix . $table;
            $drop = "DROP TABLE IF EXISTS " . $table_name;
            $wpdb->query($drop);            
        }
    }

}
?>