

<?php

    function drawForm(&$nombreCli, &$apellidoCli, &$passwordCli,&$emailCli, &$error){
        
    $dniCliSel = $_SESSION['$dniCliSel'];
    $nombreCli =  $_SESSION['nombreCli'];
        
    include 'conexion_bd.php';
        $form=<<<FORMULARIO
    <form action="modificar_propio_cli.php" method="post">
            <h1> MODIFICAR CLIENTE: $nombreCli ($dniCliSel) </h1>
            <h2> 
FORMULARIO;
        
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
        
        $formFinal=$form.$form2;

        print $formFinal;
    }
    
    
    function updateCliente($dniCli, $nombreCli, $apellidoCli,$passwordCli,$emailCli, &$error)
    {
        include 'conexion_bd.php';

        if($nombreCli==""||$apellidoCli==""||$passwordCli==""||$emailCli==""){
            $error.="<br>No debes dejar campos vacíos";
            return false;
        }
        $queryUpdate="UPDATE cliente SET "
                . "dniCli = '$dniCli', nombreCli = '$nombreCli', apellidoCli = '$apellidoCli',"
                . " passwordCli = '$passwordCli', emailCli = '$emailCli' "
                . "WHERE dniCli = '$dniCli';";
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
            session_start();
    include 'conexion_bd.php';
    
    if (empty($_POST)){
        
        $dniCliSel = $_SESSION['$dniCliSel'];
        
        $querySelect="SELECT * FROM cliente WHERE dniCli = '$dniCliSel';";
        
        $res_cli=mysqli_query($conex, $querySelect) or die (mysql_error());
        if (mysqli_num_rows($res_cli)!=0){
            while ($reg=mysqli_fetch_array($res_cli)){
                $nombreCli=$reg['nombreCli'];
                $apellidoCli=$reg['apellidoCli'];
                $passwordCli=$reg['passwordCli'];
                $emailCli=$reg['emailCli'];
                $error=""; 
            }
        }
        
    }else{
        $dniCliSel = $_SESSION['$dniCliSel'];
        $nombreCli=$_POST["nombreCli"];
        $apellidoCli=$_POST["apellidoCli"];
        $passwordCli=$_POST["passwordCli"];
        $emailCli=$_POST["emailCli"];
    }
    $error = '';
        
    if (empty($_POST))/*Rutina inicial*/{
        drawForm($nombreCli, $apellidoCli, $passwordCli, $emailCli, $error);
    }else{/*Rutina segunda vuelta*/
        if(updateCliente($dniCliSel,$nombreCli, $apellidoCli,$passwordCli,$emailCli,$error)){
            header("Location: menuCliente.php");
        }
        drawForm($nombreCli, $apellidoCli, $passwordCli, $emailCli, $error);
    }
        ?>
    </body>
</html>
