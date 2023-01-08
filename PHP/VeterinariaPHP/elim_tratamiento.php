<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd">
<?php        


    if(empty($_POST)){
        $idTrata = "";
        $error = "";
    }else{
        $idTrata = $_POST["idTrata"];
    }

    function drawForm(&$idTrata, &$error){
        
    include 'conexion_bd.php';
        $form=<<<FORMULARIO
    <form action="elim_tratamiento.php" method="post">
            <h1> ELIMINAR Tratamiento </h1>
            <h2> 
FORMULARIO;
        $form11=<<<FORM11
                ID tratamiento
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
                $error
FORM13;
            
        $form1=$form11.$form13;
        
        
        $formFinal=$form.$form1;

        print $formFinal;
    }
    
 
    function deleteTratamiento(&$idTrata, &$error)
    {
        include 'conexion_bd.php';

        $queryUpdate="DELETE FROM `tratamiento` WHERE `tratamiento`.`idTrata` = '$idTrata'";
                
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
        <title>Documento eliminar tratamiento</title>
    </head>

    <body>
        <?php
        
    if (empty($_POST))/*Rutina inicial*/{
        drawForm($idTrata, $error);
    }else{/*Rutina segunda vuelta*/
        if(deleteTratamiento($idTrata, $error)){
            header("Location: menuVeterinario.php");
        }
        drawForm($idTrata, $error);
    }
        ?>
        <input type="submit" name="Eliminar" value="Eliminar">
    </body>
</html>