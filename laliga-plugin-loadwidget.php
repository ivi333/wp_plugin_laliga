<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class LaLigaLoadWidget {


    public static function laliga_shortcode_int_TEST () {
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
        return $Content;
    }

    public static function laliga_shortcode_int () {        
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
                $Content .= 'JORNADA <span style="font-size:28px; font-weight:bold" class="success">'.$numJornada.'</span>';
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

