<?php

    $v = session_start();

    $verifica = 0;
    $inactividad = 900;
    $text = 'VERIFICANDO: ';
    if(isset($_SESSION["usuario"]) && $_SESSION["usuario"] != '')
    {

        $text .= 'S ->';
        $sessionTTL = time() - $_SESSION["timeout"];            
        if($sessionTTL > $inactividad)
            $text .= 'T -> ' . $sessionTTL;
        else
            $text .= 'X -> ' . $_SESSION["timeout"] . ' ***** ' . $sessionTTL;// .  date('H:i:s', $_SESSION["timeout"]);// ' ** ' . $sessionTTL;

    }

    echo '' . $text;
    
?>