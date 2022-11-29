<?php

// $servername = "localhost";

function queryResult($query){
    $servername = "gintestcorp.com";
    $username = "pruebagi_sistemas";
    $password = "Pass123#$%.";
    $dbname = "pruebagi_ginthercorp";

    // print_r(array($servername, $username, $password, $dbname));

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($query);
    $arreglo = [];

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($arreglo, $row);
        }
    } else {
        array_push($arreglo, array('idRespuesta'=>'3', 'mensaje'=>'No hay registros'));
    }
    $conn->close();

    return $arreglo;

}

function generaExcelDashFinanzas($query){

    // $servername = "ginthersoft.com";
    $servername = "gintestcorp.com";
    $username = "pruebagi_sistemas";
    $password = "Pass123#$%.";
    $dbname = "pruebagi_ginthercorp";


    // $servername = "gintestcorp.com";
    // $servername = "localhost";
    // $username = "pruebagi_sistemas";
    // $password = "Pass123#$%.";
    // $dbname = "pruebagi_ginthercorp";

    $html='';

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $resultado = $conn->query($query);

    if($resultado){

        $registro = mysqli_fetch_array($resultado);
        $columnas = sizeof($registro)/2;
        $campos = array_keys($registro);
        $html.="<h4>&nbsp;&nbsp;&nbsp;&nbsp;Reporte</h4>";
        $html.="<table border='1'><thead><tr>";
        $cont=0;
        foreach($campos as $campo)
        {
            if(is_string($campo))
            {
            $campos2[$cont] = $campo;
        
            $html.="<td style='background-color:#002699;color:#ffffff;font-weight:bold;'>".$campo."</td>";
            $cont++;
            }
        }
        $html.="</tr></thead><tbody>";        
        
        $saldo=0;  
        while($registro = mysqli_fetch_array($resultado))
        {
            $html.="<tr class='renglon'>";

            foreach($campos2 as $field)
            {
                
                $texto = $registro[$field];

                $html.="<td valign='top'>" . $texto  . "</td>";
                        
            }

            $html.="</tr>";
        }

        $html.="</tbody></table>";
        
    }else{
        $html.="Error, en el Query";
    }

    header("Content-type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: filename=Reporte.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    return $html;
}//-- fin function generaExcel