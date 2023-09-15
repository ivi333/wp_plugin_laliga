<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
if ( !class_exists('wlsc_wp_SoccerWay') ) {
    class wlsc_wp_SoccerWay {

        public static $BASE_URL = "https://es.soccerway.com/";
        
        public function fetchSesionTeam ($week) {
            $url = "https://es.soccerway.com/a/block_competition_matches_summary?block_id=page_competition_1_block_competition_matches_summary_9&action=changePage";
            //$url = "https://es.soccerway.com/a/block_competition_matches_summary?block_id=page_competition_1_block_competition_matches_summary_9&callback_params={\"page\":\"1\",\"block_service_id\":\"competition_summary_block_competitionmatchessummary\",\"round_id\":\"69450\",\"outgroup\":\"\",\"view\":\"1\",\"competition_id\":\"7\"}&action=changePage&params={\"page\":0}";

            $callbackParams = array();
            $callbackParams['page'] = 0;
            $callbackParams['block_service_id'] = 'competition_summary_block_competitionmatchessummary';
            $callbackParams['round_id'] = 69450;
            $callbackParams['outgroup'] = false;
            $callbackParams['view'] = $week;
            //$callbackParams['competition_id'] = 7; //Not required by now            
            $params = array();
            $params['page'] = 0;
            $callbackParamsJon = urlencode (json_encode($callbackParams, JSON_FORCE_OBJECT));
            $paramsJson = urlencode (json_encode($params, JSON_FORCE_OBJECT));            
            $url .= "&callback_params=" . $callbackParamsJon;
            $url .= "&params=" . $paramsJson;

            //echo ($url);

            $response = wp_remote_get(
                $url, 
                array( 
                    'method' => 'GET', 
                    'timeout' => 10, 
                    'redirection' => 2
                    ) 
                );
    
            print("<br/>");
            //print("<br/> is_wp_error:" . is_wp_error( $response ));
            if( !is_wp_error( $response ) ) {
                try {                
                    $json = json_decode($response['body']);
                    //echo json_encode($json, JSON_PRETTY_PRINT);                
                    $container = $json -> {'commands'}[0];
                    $content = $container->{'parameters'}->{'content'};
                    print ($content);
                } catch (Throwable  $t) {
                    echo 'Error captured:' . $t;
                }
            } else {
                print ("remote_get_failed:" . $response->get_error_message());
            }
    
        }

        public function loadTeams () {                          
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
                        $id = $this->getTeamID ($e->href);
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

        public function getTeamID ($url) {            
            $id="not_found";
            try {                
                $response = wp_remote_get(
                    $this::$BASE_URL . $url, 
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
    $soccer_way = new wlsc_wp_SoccerWay();
}