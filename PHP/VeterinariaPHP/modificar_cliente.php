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
    }else{
        $dniCli=$_POST["dniCli"];
        $nombreCli=$_POST["nombreCli"];
        $apellidoCli=$_POST["apellidoCli"];
        $passwordCli=$_POST["passwordCli"];
        $emailCli=$_POST["emailCli"];
    }
    $error = '';

    
    function drawForm(&$nombreCli, &$apellidoCli,&$passwordCli,&$emailCli, &$error){
        
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
FORM13;
            
        $form1=$form11.$form13;
        $form2=<<<FORMULARIO
                Nombre
                <input name="nombreCli" type="text" value="$nombreCli">
                <br>
                Apellidos
                <input name="apellidoCli" type="text" value="$apellidoCli">
                <br>
                Contraseña
                <input name="passwordCli" type="text" value="$passwordCli">
                <br>
                Email
                <input name="emailCli" type="email" value="$emailCli">
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
    
    
    function updateCliente(&$dniCli, &$nombreCli, &$apellidoCli,&$passwordCli,&$emailCli, &$error)
    {
        include 'conexion_bd.php';

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
    
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
    if (empty($_POST))/*Rutina inicial*/{
        drawForm($nombreCli, $apellidoCli, $passwordCli, $emailCli, $error);
    }else{/*Rutina segunda vuelta*/
        if(updateCliente($dniCli,$nombreCli, $apellidoCli,$passwordCli,$emailCli,$error)){
            header("Location: menuVeterinario.php");
        }
        drawForm($nombreCli, $apellidoCli, $passwordCli, $emailCli, $error);
    }
        ?>
    </body>
</html>
