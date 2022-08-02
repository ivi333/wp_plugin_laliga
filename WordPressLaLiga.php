<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class WordPressLaLiga
{

    public function __construct () {
    }

    public static function getAllJornadas ($urls) { 
        $res = array();
        $z=1;
        foreach ($urls as $url) {
            echo "Parsing:" . $url . "<br/>";
            $json_resp = WordPressLaLiga::getJornada ($url);
            $res["jornada" . $z++]=$json_resp;
        }
        
        echo json_encode($res, JSON_UNESCAPED_UNICODE );        
    }
    

    public static function getJornada ($url) {        
        
        /*$body = wp_remote_retrieve_body ($response);                
        $string = <<<XML
            <a>
            <b>
            <c>texto</c>
            <c>cosas</c>
            </b>
            <d>
            <c>código</c>
            </d>
            </a>
            XML;
            */
        //$xpath = new DOMXpath($body);
        //$xml = new SimpleXMLElement($string);
        //$x = $xml->xpath("//body");
        //$x = $xml->xpath("/a/b/c");
        //error_log (print_r($x));

        /*$doc = new DOMDocument();
        $doc->loadHTML($body);
        $sxml = simplexml_import_dom($doc);
        $x = $sxml->xpath("//body");
        //error_log (print_r($x));*/

        /*$doc = new DOMDocument();
        $doc->loadHTML($body);
        $xpath = new DOMXPath($doc);
        $x = $xpath->xpath("//body");
        error_log ($x);*/

        //Comprobar que la url existe
        $response = wp_remote_get($url);
        $http_code = wp_remote_retrieve_response_code( $response );        
        $html = null;
        if ($http_code === 200) {
            try {        
                $html = file_get_html($url);
            } catch (\nThrowable  $t) {
                //Exception not captured :(
                echo 'Error captured:' . $t;            
            }
        } else {
            return;
        }

        // find all table (index=0 means the first one)
        $table = $html->find('table',0);
        $z=0;
        $jornada = array();        
        foreach($table->find('tr') as $e) {
            //Numero de columnas, discard rubbish
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
                echo "<pre>" . "Fila " . $z++ . "</pre>";
                echo "fecha:" . $fecha . "<br/>";
                echo "horario:" . $horario . "<br/>";
                echo "partido:" . $partido . "<br/>";
                echo "arbitro:" . $arbitro . "<br/>";
                echo "operador:" . $operador . "<br/>";                
            }
        }
        /*echo "<pre>" . "Jornada 1 </pre>";
        echo json_encode($jornada, JSON_UNESCAPED_UNICODE );
        error_log (json_encode($jornada, JSON_UNESCAPED_UNICODE ));        */
        return $jornada;
        /*echo "size:" . count($html->find('table',1));
        echo "<br/>";
        foreach($html->find('table') as $e) 
            echo $e->plaintext;
        */

        //echo $html->plaintext;
    }

    public static function simplehtmldom () {
        // get DOM from URL or file
        $html = file_get_html('http://www.google.com/');

        // find all link
        foreach($html->find('a') as $e) 
            echo $e->href . '<br>';

        // find all image
        foreach($html->find('img') as $e)
            echo $e->src . '<br>';

        // find all image with full tag
        foreach($html->find('img') as $e)
            echo $e->outertext . '<br>';

        // find all div tags with id=gbar
        foreach($html->find('div#gbar') as $e)
            echo $e->innertext . '<br>';

        // find all span tags with class=gb1
        foreach($html->find('span.gb1') as $e)
            echo $e->outertext . '<br>';

        // find all td tags with attribite align=center
        foreach($html->find('td[align=center]') as $e)
            echo $e->innertext . '<br>';
            
        // extract text from table
        echo $html->find('td[align="center"]', 1)->plaintext.'<br><hr>';

        // extract text from HTML
        echo $html->plaintext;
    }

}


