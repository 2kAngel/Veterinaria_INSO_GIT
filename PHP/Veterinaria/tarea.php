<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    if (empty($_POST)){
        $codRefen = "";
        $idMasc="";
        $tipoTarea="";
        $precio="";
        $error="";
    }else{
        $codRefen = $_POST["codRefen"];
        $idMasc=$_POST["idMasc"];
        $tipoTarea=$_POST["tipoTarea"];
        $precio=$_POST["precio"];
    }
    
    session_start();
    include 'conexion_bd.php';	
    
    function mandarDatos(&$codRefen, &$idMasc, &$tipoTarea,&$precio, &$error){
        include 'conexion_bd.php';

        $queryInsert="INSERT INTO `tarea` (`tipoTarea`,`idMasc`,`precio`,`idTarea`,`codRefen`) "
            ."VALUES ('$tipoTarea','$idMasc','$precio',NULL,'$codRefen');";
        if(!mysqli_query($conex,$queryInsert)){
            $error= //"valores introducidos no válidos";
                    mysqli_error($conex);/*Error en los datos de entrada*/
            return false;
        }
        $today=strval(date("d.m.y"));
        $queryInsert2="INSERT INTO `factura` (`codrefen`,`Fechafact`,`idMasc`,`idTarea`) "
            ."VALUES ('$codRefen','$today','$idMasc',1);";
        if(!mysqli_query($conex,$queryInsert2)){
            $error= $error.mysqli_error($conex);/*Error en los datos de entrada*/
            //$error= "valores introducidos no válidos";

            return false;
        }
        return true;
        
    }
    
    
    function drawForm(&$codRefen, &$idMasc, &$tipoTarea,&$precio, &$error){
        $form=<<<FORMULARIO
    <form action="tarea.php" method="post">
            <h2>
FORMULARIO;
    
        if(!empty($_POST) && $codRefen==""){ /***codrefen mal*/
            $form1=<<<FORM
                Código de referencia
                    <input name="codRefen" type="number" value="$codRefen" class="error">  
                    <br>
FORM;
        }else{ /****************************codrefen bien*/
            $form1=<<<FORM
            Código de referencia
                <input name="codRefen" type="number" value="$codRefen">
                <br>
FORM;
        }
        
        if(!empty($_POST) && $idMasc==""){ /***codrefen mal*/
            $form2=<<<FORM2
                Id de la mascota
                    <input name="idMasc" type="number" value="$idMasc" class="error">  
                    <br>
FORM2;
        }else{ /****************************codrefen bien*/
            $form2=<<<FORM2
                Id de la mascota
                <input name="idMasc" type="number" value="$idMasc">
                <br>
FORM2;
        }
        
        if(!empty($_POST) && $tipoTarea==""){ /***codrefen mal*/
            $form3=<<<FORM3
                Tipo de tarea
                    <input name="tipoTarea" type="text" value="$tipoTarea" class="error">  
                    <br>
FORM3;
        }else{ /****************************codrefen bien*/
            $form3=<<<FORM3
                Tipo de tarea
                <input name="tipoTarea" type="text" value="$tipoTarea">
                <br>
FORM3;
        }
    
    
        if(!empty($_POST) && $precio==""){ /***codrefen mal*/
            $form4=<<<FORM4
                Precio
                    <input name="precio" type="number" step="0.01" value="$precio" class="error">  
                    <br>
FORM4;
        }else{ /****************************codrefen bien*/
            $form4=<<<FORM4
                Precio
                <input name="precio" type="number" step="0.01" value="$precio">
                <br>
FORM4;
        }
        $form5=<<<FORMULARIO
                </h2>
                <h3>$error </h3>
                <br>
                <br>
                <input type="submit" name="Submit" value="Enviar">
FORMULARIO;
        
    $formFinal=$form.$form1.$form2.$form3.$form4.$form5;
    
    print $formFinal;
    }
    
    
    function validar(&$codRefen, &$idMasc, &$tipoTarea,&$precio, &$error){
        if(!$codRefen || !$idMasc){
            $error="Error: Campos vacíos";
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
       drawForm($codRefen, $idMasc, $tipoTarea,$precio, $error);
    }else{/*Rutina segunda vuelta*/
        if(validar($codRefen, $idMasc, $tipoTarea, $precio, $error)){
            if(mandarDatos($codRefen, $idMasc, $tipoTarea,$precio,$error)){
                header("Location: menuVeterinario.php");
            }
        drawForm($codRefen, $idMasc, $tipoTarea,$precio, $error);
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
