<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class LaLigaLoadWidget {


    public static function laliga_shortcode_int () {        
        LaLigaSoccer::loadTeams();
        print ("<br/>");
        _e ('Sesion','laligaresultados');
        return "";
    }

    public static function laliga_shortcode_int_OLD () {
        //echo "hello world <br/>";
        $Content = '<i class="escudo-sprite c-a-osasuna"></i>';
        $week = get_query_var('week');
        if ($week == null) {
            $week = 1;
        }
        $jornada = LaLigaQuery::getJornada ($week);
        //echo ("jornada:" . $jornada);
        //print_r ($jornada);
        echo "Count:" . count($jornada) . "<br/>";
        if (count($jornada) == 1) {
            $resultados = $jornada[0]['resultados'];
            $decode = json_decode($resultados, true);
            foreach ($decode as $res) {
                //print ($res['fecha'] . "<br/>");
                print_r ($res);
            }
            //print_r ($decode[0]);
            //print_r ($decode[1]);
            //print ($decode[0]->{'fecha'});            
            //foreach ($decode as $res ){
                //foreach ($res as $key => $value) {
                    //print ($key . "=" . $value . "<br/>");
                //}
                //print ($res->{'fecha'});
                //print ("<br/>");
            //}
        }         
        //$count = LaLigaQuery::jornadasCount ();
        //echo ("Count:" . $count);


        $url = "https://es.soccerway.com/a/block_competition_matches_summary?block_id=page_competition_1_block_competition_matches_summary_9&callback_params={\"page\":\"1\",\"block_service_id\":\"competition_summary_block_competitionmatchessummary\",\"round_id\":\"69450\",\"outgroup\":\"\",\"view\":\"1\",\"competition_id\":\"7\"}&action=changePage&params={\"page\":0}";
        //$url = "https://es.soccerway.com/national/spain/primera-division/20222023/regular-season/r69450/";
        $response = wp_remote_get(
            $url, 
            array( 
                'method' => 'GET', 
                'timeout' => 10, 
                'redirection' => 5,
                /*'httpversion' => '1.1',*/
                /*'headers' => $http_args,*/
                'body' => null,                
                'cookies' => array() ) 
            );

        print("<br/>");
        //print("<br/> is_wp_error:" . is_wp_error( $response ));
        if( !is_wp_error( $response ) ) {
            try {                
                $json = json_decode($response['body']);
                //echo json_encode($json, JSON_PRETTY_PRINT);                
                $container = $json -> {'commands'}[0];
                $content = $container->{'parameters'}->{'content'};
                //print ($content);
            } catch (Throwable  $t) {
                echo 'Error captured:' . $t;
            }
        } else {
            print ("remote_get_failed:" . $response->get_error_message());
        }
        
        _e ('Sesion','laligaresultados');

        return $Content;
    }

    public static function laliga_shortcode_int_GOOD () {        
        //error_log ("ivan wordpress plugin demo attrs:" . $atts);
        //echo "<pre > ID = " . get_query_var('week') . "</pre>";

        $week = get_query_var('week');
        if ($week == null) {
            $week = 1;
        }
        $jornada = LaLigaQuery::getJornada ($week);

        if (count($jornada) == 1) {
            $resultados = $jornada[0]['resultados'];
            $jsonResultados = json_decode($resultados, true);
            $numJornada = substr($jornada[0]['title'],7,1);
        } else {
            echo "Plugin not available <br/>";
            return;
        }
        
        $Content =  '<div class="flexcontainer">';
            $Content .= '<div class="item laliga-jornadas extra">';
                $Content .= _e ('Sesion','laligaresultados') . ' <span style="font-size:28px; font-weight:bold" class="success">'.$numJornada.'</span>';
            $Content .= '</div>';
            $Content .= '<div class="item laliga-jornadas">';
                $Content .= '<select class="form-control select select_partidos" onchange="#">';
                    $Content .= '<option value="2">Jornada 2</option>';            
                    $Content .= '<option value="1" selected="" style=" font-weight:bold">Cambiar</option>';
                $Content .= '</select>';
            $Content .= '</div>';  	
            $Content .= '</div>';  	
        $Content .= '</div>';  	
        
        //Load Jornadas Cards        
        $Content .= '<div class="container flexcontainer">';

            //for ($i = 1; $i <= 10; $i++) {        
            foreach ($jsonResultados as $res) {
            $Content .= '<div class="item laliga-resultados">';
                $Content .= '<div style="padding:3px;cursor:pointer;">';
                    $Content .= '<a href="#" title="Alineaciones probables" style="text-decoration: none;">';
                    $Content .= '<div class="box box-danger partido_jornada">';
                        $Content .= '<table cellpadding="0" cellspacing="0" width="100%" border="0">';
                            $Content .= '<tr>';
                                $Content .= '<td width="20%"><img src="https://www.comuniate.com/intranet/equipos/fotos/114_peq.jpg" alt="Osasuna" style="width:25px;"></td>';
                                $Content .= '<td width="60%" style="text-align: center;">';
                                    $Content .= '<span class="operador">';
                                        $Content .= '<img src="https://www.comuniate.com/images/tv/MOVISTAR.png" style="width:75px;">';
                                    $Content .= '</span>';
                                    $Content .= '<span class="horario">';
                                        $Content .= $res['fecha'].'<br/><strong>'.$res['horario'] .'</strong>';
                                    $Content .= '</span>';
                                $Content .= '</td>';
                                $Content .= '<td width="20%"><img src="https://www.comuniate.com/intranet/equipos/fotos/15_peq.jpg" alt="Sevilla" style="width:25px;"></td>';
                            $Content .= '</tr>';
                        $Content .= '</table>';
                    $Content .= '</div>';
                $Content .= '</a>';
            $Content .= '</div>';
            $Content .= '</div>';    
            }    
        $Content .= '</div>';        
        
        return $Content;
    
    }

}

