<?php
    session_start();
    
    if (isset($_SESSION['usuarioP']) && $_SESSION['usuarioP']!='')
    {
        $_SESSION["timeout"] = time();
        echo 1;
    }else{
        session_destroy();
        echo 0;
    }
    
?>