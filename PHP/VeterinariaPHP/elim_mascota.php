<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd">
<?php        


    if(empty($_POST)){
        $idMasc = "";
        $error = "";
    }else{
        $idMasc = $_POST["idMasc"];
    }

    function drawForm(&$idMasc, &$error){
        
    include 'conexion_bd.php';
        $form=<<<FORMULARIO
    <form action="elim_mascota.php" method="post">
            <h1> ELIMINAR MASCOTA </h1>
            <h2> 
FORMULARIO;
        $form11=<<<FORM11
                ID mascota:
                <select name="idMasc">
                
FORM11;
        
        $querySelect="SELECT idMasc FROM mascota WHERE activo = '1';";
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
                $error
FORM13;
            
        $form1=$form11.$form13;
        
        
        $formFinal=$form.$form1;

        print $formFinal;
    }
    
 
    function deleteMascota(&$idMasc, &$error)
    {
        include 'conexion_bd.php';

        //$queryUpdate="DELETE FROM `mascota` WHERE `mascota`.`idMasc` = '$idMasc'";
        
        $queryUpdate = "UPDATE mascota SET activo = 0 WHERE `mascota`.`idMasc` = '$idMasc'";
                
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
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>Documento eliminar mascota</title>
    </head>

    <body>
        <?php
        
    if (empty($_POST))/*Rutina inicial*/{
        drawForm($idMasc, $error);
    }else{/*Rutina segunda vuelta*/
        if(deleteMascota($idMasc, $error)){
            header("Location: menuVeterinario.php");
        }
        drawForm($idMasc, $error);
    }
        ?>
        <input type="submit" name="Eliminar" value="Eliminar">
    </body>
</html>