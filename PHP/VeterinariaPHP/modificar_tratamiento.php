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
        $idTrata="";
        $tipoTrata="";
        $precioTrata="";
        $fechaTrata="";
        $error="";
    }else{
        $idTrata=$_POST["idTrata"];
        $tipoTrata=$_POST["tipoTrata"];
        $precioTrata=$_POST["precioTrata"];
        $fechaTrata=$_POST["fechaTrata"];
    }
    $error = '';

    
    function drawForm($idTrata, $tipoTrata, $precioTrata,$fechaTrata,$error){
        
    include 'conexion_bd.php';
        $form=<<<FORMULARIO
    <form action="modificar_tratamiento.php" method="post">
            <h1> Modificar Tratamiento </h1>
            <h2> 
FORMULARIO;
        
        /***********DESPLEGABLE Tratamiento***********/
        $form11=<<<FORM11
                idTrata
                <select name="idTrata">
FORM11;
        $querySelect="SELECT idTrata FROM tratamiento;";
        $res_tipo=mysqli_query($conex, $querySelect) or die (mysql_error());
        if (mysqli_num_rows($res_tipo)!=0){
            while ($reg=mysqli_fetch_array($res_tipo)){
                $idTrata=$reg['idTrata'];
                $form11.=<<<FORM12
                        <option  value="$idTrata">$idTrata</option>  
FORM12;
            }
            
        } 
        $form13=<<<FORM13
                
                
               </select><br>
FORM13;
             //idTrata, tipoTrata, precioTrata, fechaTrata
             //'$idTrata', '$tipoTrata', '$precioTrata', '$fechaTrata'
        $form1=$form11.$form13;
        $form2=<<<FORMULARIO
                Tipo Tratamiento
                <input name="tipoTrata" type="text" value="$tipoTrata">
                <br>
                Precio Tratamiento
                <input name="precioTrata" type="float" value="$precioTrata">
                <br>
                Fecha Tratamiento
                <input name="fechaTrata" type="date" value="$fechaTrata">
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
    
    
    function updateTratamiento($idTrata, $tipoTrata, $precioTrata,$fechaTrata,$error)
    {
        include 'conexion_bd.php';

        $queryUpdate="UPDATE `tratamiento` SET  `tipoTrata` = '$tipoTrata', "
                . "`precioTrata` = '$precioTrata', `fechaTrata` = '$fechaTrata' "
                . "WHERE `tratamiento`.`idTrata` = '$idTrata'; ";
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
drawForm($idTrata, $tipoTrata, $precioTrata,$fechaTrata,$error);
    }else{/*Rutina segunda vuelta*/
        if(updateTratamiento($idTrata, $tipoTrata, $precioTrata,$fechaTrata,$error)){
            header("Location: menuVeterinario.php");
        }
        drawForm($idTrata, $tipoTrata, $precioTrata,$fechaTrata,$error);
    }
        ?>
    </body>
</html>

