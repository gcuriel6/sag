<?php

session_start();

if(!isset($_SESSION["usuario"])){
    header('Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley');
    exit();
}

include "general.php";

if(isset($_POST['SubmitButton'])){
    
    // $resultado = queryResult($query);

    echo generaExcelDashFinanzas($_POST['query']);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Reporte</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12 my-3">
                <form action="" method="post">
                    <div class="form-group">
                        <textarea class="form-control" name="query" rows="20"></textarea>
                    </div>
                    <input type="submit" value="Excel" name="SubmitButton" class="btn btn-success btn-lg">
                </form>
            </div>
        </div>
    </div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
                        <?php

                            // if(isset($resultado)){
                            //     if(isset($resultado[0]["idRespuesta"])){
                            //         if($resultado[0]["idRespuesta"] != 0){
                            //             echo "<h1>No hay resultados</h1>";
                            //         }
                            //     }else{
                            //         echo "<table class='table'>
                            //                 <thead>
                            //                     <tr>";
                                    
                            //         $campos = array_keys($resultado[0]);
                            //         foreach ($campos as $valor) {                           
            
                            //             echo "<th scope='row'>$valor</th>";
                            //         }
                                    
                            //         echo "</tr>
                            //             </thead>
                            //             <tbody>";
    
                            //         foreach ($resultado as $valor) {
                            //             echo "<tr>";
            
                            //             foreach ($campos as $campo) {
                            //                 $string = $valor[$campo];
                            //                 echo "<td>$string</td>";
                            //             }
                            //             echo "</tr>";
                            //         }
            
                            //         echo "</tbody>
                            //         </table>";
                            //     }
                            // }else{
                            //     echo "<h1>No hay query</h1>";
                            // }
                        ?>
                
        </div>
    </div>
</div>
    
</body>
</html>