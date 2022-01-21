<?php

include "general.php";

if(isset($_POST['SubmitButton'])){

    generaExcelDashFinanzas($_POST["query"]);
    // print_r(queryResult($_POST["query"]));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>IT Helper</title>
</head>
<body>
    <div class="container">
        <form action="" method="post">
            <div class="form-group">
                <textarea class="form-control" name="query" rows="10"></textarea>
            </div>
            <input type="submit" value="Excel" name="SubmitButton" class="btn btn-success btn-lg">         
        </form>
    </div>
    
</body>
</html>