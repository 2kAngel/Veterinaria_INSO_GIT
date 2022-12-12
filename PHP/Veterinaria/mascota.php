<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
if (empty($_POST)){
        //$idMasc = "";
        $dniCli="";
        $dniVet="";
        $tipoAnimal="";
        $sexo="";
        $error="";
    }else{
        //$idMasc = $_POST["idMasc"];
        $dniCli=$_POST["dniCli"];
        $dniVet=$_POST["dniVet"];
        $tipoAnimal=$_POST["tipoAnimal"];
        $sexo=$_POST["sexo"];
    }
    
    session_start();
    include 'conexion_bd.php';
    
    function mandarDatos(&$dniCli, &$dniVet, &$tipoAnimal, &$sexo, &$error){
        include 'conexion_bd.php';

        $queryInsert="INSERT INTO `mascota` (`idMasc`, `dniCli`, `dniVet`, `tipoAnimal`, `sexo`)"
                . " VALUES (NULL, '$dniCli', '$dniVet', '$tipoAnimal', '$sexo');";
                
        
        if(!mysqli_query($conex,$queryInsert)){
            $error= "valores introducidos no válidos";
                    //mysqli_error($conex);/*Error en los datos de entrada*/
            return false;
        }
        return true;
        
    }
    
    function drawForm(&$dniCli, &$dniVet, &$tipoAnimal, &$sexo, &$error){
        $form=<<<FORMULARIO
            <form action="mascota.php" method="post">
            <h2>  
FORMULARIO;
        
        if(!empty($_POST) && $dniCli==""){ /***codrefen mal*/
            $form1=<<<FORM1
                DNI cliente
                    <input name="dniCli" type="text" value="$dniCli" class="error">  
                    <br>
FORM1;
        }else{ /****************************codrefen bien*/
            $form1=<<<FORM1
                DNI cliente
                <input name="dniCli" type="text" value="$dniCli">  
                    <br>
FORM1;
        }
        
        if(!empty($_POST) && $dniVet==""){ /***codrefen mal*/
            $form2=<<<FORM1
                DNI veterinario
                    <input name="dniVet" type="text" value="$dniVet" class="error">  
                    <br>
FORM1;
        }else{ /****************************codrefen bien*/
            $form2=<<<FORM1
                DNI veterinario
                    <input name="dniVet" type="text" value="$dniVet">  
                    <br>
FORM1;
        }
        
        $form3=<<<FORMULARIO
                Tipo de animal
                <input name="tipoAnimal" type="text" value="$tipoAnimal">
                <br>
                Sexo
                <input name="sexo" type="text" value="$sexo">
                <br>
                </h2>
                <h3>$error </h3>
                <br>
                <br>
                <input type="submit" name="Submit" value="Añadir">
                
FORMULARIO;
        
        $formFinal=$form.$form1.$form2.$form3;

        print $formFinal;
    }
    
    function validar(&$dniCli, &$dniVet,&$error){
        if(!$dniVet || !preg_match("/[0-9]{7,8}[A-Z]/",$dniVet)){
            $error="Error: Error de formato en DNI";
            return false;
        }
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

    $error = '';
    if (empty($_POST))/*Rutina inicial*/
    {
       drawForm($dniCli, $dniVet, $tipoAnimal, $sexo, $error);
    }else{/*Rutina segunda vuelta*/
        if(validar($dniCli, $dniVet,$error)){
            if(mandarDatos($dniCli, $dniVet, $tipoAnimal, $sexo, $error)){
                header("Location: menuVeterinario.php");
            }
        }
        drawForm($dniCli, $dniVet, $tipoAnimal, $sexo, $error);

    }
?>
    <style type="text/css">
        .error{
            border-color: red;
        }
        
    </style>
   
    </body>
</html>
