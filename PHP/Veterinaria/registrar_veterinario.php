<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    

    
    function mandarDatos($dniVet, $nombreVet, $numVet, $passwordVet, $emailVet)
    {
        include 'conexion_bd.php';

        $queryInsert="INSERT INTO veterinario (dniVet, nombreVet, numVet, passwordVet, emailVet) 
                     VALUES ('$dniVet', '$nombreVet', '$numVet', '$passwordVet', '$emailVet');";
        if(!mysqli_query($conex,$queryInsert)){

            return false;
        }
        return true;
          
    }

    function drawForm($dniVet, $nombreVet, $numVet, $passwordVet, $emailVet)
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
                <input name="passwordVet" type="text" value="$passwordVet">
                <br>
                Email
                <input name="emailVet" type="email" value="$emailVet">
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
    
    function validar(&$dniVet, &$error)
    {
        if(!$dniVet || !preg_match("/[0-9]{7,8}[A-Z]/",$dniVet)){
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

    session_start();
    include 'conexion_bd.php';
    
if (empty($_POST)){
        $dniVet = "";
        $nombreVet="";
        $numVet="";
        $passwordVet="";
        $emailVet="";
        $error="";
    }else{
        $dniVet = $_POST["dniVet"];
        $nombreVet=$_POST["nombreVet"];
        $numVet=$_POST["numVet"];
        $passwordVet=$_POST["passwordVet"];
        $emailVet=$_POST["emailVet"];
    }
    
    $error = '';
    
    if (empty($_POST))/*Rutina inicial*/
    {
       drawForm($dniVet, $nombreVet, $numVet,$passwordVet, $emailVet);
       
    }else{/*Rutina segunda vuelta*/
        if(validar($dniVet,$error)){
            if(mandarDatos($dniVet, $nombreVet, $numVet, $passwordVet, $emailVet)){
                header("Location: menuVeterinario.php");
            }
            
        drawForm($dniVet, $nombreVet, $numVet,$passwordVet, $emailVet);
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
