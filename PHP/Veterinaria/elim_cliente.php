<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd">
<?php        


    if(empty($_POST)){
        $dniCli = "";
        $error = "";
    }else{
        $dniCli = $_POST["dniCli"];
    }

    function drawForm(&$dniCli, &$error){
        
    include 'conexion_bd.php';
        $form=<<<FORMULARIO
    <form action="elim_cliente.php" method="post">
            <h1> ELIMINAR CLIENTE </h1>
            <h2> 
FORMULARIO;
        $form11=<<<FORM11
                DNI
                <select name="dniCli">
                
FORM11;
        
        $querySelect="SELECT dniCli FROM cliente;";
        $res_tipo=mysqli_query($conex, $querySelect) or die (mysql_error());
        if (mysqli_num_rows($res_tipo)!=0){
            while ($reg=mysqli_fetch_array($res_tipo)){
                $dniCli=$reg['dniCli'];
                $form11.=<<<FORM12
                        <option  value="$dniCli">$dniCli</option>  
FORM12;
            }
            
        } 
        $form13=<<<FORM13
               </select><br>
                $error;
FORM13;
            
        $form1=$form11.$form13;
        
        
        $formFinal=$form.$form1;

        print $formFinal;
    }
    
 
    function deleteCliente(&$dniCli, &$error)
    {
        include 'conexion_bd.php';

        $queryUpdate="DELETE FROM `cliente` WHERE `cliente`.`dniCli` = '$dniCli'";
                
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
        <title>Documento eliminar cliente</title>
    </head>

    <body>
        <?php
        
    if (empty($_POST))/*Rutina inicial*/{
        drawForm($dniCli, $error);
    }else{/*Rutina segunda vuelta*/
        if(deleteCliente($dniCli, $error)){
            header("Location: menuVeterinario.php");
        }
        drawForm($dniCli, $error);
    }
        ?>
        <input type="submit" name="Eliminar" value="Eliminar">
    </body>
</html>