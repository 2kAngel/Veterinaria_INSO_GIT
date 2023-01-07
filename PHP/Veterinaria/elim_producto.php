<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd">
<?php        


    if(empty($_POST)){
        $idProducto = "";
        $error = "";
    }else{
        $idProducto = $_POST["idProducto"];
    }

    function drawForm(&$idProducto, &$error){
        
    include 'conexion_bd.php';
        $form=<<<FORMULARIO
    <form action="elim_producto.php" method="post">
            <h1> ELIMINAR Producto </h1>
            <h2> 
FORMULARIO;
        $form11=<<<FORM11
                ID producto
                <select name="idProducto">
                
FORM11;
        
        $querySelect="SELECT idProducto FROM producto;";
        $res_tipo=mysqli_query($conex, $querySelect) or die (mysql_error());
        if (mysqli_num_rows($res_tipo)!=0){
            while ($reg=mysqli_fetch_array($res_tipo)){
                $idProducto=$reg['idProducto'];
                $form11.=<<<FORM12
                        <option  value="$idProducto">$idProducto</option>  
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
    
 
    function deleteProducto(&$idProducto, &$error)
    {
        include 'conexion_bd.php';

        $queryUpdate="DELETE FROM `producto` WHERE `producto`.`idProducto` = '$idProducto'";
                
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
        <title>Documento eliminar producto</title>
    </head>

    <body>
        <?php
        
    if (empty($_POST))/*Rutina inicial*/{
        drawForm($idProducto, $error);
    }else{/*Rutina segunda vuelta*/
        if(deleteProducto($idProducto, $error)){
            header("Location: menuVeterinario.php");
        }
        drawForm($idProducto, $error);
    }
        ?>
        <input type="submit" name="Eliminar" value="Eliminar">
    </body>
</html>