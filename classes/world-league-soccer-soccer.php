<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
if ( !class_exists('wlsc_wp_Soccer') ) {
    class wlsc_wp_Soccer {

        public static $BASE_URL = "https://es.soccerway.com/";

        public static function loadTeams () {                          
            $url = "https://es.soccerway.com/competitions/club-domestic/";
            $response = wp_remote_get(
                $url, 
                array( 
                    'method' => 'GET', 
                    'timeout' => 10, 
                    'redirection' => 2
                    ) 
                );
            if( !is_wp_error( $response ) ) {
                try {                
                    $html = str_get_html ($response['body']);
                    $z=0;
                    foreach ($html->find("div.content.competitions.index",0)->find("a") as $e) {
                        if ($z++>0) {
                            break;
                        }                        
                        $id = wlsc_wp_Soccer::getTeamID ($e->href);
                        echo (trim($e->plaintext) . ' = ' . $e->href . 'id=' . $id . '<br>');
                        sleep (2);
                    }
                } catch (Throwable  $t) {
                    echo 'Error captured:' . $t;
                }
            } else {
                print ("remote_get_failed:" . $response->get_error_message());
            }            
        }

        public static function getTeamID ($url) {            
            $id="not_found";
            try {                
                $response = wp_remote_get(
                    wlsc_wp_Soccer::$BASE_URL . $url, 
                    array( 
                        'method' => 'GET', 
                        'timeout' => 10, 
                        'redirection' => 5
                        ) 
                    );
                if( !is_wp_error( $response ) ) {
                    $html = str_get_html ($response['body']);                    
                    $link = $html->find ('link[rel=canonical]',0);
                    if (!empty($link)){
                        $id = substr((basename($link->href)),1);
                        if (!is_int($id)) {
                            $id = basename($link->href);
                        }
                    }
                }
            } catch (Throwable  $t) {
                echo 'Error captured:' . $t; 
            }
            if ($id == "not_found") {
                error_log ("Error fetching TeamId from:" . $url);
            }
            return $id;
        }
    }
}