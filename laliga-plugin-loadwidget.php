<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class LaLigaLoadWidget {

    public static function laliga_shortcode_int ($arr) {

        /*$Content = "<style>\r\n";
        $Content .= "h3.demoClass {\r\n";
        $Content .= "color: #26b158;\r\n";
        $Content .= "}\r\n";
        $Content .= "</style>\r\n";*/
        
        $Content = '<h3 class="demoClass">Check it out 333!</h3>';
        //error_log ("ivan wordpress plugin demo attrs:" . $atts);
        echo "<pre > ID = " . get_query_var('week') . "</pre>";
        $Content .=  '<div class="flexcontainer">';
            $Content .= '<div class="item laliga-jornadas extra">';
                $Content .= 'JORNADA <span style="font-size:28px; font-weight:bold" class="success">1</span>';
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
            $Content .= '<div class="item laliga-resultados">';
                $Content .= '<div style="padding:3px;cursor:pointer;">';
                    $Content .= '<a href="#" title="Alineaciones probables" style="text-decoration: none;">';
                    $Content .= '<div class="box box-danger partido_jornada">';
                        $Content .= '<table cellpadding="0" cellspacing="0" width="100%" border="0">';
                            $Content .= '<tr>';
                                $Content .= '<td width="25%"><img src="https://www.comuniate.com/intranet/equipos/fotos/114_peq.jpg" alt="Osasuna" style="width:25px;"></td>';
                                $Content .= '<td width="50%" style="text-align: center;">';
                                    $Content .= '<span class="operador">';
                                        $Content .= '<img src="https://www.comuniate.com/images/tv/MOVISTAR.png" style="width:75px;">';
                                    $Content .= '</span>';
                                    $Content .= '<span class="horario">';
                                        $Content .= 'VIE <strong>21:00</strong>';
                                    $Content .= '</span>';
                                $Content .= '</td>';
                                $Content .= '<td width="25%"><img src="https://www.comuniate.com/intranet/equipos/fotos/15_peq.jpg" alt="Sevilla" style="width:25px;"></td>';
                            $Content .= '</tr>';
                        $Content .= '</table>';
                    $Content .= '</div>';
                $Content .= '</a>';
            $Content .= '</div>';
            $Content .= '</div>';        
        $Content .= '</div>';        

        return $Content;
    
    }

}

