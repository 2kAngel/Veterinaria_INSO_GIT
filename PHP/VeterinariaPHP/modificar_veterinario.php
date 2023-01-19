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
        $aux = "";
    }else{
        $dniVet=$_POST["dniVet"];
        $nombreVet=$_POST["nombreVet"];
        $numVet=$_POST["numVet"];
        $passwordVet=$_POST["passwordVet"];
        $emailVet=$_POST["emailVet"];
        $aux = $_POST["btnAux"];
    }
    $error = '';

    
    function drawForm($dniVet,$nombreVet, $numVet,$passwordVet,$emailVet, &$error){
        
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
        
        $querySelect="SELECT dniVet FROM veterinario WHERE activo='1';";
        $res_tipo=mysqli_query($conex, $querySelect) or die (mysql_error());
        if (mysqli_num_rows($res_tipo)!=0){
            while ($reg=mysqli_fetch_array($res_tipo)){
                $dniVetF=$reg['dniVet'];
                if(strcmp($dniVet,$dniVetF)){
                    $form11.=<<<FORM12
                        <option  value="$dniVetF">$dniVetF</option>  
FORM12;
                }else{
                    $form11.=<<<FORM12
                        <option  value="$dniVetF" selected>$dniVetF</option>  
FORM12;
                }
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
                <input type="submit" name="btnAux" value="Modificar">
                <br>
                <input type="submit" name="btnAux" value="Mostrar datos">

    </form>
                
FORMULARIO;
        
        $formFinal=$form.$form1.$form2;

        print $formFinal;
    }
    
    
    function updateVeterinario(&$dniVet, &$nombreVet, &$numVet,&$passwordVet,&$emailVet, &$error)
    {
        include 'conexion_bd.php';

        if($nombreVet=""||$numVet==""||$passwordVet=""||$emailVet==""){
            $error.="<br>No debes dejar campos vacíos";
            return false;
        }
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
    
    
    function mostrarDatos($dniVet,$error,$aux){
        
        include 'conexion_bd.php';

        
        $querySelect="SELECT nombreVet,numVet,passwordVet,emailVet FROM veterinario "
                . "WHERE dniVet='$dniVet' AND activo = '1';";
        
        $res_tipo=mysqli_query($conex, $querySelect) or die (mysql_error());
        if (mysqli_num_rows($res_tipo)!=0){
            $reg=mysqli_fetch_array($res_tipo);
            $nombreVet=$reg['nombreVet'];
            $numVet=$reg['numVet'];
            $passwordVet=$reg['passwordVet'];
            $emailVet = $reg['emailVet'];
            drawForm($dniVet,$nombreVet, $numVet,$passwordVet,$emailVet,$error);
        }
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
        drawForm($dniVet,$nombreVet, $numVet, $passwordVet, $emailVet, $error);
    }else{/*Rutina segunda vuelta*/
        if(strcmp($aux,"Mostrar datos")){
            if(updateVeterinario($dniVet,$nombreVet, $numVet,$passwordVet,$emailVet,$error)){
                header("Location: menuVeterinario.php");
            }
            drawForm($dniVet,$nombreVet, $nomVet, $passwordVet, $emailVet, $error);
        }else{
            mostrarDatos($dniVet,$error,$aux);
        }
        
    }
        ?>
    </body>
</html>

