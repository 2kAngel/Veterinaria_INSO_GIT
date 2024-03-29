<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

    session_start();
    include 'conexion_bd.php';
    
    function mandarDatos($tipoTrata, $precioTrata, &$error)
    {
        include 'conexion_bd.php';

        $idTrata = null;
        
        $queryInsert="INSERT INTO tratamiento (idTrata, tipoTrata, precioTrata) 
                      VALUES ('$idTrata', '$tipoTrata', '$precioTrata' );";
         
        if(!mysqli_query($conex, $queryInsert)){
            $error ="Datos introducidos no válidos";
            return false;
        }
        return true;
          
    }
    
    function drawForm($tipoTrata, $precioTrata,$error)
    {
        print  "<form action='registrar_tratamiento.php' method='post'>";
        
        $form2=<<<FORMULARIO
 
                <h2>
                Tipo tratamiento
                <input name="tipoTrata" type="text" value="$tipoTrata">
                <br>
                Precio tratamiento
                <input name="precioTrata" type="float" value="$precioTrata">
                <br>
                <br>
                $error
                </h2>
                <br>
                <br>
                <input type="submit" name="Submit" value="Añadir">
    </form>
                
FORMULARIO;
        
        $formFinal=$form2;

        print $formFinal;
                
        print "</form>";
               
    }
    
    function validar( &$tipoTrata, &$precioTrata, &$error)
    {
        $valido = true;
        
         if ($tipoTrata == "")
        {
            $error = $error."Formato número tipo tratamiento incorrecto /";
            $tipoTrata = "";
            $valido = false;
        }
        
        $precioVal = floatval($precioTrata);  //$importeVal = intval($importe);

        if ($precioVal < 0 )
        {
            $error = $error."Precio invalido";
            $valido = false;
            $precioTrata = "";
        }else if($precioVal == 0){
            $error = $error."Precio Sin ganancias (0)";
            $valido = false;
            $precioTrata = "";
        }
        return $valido;
    }
    
    
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
<?php

    include 'conexion_bd.php';	
    
/*RUTINA PRINCIPAL*/
    if (empty($_POST)){
        $tipoTrata="";
        $precioTrata= 0;
        $error = "";
    }else{
        $tipoTrata =  $_POST["tipoTrata"];
        $precioTrata =  $_POST["precioTrata"];
        
    }
    
    $error = '';
    
    if (empty($_POST))/*Rutina inicial*/
    {
       drawForm( $tipoTrata, $precioTrata, $error);
    }else{/*Rutina segunda vuelta*/
        if(validar( $tipoTrata, $precioTrata, $error)){
            if(mandarDatos( $tipoTrata, $precioTrata, $error)){           
                header("Location: menuVeterinario.php");
            }
        }
        else{
            print $error;    
            drawForm( $tipoTrata, $precioTrata, $error);
        }
    }
?>
    <style type="text/css">
        .error{
            border-color: red;
        }
        
    </style>
    
    </body>
</html>
