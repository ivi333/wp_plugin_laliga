<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class wlsc_wp_Controller
{
    static $urls_laliga = array ();

    static function init () {
        //static initialization        
        $tmp = array();
        for ($i = 1; $i <= 38; $i++) {
            array_push ($tmp, "https://www.laliga.com/laliga-santander/resultados/2022-23/jornada-" . $i);
        }
        wlsc_wp_Controller::$urls_laliga = $tmp;
    }

    public static function reloadJornadas () {
        wlsc_wp_Query::truncateJornadas ();
        $z=1;
        foreach (wlsc_wp_Controller::$urls_laliga as $url) {
            error_log ("Processing " . $url);
            $json_resp = wlsc_wp_Controller::getJornada ($url);
            if (isset($json_resp)) {                
                wlsc_wp_Query::saveJornada($z++, json_encode($json_resp, JSON_UNESCAPED_UNICODE ));
            }
        }
    }

    public static function getAllJornadas () { 
        $res = array();
        $z=1;
        foreach (wlsc_wp_Controller::$urls_laliga as $url) {
            //echo "Parsing:" . $url . "<br/>";
            $json_resp = wlsc_wp_Controller::getJornada ($url);
            $res["jornada" . $z++]=$json_resp;
        }
        //FOR DEBUG
        //echo json_encode($res, JSON_UNESCAPED_UNICODE);
        return json_encode($res, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getJornada ($url) {                
        //Check if url exists with wp_remote_get as file_get_html cannot verify it
        $response = wp_remote_get($url);
        $http_code = wp_remote_retrieve_response_code( $response );        
        $html = null;
        if ($http_code === 200) {
            try {        
                $html = file_get_html($url);
            } catch (Throwable  $t) {
                //TODO If error occurs exception is never captured :(
                echo 'Error captured:' . $t;            
            }
        } else {
            return null;
        }

        // find all table (index=0 means the first one)
        $table = $html->find('table',0);
        $z=0;
        $jornada = array();        
        foreach($table->find('tr') as $e) {
            //Get table columns td, discard rubbish
            $size = count($e->find ('td'));
            if ($size > 1) {            
                $fecha = $e->find('td', 1)->plaintext;
                $horario = $e->find('td', 2)->plaintext;
                $partido = $e->find('td', 4)->plaintext;
                $arbitro = $e->find('td', 5)->plaintext;
                $operador = $e->find('td', 6)->plaintext;                
                $encuentro = 
                [
                    "fecha" => str_replace("\n","", trim($fecha)),
                    "horario" => str_replace("\n","", trim($horario)),
                    "partido" => str_replace("\n","", trim($partido)),
                    "arbitro" => str_replace("\n","", trim($arbitro)),
                    "operador" => str_replace("\n","", trim($operador))
                ];                
                array_push ($jornada, $encuentro);                

                //echo $e->plaintext . "<br/>";
                /* FOR DEBUG
                echo "<pre>" . "Fila " . $z++ . "</pre>";
                echo "fecha:" . $fecha . "<br/>";
                echo "horario:" . $horario . "<br/>";
                echo "partido:" . $partido . "<br/>";
                echo "arbitro:" . $arbitro . "<br/>";
                echo "operador:" . $operador . "<br/>"; 
                */
            }
        }
        /* FOR DEBUG        
        echo "<pre>" . "Jornada 1 </pre>";
        echo json_encode($jornada, JSON_UNESCAPED_UNICODE );
        error_log (json_encode($jornada, JSON_UNESCAPED_UNICODE ));
        */        
        return $jornada;        
    }
}

wlsc_wp_Controller::init();

