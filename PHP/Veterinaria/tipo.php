<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
if (empty($_POST)){
        $tipoPro = "";
        $precio="";
        $error="";
    }else{
        $tipoPro = $_POST["tipoPro"];
        $precio=$_POST["precio"];
    }
    
    session_start();
    include 'conexion_bd.php';
    
    function mandarDatos(&$tipoPro, &$precio, &$error){
        include 'conexion_bd.php';

        $queryInsert="INSERT INTO `tipo` (`tipoPro`,`precio`) "
            ."VALUES ('$tipoPro','$precio');";
        if(!mysqli_query($conex,$queryInsert)){
            $error= "valores introducidos no válidos";
                    //mysqli_error($conex);/*Error en los datos de entrada*/
            return false;
        }
        return true;
        
    }
    
    function drawForm(&$tipoPro, &$precio, &$error){
        $form=<<<FORMULARIO
            <form action="tipo.php" method="post">
            <h2>  
FORMULARIO;
        
        if(!empty($_POST) && $tipoPro==""){ /***codrefen mal*/
            $form1=<<<FORM1
                Tipo de producto
                    <input name="tipoPro" type="text" value="$tipoPro" class="error">  
                    <br>
FORM1;
        }else{ /****************************codrefen bien*/
            $form1=<<<FORM1
                Tipo de producto
                <input name="tipoPro" type="text" value="$tipoPro">
                <br>
FORM1;
        }
        
        $form2=<<<FORMULARIO
                Precio
                <input name="precio" type="number" value="$precio">
                <br>
                </h2>
                <h3>$error </h3>
                <br>
                <br>
                <input type="submit" name="Submit" value="Añadir">
                
FORMULARIO;
        
        $formFinal=$form.$form1.$form2;

        print $formFinal;
    }
    
    function validar(&$tipoPro,&$error){
        if(!$tipoPro){
            $error="Error: El tipo de producto debe introducirse";
            return false;
        }
        return true;
    }

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
<?php
/*RUTINA PRINCIPAL*/

    $error = '';
    if (empty($_POST))/*Rutina inicial*/
    {
       drawForm($tipoPro, $precio, $error);
    }else{/*Rutina segunda vuelta*/
        if(validar($tipoPro,$error)){
            if(mandarDatos($tipoPro, $precio, $error)){
                header("Location: menuVeterinario.php");
            }
        drawForm($tipoPro, $precio, $error);
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
