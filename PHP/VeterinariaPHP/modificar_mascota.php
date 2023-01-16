<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    session_start();
    include 'conexion_bd.php';
    
    if (empty($_POST)){
        $idMasc="";
        $dniCli="";
        $dniVet="";
        $tipoAnimal="";
        $sexo="";
        $error="";
    }else{
        $idMasc=$_POST["idMasc"];
        $dniVet=$_POST["dniVet"];
        $dniCli=$_POST["dniCli"];
        $tipoAnimal=$_POST["tipoAnimal"];
        $sexo=$_POST["sexo"];
    }
    $error = '';

    
    function drawForm($idMasc,$dniCli,$dniVet,$tipoAnimal,$sexo,$error){
        
    include 'conexion_bd.php';
        $form=<<<FORMULARIO
    <form action="modificar_mascota.php" method="post">
            <h1> Modificar Mascota </h1>
            <h2> 
FORMULARIO;
        
        /***********DESPLEGABLE MASCOTA***********/
        $form11=<<<FORM11
                idMasc
                <select name="idMasc">
FORM11;
        $querySelect="SELECT idMasc FROM mascota;";
        $res_tipo=mysqli_query($conex, $querySelect) or die (mysql_error());
        if (mysqli_num_rows($res_tipo)!=0){
            while ($reg=mysqli_fetch_array($res_tipo)){
                $idMasc=$reg['idMasc'];
                $form11.=<<<FORM12
                        <option  value="$idMasc">$idMasc</option>  
FORM12;
            }
            
        } 
        $form13=<<<FORM13
               </select><br>
FORM13;
            
        $form1=$form.$form11.$form13;
        
        
        /***********DESPLEGABLE CLIENTE***********/

        $form21=<<<FORM21
                DNI de cliente
                <select name="dniCli">
FORM21;
        
        $querySelect="SELECT dniCli FROM cliente;";
        $res_tipo=mysqli_query($conex, $querySelect) or die (mysql_error());
        if (mysqli_num_rows($res_tipo)!=0){
            while ($reg=mysqli_fetch_array($res_tipo)){
                $dniCli=$reg['dniCli'];
                $form21.=<<<FORM22
                        <option  value="$dniCli">$dniCli</option>  
FORM22;
            }
        } 
        $form23=<<<FORM23
               </select><br>
FORM23;
                $form2=$form21.$form23;

        /***********DESPLEGABLE VETERINARIO***********/
        $form31=<<<FORM31
                DNI veterinario
                <select name="dniVet">
FORM31;
        $querySelect="SELECT dniVet FROM veterinario;";
        $res_tipo=mysqli_query($conex, $querySelect) or die (mysql_error());
        if (mysqli_num_rows($res_tipo)!=0){
            while ($reg=mysqli_fetch_array($res_tipo)){
                $dniVet=$reg['dniVet'];
                $form31.=<<<FORM32
                        <option  value="$dniVet">$dniVet</option>  
FORM32;
            }
        } 
        $form33=<<<FORM33
               </select><br> </h2>
FORM33;
        $form3=$form31.$form33;
        
        print $form1.$form2.$form3;
        
        print "<h2>";
         print "<p> <input type='radio' name = 'sexo' value='H'";
        if ($sexo == 'H') 
            print "checked> Hembra </p>";
        else
            print "> Hembra </p>";

        print "<p> <input type='radio' name = 'sexo' value='M'";

        if ($sexo == 'M') 
            print "checked> Macho </p>";
        else
            print "> Macho </p>";
         print "</h2>";
        
        $form4=<<<FORMULARIO
                <h2>
                Tipo de animal
                <input name="tipoAnimal" type="text" value="$tipoAnimal">
                <br>
      
                <h3>$error </h3>
                <br>
                <br>
                <input type="submit" name="Submit" value="Modificar">
                </h2>
                </form>
FORMULARIO;
        
        print $form4;
      
        
    }
    
    
    function updateMascota($idMasc,$dniCli,$dniVet,$tipoAnimal,$sexo,$error)
    {
        include 'conexion_bd.php';

        $queryUpdate="UPDATE `mascota` SET `dniCli` = '$dniCli', `dniVet` = '$dniVet', "
                . "`tipoAnimal` = '$tipoAnimal', `sexo` = '$sexo' "
                . "WHERE `mascota`.`idMasc` = '$idMasc'; ";
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
drawForm($idMasc,$dniCli,$dniVet,$tipoAnimal,$sexo,$error);
    }else{/*Rutina segunda vuelta*/
        if(updateMascota($idMasc,$dniCli,$dniVet,$tipoAnimal,$sexo,$error)){
            header("Location: menuVeterinario.php");
        }
        drawForm($idMasc,$dniCli,$dniVet,$tipoAnimal,$sexo,$error);
    }
        ?>
    </body>
</html>

