<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title><!DOCTYPE html>
<!--
sacar los id de los clientes.
formulario con datos clientes
-->
<?php
    session_start();
    include 'conexion_bd.php';
    
    if (empty($_POST)){
        $dniVet="";
        $nombreVet="";
        $numVet="";
        $passwordVet="";
        $emailVet="";
        $error="";
    }else{
        $dniVet=$_POST["dniVet"];
        $nombreVet=$_POST["nombreVet"];
        $numVet=$_POST["numVet"];
        $passwordVet=$_POST["passwordVet"];
        $emailVet=$_POST["emailVet"];
    }
    $error = '';

    
    function drawForm(&$nombreVet, &$numVet,&$passwordVet,&$emailVet, &$error){
        
    include 'conexion_bd.php';
        $form=<<<FORMULARIO
    <form action="modificar_veterinario.php" method="post">
            <h1> Modificar Veterinario </h1>
            <h2> 
FORMULARIO;
        $form11=<<<FORM11
                DNI
                <select name="dniVet">
FORM11;
        
        $querySelect="SELECT dniVet FROM veterinario;";
        $res_tipo=mysqli_query($conex, $querySelect) or die (mysql_error());
        if (mysqli_num_rows($res_tipo)!=0){
            while ($reg=mysqli_fetch_array($res_tipo)){
                $dniVet=$reg['dniVet'];
                $form11.=<<<FORM12
                        <option  value="$dniVet">$dniVet</option>  
FORM12;
            }
            
        } 
        $form13=<<<FORM13
               </select><br>
FORM13;
            
        $form1=$form11.$form13;
        $form2=<<<FORMULARIO
                Nombre
                <input name="nombreVet" type="text" value="$nombreVet">
                <br>
                Número de veterinario
                <input name="numVet" type="text" value="$numVet">
                <br>
                Contraseña
                <input name="passwordVet" type="text" value="$passwordVet">
                <br>
                Email
                <input name="emailVet" type="email" value="$emailVet">
                <br>
                </h2>
                <h3>$error </h3>
                <br>
                <br>
                <input type="submit" name="Submit" value="Modificar">
    </form>
                
FORMULARIO;
        
        $formFinal=$form.$form1.$form2;

        print $formFinal;
    }
    
    
    function updateVeterinario(&$dniVet, &$nombreVet, &$numVet,&$passwordVet,&$emailVet, &$error)
    {
        include 'conexion_bd.php';

        $queryUpdate="UPDATE `veterinario` SET "
                . "`dniVet` = '$dniVet', `nombreVet` = '$nombreVet', `numVet` = '$numVet',"
                . " `passwordVet` = '$passwordVet', `emailVet` = '$emailVet' "
                . "WHERE `veterinario`.`dniVet` = '$dniVet';";
        if(!mysqli_query($conex,$queryUpdate)){
            $error= "valores introducidos no válidos";
            //mysqli_error($conex);/*Error en los datos de entrada*/
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
        
    if (empty($_POST))/*Rutina inicial*/{
        drawForm($nombreVet, $numVet, $passwordVet, $emailVet, $error);
    }else{/*Rutina segunda vuelta*/
        if(updateVeterinario($dniVet,$nombreVet, $numVet,$passwordVet,$emailVet,$error)){
            header("Location: menuVeterinario.php");
        }
        drawForm($nombreVet, $nomVet, $passwordVet, $emailVet, $error);
    }
        ?>
    </body>
</html>

