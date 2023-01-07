<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    
    session_start();
    include 'conexion_bd.php';
    
    function mandarDatos(&$dniCli, &$nombreCli, &$apellidoCli,&$passwordCli,&$emailCli, &$error)
    {
        include 'conexion_bd.php';

        $queryInsert="INSERT INTO cliente (dniCli, nombreCli, apellidoCli, passwordCli, emailCli) "
            ."VALUES ('$dniCli','$nombreCli','$apellidoCli','$passwordCli','$emailCli');";
        if(!mysqli_query($conex,$queryInsert)){
            $error= "valores introducidos no válidos";
            //mysqli_error($conex);/*Error en los datos de entrada*/
            return false;
        }
        return true;
        
        
    }

    function drawForm(&$dniCli, &$nombreCli, &$apellidoCli,&$passwordCli,&$emailCli, &$error)
    {
        $form=<<<FORMULARIO
    <form action="cliente.php" method="post">
            <h1> REGISTRAR CLIENTE </h1>
            <h2> 
FORMULARIO;
        
        if(!empty($_POST) && $dniCli==""){ /***codrefen mal*/
            $form1=<<<FORM1
                DNI
                <input name="dniCli" type="text" value="$dniCli" class="error">  
                <br>
FORM1;
        }else{ /****************************codrefen bien*/
            $form1=<<<FORM1
                DNI
                <input name="dniCli" type="text" value="$dniCli">
                <br>
FORM1;
        }
        
        $form2=<<<FORMULARIO
                Nombre
                <input name="nombreCli" type="text" value="$nombreCli">
                <br>
                Apellidos
                <input name="apellidoCli" type="text" value="$apellidoCli">
                <br>
                Contraseña
                <input name="passwordCli" type="text" value="$passwordCli">
                <br>
                Email
                <input name="emailCli" type="email" value="$emailCli">
                <br>
                </h2>
                <h3>$error </h3>
                <br>
                <br>
                <input type="submit" name="Submit" value="Añadir">
    </form>
                
FORMULARIO;
        
        $formFinal=$form.$form1.$form2;

        print $formFinal;
    }
    
    function validar(&$dniCli, &$error)
    {
        if(!$dniCli || !preg_match("/[0-9]{7,8}[A-Z]/",$dniCli)){
            $error="Error: Error de formato en DNI";
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
if (empty($_POST)){
        $dniCli = "";
        $nombreCli="";
        $apellidoCli="";
        $passwordCli="";
        $emailCli="";
        $error="";
    }else{
        $dniCli = $_POST["dniCli"];
        $nombreCli=$_POST["nombreCli"];
        $apellidoCli=$_POST["apellidoCli"];
        $passwordCli=$_POST["passwordCli"];
        $emailCli=$_POST["emailCli"];
    }
    
    
    $error = '';
    
    if (empty($_POST))/*Rutina inicial*/
    {
       drawForm($dniCli, $nombreCli, $apellidoCli,$passwordCli,$emailCli, $error);
       
    }else{/*Rutina segunda vuelta*/
        if(validar($dniCli,$error)){
            if(mandarDatos($dniCli, $nombreCli, $apellidoCli,$passwordCli,$emailCli, $error)){
                header("Location: menuVeterinario.php");
            }
            
        drawForm($dniCli, $nombreCli, $apellidoCli,$passwordCli,$emailCli, $error);
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
