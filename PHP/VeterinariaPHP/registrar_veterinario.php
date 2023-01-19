<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    

    
    function mandarDatos($dniVet, $nombreVet, $numVet, $passwordVet, $emailVet, &$error)
    {
        include 'conexion_bd.php';
        
        if($dniVet==""||$nombreVet==""||$numVet==""||$passwordVet==""||$emailVet==""){
            $error="No pueden quedar campos vacíos";
            return false;
        }

        $queryInsert="INSERT INTO veterinario (dniVet, nombreVet, numVet, passwordVet, emailVet) 
                     VALUES ('$dniVet', '$nombreVet', '$numVet', '$passwordVet', '$emailVet');";
        if(!mysqli_query($conex,$queryInsert)){

            return false;
        }
        return true;
          
    }

    function drawForm($dniVet, $nombreVet, $numVet, $passwordVet, $repPassword, $emailVet, &$error)
    {
        $form=<<<FORMULARIO
    <form action="registrar_veterinario.php" method="post">
            <h1> REGISTRAR VETERINARIO </h1>
            <h2> 
FORMULARIO;
        
        if(!empty($_POST) && $dniVet==""){ /***codrefen mal*/
            $form1=<<<FORM1
                DNI
                <input name="dniVet" type="text" value="$dniVet" class="error">  
                <br>
FORM1;
        }else{ /****************************codrefen bien*/
            $form1=<<<FORM1
                DNI
                <input name="dniVet" type="text" value="$dniVet">
                <br>
FORM1;
        }
        
        $form2=<<<FORMULARIO
                Nombre
                <input name="nombreVet" type="text" value="$nombreVet">
                <br>
                Numero Veterinario
                <input name="numVet" type="text" value="$numVet">
                <br>
                Contraseña
                <input name="passwordVet" type="password" value="$passwordVet">
                <br>
                Repetir contraseña
                <input name="repPassword" type="password" value="$repPassword">
                <br>
                Email
                <input name="emailVet" type="email" value="$emailVet">
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
    
    function validar(&$dniVet, $passwordVet, $repPassword, &$error)
    {
        if(!$dniVet || !preg_match("/[0-9]{7,8}[A-Z]/",$dniVet)){
            $error="Error: Error de formato en DNI";
            return false;
        }
        
        if($passwordVet != $repPassword){
            $error="Error: Las contraseñas no coinciden";
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

    session_start();
    include 'conexion_bd.php';
    
if (empty($_POST)){
        $dniVet = "";
        $nombreVet="";
        $numVet="";
        $passwordVet="";
        $emailVet="";
        $repPassword="";
        $error="";
    }else{
        $dniVet = $_POST["dniVet"];
        $nombreVet=$_POST["nombreVet"];
        $numVet=$_POST["numVet"];
        $passwordVet=$_POST["passwordVet"];
        $repPassword=$_POST["repPassword"];
        $emailVet=$_POST["emailVet"];
    }
    
    $error = '';
    
    if (empty($_POST))/*Rutina inicial*/
    {
       drawForm($dniVet, $nombreVet, $numVet,$passwordVet, $repPassword, $emailVet, $error);
       
    }else{/*Rutina segunda vuelta*/
        if(validar($dniVet, $passwordVet, $repPassword,$error)){
            if(mandarDatos($dniVet, $nombreVet, $numVet, $passwordVet, $emailVet, $error)){
                header("Location: menuVeterinario.php");
            }
        } 
        drawForm($dniVet, $nombreVet, $numVet,$passwordVet, $repPassword, $emailVet, $error);
    }
?>
    <style type="text/css">
        .error{
            border-color: red;
        }
        
    </style>
    
    </body>
</html>
