<?php
    session_start();
    include('../models/Proveedores.php');
    
    $idProveedor = $_REQUEST['idProveedor'];

    $modeloProveedores = new Proveedores();
    
    echo $resultado = $modeloProveedores->buscarProveedoresId($idProveedor);
  
 	
?>