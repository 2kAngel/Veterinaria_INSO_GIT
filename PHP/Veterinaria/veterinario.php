<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
if (empty($_POST)){
        $dniVet = "";
        $nombreVet="";
        $passwordVet="";
        $numVet="";
        $emailVet="";
        $error="";
    }else{
        $dniVet = $_POST["dniVet"];
        $nombreVet=$_POST["nombreVet"];
        $passwordVet=$_POST["passwordVet"];
        $numVet=$_POST["numVet"];
        $emailVet=$_POST["emailVet"];
    }
    
    session_start();
    include 'conexion_bd.php';
    
    function mandarDatos(&$dniVet, &$nombreVet, &$passwordVet,&$numVet,&$emailVet, &$error){
        include 'conexion_bd.php';
        
        $queryInsert="INSERT INTO `veterinario` (`dniVet`, `nombreVet`, `numVet`, `passwordVet`, `emailVet`) "
                . "VALUES ('$dniVet', '$nombreVet', '$numVet', '$passwordVet', '$emailVet');";

        //$queryInsert="INSERT INTO veterinario (dniVet,nombreVet,passwordVet,numVet,emailVet) "
        // ."VALUES ('$dniVet','$nombreVet','$passwordVet','$numVet','$emailVet');";
        if(!mysqli_query($conex,$queryInsert)){
            $error= "valores introducidos no válidos";
                    //mysqli_error($conex);/*Error en los datos de entrada*/
            return false;
        }
        return true;
        
        
    }

     function drawForm(&$dniVet, &$nombreVet, &$passwordVet,&$numVet,&$emailVet, &$error){
        $form=<<<FORMULARIO
    <form action="veterinario.php" method="post">
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
                Contraseña
                <input name="passwordVet" type="text" value="$passwordVet">
                <br>
                Número de teléfono
                <input name="numVet" type="text" value="$numVet">
                <br>
                Email
                <input name="emailVet" type="email" value="$emailVet">
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
    
    
    function validar(&$dniVet,&$error){
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

    $error = '';
    if (empty($_POST))/*Rutina inicial*/
    {
       drawForm($dniVet, $nombreVet, $passwordVet,$numVet,$emailVet, $error);
    }else{/*Rutina segunda vuelta*/
        if(validar($dniVet,$error)){
            if(mandarDatos($dniVet, $nombreVet, $passwordVet,$numVet,$emailVet, $error)){
                header("Location: menuVeterinario.php");
            }
        }
        drawForm($dniVet, $nombreVet, $passwordVet,$numVet,$emailVet, $error);

    }
?>
    <style type="text/css">
        .error{
            border-color: red;
        }
        
    </style>
   
    </body>
</html>
