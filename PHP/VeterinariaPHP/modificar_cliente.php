<!DOCTYPE html>
<!--
sacar los id de los clientes.
formulario con datos clientes
-->
<?php
    session_start();
    include 'conexion_bd.php';
    
    if (empty($_POST)){
        $dniCli="";
        $nombreCli="";
        $apellidoCli="";
        $passwordCli="";
        $emailCli="";
        $error="";
        $aux="";
    }else{
        $dniCli=$_POST["dniCli"];
        $nombreCli=$_POST["nombreCli"];
        $apellidoCli=$_POST["apellidoCli"];
        $passwordCli=$_POST["passwordCli"];
        $emailCli=$_POST["emailCli"];
        $aux = $_POST["btnAux"];
    }
    $error = '';

    
    function drawForm($dniCliF,$nombreCliF, $apellidoCliF,$passwordCliF,$emailCliF,&$error){
        
    include 'conexion_bd.php';
        $form=<<<FORMULARIO
    <form action="modificar_cliente.php" method="post">
            <h1> MODIFICAR CLIENTE </h1>
            <h2> 
FORMULARIO;
        $form11=<<<FORM11
                DNI
                <select name="dniCli">
                
FORM11;
        
        $querySelect="SELECT dniCli FROM cliente where activo='1';";
        $res_tipo=mysqli_query($conex, $querySelect) or die (mysql_error());
        if (mysqli_num_rows($res_tipo)!=0){
            while ($reg=mysqli_fetch_array($res_tipo)){
                $dniCli=$reg['dniCli'];
                if(strcmp($dniCli,$dniCliF)){
                    $form11.=<<<FORM12
                        <option  value="$dniCli">$dniCli</option>  
FORM12;
                }else{
                    $form11.=<<<FORM12
                        <option  value="$dniCli" selected>$dniCli</option>  
FORM12;
                }
                
            }
            
        } 
        $form13=<<<FORM13
               </select><br>
FORM13;
            
        $form1=$form11.$form13;
        $form2=<<<FORMULARIO
                Nombre
                <input name="nombreCli" type="text" value="$nombreCliF">
                <br>
                Apellidos
                <input name="apellidoCli" type="text" value="$apellidoCliF">
                <br>
                Contraseña
                <input name="passwordCli" type="text" value="$passwordCliF">
                <br>
                Email
                <input name="emailCli" type="email" value="$emailCliF">
                <br>
                </h2>
                <h3>$error </h3>
                <br>
                <br>
                <input type="submit" name="btnAux" value="Mostrar datos">
                <br>
                <input type="submit" name="btnAux" value="Modificar">
    </form>
                
FORMULARIO;
        
        $formFinal=$form.$form1.$form2;

        print $formFinal;
    }
    
    
    function updateCliente($dniCli, $nombreCli, $apellidoCli,$passwordCli,$emailCli, &$error)
    {
        include 'conexion_bd.php';
        
        if($nombreCli=="" || $apellidoCli=="" || $passwordCli=="" || $emailCli==""){
            $error.="<br>No puedes dejar campos vacíos";
            return false;
        }
        $queryUpdate="UPDATE `cliente` SET "
                . "`dniCli` = '$dniCli', `nombreCli` = '$nombreCli', `apellidoCli` = '$apellidoCli',"
                . " `passwordCli` = '$passwordCli', `emailCli` = '$emailCli' "
                . "WHERE `cliente`.`dniCli` = '$dniCli';";
        if(!mysqli_query($conex,$queryUpdate)){
            $error= "valores introducidos no válidos";
            //mysqli_error($conex);/*Error en los datos de entrada*/
            return false;
        }
        return true;
        
        
    }
    
    function mostrar_datos($dniCli,$aux,$error){
                include 'conexion_bd.php';
                
                $querySelect="SELECT nombreCli,apellidoCli,passwordCli,emailCli FROM cliente "
                        . "WHERE activo='1' AND dniCli='$dniCli';";
                
                $res_tipo=mysqli_query($conex, $querySelect) or die (mysql_error());
                
                if (mysqli_num_rows($res_tipo)!=0){
                    $reg=mysqli_fetch_array($res_tipo);
                    $nombreCli=$reg['nombreCli'];
                    $apellidoCli=$reg['apellidoCli'];
                    $emailCli=$reg['emailCli'];
                    $passwordCli = $reg['passwordCli'];
                    drawForm($dniCli,$nombreCli,$apellidoCli,$passwordCli,$emailCli,$error);
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
        drawForm($dniCli,$nombreCli, $apellidoCli, $passwordCli, $emailCli, $error);
    }else{/*Rutina segunda vuelta*/
        if(strcmp($aux,"Mostrar datos")){
            if(updateCliente($dniCli,$nombreCli, $apellidoCli,$passwordCli,$emailCli,$error)){
            header("Location: menuVeterinario.php");
            }
            drawForm($dniCli,$nombreCli, $apellidoCli, $passwordCli, $emailCli ,$error);
        }else{
            mostrar_datos($dniCli,$aux,$error);
        }
    }
        ?>
    </body>
</html>
