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
        $error="";
        $aux = "";
    }else{
        $idTrata=$_POST["idTrata"];
        $tipoTrata=$_POST["tipoTrata"];
        $precioTrata=$_POST["precioTrata"];
        $aux = $_POST["btnAux"];
    }
    $error = '';

    
    function drawForm($idTrata, $tipoTrata, $precioTrata, $error){
        
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
        $querySelect="SELECT idTrata FROM tratamiento WHERE activo='1';";
        $res_tipo=mysqli_query($conex, $querySelect) or die (mysql_error());
        if (mysqli_num_rows($res_tipo)!=0){
            while ($reg=mysqli_fetch_array($res_tipo)){
                $idTrataF=$reg['idTrata'];
                if(strcmp($idTrataF,$idTrata)){
                    $form11.=<<<FORM12
                        <option  value="$idTrataF">$idTrataF</option>  
FORM12;
                }else{
                    $form11.=<<<FORM12
                        <option  value="$idTrataF" selected>$idTrataF</option>  
FORM12;
                }
                
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
                
                </h2>
                <h3>$error </h3>
                <br>
                <br>
                <input type="submit" name="btnAux" value="Modificar">
                <br>
                <input type="submit" name="btnAux" value="Mostrar Datos">
    </form>
                
FORMULARIO;
        
        $formFinal=$form.$form1.$form2;

        print $formFinal;
       
    }
    
    
    function updateTratamiento($idTrata, $tipoTrata, $precioTrata,$error)
    {
        include 'conexion_bd.php';

        if($tipoTrata==""||$precioTrata==""){
            $error="<br>No debes dejar campos vacíos";
            return false;
        }
        $queryUpdate="UPDATE `tratamiento` SET  `tipoTrata` = '$tipoTrata', "
                . "`precioTrata` = '$precioTrata' "
                . "WHERE `tratamiento`.`idTrata` = '$idTrata'; ";
        if(!mysqli_query($conex,$queryUpdate)){
            $error= "valores introducidos no válidos";
            //mysqli_error($conex);/*Error en los datos de entrada*/
            return false;
        }
        return true;
    }
    
    
    function mostrar_datos($idTrata,&$error, $aux){
        include 'conexion_bd.php';

        $querySelect="SELECT tipoTrata, precioTrata FROM tratamiento "
                ."WHERE idTrata='$idTrata' AND activo='1';";
        
        $res_tipo=mysqli_query($conex, $querySelect) or die (mysql_error());
        if (mysqli_num_rows($res_tipo)!=0){
            $reg=mysqli_fetch_array($res_tipo);
            $tipoTrata=$reg['tipoTrata'];
            $precioTrata=$reg['precioTrata'];
            drawForm($idTrata, $tipoTrata, $precioTrata,$error);
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
        drawForm($idTrata, $tipoTrata, $precioTrata,$error);
    }else{/*Rutina segunda vuelta*/
        if(strcmp($aux,"Mostrar Datos")){
            if(updateTratamiento($idTrata, $tipoTrata, $precioTrata,$error)){
                header("Location: menuVeterinario.php");
            }
            drawForm($idTrata, $tipoTrata, $precioTrata,$error);
        }else{
            mostrar_datos($idTrata,$error, $aux);
        }
        
    }
        ?>
    </body>
</html>

