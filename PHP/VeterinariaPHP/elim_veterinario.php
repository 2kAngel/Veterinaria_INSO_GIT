<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd">
<?php        


    if(empty($_POST)){
        $dniVet = "";
        $error = "";
    }else{
        $dniVet = $_POST["dniVet"];
    }

    function drawForm(&$dniVet, &$error){
        
    include 'conexion_bd.php';
        $form=<<<FORMULARIO
    <form action="elim_veterinario.php" method="post">
            <h1> ELIMINAR Veterinario </h1>
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
                $error
FORM13;
            
        $form1=$form11.$form13;
        
        
        $formFinal=$form.$form1;

        print $formFinal;
    }
    
 
    function deleteVeterinario(&$dniVet, &$error)
    {
        include 'conexion_bd.php';

        $queryUpdate="DELETE FROM `veterinario` WHERE `veterinario`.`dniVet` = '$dniVet'";
                
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
        <title>Documento eliminar veterinario</title>
    </head>

    <body>
        <?php
        
    if (empty($_POST))/*Rutina inicial*/{
        drawForm($dniCli, $error);
    }else{/*Rutina segunda vuelta*/
        if(deleteVeterinario($dniVet, $error)){
            header("Location: menuVeterinario.php");
        }
        drawForm($dniVet, $error);
    }
        ?>
        <input type="submit" name="Eliminar" value="Eliminar">
    </body>
</html>