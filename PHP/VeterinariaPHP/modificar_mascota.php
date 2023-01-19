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
        $aux = "";//valor del botón pulsado
    }else{
        $idMasc = $_POST['idMasc'];
        $dniVet = $_POST["dniVet"];
        $dniCli = $_POST["dniCli"];
        $tipoAnimal = $_POST["tipoAnimal"];
        $sexo = $_POST["sexo"];
        $aux = $_POST["btnAux"];//valor del botón pulsado
    }
    
    $error = '';

    //$Aux es la flag que lleva el botón que se ha pulsado. Si $aux es 
    //Modificar, entonces se modifican los datos.
    //Si es Mostrar, entonces se muestran los datos de la actual
    function drawForm($idMascF,$dniCliF,$dniVetF,$tipoAnimalF,$sexoF,$aux, $error){
        
    include 'conexion_bd.php';
        $form=<<<FORMULARIO
    <form action="modificar_mascota.php" method="post">
            <h1> Modificar Mascota </h1>
            <h2> 
FORMULARIO;
        
        
        
        /***********DESPLEGABLE MASCOTA***********/
        $form.=<<<FORM11
                idMasc
                <select name="idMasc">
FORM11;
        $querySelect="SELECT idMasc FROM mascota WHERE activo = '1';";
        $res_tipo=mysqli_query($conex, $querySelect) or die (mysql_error());
        if (mysqli_num_rows($res_tipo)!=0){
            while ($reg=mysqli_fetch_array($res_tipo)){
                $idMasc=$reg['idMasc'];
                if(strcmp($idMasc,$idMascF)==0){
                    $form.=<<<FORM12
                        <option  value="$idMascF" selected>$idMascF</option>
FORM12;
                }else{
                    $form.=<<<FORM12
                        <option  value="$idMasc" >$idMasc</option>  
FORM12;
                }
                
            }
        } 
        $form.=<<<FORM13
               </select><br>
FORM13;
        
        
        /***********DESPLEGABLE CLIENTE***********/

        $form.=<<<FORM21
                DNI de cliente
                <select name="dniCli">
FORM21;
        
        $querySelect="SELECT dniCli FROM cliente WHERE activo = '1';";
        $res_tipo=mysqli_query($conex, $querySelect) or die (mysql_error());
        if (mysqli_num_rows($res_tipo)!=0){
            while ($reg=mysqli_fetch_array($res_tipo)){
                $dniCli=$reg['dniCli'];
                if(strcmp($dniCli,$dniCliF)==0){
                    $form.=<<<FORM12
                        <option  value="$dniCli" selected>$dniCli</option>
FORM12;
                }else{
                    $form.=<<<FORM22
                        <option  value="$dniCli" >$dniCli</option>  
FORM22;
                }
                
            }
        } 
        $form.=<<<FORM23
               </select><br>
FORM23;

                
                
        /***********DESPLEGABLE VETERINARIO***********/
        $form.=<<<FORM31
                DNI veterinario
                <select name="dniVet">
FORM31;
        
        $querySelect="SELECT dniVet FROM veterinario WHERE activo = '1';";
        $res_tipo=mysqli_query($conex, $querySelect) or die (mysql_error());
        if (mysqli_num_rows($res_tipo)!=0){
            while ($reg=mysqli_fetch_array($res_tipo)){
                $dniVet=$reg['dniVet'];
                if(strcmp($dniVet,$dniVetF)==0){
                    $form.=<<<FORM12
                        <option  value="$dniVetF" selected>$dniVetF</option>
FORM12;
                }else{
                $form.=<<<FORM32
                        <option  value="$dniVet" >$dniVet</option>  
FORM32;
                }
            }
        } 
        $form.=<<<FORM33
               </select><br> 
                Sexo
                <br>
FORM33;
        
        
            $form.=<<<FORM43
                    Macho
                <input name="sexo" type="radio" value="Macho" checked>
FORM43;
            $form.=<<<FORM43
                    Hembra
                <input name="sexo" type="radio" value="Hembra">
FORM43;
        
         
       
        
        $form.=<<<FORMULARIO
                <h2>
                Tipo de animal
                <input name="tipoAnimal" type="text" value="$tipoAnimalF">
                <br>
                
                <h3>$error </h3>
                <br>
                <br>
                <input type="submit" name="btnAux" value="Modificar">
                <br><br><br>
                <input type="submit" name="btnAux" value="Mostrar datos">
                </h2>
                </form>
FORMULARIO;
        
        print $form;
      
        
    }
    
    function mostrarDatos($idMasc,$error,$aux){
        
        include 'conexion_bd.php';

        $querySelect="SELECT dniCli,dniVet,tipoAnimal,sexo FROM mascota "
                . "WHERE idMasc='$idMasc' AND activo = '1';";
        
        $res_tipo=mysqli_query($conex, $querySelect) or die (mysql_error());
        if (mysqli_num_rows($res_tipo)!=0){
            $reg=mysqli_fetch_array($res_tipo);
            $dniCli=$reg['dniCli'];
            $dniVet=$reg['dniVet'];
            $tipoAnimal=$reg['tipoAnimal'];
            $sexo = $reg['sexo'];
            drawForm($idMasc,$dniCli,$dniVet,$tipoAnimal,$sexo,$aux, $error);
        }
    }
    
    function updateMascota($idMasc,$dniCli,$dniVet,$tipoAnimal,$sexo,&$error)
    {
        include 'conexion_bd.php';
        if($dniCli=="" ||$dniVet==""||$tipoAnimal==""){
            $error.="<br>No puedes dejar campos vacíos";
            return false;
        }

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
        
    if (empty($_POST)){
        drawForm($idMasc,$dniCli,$dniVet,$tipoAnimal,$sexo,$aux,$error);
    }else{
        if(strcmp($aux,"Mostrar datos")){
            if(updateMascota($idMasc,$dniCli,$dniVet,$tipoAnimal,$sexo,$error)){
                header("Location: menuVeterinario.php");
            }
            drawForm($idMasc,$dniCli,$dniVet,$tipoAnimal,$sexo,$aux, $error);
        }else{
            mostrarDatos($idMasc, $error, $aux);
        }
    }    
        ?>
    </body>
</html>