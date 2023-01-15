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
        $idProducto="";
        $tipoProducto="";
        $nombrePro="";
        $stock="";
        $error="";
    }else{
        $idProducto=$_POST["idProducto"];
        $tipoProducto=$_POST["tipoProducto"];
        $nombrePro=$_POST["nombrePro"];
        $stock=$_POST["stock"];
    }
    $error = '';

    
    function drawForm($idProducto,$tipoProducto,$nombrePro,$stock,$error){
        
    include 'conexion_bd.php';
        $form=<<<FORMULARIO
    <form action="modificar_producto.php" method="post">
            <h1> Modificar Producto </h1>
            <h2> 
FORMULARIO;
        
        /***********DESPLEGABLE Producto***********/
        $form11=<<<FORM11
                idProducto
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
FORM13;
            
        $form1=$form11.$form13;
        $form2=<<<FORMULARIO
                Tipo
                <input name="tipoProducto" type="text" value="$tipoProducto">
                <br>
                Nombre Producto
                <input name="nombrePro" type="text" value="$nombrePro">
                <br>
                Stock
                <input name="stock" type="text" value="$stock">
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
    
    
    function updateProducto($idProducto,$tipoProducto,$nombrePro,$stock,$error)
    {
        include 'conexion_bd.php';

        $queryUpdate="UPDATE `producto` SET `idProducto` = '$idProducto', `tipoProducto` = '$tipoProducto', "
                . "`nombrePro` = '$nombrePro', `stock` = '$stock' "
                . "WHERE `producto`.`idProducto` = '$idProducto'; ";
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
drawForm($idProducto,$tipoProducto,$nombrePro,$stock,$error);
    }else{/*Rutina segunda vuelta*/
        if(updateProducto($idProducto,$tipoProducto,$nombrePro,$stock,$error)){
            header("Location: menuVeterinario.php");
        }
        drawForm($idProducto,$tipoProducto,$nombrePro,$stock,$error);
    }
        ?>
    </body>
</html>

