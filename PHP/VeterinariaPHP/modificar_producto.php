<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    session_start();
    include 'conexion_bd.php';


    function drawForm($idProductoSel,$tipoProducto,$nombrePro,$stock,$error){
        
    include 'conexion_bd.php';

    print "<form action='modificar_producto.php' method='post'>";
    print "<h1> Modificar Producto </h1>";
 
        include 'conexion_bd.php';
          
        $querySelect="SELECT idProducto FROM producto;";
        $res_tipo=mysqli_query($conex, $querySelect) or die (mysql_error());

        print("<h2>idProducto: </h2>");

        if (mysqli_num_rows($res_tipo)!=0)
        {
            print ("<select name='idProducto'>");

             while ($reg=mysqli_fetch_array($res_tipo))
            {
                $idProducto = $reg['idProducto'];
           
                if ($idProductoSel == $idProducto)  
                    print ("<option value='$idProducto' selected> $idProducto");
                else
                    print ("<option value='$idProducto'> $idProducto"); 
            }
             
            print("</select>");

        }else           
        {
            print ("<p>No hay ningun producto</p>");
        }
        
        
        //---------------------------------------------------------------
        $form2=<<<FORMULARIO
                <h2>
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
                </h2>
    </form>
                
FORMULARIO;
        
        $formFinal=$form2;

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
            
    if (empty($_POST)){
        $idProducto= null;
        $tipoProducto= null;
        $nombrePro= null;
        $stock= null;
   
    }else{
        $idProducto=$_POST["idProducto"];
        $tipoProducto=$_POST["tipoProducto"];
        $nombrePro=$_POST["nombrePro"];
        $stock=$_POST["stock"];
    }
    
    $error = '';
        
    if (empty($_POST) ||  ($_POST["idProducto"] != null && $tipoProducto== null && $nombrePro== null && $stock== null))/*Rutina inicial*/{
        
        if (empty($_POST)){
            $idProducto= null;
            $tipoProducto= null;
            $nombrePro= null;
            $stock= null;

        } elseif ($_POST["idProducto"] != null && $tipoProducto== null && $nombrePro== null && $stock== null){

            $idProducto= $_POST["idProducto"];

            $querySelect="SELECT * FROM producto WHERE idProducto = '$idProducto';";

            $res_cli=mysqli_query($conex, $querySelect) or die (mysql_error());
            if (mysqli_num_rows($res_cli)!=0){
                while ($reg=mysqli_fetch_array($res_cli)){
                    $tipoProducto=$reg['tipoProducto'];
                    $nombrePro=$reg['nombrePro'];
                    $stock=$reg['stock'];
                    $error="";
                }
            }
        }
        
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

