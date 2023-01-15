<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

    session_start();
    include 'conexion_bd.php';
    
    function mandarDatos($idTrata, $tipoTrata, $precioTrata, $fechaTrata)
    {
        include 'conexion_bd.php';

        //$precio = floatval($precioTrata);
        //$id = intval($idTrata);
        
         $queryInsert="INSERT INTO tratamiento (idTrata, tipoTrata, precioTrata, fechaTrata) 
                      VALUES ('$idTrata', '$tipoTrata', '$precioTrata', '$fechaTrata' );";
         
        if(!mysqli_query($conex, $queryInsert)){

            return false;
        }
        return true;
          
    }
    
    function drawForm($idTrata, $tipoTrata, $precioTrata, $fechaTrata)
    {
        
    $form=<<<FORMULARIO
    <form action="registrar_tratamiento.php" method="post">
            <h1> REGISTRAR TRATAMIENTO </h1>
            <h2> 
FORMULARIO;
        
        if(!empty($_POST) && $idTrata==""){ /***codrefen mal*/
            $form1=<<<FORM1
                ID Tratamiento
                <input name="idTrata" type="number" value="$idTrata" class="error">  
                <br>
FORM1;
        }else{ /****************************codrefen bien*/
            $form1=<<<FORM1
               ID Tratamiento
                <input name="idTrata" type="number" value="$idTrata" class="error">  
                <br>
FORM1;
        }
        
        $form2=<<<FORMULARIO
                Tipo tratamiento
                <input name="tipoTrata" type="text" value="$tipoTrata">
                <br>
                Precio tratamiento
                <input name="precioTrata" type="float" value="$precioTrata">
                <br>
                Fecha tratamiento
                <input name="fechaTrata" type="date" value="$fechaTrata">
                <br>
                </h2>
                <br>
                <br>
                <input type="submit" name="Submit" value="Añadir">
    </form>
                
FORMULARIO;
        
        $formFinal=$form.$form1.$form2;

        print $formFinal;
                
               
    }
    
    function validar(&$idTrata, &$tipoTrata, &$precioTrata, &$fechaTrata, &$error)
    {
        $valido = true;
        
         if (($idTrata == "") || (!preg_match("/^[0-9]{5}/", $idTrata)))
        {
            $error = $error."Formato número tratamiento incorrecto /";
            $valido = false;
            $idTrata = "";
        }
        
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
        
        if ($fechaTrata == null){
            $error = $error."Fecha de creacion vacia";
            $valido = false;
            $fechaTrata = null;
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
        $idTrata = "";
        $tipoTrata="";
        $precioTrata= 0;
        $fechaTrata= null;
        $error = "";
    }else{
        $idTrata =  $_POST["idTrata"];
        $tipoTrata =  $_POST["tipoTrata"];
        $precioTrata =  $_POST["precioTrata"];
        $fechaTrata =  $_POST["fechaTrata"];
    }
    
    $error = '';
    
    if (empty($_POST))/*Rutina inicial*/
    {
       drawForm($idTrata, $tipoTrata, $precioTrata, $fechaTrata);
    }else{/*Rutina segunda vuelta*/
        if(validar($idTrata, $tipoTrata, $precioTrata, $fechaTrata, $error)){
            if(mandarDatos($idTrata, $tipoTrata, $precioTrata, $fechaTrata)){           
                header("Location: menuVeterinario.php");
            }
        }
        else{
            print $error;    
            drawForm($idTrata, $tipoTrata, $precioTrata, $fechaTrata);
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
